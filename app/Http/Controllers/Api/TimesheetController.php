<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $calender_date = $request->input('calender_date');
        $calender_day = $request->input('calender_day');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $hours = $request->input('hours');
        $project_id = $request->input('project_id');
        $project_phase_id = $request->input('project_phase_id');
        $notes = $request->input('notes');
        $timesheet_id = "ISL-TM-" . Str::random(6);
    }
}
