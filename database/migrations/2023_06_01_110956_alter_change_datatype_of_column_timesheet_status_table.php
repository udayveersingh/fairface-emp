<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeDatatypeOfColumnTimesheetStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timesheet_statuses', function (Blueprint $table) {
            $table->string('status')->nullable()->change();

        });

        Schema::table('employee_timesheets', function (Blueprint $table) {
            $table->string('timesheet_id')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timesheet_statuses', function (Blueprint $table) {
            $table->dropColumn('status')->change();
        });

        Schema::table('employee_timesheets', function (Blueprint $table) {
            $table->dropColumn('timesheet_id')->nullable()->change();
        });
    }
}
