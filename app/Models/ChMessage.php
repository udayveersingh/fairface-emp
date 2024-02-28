<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    // use UUID;

    protected $table = "ch_messages";

    protected $fillable = ['from_id', 'to_id', 'body', 'attachment', 'seen'];


    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }


    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
