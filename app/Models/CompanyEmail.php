<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CompanyEmail extends Model
{
    use Notifiable;
    protected $table = "company_emails";

    protected $fillable = ['from_id','to_id','company_cc','date','time','subject','body','attachment','read_at','sent_by_user_id','to_mails'];

    public function employeejob(){
        return $this->belongsTo(EmployeeJob::class,'from_id','id');
    }

    public function getToIddAttribute()
    {
        dd("coming");
        return explode(',', $this->to_id); 
    }
}
