<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname','lastname','uuid',
        'email','phone',
        'department_id','designation_id','company','avatar','alternate_phone_number','national_insurance_number',
        'nationality','passport_number','marital_status','record_status','date_of_birth','passport_issue_date','passport_expiry_date'
    ];


    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    
}
