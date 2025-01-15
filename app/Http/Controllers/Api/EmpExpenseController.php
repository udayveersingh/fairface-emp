<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\TimesheetStatus;
use Illuminate\Http\Request;

class EmpExpenseController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employee = Employee::where('user_id', '=', $user->id)->first();
            if ($request->employee) {
                $employee_id = $request->employee;
            } else {
                $employee_id = $employee->id;
            }
            $timesheet_status = TimesheetStatus::where('status', TimesheetStatus::PENDING_APPROVED)->value('id');
            $date = $request->year . "-" . $request->month . "-01";
            $expense_format = (date("M-Y-d", strtotime($date)));
            $expenses =  Expense::create([
                'expense_id' => "Exp-" . $expense_format,
                'supervisor_id' => $request->supervisor_id,
                'project_id' => $request->project,
                'employee_id' => $employee_id,
                'expense_type_id' => $request->expense_type,
                'timesheet_status_id' => $timesheet_status,
                'expense_occurred_date' => $request->expense_occurred_date,
                'cost' => $request->expense_cost,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true, 'data' => 'expense has been created'], 201);
        }
    }
}
