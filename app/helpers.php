<?php

use App\Models\EmployeeJob;
use App\Models\Holiday;
use App\Models\Leave;
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
        return User::where('id','!=',Auth::user()->id)->whereHas('role', function ($q) {
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

if(!function_exists('getHoliday'))
{
    function getHoliday()
    {
        return Holiday::get(); 
    }
}


if(!function_exists('getEmployeeJob'))
{
    function getEmployeeJob()
    {
        return EmployeeJob::with('employee')->get();
    }
}

if(!function_exists('getLeaveStatus'))
{
    function getLeaveStatus()
    {
        return TimesheetStatus::where('status','!=',TimesheetStatus::SUBMITTED)->get();
    }
}

//new leave notifiaction
if(!function_exists('getNewLeaveNotifiaction'))
{
    function getNewLeaveNotifiaction()
    {
        $new_leave_notifi=[];
        $new_leave_notifiactions =  DB::table('notifications')->where('type','=','App\Notifications\newLeaveNotification')->get();
        foreach($new_leave_notifiactions as $index=>$notification)
        {
           $new_leave_notifi[$index] = json_decode($notification->data);
        }
        return $new_leave_notifi;
        // $leave=[];
        // foreach($new_leave_notifi as $index=>$value){
        //  return $leave[$index] = Leave::with('leaveType','employee', 'time_sheet_status')->find($value->leave);
        // }
    }
}


//new notifiaction admin side 
if(!function_exists('getNewNotification')){
    function getNewNotification()
    {
         return DB::table('notifications')->get();
    }
}
