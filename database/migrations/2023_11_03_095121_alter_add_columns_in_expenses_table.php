<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnsInExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
          $table->string('expense_id')->nullable()->after('status');
          $table->date('expense_occurred_date')->nullable()->after('expense_id');
          $table->double('cost',15,2)->nullale()->after('expense_occurred_date');
          $table->text('description')->nullable()->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('expense_id');
            $table->dropColumn('expense_occurred_date');
            $table->dropColumn('cost');
            $table->dropColumn('description');
        });
    }
}
