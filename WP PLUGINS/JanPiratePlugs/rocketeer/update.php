<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/7/2016
 * Time: 7:22 PM
 */

require( 'app/Http/utility.php' );

$env_file                           =   file_get_contents( '.env' );
$lines                              =   explode("\n", $env_file);
$db_info                            =   [
    'host'                          =>  strip_swag(substr( $lines[5], 8 )),
    'name'                          =>  strip_swag(substr( $lines[6], 12 )),
    'user'                          =>  strip_swag(substr( $lines[7], 12 )),
    'pass'                          =>  strip_swag(substr( $lines[8], 12 )),
];

$db                                 =   new PDO('mysql:host=' . $db_info['host'] . ';dbname=' . $db_info['name'], $db_info['user'], $db_info['pass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$settings                           =   $db->prepare("SELECT * FROM settings WHERE id='1'");
$settings->execute();
$settings                           =   $settings->fetch(PDO::FETCH_ASSOC);
$ver                                =   $settings['site_ver'];

if($ver < 4)
{
    $updateQuery            =   $db->prepare("
      ALTER TABLE `categories` ADD `slug_url` VARCHAR(255) NULL, ADD `cat_img` VARCHAR(255) NULL,
                               ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                               ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

      ALTER TABLE `media` ADD `featured_img` varchar(255) NULL, ADD `uploads` text NOT NULL,
                          ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                          ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

     ALTER TABLE `media_likes`  ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

     ALTER TABLE `memes` ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

     ALTER TABLE `pages` ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

     ALTER TABLE `poll_votes` CHANGE `answer_key` `vote_keys` text,
                              ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                              ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

     ALTER TABLE `settings` ADD `canViewPoll` tinyint(3) unsigned NOT NULL DEFAULT '1', ADD `canViewQuiz` tinyint(3) unsigned NOT NULL DEFAULT '1',
                            ADD `canViewImage` tinyint(3) unsigned NOT NULL DEFAULT '1', ADD `canViewVideo` tinyint(3) unsigned NOT NULL DEFAULT '1',
                            ADD `canViewArticles` tinyint(3) unsigned NOT NULL DEFAULT '1', ADD `canViewLists` tinyint(3) unsigned NOT NULL DEFAULT '1',
                            ADD `twitter_client_id` VARCHAR(255) NULL, ADD `twitter_client_secret` VARCHAR(255) NULL,
                            ADD `google_client_id` VARCHAR(255) NULL, ADD `google_client_secret` VARCHAR(255) NULL,
                            ADD `main_comment_system` tinyint(3) unsigned NOT NULL DEFAULT '1', ADD `widgets` text NOT NULL,
                            ADD `custom_css` text NOT NULL, ADD `media_overrides` text NOT NULL, ADD `media_defaults` text NOT NULL,
                            ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                            ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

     ALTER TABLE `users` CHANGE `pass` `password` varchar(255), CHANGE `login_token` `remember_token` varchar(100),
                         ADD `login_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
                         ADD `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                         ADD `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00';

    ");
    $updateQuery->execute();
    $updateQuery->closeCursor();

    $addTableQuery          =   $db->prepare("
    CREATE TABLE IF NOT EXISTS `comments` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `uid` bigint(20) NOT NULL,
      `mid` bigint(20) NOT NULL,
      `body` text COLLATE utf8_unicode_ci NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    CREATE TABLE IF NOT EXISTS `followers` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `subscriber_uid` bigint(20) NOT NULL,
      `followed_uid` bigint(20) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    CREATE TABLE IF NOT EXISTS `migrations` (
      `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `batch` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    CREATE TABLE IF NOT EXISTS `password_resets` (
      `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      KEY `password_resets_email_index` (`email`),
      KEY `password_resets_token_index` (`token`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ");
    $addTableQuery->execute();
    $addTableQuery->closeCursor();

    $updateSettingsQuery    =   $db->prepare("UPDATE settings SET slides='[]', widgets='[]', media_overrides=:a, media_defaults=:b WHERE id='1'");
    $updateSettingsQuery->execute([
        ':a'                =>  json_encode([
            'poll_page_content'                     =>  2,
            'poll_style'                            =>  2,
            'poll_animation'                        =>  2,
            'quiz_page_content'                     =>  2,
            'quiz_style'                            =>  2,
            'quiz_timed'                            =>  2,
            'quiz_timer'                            =>  2,
            'quiz_randomize_questions'              =>  2,
            'quiz_randomize_answers'                =>  2,
            'image_page_content'                    =>  2,
            'meme_page_content'                     =>  2,
            'video_page_content'                    =>  2,
            'list_page_content'                     =>  2,
            'list_style'                            =>  2,
            'list_animation'                        =>  2
        ]),
        ':b'                =>  json_encode([
            'poll_style'                            =>  1,
            'poll_animation'                        =>  '',
            'quiz_style'                            =>  1,
            'quiz_timed'                            =>  2,
            'quiz_timer'                            =>  0,
            'quiz_randomize_questions'              =>  1,
            'quiz_randomize_answers'                =>  1,
            'list_style'                            =>  1,
            'list_animation'                        =>  1,
        ])
    ]);

    $mediaQuery             =   $db->prepare("SELECT * FROM media WHERE status='1'"); //
    $mediaQuery->execute();
    $mediaRows              =   $mediaQuery->fetchAll();

    foreach($mediaRows as $mk => $mv){

        $content            =   @json_decode($mv['content']);

        if(is_array($content)){

        }else if(is_object($content)){
            $content->style    =   1;
        }

        $updateMediaQuery   =   $db->prepare("UPDATE media SET content=:cont, status=:s WHERE id=:id");
        $updateMediaQuery->execute([
            ':cont'         =>  json_encode($content),
            ':s'            =>  2,
            ':id'           =>  $mv['id']
        ]);
    }

    $ver                    =   4;
}
else if($ver < 5)
{
    $alterQuery                     =   $db->prepare("
        ALTER TABLE `media` ADD `share_img` varchar(255) NULL;
        ALTER TABLE `settings` ADD COLUMN `cache_enabled` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1';
        ALTER TABLE `settings` ADD COLUMN `lang_switcher` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1';
        ALTER TABLE `settings` ADD COLUMN `lang_switcher_loc` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1';
        ALTER TABLE `settings` ADD COLUMN `languages` TEXT NOT NULL;
        ALTER TABLE `settings` ADD COLUMN `infinite_pagination` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1';
    ");
    $alterQuery->execute();
    $alterQuery->closeCursor();

    $updateMediaQuery               =   $db->prepare("
        UPDATE media SET share_img = featured_img WHERE id>'0'
    ");
    $updateMediaQuery->execute();
    $updateMediaQuery->closeCursor();

    $overrides                      =   json_decode($settings['media_overrides']);
    $defaults                       =   json_decode($settings['media_defaults']);
    $overrides->quiz_animation      =   2;
    $defaults->quiz_animation       =   '';

    $updateSettingsQuery            =   $db->prepare("UPDATE settings SET media_overrides = :mo, media_defaults = :md, languages = :l WHERE id='1'");
    $updateSettingsQuery->execute([
        ":mo"                       =>  json_encode($overrides),
        ":md"                       =>  json_encode($defaults),
        ":l"                        =>  json_encode([
            [
                'locale'            =>  'en',
                'readable_name'     =>  'English'
            ]
        ])
    ]);

    // Update Quizzes
    $getQuizzesQuery                =   $db->prepare("SELECT * FROM media WHERE media_type='2' OR media_type='3'");
    $getQuizzesQuery->execute();
    $getQuizzesRow                  =   $getQuizzesQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach($getQuizzesRow as $qk => $qv){
        $qv['content']              =   json_decode( $qv['content'] );

        if(isset($qv['content']->animaton)) continue;

        $qv['content']->animation   =   '';
        $updateQuizQuery            =   $db->prepare("UPDATE media SET content = :ct WHERE id = :id");
        $updateQuizQuery->execute([
            ":ct"                   =>  json_encode($qv['content']),
            ":id"                   =>  $qv['id']
        ]);
    }

    $ver                            =   5;
}
else if($ver < 6)
{
    $alterQuery                     =   $db->prepare("
     ALTER TABLE `settings` ADD COLUMN `aws_s3` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `infinite_pagination`,
                            ADD COLUMN `aws_s3_key` VARCHAR(255) NULL AFTER `aws_s3`,
	                        ADD COLUMN `aws_s3_secret` VARCHAR(255) NULL AFTER `aws_s3_key`,
	                        ADD COLUMN `aws_s3_region` VARCHAR(255) NULL AFTER `aws_s3_secret`,
	                        ADD COLUMN `aws_s3_bucket` VARCHAR(255) NULL AFTER `aws_s3_region`,
	                        ADD COLUMN `duplicate_list` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `aws_s3_bucket`,
	                        ADD COLUMN `notify_user_duplicate_list` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER `duplicate_list`;

     ALTER TABLE `users` ADD `is_demo` tinyint(3) unsigned NOT NULL DEFAULT '1';
    ");
    $alterQuery->execute();
    $alterQuery->closeCursor();

    // Update Polls
    $getPollsQuery                  =   $db->prepare("SELECT * FROM media WHERE media_type='1' OR media_type='2' OR media_type='3'");
    $getPollsQuery->execute();
    $getPollsRow                    =   $getPollsQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach($getPollsRow as $qk => $qv){
        $qv['content']              =   json_decode( $qv['content'] );

        foreach($qv['content']->questions as $ik => $iv){
            $qv['content']->questions[$ik]->answer_display_type = 1;
        }

        $updatePollQuery            =   $db->prepare("UPDATE media SET content = :ct WHERE id = :id");
        $updatePollQuery->execute([
            ":ct"                   =>  json_encode($qv['content']),
            ":id"                   =>  $qv['id']
        ]);
    }

    $ver                            =   6;
}
else if($ver < 7)
{
    $alterQuery                     =   $db->prepare("
     ALTER TABLE `settings` ADD COLUMN `poll_signed_in_votes` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `notify_user_duplicate_list`,
                            ADD COLUMN `enable_newsletter_subscribe` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `poll_signed_in_votes`,
                            ADD COLUMN `mailchimp_api_key` VARCHAR(255) NULL AFTER `enable_newsletter_subscribe`,
	                        ADD COLUMN `mailchimp_list_id` VARCHAR(255) NULL AFTER `mailchimp_api_key`,
	                        ADD COLUMN `iframe_urls` TEXT AFTER `mailchimp_list_id`,
	                        ADD COLUMN `allow_embeds` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `iframe_urls`;
    ALTER TABLE `pages`  ADD COLUMN `page_type` TINYINT(2) UNSIGNED NOT NULL DEFAULT '1' AFTER `title`,
                         ADD COLUMN `contact_email` VARCHAR(255) NULL AFTER `page_content`,
	                     ADD COLUMN `direct_url` VARCHAR(255) NULL AFTER `contact_email`;
    ");
    $alterQuery->execute();
    $alterQuery->closeCursor();

    // Update Trivia
    $getTriviasQuery                =   $db->prepare("SELECT * FROM media WHERE media_type='2'");
    $getTriviasQuery->execute();
    $getTriviasRow                  =   $getTriviasQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach($getTriviasRow as $qk => $qv){
        $qv['content']              =   json_decode( $qv['content'] );

        foreach($qv['content']->questions as $ik => $iv){
            $qv['content']->questions[$ik]->explanation = '';
        }

        $updateTriviaQuery          =   $db->prepare("UPDATE media SET content = :ct WHERE id = :id");
        $updateTriviaQuery->execute([
            ":ct"                   =>  json_encode($qv['content']),
            ":id"                   =>  $qv['id']
        ]);
    }

    // Update Settings Iframe URLS
    $updateSettingsQuery            =   $db->prepare("UPDATE settings SET iframe_urls = :iu WHERE id='1'");
    $updateSettingsQuery->execute([
        ":iu"                       =>  json_encode([
            "www.youtube.com/embed/", "player.vimeo.com/video/", "w.soundcloud.com/player/", "www.instagram.com"
        ])
    ]);

    // ADD BADGES TABLES
    $addTableQuery          =   $db->prepare("
    CREATE TABLE IF NOT EXISTS `badges` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `badge_desc` text COLLATE utf8_unicode_ci NOT NULL,
      `min_points` int(20) unsigned NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    CREATE TABLE IF NOT EXISTS `user_badge` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `uid` bigint(20) unsigned NOT NULL,
      `bid` bigint(20) unsigned NOT NULL,
      `user_checked` tinyint(3) unsigned NOT NULL DEFAULT '1',
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ");
    $addTableQuery->execute();
    $addTableQuery->closeCursor();

    // Process Polls, Lists, Quizzes for Media Type URLs and Embed
    $embedMediaQuery                =   $db->prepare("SELECT * FROM media WHERE media_type='1' OR media_type='2' OR media_type='3' OR media_type='8'");
    $embedMediaQuery->execute();
    $embedMediaRow                  =   $embedMediaQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach($embedMediaRow as $mk => $mv){
        $mv['content']              =   json_decode( $mv['content'] );

        if($mv['media_type'] == 1 || $mv['media_type'] == 2 || $mv['media_type'] == 3){
            foreach($mv['content']->questions as $qk => $qv){
                if($qv->media_type == 2){
                    $mv['content']->questions[$qk]->embed_url = $qv->yt_url;
                    $mv['content']->questions[$qk]->embed_code = $qv->yt_url;
                }else if($qv->media_type == 3){
                    $mv['content']->questions[$qk]->media_type = 2;
                    $mv['content']->questions[$qk]->embed_url = $qv->vine_url;
                    $mv['content']->questions[$qk]->embed_code = $qv->vine_url;
                }else if($qv->media_type == 4){
                    $mv['content']->questions[$qk]->media_type = 2;
                    $mv['content']->questions[$qk]->embed_url = $qv->vimeo_url;
                    $mv['content']->questions[$qk]->embed_code = $qv->vimeo_url;
                }else if($qv->media_type == 5){
                    $mv['content']->questions[$qk]->media_type = 2;
                    $mv['content']->questions[$qk]->embed_url = $qv->soundcloud_url;
                    $mv['content']->questions[$qk]->embed_code = $qv->soundcloud_url;
                }else if($qv->media_type == 6){
                    $mv['content']->questions[$qk]->media_type = 2;
                    $mv['content']->questions[$qk]->embed_url = $qv->facebook_url;
                    $mv['content']->questions[$qk]->embed_code = $qv->facebook_url;
                }else if($qv->media_type == 7){
                    $mv['content']->questions[$qk]->media_type = 2;
                    $mv['content']->questions[$qk]->embed_url = $qv->tweet;
                    $mv['content']->questions[$qk]->embed_code = $qv->tweet;
                }else if($qv->media_type == 8){
                    $mv['content']->questions[$qk]->media_type = 2;
                    $mv['content']->questions[$qk]->embed_url = $qv->instagram_url;
                    $mv['content']->questions[$qk]->embed_code = $qv->instagram_url;
                }

            }
        }

        if($mv['media_type'] == 8){
            foreach($mv['content']->items as $ik => $iv){
                if($iv->media_type == 2){
                    $mv['content']->items[$ik]->media_type = 2;
                    $mv['content']->items[$ik]->embed_url = $iv->yt_url;
                    $mv['content']->items[$ik]->embed_code = $iv->yt_url;
                }else if($iv->media_type == 3){
                    $mv['content']->items[$ik]->media_type = 2;
                    $mv['content']->items[$ik]->embed_url = $iv->vine_url;
                    $mv['content']->items[$ik]->embed_code = $iv->vine_url;
                }else if($iv->media_type == 4){
                    $mv['content']->items[$ik]->media_type = 2;
                    $mv['content']->items[$ik]->embed_url = $iv->vimeo_url;
                    $mv['content']->items[$ik]->embed_code = $iv->vimeo_url;
                }else if($iv->media_type == 5){
                    $mv['content']->items[$ik]->media_type = 2;
                    $mv['content']->items[$ik]->embed_url = $iv->soundcloud_url;
                    $mv['content']->items[$ik]->embed_code = $iv->soundcloud_url;
                }else if($iv->media_type == 6){
                    $mv['content']->items[$ik]->media_type = 2;
                    $mv['content']->items[$ik]->embed_url = $iv->facebook_url;
                    $mv['content']->items[$ik]->embed_code = $iv->facebook_url;
                }else if($iv->media_type == 7){
                    $mv['content']->items[$ik]->media_type = 2;
                    $mv['content']->items[$ik]->embed_url = $iv->tweet;
                    $mv['content']->items[$ik]->embed_code = $iv->tweet;
                    die('swag');
                }else if($iv->media_type == 8){
                    $mv['content']->items[$ik]->media_type = 2;
                    $mv['content']->items[$ik]->embed_url = $iv->instagram_url;
                    $mv['content']->items[$ik]->embed_code = $iv->instagram_url;
                }
            }
        }

        $updateEmbedQuery           =   $db->prepare("UPDATE media SET content = :ct WHERE id = :id");
        $updateEmbedQuery->execute([
            ":ct"                   =>  json_encode($mv['content']),
            ":id"                   =>  $mv['id']
        ]);
    }

    $ver                            =   7;
}
else if($ver < 7.1){
    // Update Tables
    $alterQuery                     =   $db->prepare("
     ALTER TABLE `settings` ADD COLUMN `google_font` VARCHAR(255) NOT NULL DEFAULT 'Open+Sans:400,700,800,300' AFTER `allow_embeds`,
	                        ADD COLUMN `site_font` VARCHAR(255) NOT NULL DEFAULT '\'Open Sans\', sans-serif' AFTER `google_font`,
	                        ADD COLUMN `auto_scroll` TINYINT(4) NOT NULL DEFAULT '1' AFTER `site_font`,
	                        ADD COLUMN `auto_scroll_timer` INT(11) NOT NULL DEFAULT '3000' AFTER `auto_scroll`,
	                        ADD COLUMN `generate_special_share_img` TINYINT(4) UNSIGNED NOT NULL DEFAULT '1' AFTER `auto_scroll_timer`;
	 ALTER TABLE `media` ADD COLUMN `page_content_filtered` TEXT NOT NULL AFTER `page_content`;
	 ALTER TABLE `users` ADD COLUMN `stripe_id` VARCHAR(255) NULL AFTER `is_demo`,
                         ADD COLUMN `card_brand` VARCHAR(255) NULL AFTER `stripe_id`,
                         ADD COLUMN `card_last_four` VARCHAR(255) NULL AFTER `card_brand`;
    ");
    $alterQuery->execute();
    $alterQuery->closeCursor();

    // Update Trivia
    $getTriviasQuery                =   $db->prepare("SELECT * FROM media WHERE media_type='2'");
    $getTriviasQuery->execute();
    $getTriviasRow                  =   $getTriviasQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach($getTriviasRow as $qk => $qv){
        $qv['content']              =   json_decode( $qv['content'] );
        $qv['content']->show_correct_answer = 1;

        $updateTriviaQuery          =   $db->prepare("UPDATE media SET content = :ct WHERE id = :id");
        $updateTriviaQuery->execute([
            ":ct"                   =>  json_encode($qv['content']),
            ":id"                   =>  $qv['id']
        ]);
    }

    // ADD MEDIA POINTS TABLES
    $addTableQuery          =   $db->prepare("
    CREATE TABLE IF NOT EXISTS `media_points` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `uid` bigint(20) unsigned NOT NULL,
      `mid` bigint(20) unsigned NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
     CREATE TABLE IF NOT EXISTS `user_notifications` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `uid` bigint(20) unsigned NOT NULL,
      `message` text NOT NULL,
      `is_read` tinyint(4) unsigned NOT NULL DEFAULT '1',
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    CREATE TABLE IF NOT EXISTS `subscriptions` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` bigint(20) unsigned NOT NULL,
      `name` VARCHAR(255) NOT NULL,
      `stripe_id` VARCHAR(255) NOT NULL,
      `stripe_plan` VARCHAR(255) NOT NULL,
      `quantity` INT(11) NOT NULL,
      `trial_ends_at` timestamp NULL,
      `ends_at` timestamp NULL,
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ");
    $addTableQuery->execute();
    $addTableQuery->closeCursor();

    // Update Settings
    $overrides                      =   json_decode($settings['media_overrides']);
    $defaults                       =   json_decode($settings['media_defaults']);
    $overrides->quiz_show_correct_answer      =   2;
    $defaults->quiz_show_correct_answer       =   1;

    $updateSettingsQuery            =   $db->prepare("UPDATE settings SET media_overrides = :mo, media_defaults = :md WHERE id='1'");
    $updateSettingsQuery->execute([
        ":mo"                       =>  json_encode($overrides),
        ":md"                       =>  json_encode($defaults)
    ]);

    // UPDATE PAGE FILTER CONTENT
    $updateMediaPageContentQuery    =   $db->prepare("UPDATE media SET page_content_filtered = page_content");
    $updateMediaPageContentQuery->execute();

    $ver                            =   7.1;
}else if($ver < 7.2){
    $ver                            =   7.2;
}


$finalUpdateQuery           =   $db->prepare("UPDATE settings SET site_ver=:v WHERE id='1'");
$finalUpdateQuery->execute([
    ':v'                            =>  $ver
]);

echo 'If you see no errors before this message, then you have successfully updated Rocketeer. Please delete this file.';