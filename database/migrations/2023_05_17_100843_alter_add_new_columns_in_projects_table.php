<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddNewColumnsInProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_type');
            $table->string('client_name');
            $table->text('client_address')->nullable();
            $table->string('work_location')->nullable();
            $table->date('client_cont_start_date')->nullable();
            $table->date('client_cont_end_date')->nullable();
            $table->string('contract_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
}
