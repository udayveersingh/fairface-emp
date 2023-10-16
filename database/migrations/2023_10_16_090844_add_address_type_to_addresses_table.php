<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressTypeToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_addresses', function (Blueprint $table) {
            //
            $table->enum('address_type', ['main', 'temprarory'])->after('home_address_line_2')->default('main');
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
            //
            $table->dropColumn('address_type'); 
        });
    }
}
