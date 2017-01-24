<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('upl_dir');
            $table->rememberToken();
            $table->string('location')->nullable();
            $table->tinyInteger('gender')->unsigned()->default(1);
            $table->text('about');
            $table->string('profile_img')->default('default-profile.png');
            $table->integer('points')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->string('display_name');
            $table->tinyInteger('isAdmin')->default(1);
            $table->tinyInteger('isMod')->default(1);
            $table->string('header_img')->default('headers/4.jpg');
            $table->string('intro_text')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('gplus')->nullable();
            $table->string('vk')->nullable();
            $table->string('soundcloud')->nullable();
            $table->tinyInteger('autoapprove')->unsigned()->default(1);
            $table->tinyInteger('email_confirmed')->unsigned()->default(1);
            $table->tinyInteger('login_type')->unsigned()->default(1);
            $table->string('confirmation_code');
            $table->tinyInteger('is_demo')->unsigned()->default(1);
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
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
        Schema::drop('users');
    }
}
