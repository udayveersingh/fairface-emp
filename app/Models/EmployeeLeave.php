<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    protected $fillable = [
        'leave_type_id','employee_id','supervisor_id','project_id','project_phase_id',
        'from_date','to_date','reason','timesheet_status_id','status_reason','approved_date_time'
     ];
}
