<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('supervisor')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('timesheet_approval_incharge')->nullable()->constrained('employees')->onDelete('cascade');
            $table->string('job_title')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->string('work_email')->nullable();
            $table->string('work_phone_number')->nullable();
            $table->date('start_date')->nullable();
            $table->enum('job_type',['full_time', 'part_time'])->nullable();
            $table->time('contracted_weekly_hours')->nullable();
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
        Schema::dropIfExists('employee_jobs');
    }
}
