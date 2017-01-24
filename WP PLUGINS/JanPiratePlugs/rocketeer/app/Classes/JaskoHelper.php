<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 11/15/2015
 * Time: 6:46 PM
 */
namespace App\Classes;

use Imagecraft\ImageBuilder;
use App\Classes\Zebra_Image;
use App\Classes\PHPImage;
use App\SiteSettings;
use App\UserUploads;
use App\Badge;
use App\UserBadge;
use Storage;
use Purifier;
use Mail;
use Auth;

class JaskoHelper {
    protected $settings;
    public static $countryArray             =   array(  'AE' => 'United Arab Emirates', 'AF' => 'Afghanistan', 'AG' => 'Antigua and Barbuda',
        'AL' => 'Albania', 'AM' => 'Armenia', 'AO' => 'Angola', 'AR' => 'Argentia',
        'AT' => 'Austria', 'AU' => 'Australia', 'AZ' => 'Azerbaijan', 'BA' => 'Bosnia and Herzegovina',
        'BB' => 'Barbados', 'BD' => 'Bangladesh', 'BE' => 'Belgium', 'BF' => 'Burkina Faso',
        'BG' => 'Bulgaria', 'BI' => 'Burundi', 'BJ' => 'Benin', 'BN' => 'Brunei Darussalam',
        'BO' => 'Bolivia', 'BR' => 'Brazil', 'BS' => 'Bahamas', 'BT' => 'Bhutan',
        'BW' => 'Botswana', 'BY' => 'Belarus', 'BZ' => 'Belize', 'CA' => 'Canada',
        'CD' => 'Congo', 'CF' => 'Central African Republic', 'CG' => 'Congo', 'CH' => 'Switzerland',
        'CI' => "Cote d'Ivoire", 'CL' => 'Chile', 'CM' => 'Cameroon', 'CN' => 'China', 'CO' => 'Colombia',
        'CR' => 'Costa Rica', 'CU' => 'Cuba', 'CV' => 'Cape Verde', 'CY' => 'Cyprus',
        'CZ' => 'Czech Republic', 'DE' => 'Germany', 'DJ' => 'Djibouti', 'DK' => 'Denmark',
        'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'DZ' => 'Algeria', 'EC' => 'Ecuador',
        'EE' => 'Estonia', 'EG' => 'Egypt', 'ER' => 'Eritrea', 'ES' => 'Spain', 'ET' => 'Ethiopia',
        'FI' => 'Finland', 'FJ' => 'Fiji', 'FK' => 'Falkland Islands', 'FR' => 'France', 'GA' => 'Gabon',
        'GB' => 'United Kingdom', 'GD' => 'Grenada', 'GE' => 'Georgia', 'GF' => 'French Guiana',
        'GH' => 'Ghana', 'GL' => 'Greenland', 'GM' => 'Gambia', 'GN' => 'Guinea', 'GQ' => 'Equatorial Guinea',
        'GR' => 'Greece', 'GT' => 'Guatemala', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HN' => 'Honduras',
        'HR' => 'Croatia', 'HT' => 'Haiti', 'HU' => 'Hungary', 'ID' => 'Indonesia', 'IE' => 'Ireland',
        'IL' => 'Israel', 'IN' => 'India', 'IQ' => 'Iraq', 'IR' => 'Iran', 'IS' => 'Iceland',
        'IT' => 'Italy', 'JM' => 'Jamaica', 'JO' => 'Jordan', 'JP' => 'Japan', 'KE' => 'Kenya',
        'KG' => 'Kyrgyz Republic', 'KH' => 'UrlId', 'KM' => 'Comoros', 'KN' => 'Saint Kitts and Nevis',
        'KP' => 'North Korea', 'KR' => 'South Korea', 'KW' => 'Kuwait', 'KZ' => 'Kazakhstan',
        'LA' => "Lao People's Democratic Republic", 'LB' => 'Lebanon', 'LC' => 'Saint Lucia',
        'LK' => 'Sri Lanka', 'LR' => 'Liberia', 'LS' => 'Lesotho', 'LT' => 'Lithuania', 'LV' => 'Latvia',
        'LY' => 'Libya', 'MA' => 'Morocco', 'MD' => 'Moldova', 'MG' => 'Madagascar', 'MK' => 'Macedonia',
        'ML' => 'Mali', 'MM' => 'Myanmar', 'MN' => 'Mongolia', 'MR' => 'Mauritania', 'MT' => 'Malta',
        'MU' => 'Mauritius', 'MV' => 'Maldives', 'MW' => 'Malawi', 'MX' => 'Mexico', 'MY' => 'Malaysia',
        'MZ' => 'Mozambique', 'NA' => 'Namibia', 'NC' => 'New Caledonia', 'NE' => 'Niger',
        'NG' => 'Nigeria', 'NI' => 'Nicaragua', 'NL' => 'Netherlands', 'NO' => 'Norway', 'NP' => 'Nepal',
        'NZ' => 'New Zealand', 'OM' => 'Oman', 'PA' => 'Panama', 'PE' => 'Peru', 'PF' => 'French Polynesia',
        'PG' => 'Papua New Guinea', 'PH' => 'Philippines', 'PK' => 'Pakistan', 'PL' => 'Poland',
        'PT' => 'Portugal', 'PY' => 'Paraguay', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania',
        'RS' => 'Serbia', 'RU' => 'Russian Federationß', 'RW' => 'Rwanda', 'SA' => 'Saudi Arabia',
        'SB' => 'Solomon Islands', 'SC' => 'Seychelles', 'SD' => 'Sudan', 'SE' => 'Sweden',
        'SI' => 'Slovenia', 'SK' => 'Slovakia', 'SL' => 'Sierra Leone', 'SN' => 'Senegal',
        'SO' => 'Somalia', 'SR' => 'Suriname', 'ST' => 'Sao Tome and Principe', 'SV' => 'El Salvador',
        'SY' => 'Syrian Arab Republic', 'SZ' => 'Swaziland', 'TD' => 'Chad', 'TG' => 'Togo',
        'TH' => 'Thailand', 'TJ' => 'Tajikistan', 'TL' => 'Timor-Leste', 'TM' => 'Turkmenistan',
        'TN' => 'Tunisia', 'TR' => 'Turkey', 'TT' => 'Trinidad and Tobago', 'TW' => 'Taiwan',
        'TZ' => 'Tanzania', 'UA' => 'Ukraine', 'UG' => 'Uganda', 'US' => 'United States of America',
        'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'VU' => 'Vanuatu',
        'YE' => 'Yemen', 'ZA' => 'South Africa', 'ZM' => 'Zambia','ZW' => 'Zimbabwe'
    );
    protected static $colors                       =   [
        "alizarin" => "#e74c3c", "android" => "#9c0", "apple" => "#a7a9ab",
        "asbestos" => "7f8c8d", "behance"=> "#0c77a1", "belizehole"=> "#2980b9",
        "black" => "#424242", "blogger"=> "#f6821f", "blue"=> "#4fc1e9", "carrot"=> "#e67e22",
        "chrome"=> "#ce4e4d","clouds"=> "#ecf0f1","concrete"=> "#95a5a6","delicious"=> "#3399ff",
        "deviantart"=> "#404f4c","dribbble"=> "#ea4c89","dropbox"=> "#007ee5","emerald"=> "#2ecc71",
        "evernote"=> "#5fb336","facebook"=> "#395693","firefox"=> "#ca4b27","flattr"=> "#7fa92c",
        "flickr"=> "#1e75ce","forrst"=> "#3b7140","foursquare"=> "#1db0ec","github"=> "#bd2c00",
        "googleplus"=> "#df4a32","green"=> "#a0d468","greensea"=> "#16a085","icomoon"=> "#b35047",
        "ie"=> "#14b8f7","instagram"=> "#3a688f","joomla"=> "#1578b3","lanyrd"=> "#163459",
        "lastfm"=> "#d81c23", "linkedin"=> "#0977b5","midnightblue"=> "#2c3e50","mixi"=> "#d1ad59",
        "nephritis"=> "#27ae60", "opera"=> "#cc0f16","orange"=> "#f39c12","paypal"=> "#00457c",
        "picasa"=> "#846c9e","pinterest"=> "#cb2027","pomegranate"=> "#c0392b","pumpkin"=> "#d35400",
        "purple"=> "#8e44ad","red"=> "#ed5565","reddit"=> "#ff3d00","renren"=> "#105ba3",
        "rss"=> "#f79738","safari"=> "#6dadec","silver"=> "#bdc3c7","sky"=> "#3BBFA7",
        "skype"=> "#15adf0","smashing"=> "#e6402d","soundcloud"=> "#fe531b","stackoverflow"=> "#f47a20",
        "steam"=> "#343434","sunflower"=> "#f1c40f","teal"=> "#0dd3bb","tumblr"=> "#385774",
        "turquoise"=> "#1abc9c","twitter"=> "#00acee","vimeo"=> "#1ab7ea","vk"=> "#54769a",
        "wetasphalt"=> "#34495e","windows"=> "#00ccff","wordpress"=> "#22769b","yahoo"=> "#500095",
        "yelp"=> "#c21200","youtube"=> "#cd332d"
    ];

    public static function thumbnail($img_id, $type){
        if(empty($img_id)){
            return "default-" . $type . "-thumbnail.png";
        }

        $user                           =   Auth::user();
        $user_upload                    =   UserUploads::where([
            'id'                        =>  $img_id,
            'uid'                       =>  $user->id
        ]);

        if(!$user_upload->exists()){
            return "default-" . $type . "-thumbnail.png";
        }

        $user_upload                    =   $user_upload->first();
        $thumbnail                      =   $user_upload->upl_name;

        // thumbnail name
        $thumbnail_name                 =   basename($thumbnail);
        $thumbnail_name                 =   explode(".", $thumbnail_name);

        $builder                        =   new ImageBuilder([
            'engine'                    =>  'php_gd',
            'locale'                    =>  'en'
        ]);

        $image                          =   $builder
            ->addBackgroundLayer()
            ->filename( base_path('public/uploads') . '/' . $thumbnail )
            ->resize(200, 200, 'fill_crop')
            ->done()
            ->save();

        if ($image->isValid()) {
            file_put_contents(
                base_path('public/uploads') . '/' . $user->upl_dir . '/' . $thumbnail_name[0] . '_thumbnail.' . $thumbnail_name[1],
                $image->getContents()
            );
        }

        $settings                       =   SiteSettings::find(1);
        if($settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . '/' . $thumbnail_name[0] . '_thumbnail.' . $thumbnail_name[1] );
        }

        $thumbnailObj                   =   UserUploads::create([
            'uid'                       =>  $user->id,
            'original_name'             =>  $user_upload->original_name,
            'upl_name'                  =>  $user->upl_dir . '/' . $thumbnail_name[0] . '_thumbnail.' . $thumbnail_name[1]
        ]);

        return $thumbnailObj->upl_name;
    }

    public static function featured_image($img_id, $type){
        if(empty($img_id)){
            return "default-" . $type . "-thumbnail.png";
        }

        $user                           =   Auth::user();
        $user_upload                    =   UserUploads::where([
            'id'                        =>  $img_id,
            'uid'                       =>  $user->id
        ]);

        if(!$user_upload->exists()){
            return "default-" . $type . "-thumbnail.png";
        }

        $user_upload                    =   $user_upload->first();
        $thumbnail                      =   $user_upload->upl_name;

        // thumbnail name
        $thumbnail_name                 =   basename($thumbnail);
        $thumbnail_name                 =   explode(".", $thumbnail_name);

        $builder                        =   new ImageBuilder([
            'engine'                    =>  'php_gd',
            'locale'                    =>  'en'
        ]);

        $image                          =   $builder
            ->addBackgroundLayer()
            ->filename( base_path('public/uploads') . '/' . $thumbnail )
            ->resize(550, 200, 'fill_crop')
            ->done()
            ->save();

        if ($image->isValid()) {
            file_put_contents(
                base_path('public/uploads') . '/' . $user->upl_dir . '/' . $thumbnail_name[0] . '_featured.' . $thumbnail_name[1],
                $image->getContents()
            );
        }

        $settings                       =   SiteSettings::find(1);
        if($settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . '/' . $thumbnail_name[0] . '_featured.' . $thumbnail_name[1] );
        }

        $thumbnailObj                   =   UserUploads::create([
            'uid'                       =>  $user->id,
            'original_name'             =>  $user_upload->original_name,
            'upl_name'                  =>  $user->upl_dir . '/' . $thumbnail_name[0] . '_featured.' . $thumbnail_name[1]
        ]);

        return $thumbnailObj->upl_name;
    }

    public static function share_img($img_id, $type, $txt){
        if(empty($img_id)){
            return "default-" . $type . "-thumbnail.png";
        }

        $user                           =   Auth::user();
        $user_upload                    =   UserUploads::where([
            'id'                        =>  $img_id,
            'uid'                       =>  $user->id
        ]);
        $settings                       =   SiteSettings::find(1);

        if(!$user_upload->exists()){
            return "default-" . $type . "-thumbnail.png";
        }

        $user_upload                    =   $user_upload->first();
        $thumbnail                      =   $user_upload->upl_name;

        // thumbnail name
        $thumbnail_name                 =   basename($thumbnail);
        $thumbnail_name                 =   explode(".", $thumbnail_name);

        $image                          =   new PHPImage();
        $image->setDimensionsFromImage( base_path('public/uploads') . '/' . $thumbnail );
        $image->draw( base_path('public/uploads') . '/' . $thumbnail );
        $image->resize( 1200, 630, true, true );

        // Check if special images enabled
        if($settings->generate_special_share_img == 2){
            $image->rectangle( 0, 515, 1200, 125, JaskoHelper::hextorgb( self::$colors[$settings->site_color]), 0.8 ); // X, Y, Width, Height, RGB, Opacity (optional)
            $image->setFont( storage_path('app/arialbd.ttf') );
            $image->setAlignVertical( 'center' );
            $image->setAlignHorizontal( 'center' );
            $image->setTextColor(array(255, 255, 255));
            $image->textBox( $txt, array(
                'fontSize'                  =>  30, // Desired starting font size
                'x'                         =>  15,
                'y'                         =>  530,
                'width'                     =>  1150,
                'height'                    =>  105,
                'debug'                     =>  false
            ));
        }

        $image->save( base_path('public/uploads') . '/' . $user->upl_dir . '/' . $thumbnail_name[0] . '_social.png' );

        $settings                       =   SiteSettings::find(1);
        if($settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . '/' . $thumbnail_name[0] . '_social.png' );
        }

        $thumbnailObj                   =   UserUploads::create([
            'uid'                       =>  $user->id,
            'original_name'             =>  $user_upload->original_name,
            'upl_name'                  =>  $user->upl_dir . '/' . $thumbnail_name[0] . '_social.png'
        ]);
        return $thumbnailObj->upl_name;
    }

    public static function get_countries(){
        return self::$countryArray;
    }

    public static function approve_media(){
        if(!Auth::check() || Auth::user()->is_demo == 2){
            return 1;
        }

        if(Auth::user()->isAdmin == 2 || Auth::user()->autoapprove == 2){
            return 2;
        }

        $settings               =   SiteSettings::find(1);

        if($settings->isPreapproved == 1){
            return 2;
        }

        return 1;
    }

    public static function youtube_thumbnail($id){
        $youtube_thumbnail                      =   file_get_contents("http://img.youtube.com/vi/" . $id . "/mqdefault.jpg");
        $user                                   =   Auth::user();
        $new_name                               =   str_random( mt_rand(6, 16) ) . '.jpg';
        $location                               =   $user->upl_dir . '/' . $new_name;

        file_put_contents( base_path('public/uploads') . '/' .$location,$youtube_thumbnail);

        $settings                       =   SiteSettings::find(1);
        if($settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $location );
        }

        return $location;
    }

    public static function youtube_featured_image($id){
        $youtube_thumbnail                      =   file_get_contents("http://img.youtube.com/vi/" . $id . "/hqdefault.jpg");
        $user                                   =   Auth::user();
        $new_name                               =   str_random( mt_rand(6, 16) ) . '.jpg';
        $location                               =   $user->upl_dir . '/' . $new_name;

        file_put_contents( base_path('public/uploads') . '/' .$location,$youtube_thumbnail);

        $settings                       =   SiteSettings::find(1);
        if($settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $location );
        }

        return $location;
    }

    public static function dl_thumbnail($url){
        $youtube_thumbnail                      =   file_get_contents($url);
        $user                                   =   Auth::user();
        $new_name                               =   str_random( mt_rand(6, 16) ) . '.jpg';
        $location                               =   $user->upl_dir . '/' . $new_name;

        file_put_contents( base_path('public/uploads') . '/' .$location,$youtube_thumbnail);

        $settings                       =   SiteSettings::find(1);
        if($settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $location );
        }

        return $location;
    }

    public static function update_env($s){
        $env_file                   =   Storage::get('env.txt');

        $env_file                   =   str_replace( "APP_DOMAIN=", "APP_DOMAIN=" . url('/'), $env_file );
        $env_file                   =   str_replace( "DB_HOST=", "DB_HOST=" . env('DB_HOST'), $env_file );
        $env_file                   =   str_replace( "DB_DATABASE=", "DB_DATABASE=" . env('DB_DATABASE'), $env_file );
        $env_file                   =   str_replace( "DB_USERNAME=", "DB_USERNAME=" . env('DB_USERNAME'), $env_file );
        $env_file                   =   str_replace( "DB_PASSWORD=", "DB_PASSWORD=" . env('DB_PASSWORD'), $env_file );

        $env_file                   =   str_replace( "ROCKETEER_LOCALE=", "ROCKETEER_LOCALE=" . $s->default_lang, $env_file );

        $env_file                   =   str_replace( "FACEBOOK_CLIENT_ID=", "FACEBOOK_CLIENT_ID=" . $s->fb_app_key, $env_file );
        $env_file                   =   str_replace( "FACEBOOK_CLIENT_SECRET=", "FACEBOOK_CLIENT_SECRET=" . $s->fb_app_secret, $env_file );
        $env_file                   =   str_replace( "FACEBOOK_REDIRECT_URL=", "FACEBOOK_REDIRECT_URL=" . url('/auth/facebook/callback') , $env_file );

        $env_file                   =   str_replace( "TWITTER_CLIENT_ID=", "TWITTER_CLIENT_ID=" . $s->twitter_client_id, $env_file );
        $env_file                   =   str_replace( "TWITTER_CLIENT_SECRET=", "TWITTER_CLIENT_SECRET=" . $s->twitter_client_secret, $env_file );
        $env_file                   =   str_replace( "TWITTER_REDIRECT_URL=", "TWITTER_REDIRECT_URL=" . url('/auth/twitter/callback') , $env_file );

        $env_file                   =   str_replace( "GOOGLE_CLIENT_ID=", "GOOGLE_CLIENT_ID=" . $s->google_client_id, $env_file );
        $env_file                   =   str_replace( "GOOGLE_CLIENT_SECRET=", "GOOGLE_CLIENT_SECRET=" . $s->google_client_secret, $env_file );
        $env_file                   =   str_replace( "GOOGLE_REDIRECT_URL=", "GOOGLE_REDIRECT_URL=" . url('/auth/google/callback'), $env_file );

        $env_file                   =   str_replace( "AWS_S3_KEY=", "AWS_S3_KEY=" . $s->aws_s3_key, $env_file );
        $env_file                   =   str_replace( "AWS_S3_SECRET=", "AWS_S3_SECRET=" . $s->aws_s3_secret, $env_file );
        $env_file                   =   str_replace( "AWS_S3_REGION=", "AWS_S3_REGION=" .$s->aws_s3_region, $env_file );
        $env_file                   =   str_replace( "AWS_S3_BUCKET=", "AWS_S3_BUCKET=" . $s->aws_s3_bucket, $env_file );

        $env_file                   =   str_replace( "MC_API_KEY=", "MC_API_KEY=" . $s->mailchimp_api_key, $env_file );

        file_put_contents( base_path( '.env' ), $env_file );
    }

    public static function update_htaccess( $s ){
        $htaccess                   =   Storage::get('htaccess.txt');

        $htaccess_cache             =   $s->cache_enabled == 2 ? Storage::get('htaccess-cache.txt') : '' ;
        $htaccess                   =   str_replace( "CACHE_PLACEHOLDER", $htaccess_cache, $htaccess );

        file_put_contents( base_path( '.htaccess' ), $htaccess );
    }

    public static function send_approved_medial_email($media){
        $settings                       =   SiteSettings::find(1);

        $sent                           =   Mail::send('email.media-approved', ['media' => $media], function ($m) use ($media, $settings){
            $m->from( 'no-reply@' . $settings->site_domain, $settings->site_name);
            $m->to( $media->author->email, $media->author->username);
            $m->subject( $settings->site_name . ' - Your submission has been approved!' );
        });

        if(!$sent){
            return false;
        }

        return true;
    }

    public static function resize_image( $original_path, $new_path, $width, $height ){
        $image                          =   new Zebra_Image();
        $image->source_path             =   $original_path;
        $image->target_path             =   $new_path;
        $image->jpeg_quality            =   80;
        $image->preserve_aspect_ratio   = true;
        $image->enlarge_smaller_images  = true;
        $image->resize($width, $height, ZEBRA_IMAGE_CROP_CENTER);

        return $new_path;
    }

    public static function aws_s3_upload( $file_path ){
        Storage::disk('s3')->put(
            $file_path,
            file_get_contents( public_path( 'uploads/' . $file_path) )
        );
    }

    public static function subscribe_to_newsletter( $email ){
        $settings                       =   SiteSettings::find(1);

        if( $settings->enable_newsletter_subscribe == 1 ){
            return false;
        }

        $mailchimp                      =   app('Mailchimp');

        try {
            $mailchimp->lists->subscribe(
                $settings->mailchimp_list_id,
                [
                    'email'             =>  $email
                ]
            );
        } catch (\Mailchimp_List_AlreadySubscribed $e) {
            return true;
        } catch (\Mailchimp_Error $e){
            return false;
        }

        return true;
    }

    public static function hextorgb($hex, $alpha = false) {
        $hex = str_replace('#', '', $hex);
        if ( strlen($hex) == 6 ) {
            $rgb[] = hexdec(substr($hex, 0, 2));
            $rgb[] = hexdec(substr($hex, 2, 2));
            $rgb[] = hexdec(substr($hex, 4, 2));
        }
        else if ( strlen($hex) == 3 ) {
            $rgb[] = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $rgb[] = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $rgb[] = hexdec(str_repeat(substr($hex, 2, 1), 2));
        }
        else {
            $rgb[] = '0';
            $rgb[] = '0';
            $rgb[] = '0';
        }
        if ( $alpha ) {
            $rgb[] = $alpha;
        }
        return $rgb;
    }

    public static function clean( $html ){
        return $html;
    }

    public static function add_badge( $user ){
        $badges                     =   Badge::all();

        foreach( $badges as $badge ){
            if( $badge->min_points >= $user->points ) continue; // 50 >= 5

            // Check if User has badge
            $badge_check            =   UserBadge::where([
                'uid'               =>  $user->id,
                'bid'               =>  $badge->id
            ]);

            if( $badge_check->exists() ) continue;

            // User doesn't have badge. Add Badge
            $user_badge             =   UserBadge::create([
                'uid'               =>  $user->id,
                'bid'               =>  $badge->id
            ]);
        }
    }

    public static function check_img_orientation( $path ){
        $exif                       =   exif_read_data( public_path() . '/uploads/' . $path );

        if (!empty($exif['Orientation'])) {
            $image                  =   imagecreatefromjpeg( public_path() . '/uploads/' . $path );

            switch ($exif['Orientation']) {
                case 3:
                    $image          =   imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image          =   imagerotate($image, -90, 0);
                    break;
                case 8:
                    $image          =   imagerotate($image, 90, 0);
                    break;
            }

            imagejpeg( $image, public_path() . '/uploads/' . $path , 90 );
        }
    }
}