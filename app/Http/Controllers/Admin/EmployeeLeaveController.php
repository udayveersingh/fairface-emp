<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\TimesheetStatus;

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
        $leaves = Leave::with('leaveType','employee','time_sheet_status')->get();
        $timesheet_statuses = TimesheetStatus::get(); 
        $leave_types = LeaveType::get();
        $employees = Employee::get();
        $projects = Project::get();
        $project_phases = ProjectPhase::get();
        return view('backend.employee-leaves',compact(
            'title','leaves','leave_types','employees','projects','timesheet_statuses','project_phases'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'employee'=>'required',
            'leave_type'=>'required',
            'from'=>'required',
            'to'=>'required',
            'reason'=>'required'
        ]);
        Leave::create([
            'leave_type_id'=>$request->leave_type,
            'employee_id'=>$request->employee,
            'supervisor_id' => $request->supervisor, 
            'project_id' => $request->project,
            'project_phase_id' => $request->project_phase_id,
            'from'=>$request->from,
            'to'=>$request->to,
            'reason'=>$request->reason,
            'timesheet_status_id' => $request->timesheet_status,
            'status_reason' => $request->status_reason,
            'approved_date_time' => $request->approved_date_time,
        ]);
        $notification = notify("Employee leave has been added");
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
        $leave = Leave::find($request->id);
        $leave->update([
            'leave_type_id'=>$request->leave_type,
            'employee_id'=>$request->employee,
            'supervisor_id' => $request->supervisor, 
            'project_id' => $request->project,
            'project_phase_id' => $request->project_phase_id,
            'from'=>$request->from,
            'to'=>$request->to,
            'reason'=>$request->reason,
            'status_reason' => $request->status_reason,
            'timesheet_status_id' => $request->timesheet_status,
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
        $this->validate($request,[
            'timesheet_status'=>'required',
        ]);
        $employee_leave_status = Leave::find($request->id);
        $employee_leave_status->timesheet_status_id =  $request->input('timesheet_status');
        $employee_leave_status->save();
        return back()->with('success', "Employee Leave TimeSheet status has been updated successfully!!.");

    }
}
