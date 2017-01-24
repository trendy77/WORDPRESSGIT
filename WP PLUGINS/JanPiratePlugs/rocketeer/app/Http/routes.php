<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Home
Route::get( '/', [ 'as' => 'home', 'uses' => 'PagesController@home' ] );
Route::get( 'page/{slug}', [ 'as' => 'page', 'uses' => 'PagesController@page' ] );

// Utility
Route::get( 'sitemap', 'PagesController@sitemap' );
Route::get( 'set-language/{locale}', [ 'as' => 'setLang', 'uses' => 'ProcessController@set_language' ] );
Route::post( 'process/upload-media-img', 'ProcessController@upload_media_img' )->middleware('auth');
Route::post( 'process/get-media-items', 'ProcessController@get_media_items' );
Route::post( 'process/get-topic-items', 'ProcessController@get_topic_items' );
Route::post( 'process/toggle-media-like',  'ProcessController@toggle_media_like' );
Route::post( 'universal-newsletter-subscribe',  'ProcessController@universal_newsletter_subscribe' );
Route::post( 'process/contact',  'ProcessController@contact' );
Route::post( 'process/user-media-award-points',  'ProcessController@user_media_award_points' )->middleware('auth');

// User
Route::get( 'register', [ 'as' => 'register', 'uses' => 'Users\AuthController@register_page' ] );
Route::post( 'register', 'Users\AuthController@register' );
Route::get( 'confirm-registration/{code}', [ 'as' => 'confirm_registration', 'uses' => 'Users\AuthController@confirm_registration' ] );
Route::get( 'login', [ 'as' => 'login', 'uses' => 'Users\AuthController@login_page' ] );
Route::post( 'login', 'Users\AuthController@login' );
Route::get( 'auth/facebook', [ 'as' => 'auth_facebook', 'uses' => 'Users\AuthController@facebook_provider' ] );
Route::get( 'auth/facebook/callback', [ 'as' => 'auth_facebook_callback', 'uses' => 'Users\AuthController@facebook_auth' ] );
Route::get( 'auth/twitter', [ 'as' => 'auth_twitter', 'uses' => 'Users\AuthController@twitter_provider' ] );
Route::get( 'auth/twitter/callback', [ 'as' => 'auth_twitter_callback', 'uses' => 'Users\AuthController@twitter_auth' ] );
Route::get( 'auth/google', [ 'as' => 'auth_google_plus', 'uses' => 'Users\AuthController@google_plus_provider' ] );
Route::get( 'auth/google/callback', [ 'as' => 'auth_google_callback', 'uses' => 'Users\AuthController@google_auth' ] );
Route::get( 'forgot-password', [ 'as' => 'forgot_password', 'uses' => 'Users\AuthController@forgot_pass_page' ] );
Route::post( 'forgot-password', 'Users\AuthController@forgot_pass' );
Route::get( 'reset-password/{code}', [ 'as' => 'reset_pass', 'uses' => 'Users\AuthController@reset_pass_page' ] );
Route::post( 'reset-password/{code}', 'Users\AuthController@reset_pass' );
Route::get( 'profile/{username}', [ 'as' => 'profile', 'uses' => 'Users\UserController@profile' ] );
Route::post( 'profile/get-media-likes', 'Users\UserController@get_user_media_likes' );
Route::post( 'profile/get-media-submissions', 'Users\UserController@get_user_media_submissions' );
Route::get( 'notifications', [ 'as' => 'notifications', 'uses' => 'Users\UserController@notifications' ] )->middleware('auth');
Route::get( 'edit-profile', [ 'as' => 'edit_profile', 'uses' => 'Users\UserController@edit_profile_page' ] )->middleware('auth');
Route::post( 'update-basic-details',  'Users\UserController@update_basic_details' )->middleware('auth');
Route::post( 'upload-profile-img',  'Users\UserController@upload_profile_img' )->middleware('auth');
Route::post( 'upload-header-img',  'Users\UserController@upload_header_img' )->middleware('auth');
Route::post( 'update-password',  'Users\UserController@update_password' )->middleware('auth');
Route::post( 'user/toggle-follow',  'Users\UserController@toggle_follow' )->middleware('auth');
Route::post( 'user-newsletter-subscribe',  'Users\UserController@user_newsletter_subscribe' )->middleware('auth');
Route::get( 'leaderboard', [ 'as' => 'leaderboard', 'uses' => 'Users\UserController@leaderboard' ] );
Route::get( 'logout', ['as' => 'logout', function(){
    Auth::logout();
    return redirect( '/' );
}]);

// Media
Route::get( 'poll/{name}', [ 'as' => 'poll', 'uses' => 'Media\PollsController@page' ] );
Route::get( 'trivia/{name}', [ 'as' => 'trivia', 'uses' => 'Media\TriviaController@page' ] );
Route::get( 'personality/{name}', [ 'as' => 'personality', 'uses' => 'Media\PersonalityController@page' ] );
Route::get( 'image/{name}', [ 'as' => 'image', 'uses' => 'Media\ImageController@page' ] );
Route::get( 'meme/{name}', [ 'as' => 'meme', 'uses' => 'Media\MemeController@page' ] );
Route::get( 'video/{name}', [ 'as' => 'video', 'uses' => 'Media\VideoController@page' ] );
Route::get( 'news/{name}', [ 'as' => 'news', 'uses' => 'Media\NewsController@page' ] );
Route::get( 'list/{name}', [ 'as' => 'list', 'uses' => 'Media\ListController@page' ] );
Route::get( 'topic/{slug}', [ 'as' => 'topic', 'uses' => 'PagesController@topic_page' ] );

// Media Pages
Route::get( 'polls', [ 'as' => 'polls', 'uses' => 'Media\PollsController@media_page' ] );
Route::get( 'quizzes', [ 'as' => 'quizzes', 'uses' => 'Media\TriviaController@media_page' ] );
Route::get( 'images', [ 'as' => 'images', 'uses' => 'Media\ImageController@media_page' ] );
Route::get( 'videos', [ 'as' => 'videos', 'uses' => 'Media\VideoController@media_page' ] );
Route::get( 'news', [ 'as' => 'news_media_page', 'uses' => 'Media\NewsController@media_page' ] );
Route::get( 'lists', [ 'as' => 'lists', 'uses' => 'Media\ListController@media_page' ] );

// Embed
Route::get( 'embed/{id}', [ 'as' => 'embed', 'uses' => 'Media\EmbedController@main' ] );

// Polls
Route::get( 'create/poll', [ 'as' => 'createPoll', 'uses' => 'Media\PollsController@create_page' ] )->middleware('auth');
Route::post( 'create/poll', 'Media\PollsController@create' )->middleware('auth');
Route::post( 'poll/{name}', [ 'as' => 'poll_vote_url', 'uses' => 'Media\PollsController@vote' ]  );

// Trivia Quiz
Route::get( 'create/trivia', [ 'as' => 'createTrivia', 'uses' => 'Media\TriviaController@create_page' ] )->middleware('auth');
Route::post( 'create/trivia', 'Media\TriviaController@create' )->middleware('auth');

// Personality Quiz
Route::get( 'create/personality', [ 'as' => 'createPersonality', 'uses' => 'Media\PersonalityController@create_page' ] )->middleware('auth');
Route::post( 'create/personality', 'Media\PersonalityController@create' )->middleware('auth');

// Images
Route::get( 'create/image', [ 'as' => 'createImage', 'uses' => 'Media\ImageController@create_page' ] )->middleware('auth');
Route::post( 'create/image', 'Media\ImageController@create' )->middleware('auth');

// Memes
Route::get( 'create/meme', [ 'as' => 'createMeme', 'uses' => 'Media\MemeController@create_page' ] )->middleware('auth');
Route::post( 'create/meme', 'Media\MemeController@create' )->middleware('auth');

// Videos
Route::get( 'create/video', [ 'as' => 'createVideo', 'uses' => 'Media\VideoController@create_page' ] )->middleware('auth');
Route::post( 'create/video', 'Media\VideoController@create' )->middleware('auth');

// News
Route::get( 'create/news', [ 'as' => 'createNews', 'uses' => 'Media\NewsController@create_page' ] )->middleware('auth');
Route::post( 'create/news', 'Media\NewsController@create' )->middleware('auth');

// Lists
Route::get( 'create/list', [ 'as' => 'createList', 'uses' => 'Media\ListController@create_page' ] )->middleware('auth');
Route::post( 'create/list', 'Media\ListController@create' )->middleware('auth');
Route::get( 'duplicate/list/{id}', [ 'as' => 'duplicateList', 'uses' => 'Media\ListController@duplicate_page' ] )->middleware('auth');
Route::post( 'duplicate/list/{id}', 'Media\ListController@duplicate' )->middleware('auth');

// Search
Route::get( 'search', [ 'as' => 'search', 'uses' => 'SearchController@page' ] );

// Comments
Route::get( 'comments/get', 'CommentsController@get_media_comments' );
Route::post( 'comments/add', 'CommentsController@add_media_comment' );

// Admin
Route::get( 'admin/dashboard', ['as' => 'admin_dashboard', 'uses' => 'Admin\MainController@dashboard' ] );
Route::post( 'admin/process/upload-media-img', 'Admin\MainController@upload_media_img' );

// Admin Settings
Route::get( 'admin/settings/general', [ 'as' => 'adminGeneralSettings', 'uses' => 'Admin\SettingsController@general' ] );
Route::post( 'admin/settings/general', 'Admin\SettingsController@update_general' );
Route::get( 'admin/settings/media', [ 'as' => 'adminMediaSettings', 'uses' => 'Admin\SettingsController@media' ] );
Route::post( 'admin/settings/media', 'Admin\SettingsController@update_media' );
Route::get( 'admin/settings/users', [ 'as' => 'adminUsersSettings', 'uses' => 'Admin\SettingsController@users' ] );
Route::post( 'admin/settings/users', 'Admin\SettingsController@update_users' );
Route::get( 'admin/settings/security', [ 'as' => 'adminSecuritySettings', 'uses' => 'Admin\SettingsController@security' ] );
Route::post( 'admin/settings/security', 'Admin\SettingsController@update_security' );
Route::get( 'admin/settings/lang', [ 'as' => 'adminLangSettings', 'uses' => 'Admin\SettingsController@lang' ] );
Route::post( 'admin/settings/lang', 'Admin\SettingsController@update_lang' );
Route::get( 'admin/settings/email', [ 'as' => 'adminEmailSettings', 'uses' => 'Admin\SettingsController@email' ] );
Route::post( 'admin/settings/email', 'Admin\SettingsController@update_email' );
Route::get( 'admin/settings/slideshow', [ 'as' => 'adminSlideshowSettings', 'uses' => 'Admin\SettingsController@slideshow' ] );
Route::post( 'admin/settings/slideshow', 'Admin\SettingsController@update_slideshow' );
Route::get( 'admin/settings/site-images', [ 'as' => 'adminSiteImagesSettings', 'uses' => 'Admin\SettingsController@site_images' ] );
Route::post( 'admin/settings/logo', 'Admin\SettingsController@update_logo' );
Route::post( 'admin/settings/watermark', 'Admin\SettingsController@update_watermark' );
Route::post( 'admin/settings/nsfw', 'Admin\SettingsController@update_nsfw' );
Route::post( 'admin/settings/favicon', 'Admin\SettingsController@update_favicon' );
Route::get( 'admin/settings/comment', [ 'as' => 'adminCommentSettings', 'uses' => 'Admin\SettingsController@comment' ] );
Route::post( 'admin/settings/comment', 'Admin\SettingsController@update_comment' );
Route::get( 'admin/settings/widget', [ 'as' => 'adminWidgetSettings', 'uses' => 'Admin\SettingsController@widget' ] );
Route::post( 'admin/settings/widget', 'Admin\SettingsController@update_widget' );

// Admin Manage Media
Route::get( 'admin/manage-media', [ 'as' => 'adminManageMedia', 'uses' => 'Admin\ManageMediaController@manage' ] );
Route::post( 'admin/delete-media', 'Admin\ManageMediaController@delete' );
Route::get( 'admin/edit-poll/{id}', [ 'as' => 'editPoll', 'uses' => 'Admin\ManageMediaController@edit_poll_page' ] );
Route::post( 'admin/edit-poll/{id}', 'Admin\ManageMediaController@edit_poll' );
Route::get( 'admin/edit-trivia/{id}', [ 'as' => 'editTrivia', 'uses' => 'Admin\ManageMediaController@edit_trivia_page' ] );
Route::post( 'admin/edit-trivia/{id}', 'Admin\ManageMediaController@edit_trivia' );
Route::get( 'admin/edit-personality/{id}', [ 'as' => 'editPersonality', 'uses' => 'Admin\ManageMediaController@edit_personality_page' ] );
Route::post( 'admin/edit-personality/{id}', 'Admin\ManageMediaController@edit_personality' );
Route::get( 'admin/edit-image/{id}', [ 'as' => 'editImage', 'uses' => 'Admin\ManageMediaController@edit_image_page' ] );
Route::post( 'admin/edit-image/{id}', 'Admin\ManageMediaController@edit_image' );
Route::get( 'admin/edit-meme/{id}', [ 'as' => 'editMeme', 'uses' => 'Admin\ManageMediaController@edit_meme_page' ] );
Route::post( 'admin/edit-meme/{id}', 'Admin\ManageMediaController@edit_meme' );
Route::get( 'admin/edit-video/{id}', [ 'as' => 'editVideo', 'uses' => 'Admin\ManageMediaController@edit_video_page' ] );
Route::post( 'admin/edit-video/{id}', 'Admin\ManageMediaController@edit_video' );
Route::get( 'admin/edit-news/{id}', [ 'as' => 'editNews', 'uses' => 'Admin\ManageMediaController@edit_news_page' ] );
Route::post( 'admin/edit-news/{id}', 'Admin\ManageMediaController@edit_news' );
Route::get( 'admin/edit-list/{id}', [ 'as' => 'editList', 'uses' => 'Admin\ManageMediaController@edit_list_page' ] );
Route::post( 'admin/edit-list/{id}', 'Admin\ManageMediaController@edit_list' );

// Admin Manage Users
Route::get( 'admin/manage-users', [ 'as' => 'adminManageUsers', 'uses' => 'Admin\ManageUsersController@manage' ] );
Route::post( 'admin/delete-user', 'Admin\ManageUsersController@delete' );
Route::get( 'admin/edit-user/{id}', [ 'as' => 'adminEditUser', 'uses' => 'Admin\ManageUsersController@edit_user_page' ] );
Route::post( 'admin/edit-user/{id}', 'Admin\ManageUsersController@edit_user'  );

// Admin Categories
Route::get( 'admin/categories', [ 'as' => 'adminCategories', 'uses' => 'Admin\CategoriesController@manage' ] );
Route::post( 'admin/categories/add', 'Admin\CategoriesController@add' );
Route::post( 'admin/categories/delete', 'Admin\CategoriesController@delete' );
Route::post( 'admin/categories/update', 'Admin\CategoriesController@update' );
// Admin Memes
Route::get( 'admin/memes', [ 'as' => 'adminMemes', 'uses' => 'Admin\MemesController@manage' ] );
Route::post( 'admin/memes/add', 'Admin\MemesController@add' );
Route::post( 'admin/memes/delete', 'Admin\MemesController@delete' );
Route::post( 'admin/memes/update', 'Admin\MemesController@update' );
// Admin Pages
Route::get( 'admin/pages', [ 'as' => 'adminPages', 'uses' => 'Admin\PagesController@manage' ] );
Route::get( 'admin/pages/add', [ 'as' => 'adminAddPage', 'uses' => 'Admin\PagesController@add_page' ] );
Route::post( 'admin/pages/add', 'Admin\PagesController@add' );
Route::get( 'admin/pages/update/{pid}', [ 'as' => 'adminUpdatePage', 'uses' => 'Admin\PagesController@update_page' ] );
Route::post( 'admin/pages/update/{pid}', 'Admin\PagesController@update' );
Route::post( 'admin/pages/delete', 'Admin\PagesController@delete' );

// Admin E-mail
Route::post( 'admin/process/export-emails', 'Admin\EmailController@export' );
Route::get( 'admin/process/export-emails', [ 'as' => 'adminDownloadExportedEmails', 'uses' => 'Admin\EmailController@download' ] );

// Admin Badges
Route::get( 'admin/badges', [ 'as' => 'adminBadges', 'uses' => 'Admin\BadgesController@manage' ] );
Route::post( 'admin/badges/add', 'Admin\BadgesController@add' );
Route::post( 'admin/badges/delete', 'Admin\BadgesController@delete' );
Route::post( 'admin/badges/update', 'Admin\BadgesController@update' );