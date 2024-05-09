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
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReminderMail;
use App\Models\CompanyEmail;
use App\Models\EmployeeJob;
use App\Models\LeaveType;
use App\Models\UserLog;
use Illuminate\Support\Facades\DB;
use App\Notifications\DocumentExpireNotification;
use DocumentExpireNotification as GlobalDocumentExpireNotification;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $clients_count = Client::count();
        // Announcements
        $todayDate = Carbon::now()->toDateString();
        $annoucement_list = Annoucement::where('start_date', '<=', $todayDate)
            ->where('end_date', '>=', $todayDate)
            ->where('status', '=', 'active')->get();
        // Top Counter
        $employee_count = Employee::where('record_status', '=', 'active')->count();
        // $test1 =Carbon::now();
        // dd($test1);s
        $nextSixMonth = date('Y-m-d', strtotime('+6 month'));
        $passport_expiry_six_month = Employee::whereBetween("passport_expiry_date", [date('Y-m-d'), $nextSixMonth])->count();
        $visa_expiry_six_month = EmployeeVisa::whereBetween("visa_expiry_date", [date('Y-m-d'), $nextSixMonth])->count();
        $cos_expiry_six_month = EmployeeVisa::whereBetween("cos_expiry_date", [date('Y-m-d'), $nextSixMonth])->count();

        // timesheet
        $firstDayLastMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $lastDayLastMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $timesheet_approval_count = EmployeeTimesheet::select('*', DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"), DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->whereYear('created_at', date('Y'))->whereHas('timesheet_status', function ($q) {
            $q->where('status', '=', TimesheetStatus::APPROVED);
        })->groupBy('end_date')->latest()->get();

        // $timesheet_pending_app_count = EmployeeTimesheet::whereBetween('employee_timesheets.created_at', [$firstDayLastMonth, $lastDayLastMonth])->whereHas('timesheet_status', function ($q) {
        //     $q->where('status', '=', TimesheetStatus::PENDING_APPROVED);
        // })->count();

        $timesheet_pending_app_count = EmployeeTimesheet::select('*', DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"), DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->whereYear('created_at', date('Y'))->whereHas('timesheet_status', function ($q) {
            $q->where('status', '=', TimesheetStatus::PENDING_APPROVED);
        })->groupBy('end_date')->latest()->get();

        $timesheet_rejected_count = EmployeeTimesheet::select('*', DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"), DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->whereYear('created_at', date('Y'))->whereHas('timesheet_status', function ($q) {
            $q->where('status', '=', TimesheetStatus::REJECTED);
        })->groupBy('end_date')->latest()->get();

        // $timesheet_submitted_count = EmployeeTimesheet::join('timesheet_statuses', 'timesheet_statuses.id', '=', 'employee_timesheets.timesheet_status_id')
        //     ->whereBetween('employee_timesheets.created_at', [$firstDayLastMonth, $lastDayLastMonth])
        //     ->where('timesheet_statuses.status', '=', 'submitted')
        //     ->count();

        $timesheet_submitted_count = EmployeeTimesheet::select('*', DB::raw("GROUP_CONCAT(start_date SEPARATOR ',') as `start_date`"), DB::raw("GROUP_CONCAT(end_date SEPARATOR ',') as `end_date`"))->whereYear('created_at', date('Y'))->groupBy('end_date')->latest()->get();

        // Leaves

        $leaves_approval_count = Leave::whereYear('created_at', date('Y'))->whereHas('time_sheet_status', function ($q) {
            $q->where('status', '=', TimesheetStatus::APPROVED);
        })->count();

        $leaves_pending_app_count = Leave::whereYear('created_at', date('Y'))->whereHas('time_sheet_status', function ($q) {
            $q->where('status', '=', TimesheetStatus::PENDING_APPROVED);
        })->count();

        $leaves_rejected_count = Leave::whereYear('created_at', date('Y'))->whereHas('time_sheet_status', function ($q) {
            $q->where('status', '=', TimesheetStatus::REJECTED);
        })->count();

        $leaves_submitted_count = Leave::join('timesheet_statuses', 'timesheet_statuses.id', '=', 'leaves.timesheet_status_id')
            ->whereYear('leaves.created_at', date('Y'))->count();

        // employee list of passport expiry
        $passport_expiry_list = Employee::whereBetween("passport_expiry_date", [date('Y-m-d'), $nextSixMonth])->get();
        $visa_expiry_list = EmployeeVisa::join('employees', 'employees.id', '=', 'employee_visas.employee_id')
            ->whereBetween("visa_expiry_date", [date('Y-m-d'), $nextSixMonth])
            ->select(['employees.id', 'employees.employee_id', 'visa_expiry_date', 'employees.firstname', 'employees.lastname'])
            ->get();
        $cos_expiry_list = EmployeeVisa::join('employees', 'employees.id', '=', 'employee_visas.employee_id')
            ->whereBetween("cos_expiry_date", [date('Y-m-d'), $nextSixMonth])
            ->select(['employees.id', 'employees.employee_id', 'cos_expiry_date', 'employees.firstname', 'employees.lastname'])
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
        // Announcements
        $todayDate = Carbon::now()->toDateString();
        $annoucement_list = Annoucement::where('start_date', '<=', $todayDate)
            ->where('end_date', '>=', $todayDate)
            ->where('status', '=', 'active')->get();
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE || Auth::user()->role->name == Role::SUPERVISOR) {
            $employee = Employee::with('department', 'designation', 'country', 'branch')->where('user_id', '=', Auth::user()->id)->first();
            // Leaves List Latest 4
            $leaves_list = Leave::leftJoin('leave_types', 'leaves.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('timesheet_statuses', 'leaves.timesheet_status_id', '=', 'timesheet_statuses.id')
                ->where('leaves.employee_id', '=', $employee->id)
                ->orderBy('leaves.updated_at', 'DESC')
                ->select(['leaves.employee_id', 'leave_types.type', 'timesheet_statuses.status', 'leaves.created_at', 'leaves.from', 'leaves.to'])
                ->limit(4)
                ->get();
            // Recent Timesheet Latest 4
            $timesheet_list = EmployeeTimesheet::leftJoin('timesheet_statuses', 'employee_timesheets.timesheet_status_id', '=', 'timesheet_statuses.id')
                ->where('employee_timesheets.employee_id', '=', $employee->id)
                ->groupBy('employee_timesheets.timesheet_id')
                ->orderBy('employee_timesheets.updated_at', 'DESC')
                ->select(['employee_timesheets.employee_id', 'employee_timesheets.timesheet_id', 'timesheet_statuses.status', 'employee_timesheets.start_date', 'employee_timesheets.end_date', 'employee_timesheets.created_at'])
                ->limit(4)
                ->get();

            $currentYear = date('Y');
            $employee_leaves = Leave::where('employee_id', '=', $employee->id)->whereHas('time_sheet_status', function ($q) {
                $q->where('status', '=', TimesheetStatus::APPROVED);
            })->whereHas('leaveType', function ($q) {
                $q->where('type', '=', 'Annual Holiday');
            })->whereYear('created_at', $currentYear)->count();

            $employee_others_leaves = Leave::where('employee_id', '=', $employee->id)->whereHas('time_sheet_status', function ($q) {
                $q->where('status', '=', TimesheetStatus::APPROVED);
            })->whereHas('leaveType', function ($q) {
                $q->where('type', '!=', 'Annual Holiday');
            })->whereYear('created_at', $currentYear)->count();

            $total_annual_leaves = LeaveType::where('type', '=', 'Annual Holiday')->value('days');
            $remaining_leaves = $total_annual_leaves -  $employee_leaves;

            $timesheet_submitted_count = EmployeeTimesheet::where('employee_id', '=', $employee->id)->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonth()->toDateString())->whereHas('timesheet_status', function ($q) {
                $q->where('status', '=', TimesheetStatus::SUBMITTED);
            })->count();
            return view('includes.frontend.employee-dashboard', compact('title', 'annoucement_list', 'leaves_list', 'timesheet_list', 'employee', 'employee_leaves', 'timesheet_submitted_count', 'remaining_leaves', 'total_annual_leaves', 'employee_others_leaves'));
        }
    }

    public function sendReminderMail($type,$expiry_date,$emp_id)
    {
        $employee = Employee::find($emp_id);
        $employee_job = EmployeeJob::where('employee_id', '=', $employee->id)->first();
        $expiry_date = !empty($expiry_date) ? $expiry_date : '';
        $content = [
            'subject_type' => 'Your ' . $type . ' application is going to be expire soon!',
            'name' => "Dear " . $employee->firstname . " " . $employee->lastname . ",",
            'subject' => "This is a reminder to notify you that your " . $type . " will be expired on  " . $expiry_date . "." . "Pls contact HR to update your document.",
            'regards' => 'Regards,HR Team.'
        ];

        $carbon = Carbon::now();
        $date = date('Y-m-d', (strtotime($carbon)));
        $time = date('H:i:s', (strtotime($carbon)));

        if (!empty($employee_job)) {
            $company_email = new CompanyEmail();
            $company_email->to_id = $employee_job->id;
            $company_email->date = $date;
            $company_email->time = $time;
            $company_email->subject = $content['subject_type'];
            $company_email->body =  $content['subject'];
            $company_email->read_at = Carbon::now();
            $company_email->sent_by_user_id = Auth::user()->id;
            $employee->notify(new DocumentExpireNotification($employee, $content));
            $company_email->save();
            return back()->with('success', "Reminder email has been sent.");
        } else {
            return back()->with('success', "Please add employee job details");
        }
    }
}
