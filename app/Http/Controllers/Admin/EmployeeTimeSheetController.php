<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeProject;
use App\Models\EmployeeTimesheet;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Settings\CompanySettings;
use App\Models\TimesheetStatus;
use App\Models\User;
use App\Notifications\ApprovedTimesheetByAdminNotification;
use App\Notifications\RejectedTimesheetByAdminNotification;
use App\Notifications\SendTimesheetNotificationToAdmin;
use App\Notifications\SendTimeSheetToSupervisorNotification;
use DateInterval;
use DatePeriod;
use DateTime;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        // $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase', 'timesheet_status')->orderBy('id', 'desc')->get();
        $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase', 'timesheet_status')->select('*', DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"), DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->groupBy('end_date', 'employee_id')->latest()->get();
        return view('backend.employee-timesheet', compact('title', 'employee_timesheets', 'employees', 'projects', 'project_phases', 'timesheet_statuses'));
    }


    /**
     * employee timesheet view
     */
    public function employeeTimesheetView(CompanySettings $settings)
    {
        $title = "Employee TimeSheet";
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employees = Employee::get();
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $employee_leave = Leave::where('employee_id', '=', $employee->id)->get();
            // $employee_project = EmployeeProject::with('projects')->where('employee_id', $employee->id)->get();
            $employee_timesheets = EmployeeTimesheet::with('project', 'projectphase')->where('employee_id', '=', $employee->id)->first();
        }
        return view('backend.employee-timesheet.employee-timesheet-view', compact('title', 'employee', 'settings', 'employee_timesheets', 'employees', 'employee_leave'));
    }

    public function TimesheetView(CompanySettings $settings)
    {
        $title = "Employee TimeSheet";
        // dd(getEmployeeRole()); 
        $employee_project = EmployeeProject::with('projects')->get();
        return view('backend.employee-timesheet.timesheet-view', compact('title', 'settings', 'employee_project'));
    }

    /**
     * Employee Timesheet Edit View
     */
    public function empTimesheetEditView(CompanySettings $settings, $id, $start_date, $end_date)
    {
        $title = "Edit Employee TimeSheet";
        $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase')->where('employee_id', '=', $id)->where('start_date', '=', $start_date)->where('end_date', '=', $end_date)->orderBy("calender_date", "asc")->get();
        $employee_project = EmployeeProject::with('projects')->where('employee_id', $id)->get();
        return view('backend.employee-timesheet.timesheet-edit-view', compact('employee_timesheets', 'title', 'settings', 'start_date', 'end_date', 'id', 'employee_project'));
    }

    /**
     * Employee Timesheet Detail
     */
    public function employeeTimeSheetDetail($id, $start_date, $end_date)
    {
        $title = "Employee TimeSheet";
        $userID = Employee::where('id', '=', $id)->value('user_id');
        $loginUserId = User::where('id', '=', $userID)->value('id');
        $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase')->where('employee_id', '=', $id)->where('start_date', '=', $start_date)->where('end_date', '=', $end_date)->orderBy('calender_date', 'ASC')->get();
        // $timesheet_statuses = TimesheetStatus::get();
        $timesheet_statuses = TimesheetStatus::where('status', '=', TimesheetStatus::APPROVED)->Orwhere('status', '=', TimesheetStatus::REJECTED)->get();
        // $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase')->get();
        // dd($employee_timesheets);

        return view('backend.employee-timesheet.timesheet-detail', compact('employee_timesheets', 'title', 'start_date', 'end_date', 'timesheet_statuses', 'id', 'loginUserId'));
    }

    /**
     * employee timesheet listing
     */
    public function employeeTimesheetList()
    {
        $title = "Employee TimeSheet";
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $projects = Project::get();
            $project_phases = ProjectPhase::get();
            $timesheet_statuses = TimesheetStatus::get();
            $employee_timesheets = DB::table('employee_timesheets')->where('employee_id', '=', $employee->id)->select('*', DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"), DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->groupBy('end_date')->orderBy('id', 'Desc')->get();
            // dd($employee_timesheets);
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
        $this->validate($request, [
            // 'supervisor_id'   => 'required',
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
        $timesheet_id = "ISL-TM-" . Str::random(6);
        // $timesheet_id = IdGenerator::generate(['table' => 'employee_timesheets', 'field' => 'timesheet_id', 'length' => 7, 'prefix' => 'ISL-TM-']);
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
            // $emp_timesheet->timesheet_id = $timesheet_id;
            // $emp_timesheet->timesheet_id = $timesheet_id . "-" . $calender_date[$key];
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
        $employee = Employee::find( $request->input('employee_id'));
        $emp_timesheet['from_name'] = $employee->firstname ." ". $employee->lastname;
        $emp_timesheet->notify(new SendTimesheetNotificationToAdmin($emp_timesheet));
        //  $emp_timesheet->notify(new SendTimeSheetToSupervisorNotification($emp_timesheet));
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            return redirect()->route('employee-timesheet-list')->with('success', $message);
        } else {
            return redirect()->route('employee-timesheet-detail', ['id' => $emp_timesheet->employee_id, 'start_date' => $start_date, 'end_date' => $end_date])->with('success', $message);
        }
        // } else {
        //     $this->validate($request, [
        //         'timesheet_id' => 'required|unique:employee_timesheets,timesheet_id,' . $request->id,
        //         'employee_id'  => 'required',
        //     ]);
        //     if (!empty($request->id)) {
        //         $employee_timesheet = EmployeeTimesheet::find($request->id);
        //         $message = "Employee TimeSheet Data has been updated successfully!!.";
        //     } else {
        //         $employee_timesheet = new EmployeeTimesheet();
        //         $message = "Employee TimeSheet Data has been added successfully!!.";
        //     }
        //     $employee_timesheet->timesheet_id = $request->input('timesheet_id');
        //     $employee_timesheet->employee_id  = $request->input('employee_id');
        //     $employee_timesheet->supervisor_id  = $request->input('supervisor_id');
        //     $employee_timesheet->project_id  = $request->input('project_id');
        //     $employee_timesheet->project_phase_id  = $request->input('project_phase_id');
        //     $employee_timesheet->calender_day = $request->input('calendar_day');
        //     $employee_timesheet->calender_date = $request->input('calender_date');
        //     $employee_timesheet->from_time = $request->input('from_time');
        //     $employee_timesheet->to_time = $request->input('to_time');
        //     $employee_timesheet->total_hours_worked = $request->input('total_hours_works');
        //     $employee_timesheet->notes = $request->input('notes');
        //     $employee_timesheet->timesheet_status_id = $request->input('timesheet_status');
        //     $employee_timesheet->status_reason = $request->input('status_reason');
        //     $employee_timesheet->approved_date_time = $request->input('approved_date_time');
        //     $employee_timesheet->save();
        //     return back()->with('success', $message);
    }
    // }

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
        $timesheet_status = TimesheetStatus::find($request->timesheet_status);
        $status_reason = '';
        if (!empty($timesheet_status->status) && $timesheet_status->status == TimesheetStatus::REJECTED) {
            $status_reason = 'required';
        }
        $this->validate($request, [
            'timesheet_status' => 'required',
            'status_reason' =>  $status_reason,
        ]);
        $employee_timesheet = EmployeeTimesheet::where('employee_id', '=', $request->emp_id)->where('start_date', '=', $request->start_date)->where('end_date', '=', $request->end_date)->get();
        if (!empty($employee_timesheet)) {
            foreach ($employee_timesheet as $timesheet) {
                $employee_timesheet = EmployeeTimesheet::find($timesheet->id);
                $employee_timesheet->timesheet_status_id =  $request->input('timesheet_status');
                $employee_timesheet->status_reason = $request->input('status_reason');
                $employee_timesheet->save();
            }
        }
        $timesheet_status = TimesheetStatus::find($request->timesheet_status);
        $employee_timesheet = EmployeeTimesheet::with('employee')->where('employee_id', '=', $request->emp_id)->where('start_date', '=', $request->start_date)->where('end_date', '=', $request->end_date)->first();
        $notification_message = ([
            'to'   => $employee_timesheet->employee_id,
            'from' => $employee_timesheet->supervisor_id,
            'timesheet_id' => $employee_timesheet->timesheet_id,
            'message' => 'Your' . " " . 'TimeSheet has been' . " " . $timesheet_status->status . " " . 'by Admin' . " " . ucfirst(Auth::user()->name),
            'approved_date_time' => $employee_timesheet->approved_date_time,
            'start_date' => $employee_timesheet->start_date,
            'end_date' => $employee_timesheet->end_date,
        ]);
        if ($timesheet_status->status == TimesheetStatus::APPROVED) {
            $employee_timesheet->notify(new ApprovedTimesheetByAdminNotification($notification_message));
        } elseif ($timesheet_status->status == TimesheetStatus::REJECTED) {
            $employee_timesheet->notify(new RejectedTimesheetByAdminNotification($notification_message));
        }
        return redirect()->route('employee-timesheet')->with('success', "Employee TimeSheet status has been updated successfully!!.");
    }

    public function getWeekDays(Request $request)
    {
        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $month = $request->month;
        $year = date('Y'); // Current year
        // $year = '2026';
        $start_date = "01-" . $month . "-$year";
        $start_date_day = date("l", strtotime($start_date));
        $start_day_index = array_search($start_date_day, $days);

        if ($start_day_index !== 0) {
            $weekStartDate = date("d-m-Y", strtotime($start_date . "+" . (7 - $start_day_index) . "days"));
        } else {
            $weekStartDate = date("d-m-Y", strtotime($start_date));
        }

        // Get the previous week's data (yesterday's week)
        $previousWeekStartDate = date("d-m-Y", strtotime($weekStartDate . "-1 week"));
        $previousWeekEndDate = date("d-m-Y", strtotime($previousWeekStartDate . "+6 days"));

        // Store the previous week's data
        $weeksData = [
            [
                'week_start_date' => $previousWeekStartDate,
                'week_end_date' => $previousWeekEndDate
            ]
        ];

        // Generate the current month's weeks data
        for ($weeks = 0; $weeks <= 5; $weeks++) {
            $week_end_date = date("d-m-Y", strtotime($weekStartDate . "+ 6 days"));
            $weeksData[] = [
                'week_start_date' => $weekStartDate,
                'week_end_date' => $week_end_date
            ];
            $weekStartDate = date("d-m-Y", strtotime($week_end_date . "+1 day"));

            if (date("m", strtotime($weekStartDate)) != $month) {
                break;
            }
        }


        // $holidays = [];
        // foreach(getHoliday() as $value)
        // {
        //     $holidays[] = ['holiday_date' => $value->holiday_date];
        // }
        return json_encode(array('data' => $weeksData));
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

    public function getHolidayDays(Request $request)
    {
        $year = $request->year;
        $month = ($request->month >= 10) ? $request->month : '0' . $request->month;
        if ($request->selectedWeek != null) {
            $selectedWeek = explode(',', $request->selectedWeek);
            $start_date = date("Y-m-d", strtotime($selectedWeek[0]));
            $end_date = date("Y-m-d", strtotime($selectedWeek[1]));
        } else {
            $start_date = $year . "-" . $month . "-01";
            $end_date =  date("Y-m-t", strtotime($start_date));
        }

        // dd( $start_date,$end_date);

        // $dates = [];
        // $start = strtotime($start_date);
        // $end = strtotime('+1 day', strtotime($end_date));

        /*$interval = 1;
        $out = '';
        $int = 24 * 60 * 60 * $interval;
        $count = 0;
        for ($i = $start; $i <= $end; $i += $int) {
            $dates[$count] = date('Y-m-d', $i);
            $i++;
            $count++;
        }*/

        //get holiday data
        $holidaysData = [];

        $holidays = Holiday::whereBetween("holiday_date", [$start_date, $end_date])->get();
        if ($holidays) {
            foreach ($holidays as $holiday) {
                $holidaysData[] = ['type' => 'holiday', 'name' => $holiday->name, 'holiday_date' => $holiday->holiday_date,];
            }
        }

        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employeeID = Employee::where('user_id', '=', Auth::user()->id)->value('id');
        } else {
            $employeeID = $request->employeeId;
        }

        // dd($start_date,$end_date);
        $employee_leaves = Leave::with('leaveType', 'time_sheet_status')
            ->where('employee_id', '=', $employeeID)
            ->whereDate('from', '>=', $start_date)
            ->whereDate('to', '<=', $end_date)->whereHas('time_sheet_status', function ($q) {
                $q->where('status', '=', TimesheetStatus::APPROVED);
            })->get();


        // $employeeProejcts =[];

        // $datesArray =[];
        // while($start_date <= $end_date ) {
        // $datesArray[$start_date] = 0;
        // $start_date = strtotime( '+1 day',$start_date );
        // }

        // dd($datesArray);
        if ($employee_leaves) {
            foreach ($employee_leaves as $leave) {

                $leaveFirstDate = $leave->from;

                $leaveStartDate = new DateTime($leaveFirstDate);
                $leaveEndDate = new DateTime($leave->to);
                $interval = $leaveStartDate->diff($leaveEndDate);
                if ($interval->invert == 0 && $interval->days > 0) {
                    for ($leavesLoop = 0; $leavesLoop <= $interval->days; $leavesLoop++) {
                        $holidaysData[] = ['type' => 'leave', 'name' => $leave->leaveType->type, 'holiday_date' => $leaveFirstDate, 'reason' => $leave->reason];
                        $leaveFirstDate = date("Y-m-d", strtotime($leaveFirstDate . " +1 day"));
                    }
                } else {
                    $holidaysData[] = ['type' => 'leave', 'name' => $leave->leaveType->type, 'holiday_date' => $leaveFirstDate, 'reason' => $leave->reason];
                }
            }
        }

        // $startDate = date('Y-m-d', strtotime($start_date));
        // $endDate = date('Y-m-d', strtotime($end_date));

        // Step 1: Setting the Start and End Dates
        $startDate = date_create($start_date);
        $endDate = date_create($end_date);

        // // Step 2: Defining the Date Interval
        $interval = new DateInterval('P1D');

        // // Step 3: Creating the Date Range
        $date_range = new DatePeriod($startDate, $interval, $endDate);

        $employee_projects = [];

        $emp_projects = EmployeeProject::with('projects')
            ->where('employee_id', '=', $employeeID)
            ->where(function ($query) use ($startDate, $end_date) {
                $query->whereBetween('start_date', [$startDate, $end_date]) // Projects starting within the range
                    ->orWhereBetween('end_date', [$startDate, $end_date]) // Projects ending within the range
                    ->orWhere(function ($query) use ($startDate, $end_date) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $end_date); // Projects that encompass the entire range
                    });
            })
            ->get();

        foreach ($emp_projects as $index => $Project) {
            $employee_projects[$index] = ["id" => $Project->projects->id, "name" => !empty($Project->projects->name) ? $Project->projects->name : ''];
        }




        // $emp_projects = EmployeeProject::with('projects')->where('employee_id', '=', $employeeID)
        //    ->WhereDate('start_date','<=', $startDate)
        //    ->whereDate('end_date', '>=', $end_date)->get();

        //     $employee_projects[] = ["id" => $emp_projects->id, "name" => !empty($emp_projects->projects->name) ? $emp_projects->projects->name:''];


        // // Step 4: Looping Through the Date Range
        // foreach ($date_range as $index => $date) {
        //     // dd($date->format('Y-m-d') ,$end_date);
        //     $emp_projects = EmployeeProject::with('projects')->where('employee_id', '=', $employeeID)
        //         ->whereDate('start_date', '=', $date->format('Y-m-d'))->whereDate('end_date', '>=', $end_date)
        //         ->orwhereDate('end_date','<=',$end_date)->first();

        //     if (!empty($emp_projects)) {
        //         $employee_projects[$index] = ["id" => $emp_projects->id, "name" => !empty($emp_projects->projects->name) ? $emp_projects->projects->name:''];
        //     }
        // }

        return json_encode(array('data' => $holidaysData, 'employee_projects' => $employee_projects));
    }


    public function getEmployeeProjects(Request $request)
    {
        $emp_projects = EmployeeProject::with('projects')->where('employee_id', '=', $request->employeeId)->get();
        return json_encode(array('data' => $emp_projects));
    }
}
