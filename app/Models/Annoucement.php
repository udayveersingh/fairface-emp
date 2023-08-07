<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Annoucement extends Model
{
    use Notifiable;
    protected $fillable = ['description','status','user_id'];

    const ACTIVE = 'active';
    
}
