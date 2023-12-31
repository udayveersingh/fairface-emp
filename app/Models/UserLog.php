<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','location_ip', 'location_name','message','date_time','out_time','status'
    ];
}
