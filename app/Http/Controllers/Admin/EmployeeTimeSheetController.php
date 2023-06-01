<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeTimesheet;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\TimesheetStatus;
use Illuminate\Http\Request;

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
        $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase', 'timesheet_status')->get();
        return view('backend.employee-timesheet', compact('title', 'employee_timesheets', 'employees', 'projects', 'project_phases', 'timesheet_statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'timesheet_id' => 'required|unique:employee_timesheets,timesheet_id,'. $request->id,
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
        return back()->with('success',$message);
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
        $employee_timesheet = EmployeeTimesheet::find($request->id);
        $employee_timesheet->timesheet_status_id =  $request->input('timesheet_status');
        $employee_timesheet->save();
        return back()->with('success', "Employee TimeSheet status has been updated successfully!!.");
    }
}
