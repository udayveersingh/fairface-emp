<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    protected $fillable = [
       'employee_id','address_type','home_address_line_1','home_address_line_2','post_code','from_date','to_date'
    ];
    
}
