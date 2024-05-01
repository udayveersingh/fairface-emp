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
            $table->string('temp_password')->after('avatar')->nullable();
            $table->boolean('active_status')->after('temp_password')->default(0);
            $table->boolean('dark_mode')->after('active_status')->default(0);
            $table->string('messenger_color')->after('dark_mode')->nullable();
            $table->string('role_id')->after('messenger_color')->nullable();
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
            $table->dropColumn('active_status')->after('temp_password')->default(0);
            $table->dropColumn('dark_mode')->after('active_status')->default(0);
            $table->dropColumn('messenger_color')->after('dark_mode')->nullable();

        });
    }
}
