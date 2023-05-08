<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBank extends Model
{
    protected $fillable = [
        'employee_id','account_name','bank_name','bank_account_number','bank_sort_code','ifsc_code'
     ];
}
