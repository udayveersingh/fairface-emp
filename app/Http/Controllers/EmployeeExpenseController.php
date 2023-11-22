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
// Use DB;
use Illuminate\Support\Facades\DB;

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
        $expense_ids = Expense::groupBy('expense_id')->where('employee_id','=',$employee->id)->orderBy('expense_id', 'DESC')->get();
        //dd($expenses);
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
            'expense_ids'
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
    public function show($expense_id,$emp_id)
    {
        // dd($expense_id);
       $title = "Expense details";
    //    $expenses = Expense::with('expensetype', 'employee', 'project')->where('expense_id','=',$expense_id)->get();
    //    dd($expenses);
       $expenses = DB::table('expenses')
                       ->leftJoin('employees', 'employees.id', '=', 'expenses.employee_id')
                       ->leftJoin('projects', 'projects.id', '=', 'expenses.project_id')
                       ->leftJoin('expense_types','expense_types.id','=','expenses.expense_type_id')
                       ->where('expenses.expense_id', '=', $expense_id)
                       ->get();
    //    dd($expenses);
       return view('backend.employee-expense.expense-view',compact('expenses','title'));
    }

    public function getExpenseId(Request $request)
    {
        // $expense_date = $request->expense_id;
        $expense_date=  str_replace("Exp-","", $request->expense_id);
        $year = (date("Y", strtotime( $expense_date)));
        $months = (date("m", strtotime( $expense_date)));
        if($months < 10 ){
           $month = str_replace("0","", $months);
        }else{
            $month =  $months;
        }

        return json_encode(array('expense_id' => $request->expense_id, 'year' => $year , 'month' => $month));
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
