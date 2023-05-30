<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeDataTypeOfFieldInEmployeeJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_jobs', function (Blueprint $table) {
            $table->string('contracted_weekly_hours')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_jobs', function (Blueprint $table) {
            $table->dropColumn('contracted_weekly_hours')->change();
        });
    }
}
