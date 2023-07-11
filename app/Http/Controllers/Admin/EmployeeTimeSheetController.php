<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeProject;
use App\Models\EmployeeTimesheet;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Settings\CompanySettings;
use App\Models\TimesheetStatus;
use DateInterval;
use DatePeriod;
use DateTime;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeTimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Employee TimeSheet";
        $employees = Employee::get();
        $projects = Project::get();
        $project_phases = ProjectPhase::get();
        $timesheet_statuses = TimesheetStatus::get();
        $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase', 'timesheet_status')->orderBy('id', 'desc')->get();
        return view('backend.employee-timesheet', compact('title', 'employee_timesheets', 'employees', 'projects', 'project_phases', 'timesheet_statuses'));
    }


    /**
     * employee timesheet view
     */
    public function employeeTimesheetView(CompanySettings $settings)
    {
        $title = "Employee TimeSheet";
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $employees = Employee::get();
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $employee_project = EmployeeProject::with('projects')->where('employee_id', $employee->id)->get();
            $employee_timesheets = EmployeeTimesheet::with('project', 'projectphase')->where('employee_id', '=', $employee->id)->first();
        }
        return view('backend.employee-timesheet.employee-timesheet-view', compact('title', 'employee', 'settings', 'employee_timesheets', 'employees', 'employee_project'));
    }

    /**
     * Employee Timesheet Detail
     */
    public function employeeTimeSheetDetail($id, $start_date, $end_date)
    {
        $title = "Employee TimeSheet";
        $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase')->where('employee_id', '=', $id)->where('start_date', '=', $start_date)->where('end_date', '=', $end_date)->get();
        // $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase')->get();
        // dd($employee_timesheets);

        return view('backend.employee-timesheet.timesheet-detail', compact('employee_timesheets', 'title', 'start_date'));
    }

    /**
     * employee timesheet listing
     */
    public function employeeTimesheetList()
    {
        $title = "Employee TimeSheet";
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $projects = Project::get();
            $project_phases = ProjectPhase::get();
            $timesheet_statuses = TimesheetStatus::get();
            $employee_timesheets = DB::table('employee_timesheets')->select('*', DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"), DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->groupBy('end_date')->latest()->get();
            // $employee_timesheets = EmployeeTimesheet::select('*', DB::raw("CONCAT('start_date', '-','end_date') AS timesheet_date"))->groupBy('timesheet_date')->get();
            // dd($employee_timesheets);
        }

        return view('backend.employee-timesheet.timesheet-list', compact('title', 'projects', 'project_phases', 'timesheet_statuses', 'employee_timesheets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_end_date = explode(" ", $request->week);
        $start_date =  date('Y-m-d', strtotime($start_end_date[0]));
        $end_date = date('Y-m-d', strtotime($start_end_date[2]));
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $this->validate($request, [
                'supervisor_id'   => 'required',
                'calender_date.*' => 'required',
                'calender_day.*'  => 'required',
                'start_time.*'    => 'nullable',
                'end_time.*'      => 'nullable',
                'hours.*'         => 'nullable',
            ]);
            $timesheet_status = TimesheetStatus::where('status', TimesheetStatus::PENDING_APPROVED)->first();
            $calender_date = $request->input('calender_date');
            $calender_day = $request->input('calender_day');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $hours = $request->input('hours');
            $project_id = $request->input('project_id');
            $project_phase_id = $request->input('project_phase_id');
            $notes = $request->input('notes');
            foreach ($start_time as $key => $value) {
                if (!empty($hours[$key]) && $hours[$key] == "full_day") {
                    $total_hours_worked = "8 hours";
                } elseif (!empty($hours[$key]) && $hours[$key] == "half_day") {
                    $total_hours_worked = "4 hours";
                } else {
                    $total_hours_worked = "";
                }
                $timesheet_id = IdGenerator::generate(['table' => 'employee_timesheets', 'field' => 'timesheet_id', 'length' => 7, 'prefix' => 'ISL-TM-']);
                $employee_timesheet = EmployeeTimesheet::where('calender_date', '=', $calender_date[$key])->first();
                if (empty($employee_timesheet)) {
                    $emp_timesheet = new EmployeeTimesheet();
                    $emp_timesheet->timesheet_id = $timesheet_id."-".$calender_date[$key];
                    $emp_timesheet->employee_id = $request->input('employee_id');
                    $emp_timesheet->supervisor_id = $request->input('supervisor_id');
                    $emp_timesheet->project_id = $project_id[$key];
                    $emp_timesheet->project_phase_id  = $project_phase_id[$key];
                    $emp_timesheet->calender_day = $calender_day[$key];
                    $emp_timesheet->calender_date = $calender_date[$key];
                    $emp_timesheet->from_time = $value;
                    $emp_timesheet->to_time = $end_time[$key];
                    $emp_timesheet->notes =  $notes[$key];
                    $emp_timesheet->total_hours_worked = $total_hours_worked;
                    $emp_timesheet->timesheet_status_id = $timesheet_status->id;
                    $emp_timesheet->start_date = $start_date;
                    $emp_timesheet->end_date = $end_date;
                    $emp_timesheet->save();
                }
            }
            return redirect()->route('employee-timesheet-list')->with('success', "Employee TimeSheet Data has been added successfully!");
        } else {
            $this->validate($request, [
                'timesheet_id' => 'required|unique:employee_timesheets,timesheet_id,' . $request->id,
                'employee_id'  => 'required',
            ]);

            if (!empty($request->id)) {
                $employee_timesheet = EmployeeTimesheet::find($request->id);
                $message = "Employee TimeSheet Data has been updated successfully!!.";
            } else {
                $employee_timesheet = new EmployeeTimesheet();
                $message = "Employee TimeSheet Data has been added successfully!!.";
            }
            $employee_timesheet->timesheet_id = $request->input('timesheet_id');
            $employee_timesheet->employee_id  = $request->input('employee_id');
            $employee_timesheet->supervisor_id  = $request->input('supervisor_id');
            $employee_timesheet->project_id  = $request->input('project_id');
            $employee_timesheet->project_phase_id  = $request->input('project_phase_id');
            $employee_timesheet->calender_day = $request->input('calendar_day');
            $employee_timesheet->calender_date = $request->input('calender_date');
            $employee_timesheet->from_time = $request->input('from_time');
            $employee_timesheet->to_time = $request->input('to_time');
            $employee_timesheet->total_hours_worked = $request->input('total_hours_works');
            $employee_timesheet->notes = $request->input('notes');
            $employee_timesheet->timesheet_status_id = $request->input('timesheet_status');
            $employee_timesheet->status_reason = $request->input('status_reason');
            $employee_timesheet->approved_date_time = $request->input('approved_date_time');
            $employee_timesheet->save();
            return back()->with('success', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee_timesheet = EmployeeTimesheet::find($request->id);
        $employee_timesheet->delete();
        return back()->with('success', "Employee TimeSheet has been deleted successfully!!.");
    }

    public function TimesheetStatusUpdate(Request $request)
    {
        $this->validate($request, [
            'timesheet_status' => 'required',
        ]);
        $employee_timesheet = EmployeeTimesheet::find($request->id);
        $employee_timesheet->timesheet_status_id =  $request->input('timesheet_status');
        $employee_timesheet->save();
        return back()->with('success', "Employee TimeSheet status has been updated successfully!!.");
    }

    public function getWeekDays(Request $request)
    {
        // $date_days = "";

        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $month = $request->month;
        $year = 2023;
        $start_date = "01-" . $month . "-2023";
        $start_date_day = date("l", strtotime($start_date));
        $start_day_index = array_search($start_date_day, $days);

        if($start_day_index !== 0){
            $weekStartDate = date("d-m-Y", strtotime($start_date. "+". (7-$start_day_index). "days" ));
        }else{
            $weekStartDate = date("d-m-Y", strtotime($start_date));
        }

        $weeksData = [];
        for($weeks =0; $weeks <= 5; $weeks++){
            $week_end_date = date("d-m-Y", strtotime($weekStartDate. "+ 6 days" ));
            $weeksData[] = [
                'week_start_date' => $weekStartDate,
                'week_end_date' => $week_end_date
            ];
            $weekStartDate = date("d-m-Y", strtotime($week_end_date. "+1 day" ));
            
            if(date("m", strtotime($weekStartDate)) != $month ){
                break;
            }
        }

        return json_encode(array('data'=> $weeksData));


        /*
        $weeks = [];
        $year = 2023;
        $month = $request->month;
        
        // Get the first day of the month
        $firstDay = strtotime("$year-$month-01");
        
        // Get the last day of the month
        $lastDay = strtotime(date("Y-m-t", $firstDay));
        
        // Iterate over each day and determine the week number
        $currentDay = $firstDay;
        $weekDates = array();
        while ($currentDay <= $lastDay) {
            $weekNumber = date("W", $currentDay);
            $weekDates[$weekNumber][] = date("Y-m-d", $currentDay);
            $currentDay = strtotime("+1 day", $currentDay);
        }
        array_shift($weekDates);
        
        foreach ($weekDates as $weekNumber => $dates) {
           if(count($dates) < 7){
               $start = $weekDates[$weekNumber][0];
               $weekDates[$weekNumber] = $this->get_next_days($start);
           }
        }

        dd($weekDates);
        // foreach($weekDates as $key=> $value){
        //     dd($value);

        // }

        return json_encode(array('data'=>$weekDates));
        // echo "<pre>";
        // print_r($weekDates);
        */

}


// function get_next_days($date){
//     $date = date($date, strtotime('+1 day')); //tomorrow date
//     $weekOfdays = array();
//     $begin = new DateTime($date);
//     $end = new DateTime($date);
//     $end = $end->add(new DateInterval('P7D'));
//     $interval = new DateInterval('P1D');
//     $daterange = new DatePeriod($begin, $interval ,$end);
    
//     foreach($daterange as $dt){
//         $weekOfdays[] = $dt->format('Y-m-d');
//     }
//     return $weekOfdays;
// }

}
