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
use App\Models\Annoucement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $clients_count = Client::count();
        // Announcements
        $annoucement_list =Annoucement::where('status','=','active')->get();
        // Top Counter
        $employee_count = Employee::where('record_status','=','active')->count();
        // $test1 =Carbon::now();
        // dd($test1);s
        $nextSixMonth = date('Y-m-d', strtotime('+6 month'));
        $passport_expiry_six_month = Employee::whereBetween("passport_expiry_date",[date('Y-m-d'), $nextSixMonth])->count();
        $visa_expiry_six_month = EmployeeVisa::whereBetween("visa_expiry_date",[date('Y-m-d'), $nextSixMonth])->count();
        $cos_expiry_six_month = EmployeeVisa::whereBetween("cos_expiry_date",[date('Y-m-d'), $nextSixMonth])->count();
        
        // timesheet
        $firstDayLastMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $lastDayLastMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();
        
        $timesheet_approval_count = EmployeeTimesheet::whereBetween('employee_timesheets.created_at', [$firstDayLastMonth,$lastDayLastMonth])->whereHas('timesheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::APPROVED);
        })->count();

        $timesheet_pending_app_count = EmployeeTimesheet::whereBetween('employee_timesheets.created_at', [$firstDayLastMonth,$lastDayLastMonth])->whereHas('timesheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::PENDING_APPROVED);
        })->count();

        $timesheet_rejected_count = EmployeeTimesheet::whereBetween('employee_timesheets.created_at', [$firstDayLastMonth,$lastDayLastMonth])->whereHas('timesheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::REJECTED);
        })->count();

        $timesheet_submitted_count = EmployeeTimesheet::join('timesheet_statuses','timesheet_statuses.id','=','employee_timesheets.timesheet_status_id')
                                                        ->whereBetween('employee_timesheets.created_at', [$firstDayLastMonth,$lastDayLastMonth])
                                                        ->where('timesheet_statuses.status','=','submitted')
                                                        ->count();
        // Leaves
               
        $leaves_approval_count = Leave::whereBetween('leaves.created_at', [$firstDayLastMonth,$lastDayLastMonth])->whereHas('time_sheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::APPROVED);
        })->count();

        $leaves_pending_app_count = Leave::whereBetween('leaves.created_at', [$firstDayLastMonth,$lastDayLastMonth])->whereHas('time_sheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::PENDING_APPROVED);
        })->count();

        $leaves_rejected_count = Leave::whereBetween('leaves.created_at', [$firstDayLastMonth,$lastDayLastMonth])->whereHas('time_sheet_status', function ($q) {
            $q->where('status', '=',TimesheetStatus::REJECTED);
        })->count();

        $leaves_submitted_count = Leave::join('timesheet_statuses','timesheet_statuses.id','=','leaves.timesheet_status_id')
                                                        ->whereBetween('leaves.created_at', [$firstDayLastMonth,$lastDayLastMonth])
                                                        ->where('timesheet_statuses.status','=','submitted')
                                                        ->count();
        
        // employee list of passport expiry
        $passport_expiry_list = Employee::whereBetween("passport_expiry_date",[date('Y-m-d'), $nextSixMonth])->get();
        $visa_expiry_list = EmployeeVisa::join('employees','employees.id','=','employee_visas.employee_id')
                                          ->whereBetween("visa_expiry_date",[date('Y-m-d'), $nextSixMonth])
                                          ->select(['employees.employee_id','visa_expiry_date','employees.firstname','employees.lastname'])
                                          ->get();
        $cos_expiry_list = EmployeeVisa::join('employees','employees.id','=','employee_visas.employee_id')
                                          ->whereBetween("cos_expiry_date",[date('Y-m-d'), $nextSixMonth])
                                          ->select(['employees.employee_id','cos_expiry_date','employees.firstname','employees.lastname'])
                                          ->get();
        
        return view('backend.dashboard', compact(
            'title',
            'annoucement_list',
            'clients_count',
            'employee_count',
            'timesheet_approval_count',
            'timesheet_pending_app_count',
            'timesheet_rejected_count',
            'timesheet_submitted_count',
            'passport_expiry_six_month',
            'visa_expiry_six_month',
            'cos_expiry_six_month',
            'leaves_approval_count',
            'leaves_pending_app_count',
            'leaves_rejected_count',
            'leaves_submitted_count',
            'passport_expiry_list',
            'visa_expiry_list',
            'cos_expiry_list',
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
