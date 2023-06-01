<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdToEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_id')->unique();
            $table->dropForeign('employees_designation_id_foreign');
            $table->dropColumn('designation_id');
            $table->dropForeign('employees_branch_id_foreign');
            $table->dropColumn('branch_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreignId('branch_id')->nullable()->change();
            $table->dropForeign('employees_department_id_foreign');
            $table->dropColumn('department_id');
            $table->dropColumn('company');
            DB::statement("ALTER TABLE `employees` CHANGE `record_status` `record_status` ENUM('active','archieve','delete') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active';");
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
            $table->dropColumn('employee_id');
        });
    }
}
