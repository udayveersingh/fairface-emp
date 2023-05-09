<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProject extends Model
{
    protected $fillable = [
        'employee_id','project_id','start_date','end_date'
     ];


     public function projects(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
}
