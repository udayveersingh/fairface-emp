<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Models\TimesheetStatus;
use App\Notifications\EmployeeLeaveApprovedNotification;
use App\Notifications\NewLeaveNotification;
use App\Notifications\RejectedLeaveByAdminNotification;
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
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $leaves = Leave::with('leaveType', 'employee', 'time_sheet_status')->where('employee_id', '=', $employee->id)->orderBy('id', 'desc')->get();
        } else {
            $leaves = Leave::with('leaveType', 'employee', 'time_sheet_status')->orderBy('id', 'desc')->get();
        }
        $timesheet_statuses = TimesheetStatus::get();
        $leave_types = LeaveType::get();
        $employees = Employee::get();
        $projects = Project::get();
        $project_phases = ProjectPhase::get();
        return view('backend.employee-leaves', compact('title','leaves','leave_types','employees','projects','timesheet_statuses','project_phases'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $employee_id = $employee->id;
            $timesheet_status = TimesheetStatus::where('status','pending approval')->first();
            $timesheet_status_id =  $timesheet_status->id;
            $employee_field = 'nullable';
            $timesheet_status_field = 'nullable';
        } else {
            $employee_id = $request->employee;
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
      $leave = Leave::create([
            'leave_type_id' => $request->leave_type,
            'employee_id' => $employee_id,
            'supervisor_id' => $request->supervisor,
            'project_id' => $request->project,
            'project_phase_id' => $request->project_phase_id,
            'from' => $request->from,
            'to' => $request->to,
            'reason' => $request->reason,
            'timesheet_status_id' =>  $timesheet_status_id,
            'status_reason' => $request->status_reason,
            'approved_date_time' => $request->approved_date_time,
        ]);
        $leave->notify(new NewLeaveNotification($leave)); 
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
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $employee_id = $employee->id;
            $timesheet_status = TimesheetStatus::where('status','pending approval')->first();
            $timesheet_status_id =  $timesheet_status->id;
            $employee_field = 'nullable';
            $timesheet_status_field = 'nullable';
        } else {
            $employee_id = $request->employee;
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
            'timesheet_status' => $timesheet_status_field,
        ]);
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
        $this->validate($request, [
            'timesheet_status' => 'required',
        ]);
        $date = date('Y-m-d');
        $employee_leave_status = Leave::with('leaveType','time_sheet_status')->find($request->id);
        $employee_leave_status->timesheet_status_id =  $request->input('timesheet_status');
        $employee_leave_status->status_reason = $request->input('status_reason');
        $employee_leave_status->approved_date_time =  $date;
        //  $timesheet_status = TimesheetStatus::find($employee_leave_status->time_sheet_status->id);
        //  if($timesheet_status->status == TimesheetStatus::APPROVED){
            //      $employee_leave_status->notify(new EmployeeLeaveApprovedNotification($leave_status)); 
            //  }elseif($timesheet_status->status == TimesheetStatus::REJECTED){
                //     $employee_leave_status->notify(new RejectedLeaveByAdminNotification($leave_status));
                //  }            
                $employee_leave_status->save();
                $leave_status = ([
                         'to'   => $employee_leave_status->employee_id,
                         'from' => $employee_leave_status->supervisor_id,
                         'leave_id' => $employee_leave_status->id,
                         'message' => 'your'." ".$employee_leave_status->leaveType->type." ".'has been'." ".'approved by'." ". ucfirst(Auth::user()->name),
                         'type' => $employee_leave_status->leaveType->type,
                         'approved_date_time' => $employee_leave_status->approved_date_time
                         ]);
                //  $timesheet_status = TimesheetStatus::find($employee_leave_status->time_sheet_status->id);
                //  if($timesheet_status->status == TimesheetStatus::APPROVED){
                     $employee_leave_status->notify(new EmployeeLeaveApprovedNotification($leave_status)); 
                //  }
                //  elseif($timesheet_status->status == TimesheetStatus::REJECTED){
                //     $employee_leave_status->notify(new RejectedLeaveByAdminNotification($leave_status));
                //  }     
        return back()->with('success', "Employee Leave TimeSheet status has been updated successfully!!.");
    }
}
