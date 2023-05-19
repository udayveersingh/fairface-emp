<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnsInProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('rate');
            $table->dropColumn('rate_type');
            $table->dropColumn('priority');
            $table->dropColumn('team');
            $table->dropColumn('description');
            $table->dropColumn('progress');
            $table->dropForeign('projects_client_id_foreign');
            $table->dropColumn('client_id');
            $table->dropForeign('projects_leader_foreign');
            $table->dropColumn('leader');
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
