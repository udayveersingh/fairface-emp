<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\ExpenseType;
use App\Models\LeaveType;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\TimesheetStatus;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'expenses';
        $expenses = Expense::with('expensetype','employee','project','projectphase')->get();
        // dd($expenses);
        $timesheet_statuses = TimesheetStatus::get();
        $expensive_type = ExpenseType::get();
        $leave_types = LeaveType::get();
        $employees = Employee::get();
        $projects = Project::get();
        $project_phases = ProjectPhase::get();
        return view('backend.expenses', compact(
            'title',
            'expensive_type',
            'expenses',
            'timesheet_statuses',
            'leave_types',
            'employees',
            'projects',
            'project_phases'
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
        $this->validate($request, [
            'expense_type' => 'required',
            'employee' => 'required',
            'supervisor' => 'required',
            'project' => 'required',
            'project_phase_id' => 'required',
            'timesheet_status' => 'required'
        ]);
        // $file_name = null;
        // if ($request->hasFile('file')) {
        //     $file_name = time() . '.' . $request->file->extension();
        //     $request->file->move(public_path('storage/expenses'), $file_name);
        // }
        Expense::create([
            'expense_type_id' => $request->expense_type,
            'employee_id' =>$request->employee,
            'supervisor_id' => $request->supervisor,
            'project_id' => $request->project,
            'project_phase_id' => $request->project_phase_id,
            'timesheet_status_id' => $request->timesheet_status,
            'status_reason' => $request->status_reason,
            'approved_date_time' => $request->approved_date_time,
        ]);
        $notification = notify('expense has been created');
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
        $this->validate($request, [
            'expense_type' => 'required',
            'employee' => 'required',
            'supervisor' => 'required',
            'project' => 'required',
            'project_phase_id' => 'required',
            'timesheet_status' => 'required'
        ]);
        $expense = Expense::findOrFail($request->id);
        $file_name = $expense->file;
        if ($request->hasFile('file')) {
            $file_name = time() . '.' . $request->file->extension();
            $request->file->move(public_path('storage/expenses'), $file_name);
        }
        $expense->update([
            'expense_type_id' => $request->expense_type,
            'employee_id' =>$request->employee,
            'supervisor_id' => $request->supervisor,
            'project_id' => $request->project,
            'project_phase_id' => $request->project_phase_id,
            'timesheet_status_id' => $request->timesheet_status,
            'status_reason' => $request->status_reason,
            'approved_date_time' => $request->approved_date_time,
        ]);
        $notification = notify('expense has been updated');
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
        Expense::findOrFail($request->id)->delete();
        $notification = notify('expense has been deleted');
        return back()->with($notification);
    }
}
