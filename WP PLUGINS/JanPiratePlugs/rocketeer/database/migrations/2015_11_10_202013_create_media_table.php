<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('media_desc');
            $table->text('content');
            $table->tinyInteger('media_type')->unsigned()->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('featured_img')->nullable();
            $table->string('share_img')->nullable();
            $table->bigInteger('uid')->unsigned();
            $table->integer('cid')->unsigned();
            $table->string('slug_url');
            $table->integer('like_count')->unsigned()->default(0);
            $table->integer('comment_count')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->text('page_content');
            $table->text('page_content_filtered');
            $table->integer('weekly_like_count')->unsigned()->default(0);
            $table->tinyInteger('nsfw')->unsigned()->default(1);
            $table->text('uploads');
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
        Schema::drop('media');
    }
}
