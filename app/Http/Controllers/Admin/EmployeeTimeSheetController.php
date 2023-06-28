<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeTimesheet;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Settings\CompanySettings;
use App\Models\TimesheetStatus;
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
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $employee_timesheets = EmployeeTimesheet::with('project', 'projectphase')->where('employee_id', '=', $employee->id)->first();
        }
        return view('backend.employee-timesheet.employee-timesheet-view', compact('title', 'employee', 'settings', 'employee_timesheets'));
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
            $start_end_datetime = EmployeeTimesheet::get();
            $employee_timesheets = DB::table('employee_timesheets')->select(DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"),DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->groupBy('end_date')->get();
            // dd($employee_timesheets);

            // $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase', 'timesheet_status')->where('employee_id', '=', $employee->id)->get();
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
        $start_end_date = explode(" ", $request->daterange);
        $start_date =  date('Y-m-d', strtotime($start_end_date[0]));
        $end_date = date('Y-m-d', strtotime($start_end_date[2]));
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $this->validate($request, [
                'calender_date.*' => 'required',
                'calender_day.*' => 'required',
                'start_time.*' => 'nullable',
                'end_time.*' => 'nullable',
                'hours.*' => 'nullable',
            ]);
            $timesheet_status = TimesheetStatus::where('status', TimesheetStatus::PENDING_APPROVED)->first();
            $calender_date = $request->input('calender_date');
            $calender_day = $request->input('calender_day');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
            $hours = $request->input('hours');
            foreach ($start_time as $key => $value) {
                if (!empty($hours[$key]) == "full_day") {
                    $total_hours_worked = "8 hours";
                } elseif (!empty($hours[$key]) == "half_day") {
                    $total_hours_worked = "4 hours";
                } else {
                    $total_hours_worked = "";
                }
                $employee_timesheet = EmployeeTimesheet::where('calender_date', '=', $calender_date[$key])->first();
                if (empty($employee_timesheet)) {
                    $emp_timesheet = new EmployeeTimesheet();
                    $emp_timesheet->employee_id = $request->input('employee_id');
                    $emp_timesheet->calender_day = $calender_day[$key];
                    $emp_timesheet->calender_date = $calender_date[$key];
                    $emp_timesheet->from_time = $value;
                    $emp_timesheet->to_time = $end_time[$key];
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
}
