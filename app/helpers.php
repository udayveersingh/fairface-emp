<?php

use App\Models\Role;
use App\Models\User;

if (!function_exists('getSupervisor')) {
    function getSupervisor()
    {
        return User::whereHas('role', function ($q) {
            $q->where('name', '=', Role::SUPERVISOR);
        })->get();
    }
}
