<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnsInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // $table->id()->change();
            // $table->renameColumn('data','description');
            // $table->unsignedBigInteger('from_id')->nullable();
            // $table->unsignedBigInteger('to_id')->nullable();
            // $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // $table->dropColumn('id')->change();
            // $table->renameColumn('description','data');
            // $table->dropColumn('from_id')->nullable();
            // $table->dropColumn('to_id')->nullable();
            // $table->dropColumn('status')->nullable();
        });
    }
}
