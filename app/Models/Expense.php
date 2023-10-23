<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_type_id','employee_id','supervisor_id','project_id',
        'project_phase_id','timesheet_status_id','status_reason','approved_date_time','status',
    ];

    // protected function user(){
    //     return $this->belongsTo(User::class);
    // }
    public function expensetype(){
        return $this->belongsTo(ExpenseType::class, 'expense_type_id','id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function time_sheet_status(){
        return $this->belongsTo(TimesheetStatus::class,'timesheet_status_id','id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }

    public function projectphase()
    {
       return $this->belongsTo(ProjectPhase::class,'project_phase_id'); 
    }
    
}
