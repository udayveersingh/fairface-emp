<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTimesheet;
use App\Models\TimesheetStatus;
use Illuminate\Http\Request;

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
        $weeklyData = json_decode($request->weeklyData, true);

        return $weeklyData;


        $calender_date = $request->input('calender_date');
        $calender_day = $request->input('calender_day');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $hours = $request->input('hours');
        $project_id = $request->input('project_id');
        $project_phase_id = $request->input('project_phase_id');
        $notes = $request->input('notes');
        $timesheet_id = "ISL-TM-" . Str::random(6);

        foreach ($start_time as $key => $value) {
            if (!empty($hours[$key]) && $hours[$key] == "full_day") {
                $total_hours_worked = "8 hours";
            } elseif (!empty($hours[$key]) && $hours[$key] == "half_day") {
                $total_hours_worked = "4 hours";
            } else {
                $total_hours_worked = "";
            }

            $employee_timesheet = EmployeeTimesheet::where('employee_id', '=', $request->employee_id)->where('calender_date', '=', $calender_date[$key])->first();
            if (empty($employee_timesheet)) {
                $emp_timesheet = new EmployeeTimesheet();
                $message = "Employee TimeSheet Data has been added successfully!!.";
            } else {
                $emp_timesheet = EmployeeTimesheet::find($employee_timesheet->id);
                $message = "Employee TimeSheet Data has been updated successfully!!.";
            }
            
            $emp_timesheet->timesheet_id = $timesheet_id;
            $emp_timesheet->employee_id = $request->input('employee_id');
            $emp_timesheet->supervisor_id = $request->input('supervisor_id');
            $emp_timesheet->project_id = $project_id[$key];
            $emp_timesheet->project_phase_id  = $project_phase_id[$key];
            $emp_timesheet->calender_day = $calender_day[$key];
            $emp_timesheet->calender_date = $calender_date[$key];
            if ($value == Null && !empty($hours[$key]) && $hours[$key] == "full_day" ||  $hours[$key] == "half_day") {
                $emp_timesheet->from_time = "9:00";
            } else {
                $emp_timesheet->from_time = $value;
            }

            if ($end_time[$key] == Null && !empty($hours[$key]) && $hours[$key] == "full_day") {
                $emp_timesheet->to_time = "17:00";
            } else if ($end_time[$key] == Null && !empty($hours[$key]) && $hours[$key] == "half_day") {
                $emp_timesheet->to_time = "13:00";
            } else {
                $emp_timesheet->to_time = $end_time[$key];
            }
            $emp_timesheet->notes =  $notes[$key];
            $emp_timesheet->total_hours_worked = $total_hours_worked;
            $emp_timesheet->timesheet_status_id = $timesheet_status->id;
            $emp_timesheet->start_date = $start_date;
            $emp_timesheet->end_date = $end_date;
            $emp_timesheet->save();
        }

    }
}
