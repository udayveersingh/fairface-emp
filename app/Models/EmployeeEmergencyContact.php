<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEmergencyContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id','full_name','address','phone_number_1','phone_number_2','relationship','overseas_full_name','overseas_address','overseas_phone_number_1','overseas_phone_number_2','overseas_relationship'
    ];
}
