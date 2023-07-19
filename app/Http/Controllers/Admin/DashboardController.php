<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeLeave;
use App\Models\EmployeeProject;
use App\Models\Leave;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $clients_count = Client::count();
        $employee_count = Employee::count();
        return view('backend.dashboard', compact(
            'title',
            'clients_count',
            'employee_count'
        ));
    }

    public function EmployeeDashboard()
    {
        $title = 'Employee Dashboard';
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE || Auth::user()->role->name == Role::SUPERVISOR) {
            $employee = Employee::with('department', 'designation', 'country', 'branch')->where('user_id', '=', Auth::user()->id)->first();
            $employee_projects = EmployeeProject::where('employee_id', '=', $employee->id)->get();
            $employee_leaves = Leave::where('employee_id','=',$employee->id)->where('timesheet_status_id','!=',2)->get();
            return view('includes.frontend.employee-dashboard', compact('title', 'employee','employee_projects','employee_leaves'));
        }
    }
}
