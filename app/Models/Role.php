<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = "roles";

    protected $fillable = ['name', 'guard_name'];

    const EMPLOYEE = 'Employee';
    const SUPERADMIN = 'Super admin';
}
