<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeProject;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\LeaveType;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\TimesheetStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'expenses';
        $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
        $expenses = Expense::with('expensetype', 'employee', 'project', 'projectphase')->where('employee_id','=',$employee->id)->groupBy('expense_id')->latest()->get();
        // dd($expenses);
        $timesheet_statuses = TimesheetStatus::get();
        $expensive_type = ExpenseType::get();
        $projects = EmployeeProject::with('projects')->where('employee_id','=',$employee->id)->get();
        return view('backend.employee-expense.expenses', compact(
            'title',
            'expensive_type',
            'expenses',
            'timesheet_statuses',
            'employee',
            'projects',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $timesheet_status = TimesheetStatus::where('status', TimesheetStatus::PENDING_APPROVED)->value('id');
        $date = $request->year . "-" . $request->month . "-01";
        $expense_format = (date("M-Y-d", strtotime($date)));
        Expense::create([
            'expense_id' => "Exp-" . $expense_format,
            'supervisor_id' => $request->supervisor,
            'project_id' => $request->project,
            'employee_id' => $request->employee,
            'expense_type_id' => $request->expense_type,
            'timesheet_status_id' => $timesheet_status,
            'expense_occurred_date' => $request->occurred_date,
            'cost' => $request->expense_cost,
            'description' => $request->description,
        ]);
        $notification = notify('expense has been created');
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $title = "Expense details";
       $expenses = Expense::with('expensetype', 'employee', 'project')->find($id);
       return view('backend.employee-expense.expense-view',compact('expenses','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
