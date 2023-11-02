<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnToMailsCompanyEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_emails', function (Blueprint $table) {
            $table->string('to_mails')->nullable();
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
            $table->dropColumn('to_mails')->nullable();
        });
    }
}
