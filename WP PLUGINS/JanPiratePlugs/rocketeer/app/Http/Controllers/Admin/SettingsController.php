<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SiteSettings;
use App\Http\Controllers\Controller;
use Storage;
use App\Classes\JaskoHelper;
use Auth;

class SettingsController extends Controller
{
    protected $settings;
    protected $colors                       =   [
        "alizarin", "android", "apple", "asbestos", "behance", "belizehole", "black", "blogger", "blue",
        "carrot", "chrome", "clouds", "concrete", "delicious", "deviantart", "dribbble", "dropbox",
        "emerald", "evernote", "facebook", "firefox", "flattr", "flickr", "forrst", "foursquare", "github",
        "googleplus", "green", "greensea", "icomoon", "ie",  "instagram", "joomla", "lanyrd",  "lastfm",
        "linkedin", "midnightblue", "mixi", "nephritis", "opera", "orange", "paypal", "picasa", "pinterest",
        "pomegranate", "pumpkin", "purple", "red", "reddit", "renren", "rss", "safari", "silver", "skype",
        "smashing", "soundcloud", "stackoverflow", "steam", "sunflower", "tumblr", "turquoise",
        "twitter", "vimeo", "vk", "wetasphalt", "windows", "wordpress", "yahoo",  "yelp", "youtube"
    ];

    public function __construct(){
        $this->middleware('admin');
        $this->settings                     =   SiteSettings::find(1);
    }
    public function general(){
        $tos                                =   Storage::get('tos.html');

        return view('admin.settings.general')->with([
            'colors'                        =>  $this->colors,
            'tos'                           =>  $tos,
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function media(){
        return view('admin.settings.media')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function users(){
        return view('admin.settings.users')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function security(){
        $iframe_urls                        =   json_decode( $this->settings->iframe_urls );

        return view('admin.settings.security')->with([
            'is_demo'                       =>  Auth::user()->is_demo,
            'iframe_urls'                   =>  $iframe_urls
        ]);
    }
    public function lang(){
        return view('admin.settings.lang')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function email(){
        return view('admin.settings.email')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function slideshow(){
        return view('admin.settings.slideshow')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function site_images(){
        return view('admin.settings.site-images')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function comment(){
        return view('admin.settings.comment')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function widget(){
        return view('admin.settings.widget')->with([
            'is_demo'                       =>  Auth::user()->is_demo
        ]);
    }
    public function update_general(Request $request){
        $output                             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->site_name          =   $request->input( 'name' );
        $this->settings->site_title         =   $request->input( 'title' );
        $this->settings->site_desc          =   $request->input( 'desc' );
        $this->settings->display_count      =   $request->input( 'display_count' );
        $this->settings->google_font        =   $request->input( 'google_font' );
        $this->settings->site_font          =   $request->input( 'site_font' );

        $this->settings->aws_s3             =   $request->input( 'aws_s3' );
        $this->settings->aws_s3_key         =   $request->input( 'aws_s3_key' );
        $this->settings->aws_s3_secret      =   $request->input( 'aws_s3_secret' );
        $this->settings->aws_s3_region      =   $request->input( 'aws_s3_region' );
        $this->settings->aws_s3_bucket      =   $request->input( 'aws_s3_bucket' );

        $this->settings->sidebar_ad         =   $request->input( 'sidebar_ad' );
        $this->settings->header_ad          =   $request->input( 'header_ad' );
        $this->settings->footer_ad          =   $request->input( 'footer_ad' );
        $this->settings->list_ad            =   $request->input( 'list_ad' );
        $this->settings->list_ad_type       =   $request->input( 'list_ad_type' );
        $this->settings->list_ad_nth_count  =   $request->input( 'ad_nth_count' );
        $this->settings->site_color         =   $request->input( 'color' );
        $this->settings->cache_enabled      =   $request->input( 'cache_enabled' );
        $this->settings->homepage_type      =   $request->input( 'homepage_type' );
        $this->settings->custom_css         =   $request->input( 'custom_css' );
        $this->settings->facebook           =   $request->input( 'facebook' );
        $this->settings->twitter            =   $request->input( 'twitter' );
        $this->settings->gp                 =   $request->input( 'gp' );
        $this->settings->youtube            =   $request->input( 'youtube' );
        $this->settings->soundcloud         =   $request->input( 'soundcloud' );
        $this->settings->instagram          =   $request->input( 'instagram' );
        $this->settings->fb_app_key                     =   $request->input( 'fb_key' );
        $this->settings->fb_app_secret                  =   $request->input( 'fb_secret' );
        $this->settings->twitter_client_id              =   $request->input( 'twitter_key' );
        $this->settings->twitter_client_secret          =   $request->input( 'twitter_secret' );
        $this->settings->google_client_id               =   $request->input( 'google_key' );
        $this->settings->google_client_secret           =   $request->input( 'google_secret' );
        $this->settings->soundcloud_client_id           =   $request->input( 'sc_client_id' );
        $this->settings->soundcloud_client_secret       =   $request->input( 'sc_client_secret' );
        $this->settings->google_analytics_tracking_id   =   $request->input( 'ga_tracking_id' );
        $this->settings->recaptcha_public_key           =   $request->input( 'recaptcha_public_key' );
        $this->settings->save();

        Storage::disk('local')->put('tos.html', $request->input('tos') );

        JaskoHelper::update_env( $this->settings );
        JaskoHelper::update_htaccess( $this->settings );

        $output['status']                   =   2;
        return response()->json( $output );
    }
    public function update_media(Request $request){
        $output                             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->max_media_img_size         =   $request->input( 'max_img_size' );
        $this->settings->isPreapproved              =   $request->input( 'preapprove_media' );
        $this->settings->allow_custom_memes         =   $request->input( 'custom_memes' );
        $this->settings->send_approved_media_email  =   $request->input( 'send_media_approve_email' );
        $this->settings->infinite_pagination        =   $request->input( 'infinite_pagination' );
        $this->settings->duplicate_list             =   $request->input( 'duplicate_list' );
        $this->settings->notify_user_duplicate_list =   $request->input( 'notify_duplicate_list' );
        $this->settings->poll_signed_in_votes       =   $request->input( 'poll_signed_in_votes' );
        $this->settings->allow_embeds               =   $request->input( 'allow_embeds' );
        $this->settings->auto_scroll                =   $request->input( 'auto_scroll' );
        $this->settings->auto_scroll_timer          =   $request->input( 'auto_scroll_timer' );
        $this->settings->generate_special_share_img =   $request->input( 'generate_share_img' );

        $this->settings->canCreatePoll              =   $request->input( 'create_polls' );
        $this->settings->canCreateTrivia            =   $request->input( 'create_trivia' );
        $this->settings->canCreatePersonality       =   $request->input( 'create_personality' );
        $this->settings->canCreateImage             =   $request->input( 'create_images' );
        $this->settings->canCreateMeme              =   $request->input( 'create_memes' );
        $this->settings->canCreateVideo             =   $request->input( 'create_videos' );
        $this->settings->canCreateArticles          =   $request->input( 'create_articles' );
        $this->settings->canCreateLists             =   $request->input( 'create_lists' );
        $this->settings->canViewPoll                =   $request->input( 'view_polls' );
        $this->settings->canViewQuiz                =   $request->input( 'view_quiz' );
        $this->settings->canViewImage               =   $request->input( 'view_images' );
        $this->settings->canViewVideo               =   $request->input( 'view_videos' );
        $this->settings->canViewArticles            =   $request->input( 'view_articles' );
        $this->settings->canViewLists               =   $request->input( 'view_lists' );
        $this->settings->media_overrides            =   json_encode([
            'poll_page_content'                     =>  $request->input( 'check_poll_page_content' ) == "true" ? 2 : 1,
            'poll_style'                            =>  $request->input( 'check_poll_style' ) == "true" ? 2 : 1,
            'poll_animation'                        =>  $request->input( 'check_poll_animation' ) == "true" ? 2 : 1,
            'quiz_page_content'                     =>  $request->input( 'check_quiz_page_content' ) == "true" ? 2 : 1,
            'quiz_animation'                        =>  $request->input( 'check_quiz_animation' ) == "true" ? 2 : 1,
            'quiz_style'                            =>  $request->input( 'check_quiz_style' ) == "true" ? 2 : 1,
            'quiz_timed'                            =>  $request->input( 'check_quiz_timed' ) == "true" ? 2 : 1,
            'quiz_timer'                            =>  $request->input( 'check_quiz_timer' ) == "true" ? 2 : 1,
            'quiz_randomize_questions'              =>  $request->input( 'check_quiz_randomize_questions' ) == "true" ? 2 : 1,
            'quiz_randomize_answers'                =>  $request->input( 'check_quiz_randomize_answers' ) == "true" ? 2 : 1,
            'quiz_show_correct_answer'              =>  $request->input( 'check_quiz_show_correct_answer' ) == "true" ? 2 : 1,
            'image_page_content'                    =>  $request->input( 'check_image_page_content' ) == "true" ? 2 : 1,
            'meme_page_content'                     =>  $request->input( 'check_meme_page_content' ) == "true" ? 2 : 1,
            'video_page_content'                    =>  $request->input( 'check_video_page_content' ) == "true" ? 2 : 1,
            'list_page_content'                     =>  $request->input( 'check_list_page_content' ) == "true" ? 2 : 1,
            'list_style'                            =>  $request->input( 'check_list_style' ) == "true" ? 2 : 1,
            'list_animation'                        =>  $request->input( 'check_list_animation' ) == "true" ? 2 : 1
        ]);
        $this->settings->media_defaults             =   json_encode([
            'poll_style'                            =>  $request->input( 'poll_style' ),
            'poll_animation'                        =>  $request->input( 'poll_animation' ),
            'quiz_animation'                        =>  $request->input( 'quiz_animation' ),
            'quiz_style'                            =>  $request->input( 'quiz_style' ),
            'quiz_timed'                            =>  $request->input( 'quiz_timed' ),
            'quiz_timer'                            =>  $request->input( 'quiz_timer' ),
            'quiz_randomize_questions'              =>  $request->input( 'quiz_randomize_questions' ),
            'quiz_randomize_answers'                =>  $request->input( 'quiz_randomize_answers' ),
            'quiz_show_correct_answer'              =>  $request->input( 'quiz_show_correct_answer' ),
            'list_style'                            =>  $request->input( 'list_style' ),
            'list_animation'                        =>  $request->input( 'list_animation' ),
        ]);
        $this->settings->save();

        $output['status']                           =   2;
        return response()->json( $output );
    }
    public function update_users(Request $request){
        $output                                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->user_registration      =   $request->input( 'registration' );
        $this->settings->confirm_registration   =   $request->input( 'confirm_reg' );
        $this->settings->profile_img_size       =   $request->input( 'profile_img_size' );
        $this->settings->save();

        $output['status']                       =   2;
        return response()->json( $output );
    }
    public function update_security(Request $request){
        $output                                         =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->iframe_urls                    =   empty($request->input('urls')) ? '[]' : json_encode( $request->input( 'urls' ) );
        $this->settings->save();

        $output['status']                               =   2;
        return response()->json( $output );
    }
    public function update_email(Request $request){
        $output                             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->enable_newsletter_subscribe          =   $request->input( 'newsletter' );
        $this->settings->mailchimp_api_key  =   $request->input( 'mc_api_key' );
        $this->settings->mailchimp_list_id  =   $request->input( 'mc_list_id' );
        $this->settings->save();

        JaskoHelper::update_env( $this->settings );

        $output['status']                   =   2;
        return response()->json( $output );
    }
    public function update_lang(Request $request){
        $output                                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        if( !file_exists( base_path( '/resources/lang/' . $request->input('default_lang') ) ) ){
            return response()->json($output);
        }

        $this->settings->default_lang           =   $request->input( 'default_lang' );
        $this->settings->lang_switcher          =   $request->input( 'lang_switcher' );
        $this->settings->lang_switcher_loc      =   $request->input( 'lang_switcher_loc' );
        $this->settings->languages              =   empty( $request->input( 'langs' ) ) ? '[]' : json_encode( $request->input( 'langs' ) );
        $this->settings->save();

        JaskoHelper::update_env( $this->settings );

        $output['status']                       =   2;
        return response()->json( $output );
    }
    public function update_slideshow(Request $request){
        $output                                         =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->slides                         =   empty($request->input('slides')) ? '[]' : json_encode( $request->input( 'slides' ) );
        $this->settings->save();

        $output['status']                               =   2;
        return response()->json( $output );
    }
    public function update_logo(Request $request){
        $output                                         =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->logo_type                      =   $request->input('logo_type');

        if($request->hasFile('logo_img')) {
            $img                                        =   $request->file( 'logo_img' );
            $name                                       =   $img->getClientOriginalName();
            $destination                                =   base_path() . '/public/uploads/';
            $img->move( $destination, $name );
            $this->settings->logo_img                   =   $img->getClientOriginalName();
        }

        $this->settings->save();

        $output['status']                               =   2;
        return response()->json( $output );
    }
    public function update_watermark(Request $request){
        $output                                         =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->watermark_enabled              =   $request->input('enable_watermark');
        $this->settings->watermark_x_pos                =   $request->input('x_pos');
        $this->settings->watermark_y_pos                =   $request->input('y_pos');

        if($request->hasFile('watermark_img')) {
            $img                                        =   $request->file( 'watermark_img' );
            $name                                       =   $img->getClientOriginalName();
            $destination                                =   base_path() . '/public/uploads/';
            $img->move( $destination, $name );
            $this->settings->watermark_img_url          =   $img->getClientOriginalName();
        }

        $this->settings->save();

        $output['status']                               =   2;
        return response()->json( $output );
    }
    public function update_nsfw(Request $request){
        $output                                         =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        if($request->hasFile('nsfw_img')) {
            $img                                        =   $request->file( 'nsfw_img' );
            $name                                       =   $img->getClientOriginalName();
            $destination                                =   base_path() . '/public/uploads/';
            $img->move( $destination, $name );
            $this->settings->nsfw_img                   =   $img->getClientOriginalName();
        }

        $this->settings->save();

        $output['status']                               =   2;
        return response()->json( $output );
    }
    public function update_favicon(Request $request){
        $output                                         =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        if($request->hasFile('favicon')) {
            $img                                        =   $request->file( 'favicon' );
            $name                                       =   $img->getClientOriginalName();
            $destination                                =   base_path() . '/public/uploads/';
            $img->move( $destination, $name );
            $this->settings->favicon                    =   $img->getClientOriginalName();
        }

        $this->settings->save();

        $output['status']                               =   2;
        return response()->json( $output );
    }
    public function update_comment(Request $request){
        $output                             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->system_comments    =   $request->input( 'site_comments' );
        $this->settings->fb_comments        =   $request->input( 'fb_comments' );
        $this->settings->disqus_comments    =   $request->input( 'disqus_comments' );
        $this->settings->disqus_shortname   =   $request->input( 'disqus_shortname' );
        $this->settings->main_comment_system=   $request->input( 'main_comment_system' );
        $this->settings->save();

        $output['status']                   =   2;
        return response()->json( $output );
    }
    public function update_widget(Request $request){
        $output                             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $this->settings->widgets            =   empty( $request->input('widgets') ) ? '[]' : json_encode( $request->input( 'widgets' ));
        $this->settings->save();

        $output['status']                   =   2;
        return response()->json( $output );
    }
}