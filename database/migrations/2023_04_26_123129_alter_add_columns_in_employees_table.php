<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnsInEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('alternate_phone_number')->nullable();
            $table->string('national_insurance_number')->nullable();
            $table->string('nationality');
            $table->string('passport_number')->nullable();
            $table->string('marital_status');
            $table->enum('record_status', ['active', 'inactive']);
            $table->date('date_of_birth')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('alternate_phone_number');
            $table->dropColumn('national_insurance_number');
            $table->dropColumn('nationality');
            $table->dropColumn('passport_number');
            $table->dropColumn('marital_status');
            $table->dropColumn('record_status');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('passport_issue_date');
            $table->dropColumn('passport_expiry_date');
        });
    }
}
