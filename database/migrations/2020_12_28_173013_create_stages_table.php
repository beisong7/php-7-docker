<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('admin_id')->nullable();
            $table->string('title')->nullable();
            $table->uuid('automate_id')->nullable();
            $table->uuid('mail_list_id')->nullable();
            $table->integer('rebuild_round')->nullable(); //
            $table->integer('round')->nullable(); //if the rebuild_round is higher than the round, rebuild list with list_filter
            $table->integer('position')->nullable(); // 1, 2, 3 ... i.e Position withing the automated item
            $table->string('list_filter')->nullable(); //the filter to generate list members
            $table->string('process')->nullable(); //ongoing, pending
            $table->boolean('active')->nullable(); //
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
        Schema::dropIfExists('stages');
    }
}
