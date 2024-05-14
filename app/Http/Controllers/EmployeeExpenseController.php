<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeProject;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\LeaveType;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Models\TimesheetStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
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
        $employee = "";
        $employees = "";
        $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $expenses = Expense::with('expensetype', 'employee', 'project', 'projectphase')->where('employee_id', '=', $employee->id)->groupBy('expense_id')->orderBy('expense_id', 'ASC')->get();
            $expense_ids = Expense::groupBy('expense_id')->where('employee_id', '=', $employee->id)->orderBy('expense_id', 'DESC')->get();
            $projects = EmployeeProject::with('projects')->where('employee_id','=', $employee->id)->get();
        } elseif (Auth::user()->role->name == Role::ADMIN) {
            $expenses = Expense::with('expensetype', 'employee', 'project','projectphase')->Orwhere('employee_id', '=', $employee->id)
                ->OrWhere('supervisor_id','=',$employee->id)->groupBy(['expense_id','employee_id'])->orderBy('expense_id', 'ASC')->get();
            $expense_ids = Expense::groupBy('expense_id')->where('employee_id', '=', $employee->id)->orderBy('expense_id', 'DESC')->get();
            $projects = EmployeeProject::with('projects')->where('employee_id', '=', $employee->id)->get();
        } else {
            $expenses = Expense::with('expensetype','employee','project','projectphase')->groupBy(['expense_id','employee_id'])->latest()->get();
            $expense_ids = Expense::groupBy('expense_id')->orderBy('expense_id', 'DESC')->get();
            $projects = EmployeeProject::with('projects')->get();
            $employees = Employee::get();
        }
        $timesheet_statuses = TimesheetStatus::get();
        $expensive_type = ExpenseType::get();
        return view('backend.employee-expense.expenses', compact(
            'title',
            'expensive_type',
            'expenses',
            'timesheet_statuses',
            'employee',
            'employees',
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
        $this->validate($request, [
            'expense_cost' => 'required',
            'expenses_id'  => 'required',
            'expense_type' => 'required',
        ]);
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
    public function show($expense_id, $emp_id)
    {
        // dd($expense_id);
        $title = "Expense details";
        //    $expenses = Expense::with('expensetype', 'employee', 'project')->where('expense_id','=',$expense_id)->get();
        //    dd($expenses);
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $expense_ids = Expense::groupBy('expense_id')->where('employee_id', '=', $employee->id)->orderBy('expense_id', 'DESC')->get();
            $projects = EmployeeProject::with('projects')->where('employee_id', '=', $employee->id)->get();
            $expenses = DB::table('expenses')->select('expenses.*', 'employees.firstname', 'employees.lastname', 'projects.name', 'expense_types.type')
                ->leftJoin('employees', 'employees.id', '=', 'expenses.employee_id')
                ->leftJoin('projects', 'projects.id', '=', 'expenses.project_id')
                ->leftJoin('expense_types', 'expense_types.id', '=', 'expenses.expense_type_id')
                ->where('expenses.expense_id', '=', $expense_id)->where('expenses.employee_id', '=', $emp_id)
                ->get();
            return view('backend.employee-expense.expense-view', compact('expenses', 'title', 'expense_ids', 'projects', 'employee', 'expense_id', 'emp_id'));
        } else {
            $expenses = DB::table('expenses')->select('expenses.*', 'employees.firstname', 'employees.lastname', 'projects.name', 'expense_types.type')
                ->leftJoin('employees', 'employees.id', '=', 'expenses.employee_id')
                ->leftJoin('projects', 'projects.id', '=', 'expenses.project_id')
                ->leftJoin('expense_types', 'expense_types.id', '=', 'expenses.expense_type_id')
                ->where('expenses.expense_id', '=', $expense_id)->where('expenses.employee_id', '=', $emp_id)
                ->get();
            $expense_ids = Expense::groupBy('expense_id')->orderBy('expense_id', 'DESC')->get();
            $projects = EmployeeProject::with('projects')->get();
            $employees = Employee::where('record_status', '=', 'active')->get();
            //    dd($expenses);
            return view('backend.employee-expense.expense-view', compact('expenses', 'title', 'expense_ids', 'projects', 'employees', 'expense_id', 'emp_id'));
        }
    }

    public function getExpenseId(Request $request)
    {
        // dd($request->all());
        // $expense_id = $request->expense_id;

        $expense_date =  str_replace("Exp-", "", $request->expense_id);
        $year = (date("Y", strtotime($expense_date)));
        $months = (date("m", strtotime($expense_date)));
        if ($months < 10) {
            $month = str_replace("0", "", $months);
        } else {
            $month =  $months;
        }

        return json_encode(array('expense_id' => $request->expense_id, 'year' => $year, 'month' => $month));
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
    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'expense_cost' => 'required',
            'expenses_id'  => 'required',
            'expense_type' => 'required',
        ]);
        $timesheet_status = TimesheetStatus::where('status', TimesheetStatus::PENDING_APPROVED)->value('id');
        $date = $request->year . "-" . $request->month . "-01";
        $expense_format = (date("M-Y-d", strtotime($date)));
        $expense = Expense::find($request->id);
        $expense->update([
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
        $notification = notify('expense has been updated');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Expense::findOrFail($request->id)->delete();
        $notification = notify('expense has been deleted');
        return back()->with($notification);
    }


    public function ExpensePdf($expense_id, $emp_id)
    {
        $title = "Expense details";
        $expenses = DB::table('expenses')->select('expenses.*', 'employees.firstname', 'employees.lastname', 'projects.name', 'expense_types.type')
            ->leftJoin('employees', 'employees.id', '=', 'expenses.employee_id')
            ->leftJoin('projects', 'projects.id', '=', 'expenses.project_id')
            ->leftJoin('expense_types', 'expense_types.id', '=', 'expenses.expense_type_id')
            ->where('expenses.expense_id', '=', $expense_id)->where('expenses.employee_id','=',$emp_id)
            ->get();
        try {
            $mpdf = new \Mpdf\Mpdf();
            $content = view('backend.employee-expense.expense-print-pdf', compact('expenses', 'title'))->render();
            $mpdf->SetTitle('Employee Expense Detail');
            $mpdf->WriteHTML($content);
            $mpdf->Output('employeeExpenseDetail.pdf', 'I');
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function ExpenseStatusUpdate(Request $request)
    {
        // dd($request->all());
        $timesheet_status = TimesheetStatus::find($request->expense_status);
        $status_reason = '';
        if (!empty($timesheet_status->status) && $timesheet_status->status == TimesheetStatus::REJECTED) {
            $status_reason = 'required';
        }
        $this->validate($request, [
            'expense_status' => 'required',
            'status_reason' =>  $status_reason,
        ]);
        $emp_expense = Expense::find($request->id);
        if (!empty($emp_expense)) {
            $emp_expense->timesheet_status_id =  $request->input('expense_status');
            $emp_expense->status_reason = $request->input('status_reason');
            $emp_expense->approved_date_time = date('Y-m-d');
            $emp_expense->save();
        }
        $notification = notify('expense status has been updated');
        return back()->with($notification);
    }
}
