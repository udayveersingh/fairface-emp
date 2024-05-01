<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_timesheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timesheet_id');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('project_phase_id')->nullable()->constrained('project_phases')->onDelete('cascade');
            $table->string('calender_day')->nullable();
            $table->date('calender_date')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->string('total_hours_worked')->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('timesheet_status_id')->nullable()->constrained('timesheet_statuses')->onDelete('cascade');
            $table->string('reason')->nullable();
            $table->string('status_reason')->nullable();
            $table->dateTime('approved_date_time')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('employee_timesheets');
    }
}
