<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBadgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_badge', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger( 'uid' )->unsigned();
            $table->bigInteger( 'bid' )->unsigned();
            $table->tinyInteger( 'user_checked' )->unsigned()->default( 1 );
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
        Schema::drop('user_badge');
    }
}
