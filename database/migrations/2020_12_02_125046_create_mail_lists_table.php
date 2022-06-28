<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('admin_id')->nullable();
            $table->uuid('email_id')->nullable();
            $table->string('title')->nullable();
            $table->string('import_key')->nullable();
            $table->string('status')->nullable();
            $table->boolean('daily')->nullable();
            $table->string('type');
            $table->string('recursive_day')->nullable(); //daily, sunday - saturday
            $table->integer('hour')->nullable(); // 24 hrs format
            $table->integer('minute')->nullable(); // 60 mins format
            $table->bigInteger('time')->nullable(); // 60 mins format
            $table->integer('round')->nullable(); //
            $table->boolean('sunday')->nullable(); //
            $table->boolean('sunday_run')->nullable(); //
            $table->boolean('monday')->nullable(); //
            $table->boolean('monday_run')->nullable(); //
            $table->boolean('tuesday')->nullable(); //
            $table->boolean('tuesday_run')->nullable(); //
            $table->boolean('wednesday')->nullable(); //
            $table->boolean('wednesday_run')->nullable(); //
            $table->boolean('thursday')->nullable(); //
            $table->boolean('thursday_run')->nullable(); //
            $table->boolean('friday')->nullable(); //
            $table->boolean('friday_run')->nullable(); //
            $table->boolean('saturday')->nullable(); //
            $table->boolean('saturday_run')->nullable(); //
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('mail_lists');
    }
}
