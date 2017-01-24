<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_name')->default('Rocketeer');
            $table->string('site_title')->default('Rocketeer');
            $table->string('site_desc')->default('Rocketeer');
            $table->integer('display_count')->unsigned()->default(8);
            $table->string('site_dir');
            $table->integer('max_media_img_size')->unsigned()->default(1);
            $table->integer('isPreapproved')->unsigned()->default(1);
            $table->tinyInteger('canCreatePoll')->unsigned()->default(1);
            $table->tinyInteger('canCreateTrivia')->unsigned()->default(1);
            $table->tinyInteger('canCreatePersonality')->unsigned()->default(1);
            $table->tinyInteger('canCreateImage')->unsigned()->default(1);
            $table->tinyInteger('canCreateMeme')->unsigned()->default(1);
            $table->tinyInteger('canCreateVideo')->unsigned()->default(1);
            $table->tinyInteger('canCreateArticles')->unsigned()->default(1);
            $table->tinyInteger('canCreateLists')->unsigned()->default(1);
            $table->tinyInteger('canViewPoll')->unsigned()->default(1);
            $table->tinyInteger('canViewQuiz')->unsigned()->default(1);
            $table->tinyInteger('canViewImage')->unsigned()->default(1);
            $table->tinyInteger('canViewVideo')->unsigned()->default(1);
            $table->tinyInteger('canViewArticles')->unsigned()->default(1);
            $table->tinyInteger('canViewLists')->unsigned()->default(1);
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('gp')->nullable();
            $table->string('youtube')->nullable();
            $table->string('soundcloud')->nullable();
            $table->string('instagram')->nullable();
            $table->tinyInteger('user_registration')->unsigned()->default(1);
            $table->integer('profile_img_size')->unsigned()->default(1);
            $table->string('fb_app_key')->nullable();
            $table->string('fb_app_secret')->nullable();
            $table->string('twitter_client_id')->nullable();
            $table->string('twitter_client_secret')->nullable();
            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->string('site_domain');
            $table->text('slides');
            $table->text('sidebar_ad');
            $table->text('footer_ad');
            $table->text('header_ad');
            $table->text('list_ad');
            $table->string('default_lang')->default('en');
            $table->integer('last_media_cron_update')->unsigned();
            $table->tinyInteger('logo_type')->unsigned()->default(1);
            $table->string('logo_img')->nullable();
            $table->string('site_color')->default('blue');
            $table->tinyInteger('homepage_type')->unsigned()->default(1);
            $table->float('site_ver')->unsigned()->default(7.1);
            $table->string('soundcloud_client_id')->nullable();
            $table->string('soundcloud_client_secret')->nullable();
            $table->tinyInteger('list_ad_type')->unsigned()->default(1);
            $table->tinyInteger('list_ad_nth_count')->unsigned()->default(0);
            $table->string('google_analytics_tracking_id')->nullable();
            $table->string('recaptcha_public_key');
            $table->tinyInteger('confirm_registration')->unsigned()->default(1);
            $table->tinyInteger('watermark_enabled')->unsigned()->default(1);
            $table->string('watermark_img_url')->nullable();
            $table->tinyInteger('watermark_x_pos')->unsigned()->default(50);
            $table->tinyInteger('watermark_y_pos')->unsigned()->default(50);
            $table->tinyInteger('allow_custom_memes')->unsigned()->default(1);
            $table->string('nsfw_img')->default('nsfw-thumbnail.png');
            $table->tinyInteger('fb_comments')->unsigned()->default(1);
            $table->tinyInteger('disqus_comments')->unsigned()->default(1);
            $table->tinyInteger('system_comments')->unsigned()->default(2);
            $table->string('disqus_shortname')->nullable();
            $table->tinyInteger('main_comment_system')->default(1);
            $table->string('favicon')->default('favicon.ico');
            $table->tinyInteger('send_approved_media_email')->unsigned()->default(1);
            $table->text('widgets');
            $table->text('custom_css');
            $table->text('media_overrides');
            $table->text('media_defaults');
            $table->tinyInteger('cache_enabled')->default(1);
            $table->tinyInteger('lang_switcher')->default(1);
            $table->tinyInteger('lang_switcher_loc')->default(1);
            $table->text('languages');
            $table->tinyInteger('infinite_pagination')->default(1);
            $table->tinyInteger('aws_s3')->default(1);
            $table->string('aws_s3_key')->nullable();
            $table->string('aws_s3_secret')->nullable();
            $table->string('aws_s3_region')->nullable();
            $table->string('aws_s3_bucket')->nullable();
            $table->tinyInteger('duplicate_list')->default(1);
            $table->tinyInteger('notify_user_duplicate_list')->default(1);
            $table->tinyInteger('poll_signed_in_votes')->default(1);
            $table->tinyInteger('enable_newsletter_subscribe')->default(1);
            $table->string('mailchimp_api_key')->nullable();
            $table->string('mailchimp_list_id')->nullable();
            $table->text('iframe_urls');
            $table->tinyInteger('allow_embeds')->unsigned()->default(1);
            $table->string( 'google_font' )->default( 'Open+Sans:400,700,800,300' );
            $table->string( 'site_font' )->default( '"Open Sans", sans-serif' );
            $table->tinyInteger('auto_scroll')->unsigned()->default(1);
            $table->integer('auto_scroll_timer')->unsigned()->default(3000);
            $table->tinyInteger('generate_special_share_img')->unsigned()->default(1);
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
        Schema::drop('settings');
    }
}
