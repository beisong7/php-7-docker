<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('admin_id')->nullable();
            $table->string('from')->nullable();
            $table->string('subject')->nullable();
            $table->string('title')->nullable();
            $table->string('sender')->nullable();
            $table->string('recipient')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('active')->nullable();
            $table->boolean('private')->nullable(); //private emails are sent directly to the recipient
            $table->boolean('sent')->nullable(); //applicable to private emails
            $table->string('status')->nullable();
            $table->longText('error_message')->nullable();
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
        Schema::dropIfExists('emails');
    }
}
