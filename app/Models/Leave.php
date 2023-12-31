<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Leave extends Model
{
    use Notifiable;
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'leave_type_id','employee_id','from','to','reason','timesheet_status_id','supervisor_id','project_id','project_phase_id','status_reason','approved_date_time','no_of_days'
    ];

    public function leaveType(){
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function time_sheet_status(){
        return $this->belongsTo(TimesheetStatus::class,'timesheet_status_id','id');
    }
}
