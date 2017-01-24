<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_name', 'site_title', 'site_desc', 'display_count', 'site_dir', 'max_media_img_size', 'isPreapproved',
        'canCreatePoll', 'canCreateTrivia', 'canCreatePersonality', 'canCreateImage', 'canCreateMeme',
        'canCreateVideo', 'canCreateArticles', 'canCreateLists', 'facebook', 'twitter', 'gp', 'youtube', 'soundcloud',
        'instagram', 'user_registration', 'profile_img_size', 'fb_app_key', 'fb_app_secret', 'site_domain', 'slides',
        'sidebar_ad', 'footer_ad', 'header_ad', 'list_ad', 'default_lang', 'last_media_cron_update', 'logo_type',
        'logo_img', 'site_color', 'homepage_type', 'site_ver', 'soundcloud_client_id', 'soundcloud_client_secret',
        'list_ad_type', 'list_ad_nth_count', 'google_analytics_tracking_id', 'recaptcha_public_key',
        'confirm_registration', 'watermark_enabled', 'watermark_img_url', 'watermark_x_pos', 'watermark_y_pos',
        'allow_custom_memes', 'image_sources_enabled', 'nsfw_img', 'fb_comments', 'disqus_comments', 'system_comments',
        'disqus_shortname', 'favicon', 'send_approved_media_email', 'widgets', 'custom_css', 'media_overrides',
        'media_defaults'
    ];
}
