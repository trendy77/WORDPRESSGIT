<?php

namespace App\Http\Controllers\Users;

use App\Classes\JaskoHelper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SiteSettings;
use App\User;
use App\PasswordReset;
use Validator;
use Auth;
use Socialite;
use Storage;
use Mail;
use Carbon\Carbon;

class AuthController extends Controller{

    public function __construct(){
        $this->middleware('guest');
    }

    public function register_page(){
        $settings                       =   SiteSettings::find(1);

        if($settings->user_registration == 2){
            return redirect()->route('home');
        }

        $tos                            =   Storage::get( 'tos.html' );
        $tos                            =   str_replace( "[site_name]", $settings->site_name, $tos );

        return view( 'user.register' )->with([
            'site_title'                =>  trans('user.register') . ' - ' . $settings->site_title,
            'site_desc'                 =>  $settings->site_desc,
            'tos'                       =>  $tos
        ]);
    }

    public function register(Request $request){
        $output                         =   [ 'status' => 1, 'reload' => 1, 'msg' => null ];
        $settings                       =   SiteSettings::find(1);

        if($settings->user_registration == 2){
            return response()->json( $output );
        }

        $validator                      =   Validator::make($request->all(), [
            'username'                  => 'required|max:255|alpha_num|unique:users',
            'email'                     => 'required|email|max:255|unique:users',
            'pass'                      => 'required|min:3|confirmed',
        ]);

        if($validator->fails()){
            $output['errors']           =   $validator->errors()->all();
            return response()->json( $output );
        }

        $upl_dir                        =   strtolower(substr(e(str_slug($request->input('username'))), 0, 1)) . "/" . mt_rand(1,10) . "/" . str_slug(e($request->input('username')));
        $confirmation_code              =   str_random( mt_rand( 6, 32 ) );

        if(!mkdir( public_path() . '/uploads/' .  $upl_dir, 0777, true)){
            return response()->json( $output );
        }

        $user                           =   User::create([
            'username'                  =>  e( $request->input( 'username' ) ),
            'email'                     =>  e( $request->input( 'email' ) ),
            'password'                  =>  bcrypt( $request->input( 'pass' ) ),
            'upl_dir'                   =>  $upl_dir,
            'display_name'              =>  e( $request->input( 'username' ) ),
            'email_confirmed'           =>  $settings->confirm_registration == 2 ? 1 : 2,
            'confirmation_code'         =>  $confirmation_code
        ]);

        if($settings->confirm_registration == 1){
            $output['reload']           =   2;
            $output['msg']              =   trans('user.register_success_reload');
            Auth::loginUsingId( $user->id );
        }else{
            $output['msg']              =   trans('user.register_success_confirm_reg');
            $sent                       =   Mail::send('email.confirm-registration', ['user' => $user], function ($m) use ($request, $settings){
                $m->from( 'no-reply@' . $settings->site_domain, $settings->site_name);
                $m->to( $request->input( 'email' ), $request->input( 'username' ));
                $m->subject( $settings->site_name . ' - Confirm Registration' );
            });

            if(!$sent){
                return response()->json($output);
            }
        }

        if( $request->input('newsletter_subscribe') == 2 ){
            JaskoHelper::subscribe_to_newsletter( e( $request->input( 'email' ) ) );
        }

        $output['status']               =   2;
        return response()->json( $output );
    }

    public function confirm_registration($code){
        $user                           =   User::where( 'confirmation_code', '=', $code );
        $settings                       =   SiteSettings::find(1);

        if(!$user->exists()){
            return redirect()->route('home');
        }

        $user                           =   $user->first();
        $user->email_confirmed          =   2;
        $user->save();

        Auth::loginUsingId( $user->id );

        return view('user.confirm-registration')->with([
            'site_title'                =>  $settings->site_title,
            'site_desc'                 =>  $settings->site_desc
        ]);
    }

    public function login_page(){
        $settings                       =   SiteSettings::find(1);

        return view ('user.login' )->with([
            'site_title'                =>  trans('user.login') . ' - ' . $settings->site_title,
            'site_desc'                 =>  $settings->site_desc,
        ]);
    }

    public function login(Request $request){
        $output                 =   [ 'status' => 1 ];

        $validator              =   Validator::make($request->all(), [
            'username'          => 'required|max:255',
            'pass'              => 'required|min:3',
        ]);

        if($validator->fails()){
            $output['errors']   =   $validator->errors()->all();
            return response()->json( $output );
        }

        if (Auth::attempt([ 'username' => $request->input( 'username' ), 'password' => $request->input( 'pass' ), 'login_type' => 1, 'email_confirmed' => 2 ])) {
            // Authentication passed...
            $output['status']   =   2;
        }

        return response()->json( $output );
    }

    public function forgot_pass_page(){
        $settings                       =   SiteSettings::find(1);

        return view( 'user.forgot-pass' )->with([
            'site_title'                =>  trans('user.forgot_pass') . ' - ' . $settings->site_title,
            'site_desc'                 =>  $settings->site_desc
        ]);
    }

    public function forgot_pass(Request $request){
        $output                         =   [ 'status' => 1 ];
        $user_check                     =   User::where([
            'email'                     =>  $request->input('email'),
            'login_type'                =>  1
        ]);

        if(!$user_check->exists()){
            return response()->json($output);
        }

        $user_check                     =   $user_check->first();
        $token                          =   str_random( mt_rand( 6, 32 ) );
        $settings                       =   SiteSettings::find(1);

        PasswordReset::create([
            'email'                     =>  $user_check->email,
            'token'                     =>  $token
        ]);

        $sent                           =   Mail::send('email.pass-reset', ['code' => $token], function ($m) use ($user_check, $settings){
            $m->from( 'no-reply@' . $settings->site_domain, $settings->site_name);
            $m->to( $user_check->email, $user_check->username);
            $m->subject( $settings->site_name . ' - Reset Password' );
        });

        if(!$sent){
            return response()->json($output);
        }

        $output['status']               =   2;
        return response()->json( $output );
    }

    public function reset_pass_page($code){
        $settings                       =   SiteSettings::find(1);

        $code_exists                    =   PasswordReset::where( 'token', '=', $code )->where('created_at', '>=', Carbon::now()->subDay());

        if(!$code_exists->exists()){
            return redirect()->route('home');
        }

        return view( 'user.reset-password' )->with([
            'site_title'                =>  trans('user.reset_pass') . ' - ' . $settings->site_title,
            'site_desc'                 =>  $settings->site_desc
        ]);
    }

    public function reset_pass(Request $request, $code){
        $output                         =   [ 'status' => 1 ];

        $validator                      =   Validator::make($request->all(), [
            'pass'                      => 'required|min:3|confirmed',
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        $code_check                    =   PasswordReset::where( 'token', '=', $code )->where('created_at', '>=', Carbon::now()->subDay());

        if(!$code_check->exists()){
            return response()->json($output);
        }

        $code_check                     =   $code_check->first();

        $user_check                     =   User::where( 'email', '=', $code_check->email );

        if(!$user_check->exists()){
            return response()->json($output);
        }

        $user_check                     =   $user_check->first();
        $user_check->password           =   bcrypt( $request->input('pass') );
        $user_check->save();

        $output['status']               =   2;
        return response()->json($output);
    }

    public function facebook_provider(){
        return Socialite::driver('facebook')->redirect();
    }

    public function facebook_auth(Request $request){
        return $this->social_auth('facebook');
    }

    public function twitter_provider(){
        return Socialite::driver('twitter')->redirect();
    }

    public function twitter_auth(){
        return $this->social_auth('twitter');
    }

    public function google_plus_provider(){
        return Socialite::driver('google')->redirect();
    }

    public function google_auth(){
        return $this->social_auth('google');
    }

    public function social_auth( $type ){
        $social                     =   Socialite::driver($type)->user();

        if(empty($social->getEmail())){
            return redirect()->route('home');
        }

        if (Auth::attempt([ 'email' => $social->getEmail(), 'password' => $social->getId(), 'login_type' => 2, 'email_confirmed' => 2 ])) {
            return redirect('/');
        }

        // User doesn't exist. Check if registration is opened.
        $settings                       =   SiteSettings::find(1);
        if($settings->user_registration == 2){
            return redirect('/');
        }

        $upl_dir                    =   strtolower(substr(e($social->getName()), 0, 1)) . "/" . mt_rand(1,10) . "/" . e($social->getId());
        $confirmation_code          =   str_random( mt_rand( 6, 32 ) );

        if(!mkdir( public_path() . '/uploads/' .  $upl_dir, 0777, true)){
            return redirect('/');
        }

        $user                   =   User::create([
            'username'          =>  e( str_slug($social->getName()) ),
            'email'             =>  e( $social->getEmail() ),
            'password'          =>  bcrypt( $social->getId() ),
            'upl_dir'           =>  $upl_dir,
            'display_name'      =>  e( $social->getName() ),
            'email_confirmed'   =>  2,
            'login_type'        =>  2,
            'confirmation_code' =>  $confirmation_code
        ]);

        Auth::loginUsingId( $user->id );
        return redirect('/');
    }
}
