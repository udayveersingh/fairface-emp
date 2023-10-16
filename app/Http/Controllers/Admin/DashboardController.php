<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeLeave;
use App\Models\EmployeeProject;
use App\Models\EmployeeTimesheet;
use App\Models\EmployeeVisa;
use App\Models\Leave;
use App\Models\Project;
use App\Models\Role;
use App\Models\TimesheetStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $clients_count = Client::count();
        $employee_count = Employee::where('record_status','=','active')->count();
        // $test1 =Carbon::now();
        // dd($test1);s
        $nextSixMonth = date('Y-m-d', strtotime('+6 month'));
        $passport_expiry_six_month = Employee::where("passport_expiry_date",">", $nextSixMonth)->count();
        $visa_expiry_six_month = EmployeeVisa::groupBy('employee_id')->get();
        // dd($visa_expiry_six_month);
        $project_count =Project::count();
        $timesheet_approval_count = EmployeeTimesheet::whereHas('timesheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::APPROVED);
        })->count();

        $timesheet_pending_app_count = EmployeeTimesheet::whereHas('timesheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::PENDING_APPROVED);
        })->count();

        $timesheet_rejected_count = EmployeeTimesheet::whereHas('timesheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::REJECTED);
        })->count();

        $timesheet_submitted_count = EmployeeTimesheet::where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->whereHas('timesheet_status',function ($q){
            $q->where('status','=',TimesheetStatus::SUBMITTED);
        })->count();
        
        return view('backend.dashboard', compact(
            'title',
            'clients_count',
            'employee_count',
            'project_count',
            'timesheet_approval_count',
            'timesheet_pending_app_count',
            'timesheet_rejected_count',
            'timesheet_submitted_count',
            'passport_expiry_six_month',
            'visa_expiry_six_month',
        ));
    }

    public function EmployeeDashboard()
    {
        $title = 'Employee Dashboard';
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE || Auth::user()->role->name == Role::SUPERVISOR) {
            $employee = Employee::with('department', 'designation', 'country', 'branch')->where('user_id', '=', Auth::user()->id)->first();
            $employee_projects = EmployeeProject::where('employee_id', '=', $employee->id)->get();
            $employee_leaves = Leave::where('employee_id','=',$employee->id)->where('timesheet_status_id','!=',2)->get();
            $timesheet_submitted_count = EmployeeTimesheet::where('employee_id','=',$employee->id)->where( 'created_at', '>=', Carbon::now()->startOfMonth()->subMonth()->toDateString())->whereHas('timesheet_status', function ($q) {
                $q->where('status', '=',TimesheetStatus::SUBMITTED);
            })->count();
            return view('includes.frontend.employee-dashboard', compact('title', 'employee','employee_projects','employee_leaves','timesheet_submitted_count'));
        }
    }
}
