<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetStatus extends Model
{
    protected $fillable = [
        'status'
    ]; 

    const PENDING_APPROVED = 'pending approval';
    const APPROVED = 'approved';
    const SUBMITTED = 'submitted';
    const REJECTED = 'rejected';
}
