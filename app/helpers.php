<?php

use App\Models\Holiday;
use App\Models\ProjectPhase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;

if (!function_exists('getSupervisor')) {
    function getSupervisor()
    {
        return User::whereHas('role', function ($q) {
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


