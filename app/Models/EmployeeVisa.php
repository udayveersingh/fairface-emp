<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeVisa extends Model
{
    protected $fillable = [
        'employee_id','visa_type','cos_number','cos_issue_date','cos_expiry_date','visa_issue_date','visa_expiry_date'
     ];

     public function visa_types(){
        return $this->hasOne(Visa::class,'id','visa_type');
    }
}
