<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Media;
use App\MediaLikes;
use Auth;
use App\SiteSettings;
use Validator;
use App\UserUploads;
use App\Classes\JaskoHelper;

class MainController extends Controller
{

    public function __construct(){
        $this->middleware('mod');
    }

    public function dashboard(){
        // Counts
        $active_users                   =   User::where('status', '=', 1)->count();
        $active_media_items             =   Media::where('status', '=', 2)->count();
        $pending_media_items            =   Media::wherE('status', '=', 1)->count();
        $like_count                     =   MediaLikes::count();

        $pending_media                  =   Media::where('status', '=', 1)->take(20)->get();
        $latest_users                   =   User::orderBy('id', 'desc')->take(12)->get();
        $approved_media                 =   Media::where('status', '=', 2)->orderBy('id', 'desc')->take(12)->get();

        return view('admin.pages.dashboard')->with([
            'active_users'              =>  $active_users,
            'active_media_items'        =>  $active_media_items,
            'pending_media_items'       =>  $pending_media_items,
            'like_count'                =>  $like_count,
            'pending_media'             =>  $pending_media,
            'latest_users'              =>  $latest_users,
            'approved_media'            =>  $approved_media
        ]);
    }

    public function upload_media_img(Request $request){
        $output                 =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

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

        $upload                 =   UserUploads::create([
            'uid'               =>  $user->id,
            'original_name'     =>  $img->getClientOriginalName(),
            'upl_name'          =>  $user->upl_dir . "/" . $new_name
        ]);

        if($settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . "/" . $new_name );
        }

        $output['status']       =   2;
        $output['img']          =   array(
            "id"            =>  $upload->id,
            "new_name"      =>  $user->upl_dir . "/" . $new_name,
            "name"          =>  $img->getClientOriginalName()
        );
        return response()->json($output);
    }
}
