<?php

namespace App\Http\Controllers\Users;

use App\SiteSettings;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use App\Media;
use App\MediaLikes;
use Auth;
use App\Classes\JaskoHelper;
use App\Follower;
use App\UserBadge;
use App\Badge;
use App\UserNotification;

class UserController extends Controller
{
    protected $settings;

    public function __construct(){
        $this->settings             =   SiteSettings::find(1);
    }

    public function profile($username){
        if(!$username){
            return redirect('/');
        }

        $user                   =   User::where('username', '=', $username)->first();

        if(!$user){
            return redirect('/');
        }

        $following              =   false;

        if(Auth::check()){
            $follow_check           =   Follower::where([
                'subscriber_uid'    =>  Auth::user()->id,
                'followed_uid'      =>  $user->id
            ])->first();

            $following              =   $follow_check ? true : false;
        }

        $users_subscribed           =   Follower::where( 'followed_uid', '=', $user->id )->take(15)->get();
        $users_following            =   Follower::where( 'subscriber_uid', '=', $user->id )->take(15)->get();
        $user_sub_count             =   Follower::where( 'followed_uid', '=', $user->id )->count();
        $user_follow_count          =   Follower::where( 'subscriber_uid', '=', $user->id )->count();

        $user_badges                =   UserBadge::where( 'uid', '=', $user->id )->get();
        $badges                     =   [];
        foreach($user_badges as $user_badge){
            array_push( $badges, Badge::where( 'id', '=', $user_badge->bid )->first() );
        }

        return view('user.profile')->with([
            'site_title'            =>  $user->display_name . ' - ' . $this->settings->site_title,
            'site_desc'             =>  $this->settings->site_desc,
            'user'                  =>  $user,
            'following'             =>  $following,
            'users_subbed'          =>  $users_subscribed,
            'users_following'       =>  $users_following,
            'user_sub_count'        =>  $user_sub_count,
            'user_follow_count'     =>  $user_follow_count,
            'user_badges'           =>  $badges
        ]);
    }

    public function get_user_media_likes(Request $request){
        $output                     =   [ 'status' => 1 ];

        $validator                  =   Validator::make($request->all(), [
            'uid'                   =>  'required|integer'
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        $likes                      =   MediaLikes::where('sid', '=', $request->input('uid') )->skip($request->input('offset'))->take( $this->settings->display_count )->get();
        $items                      =   [];

        foreach($likes as $lk => $lv){
            $items[$lk]             =   Media::find($lv->mid);
            $items[$lk]->author;
            $items[$lk]->thumbnail  =   jasko_component( '/uploads/' . $items[$lk]->thumbnail ) ;
            $items[$lk]->full_url   =   full_media_url(   $items[$lk] );
            $items[$lk]->diff_for_humans        =   $items[$lk]->created_at->diffForHumans();
        }

        $output['items']            =   $items;
        $output['status']           =   2;
        return response()->json( $output );
    }

    public function get_user_media_submissions(Request $request){
        $output                     =   [ 'status' => 1 ];

        $validator                  =   Validator::make($request->all(), [
            'uid'                   =>  'required|integer'
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        $items                      =   Media::where('uid', '=', $request->input('uid') )->where('status', 2)->skip($request->input('offset'))->take( $this->settings->display_count )->get();

        foreach($items as $lk => $lv){
            $items[$lk]->author;
            $items[$lk]->thumbnail  =   jasko_component( '/uploads/' . $lv->thumbnail );
            $items[$lk]->full_url   =   full_media_url( $lv );
            $items[$lk]->diff_for_humans        =   $items[$lk]->created_at->diffForHumans();
        }

        $output['items']            =   $items;
        $output['status']           =   2;
        return response()->json( $output );
    }

    public function edit_profile_page(){
        if(!Auth::check()){
            return redirect('/');
        }

        $user                   =   Auth::user();
        $user->profile_img      =   jasko_component( '/uploads/' . $user->profile_img );
        $user->header_img       =   jasko_component( '/uploads/' . $user->header_img );

        return view( 'user.edit-profile' )->with([
            'site_title'        =>  trans('user.edit_profile') . ' - ' . $this->settings->site_title,
            'site_desc'         =>  $this->settings->site_desc,
            'user'              =>  $user,
            'countries'         =>  JaskoHelper::get_countries()
        ]);
    }

    public function update_basic_details(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(!Auth::check() || Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'display_name'      =>  'required|min:3|max:255',
            'location'          =>  'required',
            'gender'            =>  'required|integer',
            'intro'             =>  'min:3|max:255',
            'about'             =>  'min:3|max:1000'
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        $user                   =   Auth::user();
        $user->display_name     =   e( $request->input('display_name') );
        $user->location         =   e( $request->input('location') );
        $user->gender           =   intval( $request->input('gender') );
        $user->intro_text       =   e( $request->input('intro') );
        $user->about            =   e( $request->input('about') );
        $user->twitter          =   e( $request->input('twitter') );
        $user->facebook         =   e( $request->input('facebook') );
        $user->gplus            =   e( $request->input('gp') );
        $user->vk               =   e( $request->input('vk') );
        $user->soundcloud       =   e( $request->input('soundcloud') );
        $user->save();

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function upload_profile_img(Request $request){
        $output                                    =   [ 'status' => 1 ];

        if(!Auth::check() || Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        if(!$request->hasFile('img')) {
            return response()->json($output);
        }

        $user                                       =   Auth::user();
        $img                                        =   $request->file( 'img' );
        $max_size                                   =   $this->settings->profile_img_size * 1024 * 1024;

        if( $img->getClientSize() > $max_size){
            return response()->json($output);
        }

        $name                                       =   $img->getClientOriginalName();
        $destination                                =   base_path() . '/public/uploads/' . $user->upl_dir;
        $img->move( $destination, $name );

        $user->profile_img                          =   $user->upl_dir . '/' . $name;
        $user->save();

        if($this->settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . '/' . $name );
        }

        $output['img']                              =   $user->profile_img;
        $output['status']                           =   2;
        return response()->json( $output );
    }

    public function upload_header_img(Request $request){
        $output                                    =   [ 'status' => 1 ];

        if(!Auth::check() || Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        if(!$request->hasFile('img')) {
            return response()->json($output);
        }

        $user                                       =   Auth::user();
        $img                                        =   $request->file( 'img' );
        $max_size                                   =   $this->settings->profile_img_size * 1024 * 1024;

        if( $img->getClientSize() > $max_size){
            return response()->json($output);
        }

        $name                                       =   $img->getClientOriginalName();
        $destination                                =   base_path() . '/public/uploads/' . $user->upl_dir;
        $img->move( $destination, $name );

        $user->header_img                           =   $user->upl_dir . '/' . $name;
        $user->save();

        if($this->settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . '/' . $name );
        }

        $output['img']                              =   $user->header_img;
        $output['status']                           =   2;
        return response()->json( $output );
    }

    public function update_password(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(!Auth::check() || Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator              =   Validator::make($request->all(), [
            'pass'              =>  'required|min:3|max:255|confirmed'
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        $user                   =   Auth::user();
        $user->password         =   bcrypt( $request->input('pass') );
        $user->save();

        $output['status']       =   2;
        return response()->json( $output );
    }

    public function toggle_follow(Request $request){
        $output                         =   [ 'status' => 1 ];

        if( !Auth::check() ){
            return response()->json($output);
        }

        if( Auth::user()->id == $request->input('uid') ){
            return response()->json($output);
        }

        $follower_check                 =   Follower::where([
            'subscriber_uid'            =>  Auth::user()->id,
            'followed_uid'              =>  intval($request->input('uid'))
        ])->first();

        if($follower_check){
            $follower_check->delete();
        }else{
            Follower::create([
                'subscriber_uid'            =>  Auth::user()->id,
                'followed_uid'              =>  intval($request->input('uid'))
            ]);

            UserNotification::create([
                'uid'                       =>  $request->input('uid'),
                'message'                   =>  trans( 'user.follow_notification', [
                    'user'                  =>  '<a href="' . route( 'profile', [ 'username' => Auth::user()->username ] ) . '">' . Auth::user()->display_name . '</a>'
                ])
            ]);
        }

        $output['status']               =   2;
        return response()->json($output);
    }

    public function leaderboard(){
        $users                      =   User::orderBy( 'points', 'desc' )->take(100)->get();

        return view( 'user.leaderboard' )->with([
            'site_title'            =>  trans('user.leaderboard') . ' - ' . $this->settings->site_title,
            'site_desc'             =>  $this->settings->site_desc,
            'users'                 =>  $users
        ]);
    }

    public function user_newsletter_subscribe(){
        $output                     =   [ 'status' => 1 ];

        if( !JaskoHelper::subscribe_to_newsletter( Auth::user()->email ) ){
            return response()->json( $output );
        }

        $output['status']           =   2;
        return response()->json( $output );
    }

    public function notifications(){
        $notifications                          =   UserNotification::where([
            'uid'                               =>  Auth::user()->id,
            'is_read'                           =>  1
        ])->get();

        UserNotification::where([
            'uid'                               =>  Auth::user()->id,
            'is_read'                           =>  1
        ])->update([ 'is_read' => 2 ]);

        return view('user.notifications')->with([
            'site_title'                        =>  trans('user.notifications') . ' - ' . $this->settings->site_title,
            'site_desc'                         =>  $this->settings->site_desc,
            'notifications'                     =>  $notifications
        ]);
    }
}
