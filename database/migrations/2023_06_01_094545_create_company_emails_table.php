<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_id')->nullable()->constrained('employee_jobs')->onDelete('cascade');
            $table->string('to_id')->nullable();
            $table->string('company_cc')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_emails');
    }
}
