<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeTimesheet;
use App\Models\TimesheetStatus;
use App\Notifications\SendTimesheetNotificationToAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TimesheetController extends Controller
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


    public function store(Request $request)
    {
        // dd($request->all());
        $year = $request->year;
        $month = ($request->month >= 10) ? $request->month : '0' . $request->month;
        $first_date = $year . "-" . $month . "-01";
        $last_date_find = strtotime(date("Y-m-d", strtotime($first_date)) . ", last day of this month");
        $last_date = date("Y-m-d", $last_date_find);
        if ($request->week != null) {
            $start_end_date = explode(",", $request->week);
            $start_date =  date('Y-m-d', strtotime($start_end_date[0]));
            $end_date = date('Y-m-d', strtotime($start_end_date[1]));
        } else {
            $start_date = $first_date;
            $end_date =  $last_date;
        }

        // if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
        // $this->validate($request, [
        //     // 'supervisor_id'   => 'required',
        //     'calender_date.*' => 'required',
        //     'calender_day.*'  => 'required',
        //     'start_time.*'    => 'nullable',
        //     'end_time.*'      => 'nullable',
        //     'hours.*'         => 'nullable',
        // ]);

        $timesheet_status = TimesheetStatus::where('status', TimesheetStatus::PENDING_APPROVED)->first();

        // Decode the JSON string into a PHP associative array
        $weeklyData = $request->weeklyData;
        $timesheet_id = "ISL-TM-" . Str::random(6);
        $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
        foreach ($weeklyData as $data) {
            if (!empty($data['hours']) && $data['hours'] == "full_day") {
                $total_hours_worked = "8 hours";
            } elseif (!empty($data['hours']) && $data['hours'] == "half_day") {
                $total_hours_worked = "4 hours";
            } else {
                $total_hours_worked = "";
            }

            $employee_timesheet = EmployeeTimesheet::where('employee_id', '=', $request->employee_id)->where('calender_date', '=', $data['calender_date'])->first();
            if (empty($employee_timesheet)) {
                $emp_timesheet = new EmployeeTimesheet();
                $message = "Employee TimeSheet Data has been added successfully!!.";
            } else {
                $emp_timesheet = EmployeeTimesheet::find($employee_timesheet->id);
                $message = "Employee TimeSheet Data has been updated successfully!!.";
            }

            $emp_timesheet->timesheet_id = $timesheet_id;
            $emp_timesheet->employee_id = $employee->id;
            $emp_timesheet->supervisor_id = $request->input('supervisor_id');
            $emp_timesheet->project_id = $data['project_id'];
            $emp_timesheet->project_phase_id  = $data['project_phase_id'];
            $emp_timesheet->calender_day = $data['calender_day'];
            $emp_timesheet->calender_date = $data['calender_date'];
            if ($data['start_time'] == Null && !empty($data['hours']) && $data['hours'] == "full_day" ||  $data['hours'] == "half_day") {
                $emp_timesheet->from_time = "9:00";
            } else {
                $emp_timesheet->from_time = $data['start_time'];
            }

            if ($data['end_time'] == Null && !empty($data['hours']) && $data['hours'] == "full_day") {
                $emp_timesheet->to_time = "17:00";
            } else if ($data['end_time'] == Null && !empty($data['hours']) && $data['hours'] == "half_day") {
                $emp_timesheet->to_time = "13:00";
            } else {
                $emp_timesheet->to_time = $data['end_time'];
            }
            $emp_timesheet->notes = $data['notes'];
            $emp_timesheet->total_hours_worked = $total_hours_worked;
            $emp_timesheet->timesheet_status_id = $timesheet_status->id;
            $emp_timesheet->start_date = $start_date;
            $emp_timesheet->end_date = $end_date;
            $emp_timesheet->save();
        }

        $emp_timesheet->notify(new SendTimesheetNotificationToAdmin($emp_timesheet));

        return response()->json(['success' => true, 'data' => $message], 201);
    }
}
