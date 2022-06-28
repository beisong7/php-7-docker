<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name')->nullable();
            $table->boolean('modify_admin')->nullable();
            $table->boolean('modify_roles')->nullable();
            $table->boolean('modify_reg')->nullable();
            $table->boolean('modify_pages')->nullable();
            $table->boolean('modify_blog')->nullable();
            $table->boolean('modify_sliders')->nullable();
            $table->boolean('view_fund')->nullable();
            $table->boolean('modify_unique')->nullable();

            $table->boolean('member_plan')->nullable();
            $table->boolean('bus_type')->nullable();
            $table->boolean('manage_members')->nullable();
            $table->boolean('manage_channels')->nullable();
            $table->boolean('manage_split_pay')->nullable();
            $table->boolean('manage_email_sending')->nullable();
            $table->boolean('main_role')->nullable();
            $table->boolean('modify_state')->nullable();

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
        Schema::dropIfExists('roles');
    }
}
