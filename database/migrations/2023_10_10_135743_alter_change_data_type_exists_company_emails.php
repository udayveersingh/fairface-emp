<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeDataTypeExistsCompanyEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_emails', function (Blueprint $table) {
            $table->dropForeign('company_emails_to_id_foreign');
            $table->dropColumn('to_id')->nullable();
            $table->string('to_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_emails', function (Blueprint $table) {
            $table->dropColumn('to_id');
        });
    }
}
