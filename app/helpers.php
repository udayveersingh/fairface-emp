<?php

use App\Models\Employee;
use App\Models\EmployeeJob;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Models\TimesheetStatus;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('getSupervisor')) {
    function getSupervisor()
    {
        return User::where('id', '!=', Auth::user()->id)->whereHas('role', function ($q) {
            $q->where('name', '=', Role::SUPERVISOR);
        })->get();
    }
}

if (!function_exists('getEmployee')) {
    function getEmployee()
    {
        return Role::where('name', '!=', Role::SUPERADMIN)->get();
    }
}

if (!function_exists('getProject')) {
    function getProject()
    {
        return Project::get();
    }
}



if (!function_exists('getProjectPhase')) {
    function getProjectPhase()
    {
        return ProjectPhase::get();
    }
}


if (!function_exists('getMonth')) {
    function getMonth()
    {
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }
        return $months;
    }
}

if (!function_exists('getHoliday')) {
    function getHoliday()
    {
        return Holiday::get();
    }
}


if (!function_exists('getEmployeeJob')) {
    function getEmployeeJob()
    {
        return EmployeeJob::with('employee')->get();
    }
}

if (!function_exists('getLeaveStatus')) {
    function getLeaveStatus()
    {
        return TimesheetStatus::where('status', '!=', TimesheetStatus::SUBMITTED)->get();
    }
}

//new notifiaction admin side 
if (!function_exists('getNewNotification')) {
    function getNewNotification()
    {
        $user = User::where('id', '=', Auth::user()->id)->whereHas('role', function ($q) {
            $q->where('name', '=', Role::SUPERADMIN);
        })->first();
        return DB::table('notifications')->whereNull('read_at')->where('data->user_id','!=',$user->id)->get();
    }
}


//get new notification employee side 
if (!function_exists('getEmployeeNewNotification')) {
    function getEmployeeNewNotification()
    {
        $user = User::where('id', '=', Auth::user()->id)->whereHas('role', function ($q) {
            $q->where('name', '!=', Role::SUPERADMIN);
        })->first();
          return DB::table('notifications')->whereNull('read_at')->where('data->user_id','!=',$user->id)->get();
    }
}


//new leave notifiaction
if (!function_exists('getNewLeaveNotifiaction')) {
    function getNewLeaveNotifiaction()
    {
        $new_leave_notifi = [];
        $new_leave_notifiactions =  DB::table('notifications')->where('type', '=', 'App\Notifications\newLeaveNotification')->whereNull('read_at')->get();
        foreach ($new_leave_notifiactions as $index => $notification) {
            $new_leave_notifi[$index] = json_decode($notification->data);
        }
        return $new_leave_notifi;
        // $leave=[];
        // foreach($new_leave_notifi as $index=>$value){
        //  return $leave[$index] = Leave::with('leaveType','employee', 'time_sheet_status')->find($value->leave);
        // }
    }
}

//notification of leave approved by admin
if (!function_exists('getEmployeeLeaveApprovedNotification')) {
    function getEmployeeLeaveApprovedNotification()
    {
        $employee = Employee::where('user_id','=',Auth::user()->id)->first();
        $leave_approved_notifi = [];
        $leave_approved_notifiactions =  DB::table('notifications')->where('type', '=', 'App\Notifications\EmployeeLeaveApprovedNotification')->whereNull('read_at')->where('data->to', $employee->id)->get();
        foreach ($leave_approved_notifiactions as $index => $notification) {
            $leave_approved_notifi[$index] = json_decode($notification->data);
        }
        return $leave_approved_notifi;
    }
}

//notification of leave rejected by admin
if (!function_exists('getRejectedLeaveByAdminNotification')) {
    function getRejectedLeaveByAdminNotification()
    {
        $employee = Employee::where('user_id','=',Auth::user()->id)->first();
        $leave_rejected_notifi = [];
        $leave_rejected_notifications =  DB::table('notifications')->where('type', '=', 'App\Notifications\RejectedLeaveByAdminNotification')->whereNull('read_at')->where('data->to', $employee->id)->get();
        foreach ($leave_rejected_notifications as $index => $notification) {
            $leave_rejected_notifi[$index] = json_decode($notification->data);
        }
        return $leave_rejected_notifi;
    }
}

//new leave notifiaction
if (!function_exists('sendNewTimeSheetNotifiaction')) {
    function sendNewTimeSheetNotifiaction()
    {
        $new_timesheet_notifi = [];
        $new_timesheet_notifications =  DB::table('notifications')->where('type', '=', 'App\Notifications\SendTimesheetNotificationToAdmin')->whereNull('read_at')->get();
        foreach ($new_timesheet_notifications as $index => $notification) {
            $new_timesheet_notifi[$index] = json_decode($notification->data);
        }
        return $new_timesheet_notifi;
    }
}


//notification of Timesheet approved by admin
if (!function_exists('getEmployeeTimesheetApprovedNotification')) {
    function getEmployeeTimesheetApprovedNotification()
    {
        $employee = Employee::where('user_id','=',Auth::user()->id)->first();
        $leave_approved_notifi = [];
        $leave_approved_notifiactions =  DB::table('notifications')->where('type', '=', 'App\Notifications\ApprovedTimesheetByAdminNotification')->whereNull('read_at')->where('data->to', $employee->id)->get();
        foreach ($leave_approved_notifiactions as $index => $notification) {
            $leave_approved_notifi[$index] = json_decode($notification->data);
        }
        return $leave_approved_notifi;
    }
}

//notification of Timesheet Rejected by admin
if (!function_exists('getEmployeeTimesheetRejectedNotification')) {
    function getEmployeeTimesheetRejectedNotification()
    {
        $employee = Employee::where('user_id','=',Auth::user()->id)->first();
        $leave_approved_notifi = [];
        $leave_approved_notifiactions =  DB::table('notifications')->where('type', '=', 'App\Notifications\RejectedTimesheetByAdminNotification')->whereNull('read_at')->where('data->to', $employee->id)->get();
        foreach ($leave_approved_notifiactions as $index => $notification) {
            $leave_approved_notifi[$index] = json_decode($notification->data);
        }
        return $leave_approved_notifi;
    }
}



