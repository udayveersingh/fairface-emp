<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\ExpenseType;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\TimesheetStatus;
use App\Notifications\NewLeaveNotification;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getDataLeaves()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $all_data_for_leaves = [];
            $all_data_for_leaves['leave_types'] = LeaveType::get();
            $all_data_for_leaves['supervisors'] = getSupervisor();
            $all_data_for_leaves['projects'] = Project::get();
            $all_data_for_leaves['project_phases'] = ProjectPhase::get();
            $all_data_for_leaves['expense_types'] = ExpenseType::get();

            return response()->json(['success' => true, 'data' => $all_data_for_leaves], 201);
        }
    }

    public function store(Request $request)
    {
        $start = new DateTime($request->from);
        $end_date = new DateTime($request->to);

        // If you want to include the end date, you should add 1 day to it
        $end_date->modify('+1 day');

        $days = 0;

        while ($start < $end_date) {
            $weekday = $start->format('w');

            if ($weekday !== "0" && $weekday !== "6") { // 0 for Sunday and 6 for Saturday
                $days++;
            }

            $start->modify('+1 day');
        }

        $start_date = new DateTime($request->from);
        $holidays = Holiday::whereBetween('holiday_date', [$start_date, $end_date])->get();
        $holidays_date = [];
        if (!empty($holidays)) {
            foreach ($holidays as $date) {
                $holidays_date[] = $date->holiday_date;
            }
        }


        $countHolidays = 0;
        if (!empty($holidays_date) && count($holidays_date) > 0) {
            $StartHoliday = new DateTime(current($holidays_date));
            $EndHoliday =  new DateTime(end($holidays_date));

            $interval =  $StartHoliday->diff($EndHoliday);

            $countHolidays = 0;
            for ($i = 0; $i <= $interval->d; $i++) {
                $StartHoliday->modify('+1 day');
                $weekday =  $StartHoliday->format('w');

                if ($weekday !== "0" && $weekday !== "6") { // 0 for Sunday and 6 for Saturday
                    $countHolidays++;
                }
            }
            $total_days = (int)$days - (int)$countHolidays;
        } else {
            $total_days = (int)$days;
        }

        $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
        if ($request->employee) {
            $employee_id = $request->employee;
        } else {
            $employee_id = $employee->id;
        }

        $comp_total_leaves = LeaveType::where('id', '=', $request->leave_type)->value('days');
        $company_total_leaves = (int)$comp_total_leaves;
        $old_leaves = Leave::with('time_sheet_status')->where('leave_type_id', '=', $request->leave_type)->where('employee_id', '=', $employee_id)->whereHas('time_sheet_status', function ($query) {
            $query->where('status', '!=', TimeSheetStatus::REJECTED);
        })->sum('no_of_days');
        // $pending_leave = (int)$total_leaves - (int)$old_leaves;
        $comp_leave_type = LeaveType::where('id', '=', $request->leave_type)->value('type');
        $new_leaves = (int)$old_leaves + (int) $total_days;
        $remainingLeave = (int)$company_total_leaves - (int)$old_leaves;
        if ($remainingLeave == 0) {
            $message = "";
        } else {
            $message = "please apply only for $remainingLeave leave.";
        }
        if ($new_leaves > $company_total_leaves) {
            return response()->json(['success' => false, 'data' => "'Your leave has been completed. Therefore you cannot take any more leave. Company Total' .$comp_leave_type. ':'. $company_total_leaves'.'.'Your Total'.  $comp_leave_type.':'. $old_leaves . 'You have remaining'.$remainingLeave .'Leave.'.$message"], 401);
        }

        $timesheet_status = TimesheetStatus::where('status', 'pending approval')->first();
        $timesheet_status_id =  $timesheet_status->id;
        $employee_field = 'nullable';
        $timesheet_status_field = 'nullable';
        $leave = Leave::create([
            'leave_type_id' => $request->leave_type,
            'employee_id' => $employee_id,
            'supervisor_id' => $request->supervisor,
            'project_id' => $request->project,
            'project_phase_id' => $request->project_phase_id,
            'from' => $request->from,
            'to' => $request->to,
            'reason' => $request->reason,
            'no_of_days' => $days,
            'timesheet_status_id' =>  $timesheet_status_id,
            'status_reason' => $request->status_reason,
            'approved_date_time' => $request->approved_date_time,

        ]);
        $leaveType = LeaveType::find($request->leave_type);
        $employee = Employee::find($employee_id);
        $leave['leave_type'] = $leaveType->type;
        $leave['from_name'] =  $employee->firstname." ". $employee->lastname; 
        $leave->notify(new NewLeaveNotification($leave));
        $notification = notify("Employee leave has been added.");

        return response()->json(['success' => true, 'data' => 'Employee leave has been added.'], 201);
    }

    public function leaveDetails()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');
            $recent_leaves_details = Leave::leftJoin('leave_types', 'leaves.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('timesheet_statuses', 'leaves.timesheet_status_id', '=', 'timesheet_statuses.id')
                ->leftJoin('employees','employees.id','=','leaves.supervisor_id')
                ->where('leaves.employee_id', '=', $employeeID)
                ->orderBy('leaves.updated_at', 'DESC')
                ->select(['leave_types.type', 'timesheet_statuses.status', 'leaves.created_at as submitted', 'leaves.from', 'leaves.to','leaves.no_of_days','employees.firstname','employees.lastname'])
                ->limit(4)
                ->get();

            return response()->json(['success' => true, 'data' => $recent_leaves_details], 201);
        }
    }
}
