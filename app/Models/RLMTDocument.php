<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RLMTDocument extends Model
{
    protected $fillable = [
        'employee_id','name','attachment'
     ];
}
