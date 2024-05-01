<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmployeeTimesheet extends Model
{
    use Notifiable;
    protected $fillable = [
        'timesheet_id','employee_id','supervisor_id','project_id','project_phase_id','calender_day','calender_date','from_time','to_time','total_hours_worked','notes','timesheet_status_id','status_reason','approved_date_time','start_date','end_date'
     ];

     public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function projectphase(){
        return $this->belongsTo(ProjectPhase::class,'project_phase_id','id');
    }

    public function timesheet_status(){
        return $this->belongsTo(TimesheetStatus::class,'timesheet_status_id','id');
    }
}
