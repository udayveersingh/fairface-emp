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

    protected $table ="employees";
    protected $fillable = [
        'employee_id', 'branch_id','firstname','lastname','uuid','email','phone','avatar','alternate_phone_number','national_insurance_number',
        'country_id','passport_number','marital_status','record_status','date_of_birth','passport_issue_date','passport_expiry_date','user_id','status_change_date'
    ];


    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
    
}
