<?php

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

if (!function_exists('getWeekDays')) {
    function getWeekDays()
    {
        $date_days = "";
        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        $month = "03";
        $start_date = "01-" . $month . "-2023";
        $start_date_day = date("l", strtotime($start_date));

        $week_number = 4;


        $start_day_index = array_search($start_date_day, $days);
        // echo $start_day_index; die;
        if ($start_day_index !== 0) {
            $nextWeekDate = date("d-m-Y", strtotime($start_date . "+" . (7 - $start_day_index) . "days"));
            $weekStartDate = date("d-m-Y", strtotime($nextWeekDate . "+" . (($week_number - 1) * 7) . " days"));
            $weekEndDate = date("d-m-Y", strtotime($weekStartDate . "+ 6 days"));
            echo $weekStartDate . " and " . $weekEndDate;
            die;
        }
    }
}

