<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeVisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_visas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('visa_type')->nullable()->constrained('visas')->onDelete('cascade');
            $table->string('cos_number')->nullable();
            $table->date('cos_issue_date')->nullable();
            $table->date('cos_expiry_date')->nullable();
            $table->date('visa_issue_date')->nullable();
            $table->date('visa_expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_visas');
    }
}
