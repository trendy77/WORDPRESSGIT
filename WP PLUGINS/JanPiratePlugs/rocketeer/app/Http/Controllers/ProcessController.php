<?php

namespace App\Http\Controllers;

use App\Classes\JaskoHelper;
use App\Pages;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Imagecraft\ImageBuilder;
use App\Classes\PHPImage;
use App\Classes\Zebra_Image;
use App\User;
use App\UserUploads;
use App\SiteSettings;
use App\Media;
use App\MediaLikes;
use App\MediaPoints;
use Mail;
use Validator;
use Auth;

class ProcessController extends Controller
{
    protected $settings;

    public function __construct(){
        $this->settings                 =   SiteSettings::find(1);
    }

    public function upload_media_img(Request $request){
        $output                 =   [ 'status' => 1 ];

        $validator              =   Validator::make($request->all(), [
            'img'               => 'required|image',
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json($output);
        }

        $settings               =   SiteSettings::find(1);
        $img                    =   $request->file( 'img' );
        $new_name               =   str_random( mt_rand(4,16) ) . "." . $img->getClientOriginalExtension();
        $max_img_size           =   $settings->max_media_img_size * ( 1024 * 1024 );

        if($img->getClientSize() > $max_img_size){
            return response()->json($output);
        }

        // Get User
        $user                   =   Auth::user();
        $upl_dir                =   public_path() . '/uploads/' . $user->upl_dir . "/";
        $img->move( $upl_dir, $new_name );

        if( $this->settings->watermark_enabled == 2 ){
            $builder                        =   new ImageBuilder([
                'engine'                    =>  'php_gd',
                'locale'                    =>  'en'
            ]);

            $image                          =   $builder
                ->addBackgroundLayer()
                    ->filename( $upl_dir . $new_name )
                    ->done()
                ->addImageLayer()
                    ->filename( public_path() . '/uploads/' . $this->settings->watermark_img_url )
                    ->move( $this->settings->watermark_x_pos, $this->settings->watermark_y_pos, 'bottom_right')
                    ->done()
                ->save();

            if ($image->isValid()) {
                file_put_contents($upl_dir . $new_name, $image->getContents() );
            }
        }

        $upload                 =   UserUploads::create([
            'uid'               =>  $user->id,
            'original_name'     =>  $img->getClientOriginalName(),
            'upl_name'          =>  $user->upl_dir . "/" . $new_name
        ]);

        $output['status']       =   2;
        $output['img']          =   array(
            "id"            =>  $upload->id,
            "new_name"      =>  $user->upl_dir . "/" . $new_name,
            "name"          =>  $img->getClientOriginalName()
        );

        if($this->settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload($user->upl_dir . "/" . $new_name  );
        }
        
        if( $img->getClientOriginalExtension() == "jpg" ){
            JaskoHelper::check_img_orientation( $upload->upl_name );
        }

        return response()->json($output);
    }

    public function get_media_items(Request $request){
        $output                                 =   [ 'items' => [] ];

        if($request->has('types')){
            $media                              =   Media::where('status', '=',  2);
            $media                              =   $media->whereBetween( 'media_type', $request->input('types') );
        }else{
            $media                              =   Media::where( 'status', 2 );
        }

        $media                                  =   $media->orderBy('id', 'desc')->skip($request->input('offset'))->take( $this->settings->display_count )->get();

        foreach($media as $mk => $mv) {
            $media[$mk]->cat;
            $media[$mk]->author->profile_url    =   route('profile', [ 'username' => $mv->author->username ] );
            $media[$mk]->thumbnail              =   full_media_thumbnail_url( $mv );
            $media[$mk]->full_url               =   full_media_url( $mv );
            $media[$mk]->diff_for_humans        =   $media[$mk]->created_at->diffForHumans();
        }

        $output['items']                        =   $media;
        return response()->json($output);
    }

    public function get_topic_items(Request $request){
        $output                         =   [ 'items' => [] ];

        $media                          =   Media::where([
            'status'                    =>  2,
            'cid'                       =>  $request->input('tid')
        ]);

        $media                          =   $media->orderBy('id', 'desc')->skip($request->input('offset'))->take( $this->settings->display_count )->get();

        foreach($media as $mk => $mv) {
            $media[$mk]->cat;
            $media[$mk]->author->profile_url    =   url('/profile/') . $mv->author->username;
            $media[$mk]->thumbnail      =   jasko_component('/uploads/' . $mv->thumbnail);
            $media[$mk]->full_url       =   full_media_url( $mv );
            $media[$mk]->diff_for_humans        =   $media[$mk]->created_at->diffForHumans();
        }

        $output['items']                =   $media;
        return response()->json($output);
    }

    public function toggle_media_like(Request $request){
        $output                     =   [ 'status' => 1 ];
        $mid                        =   $request->input('mid');
        $media                      =   Media::find($mid);
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();

        if(!$media){
            return response()->json($output);
        }

        $author                     =   User::find($media->uid);
        $like_check                 =   MediaLikes::where([
            'mid'                   =>  $mid,
            'sid'                   =>  $sid
        ]);

        if($like_check->exists()){
            $media->like_count--;
            $media->weekly_like_count--;
            $author->points--;
            $like_check->delete();
        }else{
            $media->like_count++;
            $media->weekly_like_count++;
            $author->points++;
            $like                   =   MediaLikes::create([
                'mid'               =>  $media->id,
                'sid'               =>  $sid
            ]);

            JaskoHelper::add_badge( $author );
        }

        $author->save();
        $media->save();

        $output['likes']            =   $media->like_count;
        $output['status']           =   2;
        return response()->json($output);
    }

    public function set_language($locale){
        if($this->settings->lang_switcher != 2){
            return redirect()->route('home');
        }

        $available_languages            =   json_decode($this->settings->languages);
        $new_language                   =   $this->settings->default_lang;

        foreach($available_languages as $lang){
            if($lang->locale != $locale) continue;
            $new_language               =   $lang->locale;
        }

        session([
            'locale'                    =>  $new_language
        ]);

        return redirect()->route('home');
    }

    public function universal_newsletter_subscribe( Request $request ){
        $output                         =   [ 'status' => 1 ];

        if($this->settings->enable_newsletter_subscribe != 2){
            return response()->json( $output );
        }

        $validator                      =   Validator::make($request->all(), [
            'email'                     => 'required|email|max:255',
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        if( !JaskoHelper::subscribe_to_newsletter( e( $request->input('email') ) ) ){
            return response()->json( $output );
        }

        $output['status']               =   2;
        return response()->json( $output );
    }

    public function contact(Request $request){
        $output                         =   [ 'status' => 1 ];
        $page                           =   Pages::find($request->input('pid'));

        if(!$page || $page->page_type != 2){

            return response()->json( $output );
        }

        $validator                      =   Validator::make($request->all(), [
            'subject'                   =>  'required|min:1|max:255',
            'desc'                      =>  'required|min:10',
            'name'                      =>  'required|min:1|max:255',
            'email'                     =>  'required|email|min:1|max:255',
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        $content                        =   nl2br(e($request->input('desc')));

        Mail::send('email.contact', ['content' => $content ], function ($m) use ($request, $page){
            $m->from( $request->input('email') , $request->input('name') );

            $m->to( $page->contact_email, 'Admin' )
                ->subject( $request->input('subject') );
        });

        $output['status']               =   2;
        return response()->json( $output );
    }

    public function user_media_award_points( Request $request ){
        $output                         =   [ 'status' => 1 ];
        $user                           =   Auth::user();
        $media_point_check              =   MediaPoints::where([
            'mid'                       =>  $request->input('mid'),
            'uid'                       =>  $user->id
        ]);

        if($media_point_check->exists()){
            return response()->json($output);
        }

        $point                          =   MediaPoints::create([
            'mid'                       =>  $request->input('mid'),
            'uid'                       =>  $user->id
        ]);

        $user->points++;
        $user->save();

        $output['status']               =   2;
        return response()->json($output);
    }
}
