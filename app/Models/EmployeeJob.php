<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeJob extends Model
{
    protected $fillable = [
       'employee_id','supervisor','timesheet_approval_incharge','job_title','department_id','work_email','work_phone_number','start_date','job_type',
       'contracted_weekly_hours','end_date'
    ];


    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function supervisors()
    {
        return $this->belongsTo(Employee::class, 'supervisor');
    }

    public function timesheet_approval_incharges()
    {
        return $this->belongsTo(Employee::class,'timesheet_approval_incharge');
    }
}
