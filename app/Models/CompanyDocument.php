<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    protected $table ="company_documents";
    protected $fillable = ['name','attachment'];
}
