<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyEmail extends Model
{
    protected $table = "company_emails";

    protected $fillable = ['from_id','to_id','company_cc','date','time','subject','body','attachment'];

    public function employeejob(){
        return $this->belongsTo(EmployeeJob::class,'from_id','id');
    }
}
