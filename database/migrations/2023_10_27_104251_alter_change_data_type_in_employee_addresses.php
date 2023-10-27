<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeDataTypeInEmployeeAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_addresses', function (Blueprint $table) {
            $table->date('from_date')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('temp_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_addresses', function (Blueprint $table) {
            $table->dropColumn('from_date')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('temp_password')->nullable();
        });
    }
}
