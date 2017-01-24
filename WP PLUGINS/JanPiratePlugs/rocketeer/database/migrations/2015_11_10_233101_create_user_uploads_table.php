<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uid')->unsigned();
            $table->string('original_name');
            $table->string('upl_name');
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
        Schema::drop('user_uploads');
    }
}
