<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeProject;
use App\Models\Holiday;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Models\TimesheetStatus;
use App\Notifications\EmployeeLeaveApprovedNotification;
use App\Notifications\NewLeaveNotification;
use App\Notifications\RejectedLeaveByAdminNotification;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "employee leave";
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $leaves = Leave::with('leaveType', 'employee', 'time_sheet_status')->where('employee_id', '=', $employee->id)->orderBy('id', 'desc')->get();
        } else if (Auth::user()->role->name == Role::ADMIN) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            // $leaves = Leave::with('leaveType', 'employee', 'time_sheet_status')->where('employee_id', '=', $employee->id)
            //     ->orWhere('supervisor_id', '=', $employee->id)->orderBy('id', 'desc')->get();
            $leaves = Leave::with('leaveType', 'employee', 'time_sheet_status')->orderBy('id', 'desc')->get();
        } else {
            $leaves = Leave::with('leaveType', 'employee', 'time_sheet_status')->orderBy('id', 'desc')->get();
        }
        $timesheet_statuses = TimesheetStatus::get();
        $leave_types = LeaveType::get();
        $employees = Employee::where('record_status', '!=', 'delete')->get();
        $projects = Project::get();
        $project_phases = ProjectPhase::get();
        return view('backend.employee-leaves', compact('title', 'leaves', 'leave_types', 'employees', 'projects', 'timesheet_statuses', 'project_phases'));
    }

    public function LeaveView($id)
    {
        $title = "employee leave";
        $leave = Leave::with('leaveType', 'employee', 'time_sheet_status')->find($id);
        return view('backend.leave-view', compact('leave', 'title'));
    }


    // public function leavePdf()
    // {
    //     $mpdf = new \Mpdf\Mpdf();
    //     $mpdf->WriteHTML('Hello World');
    //     $mpdf->Output();
    // }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        // echo $days." days without weekend";

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
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE || Auth::user()->role->name == Role::ADMIN) {
            $comp_total_leaves = LeaveType::where('id', '=', $request->leave_type)->value('days');
            $company_total_leaves = (int)$comp_total_leaves;
            $old_leaves = Leave::with('time_sheet_status')->where('leave_type_id', '=', $request->leave_type)->where('employee_id', '=', $employee_id)->whereHas('time_sheet_status', function ($query) {
                $query->where('status', '!=', TimeSheetStatus::REJECTED);
            })->sum('no_of_days');
            // $pending_leave = (int)$total_leaves - (int)$old_leaves;
            $comp_leave_type = LeaveType::where('id', '=', $request->leave_type)->value('type');
            $new_leaves = (int)$old_leaves + (int) $total_days;
            $remainingLeave = (int)$company_total_leaves - (int)$old_leaves;
            if($remainingLeave == 0)
            {
               $message ="";
            }else{
                $message ="please apply only for $remainingLeave leave.";
            }
            if ($new_leaves > $company_total_leaves) {
                return back()->with('danger', "Your leave has been completed. Therefore you cannot take any more leave. Company Total $comp_leave_type : $company_total_leaves. Your Total  $comp_leave_type: $old_leaves . You have remaining  $remainingLeave Leave.
               $message");
            }

            $timesheet_status = TimesheetStatus::where('status', 'pending approval')->first();
            $timesheet_status_id =  $timesheet_status->id;
            $employee_field = 'nullable';
            $timesheet_status_field = 'nullable';
        } else {
            $comp_total_leaves = LeaveType::where('id', '=', $request->leave_type)->value('days');
            $company_total_leaves = (int)$comp_total_leaves;
            $old_leaves = Leave::with('time_sheet_status')->where('leave_type_id', '=', $request->leave_type)->where('employee_id', '=', $employee_id)->whereHas('time_sheet_status', function ($query) {
                $query->where('status', '!=', TimeSheetStatus::REJECTED);
            })->sum('no_of_days');
            // $pending_leave = (int)$total_leaves - (int)$old_leaves;
            $comp_leave_type = LeaveType::where('id', '=', $request->leave_type)->value('type');
            $new_leaves = (int)$old_leaves + (int) $total_days;
            $remainingLeave = (int)$company_total_leaves - (int)$old_leaves;
            if($remainingLeave == 0)
            {
               $message ="";
            }else{
                $message ="please apply only for $remainingLeave leave.";
            }
            if ($new_leaves > $company_total_leaves) {
                return back()->with('danger', "Your leave has been completed. Therefore you cannot take any more leave. Company Total $comp_leave_type : $company_total_leaves. Your Total  $comp_leave_type: $old_leaves . You have remaining  $remainingLeave Leave.
                 $message");
            }

            $employee_field = 'required';
            $timesheet_status_id = $request->timesheet_status;
            $timesheet_status_field = 'required';
        }
        $this->validate($request, [
            'employee' => $employee_field,
            'leave_type' => 'required',
            'from' => 'required',
            'to' => 'required',
            'reason' => 'required',
            'timesheet_status' => $timesheet_status_field
        ]);
        $days = $total_days;
        // if ($total_days != 0) {
        //     $days = $total_days;
        // }

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
        $leave->notify(new NewLeaveNotification($leave));
        $notification = notify("Employee leave has been added.");
        return back()->with($notification);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $employee_id = $employee->id;
            $timesheet_status = TimesheetStatus::where('status', 'pending approval')->first();
            $timesheet_status_id =  $timesheet_status->id;
            $employee_field = 'nullable';
            $timesheet_status_field = 'nullable';
        } else {
            $employee_id = $request->employee;
            $employee_field = 'required';
            $timesheet_status_id = $request->timesheet_status;
            $timesheet_status_field = 'required';
        }

        // $this->validate($request, [
        //     'employee' => $employee_field,
        //     'leave_type' => 'required',
        //     'from' => 'required',
        //     'to' => 'required',
        //     'reason' => 'required',
        //     'timesheet_status' => $timesheet_status_field,
        // ]);
        $leave = Leave::find($request->id);
        $leave->update([
            'leave_type_id' => $request->leave_type,
            'employee_id' => $employee_id,
            'supervisor_id' => $request->supervisor,
            'project_id' => $request->project,
            'project_phase_id' => $request->project_phase_id,
            'from' => $request->from,
            'to' => $request->to,
            'reason' => $request->reason,
            'status_reason' => $request->status_reason,
            'timesheet_status_id' => $timesheet_status_id,
            'approved_date_time' => $request->approved_date_time,

        ]);
        $notification = notify("Employee leave has been updated");;
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $leave = Leave::find($request->id);
        $leave->delete();
        $notification = notify('Employee leave has been deleted');
        return back()->with($notification);
    }

    public function LeaveStatusUpdate(Request $request)
    {
        // dd($request->all());
        $timesheet_status = TimesheetStatus::find($request->timesheet_status);
        $status_reason = '';
        if (!empty($timesheet_status->status) && $timesheet_status->status == TimesheetStatus::REJECTED) {
            $status_reason = 'required';
        }
        // $this->validate($request, [
        //     'timesheet_status' => 'required',
        //     'status_reason' =>  $status_reason,
        // ]);
        $date = date('Y-m-d');
        $employee_leave_status = Leave::with('leaveType', 'time_sheet_status')->find($request->id);
        $employee_leave_status->timesheet_status_id =  $request->input('timesheet_status');
        $employee_leave_status->status_reason = $request->input('status_reason');
        $employee_leave_status->approved_date_time =  $date;
        $timesheet_status = TimesheetStatus::find($request->timesheet_status);

        $leave_status = ([
            'to'   => $employee_leave_status->employee_id,
            'from' => $employee_leave_status->supervisor_id,
            'leave_id' => $employee_leave_status->id,
            'message' => 'Your' . " " . $employee_leave_status->leaveType->type . " " . 'has been' . " " . $timesheet_status->status . " " . 'by Admin' . " " . ucfirst(Auth::user()->name),
            'type' => $employee_leave_status->leaveType->type,
            'approved_date_time' => $employee_leave_status->approved_date_time
        ]);
        if ($timesheet_status->status == TimesheetStatus::APPROVED) {
            $employee_leave_status->notify(new EmployeeLeaveApprovedNotification($leave_status));
        } elseif ($timesheet_status->status == TimesheetStatus::REJECTED) {
            $employee_leave_status->notify(new RejectedLeaveByAdminNotification($leave_status));
        }
        $employee_leave_status->save();
        return back()->with('success', "Employee Leave status has been updated successfully!!.");
    }


    public function getProjects(Request $request)
    {
        $fromDate = date('Y-m-d', strtotime($request->input('fromDate')));
        $toDate = date('Y-m-d', strtotime($request->input('toDate')));
        $projects = Project::whereDate('client_cont_start_date', '>=', $fromDate)->whereDate('client_cont_end_date', '<=', $toDate)->Orwhere("client_cont_start_date", '=', NULL)->Orwhere("client_cont_end_date", '=', NULL)->get();

        // $projects = EmployeeProject::with('projects')->whereHas('projects', function($q){
        //     $q->whereDate('client_cont_start_date', '>=', $fromDate)->whereDate('client_cont_end_date', '<=',$toDate)->Orwhere("client_cont_start_date",'=',NULL)->Orwhere("client_cont_end_date",'=',NULL)
        // })->get();
        // $projects = EmployeeProject::with('projects')->where('employee_id', $id)->get();
        // dd($projects);
        return json_encode(array('data' =>  $projects));
    }
}
