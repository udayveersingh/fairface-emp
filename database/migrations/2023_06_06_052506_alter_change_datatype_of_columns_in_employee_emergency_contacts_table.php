<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeDatatypeOfColumnsInEmployeeEmergencyContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_emergency_contacts', function (Blueprint $table) {
            $table->string('full_name')->nullable()->change();
            $table->string('overseas_full_name')->nullable()->change();
            $table->string('relationship')->nullable()->change();
            $table->string('overseas_full_name')->nullable()->change();
            $table->string('overseas_address')->nullable()->change();
            $table->string('overseas_phone_number_1')->nullable()->change();
            $table->string('overseas_phone_number_2')->nullable()->change();
            $table->string('overseas_relationship')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_emergency_contacts', function (Blueprint $table) {
            $table->dropColumn('fullname')->change();
            $table->dropColumn('overseas_full_name')->change();
            $table->dropColumn('relationship')->change();
            $table->dropColumn('overseas_full_name')->change();
            $table->dropColumn('overseas_address')->change();
            $table->dropColumn('overseas_phone_number_1')->change();
            $table->dropColumn('overseas_phone_number_2')->change();
            $table->dropColumn('overseas_relationship')->change();
        });
    }
}
