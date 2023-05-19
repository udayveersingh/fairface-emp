<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','project_type','client_name','client_address',
        'work_location','client_cont_start_date','client_cont_end_date','contract_id','files','status'      
    ];

    protected $casts = [
        'team' => 'array',
        'files' => 'array',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function leader(){
        return $this->belongsTo(Employee::class);
    }

    public function employee($id){
        $employee = Employee::where('id', '=',$id)->first();
        return $employee;
    }
}
