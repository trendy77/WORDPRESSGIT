<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\UserUploads;
use App\Media;
Use App\Memes;
use App\Classes\UrlId;
use Purifier;
use App\Classes\JaskoHelper;
use App\Classes\Zebra_Image;
use App\Categories;
use App\User;
use App\MediaLikes;
use App\SiteSettings;
use App\Classes\PHPImage;

class MemeController extends Controller
{
    public function create_page(){
        $memes                      =   Memes::all();
        $settings                   =   SiteSettings::find(1);

        return view( 'media.memes.create' )->with([
            'site_title'            =>  trans('media.create_meme') . ' - ' . $settings->site_title,
            'site_desc'             =>  $settings->site_desc,
            'memes'                 =>  $memes,
            'user'                  =>  Auth::user()
        ]);
    }

    public function create(Request $request){
        $output                     =   [ 'status' => 1 ];

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer|min:1',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:10000',
            'meme_data'             =>  'required'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                           =   Auth::user();
        $new_name                       =   str_random( mt_rand(6,16) ) . '.png';
        $img                            =   $request->input('meme_data');
        $img                            =   str_replace('data:image/png;base64,', '', $img);
        $img                            =   str_replace(' ', '+', $img);
        $data                           =   base64_decode($img);
        $upl_dir                        =   public_path() . '/uploads/' . $user->upl_dir . "/";
        $success                        =   file_put_contents( $upl_dir . $new_name, $data );
        $uploaded_img                   =   '';
        $site_settings                  =   SiteSettings::find(1);

        if( $request->input( 'img_type' ) == 2 && $request->hasFile('upl_img') ){
            $upl_img                    =   $request->file('upl_img');
            $settings                   =   SiteSettings::find(1);
            $max_img_size               =   $settings->max_media_img_size * ( 1024 * 1024 );

            if($upl_img->getClientSize() > $max_img_size){
                return response()->json($output);
            }

            $upl_img_name               =   str_random( mt_rand(6,16) ) . '.' . $upl_img->getClientOriginalExtension();
            $upl_img->move( $upl_dir, $upl_img_name );
            $uploaded_img               =   jasko_component('/uploads/' . $user->upl_dir . '/' . $upl_img_name);
        }

        if( $site_settings->watermark_enabled == 2 ){
            // Create Watermark Image
            $watermark_img          =   new PHPImage();
            $watermark_img->setDimensionsFromImage( $upl_dir . $new_name );
            $watermark_img->draw( $upl_dir . $new_name );
            $watermark_img->draw( $upl_dir . $site_settings->watermark_img_url, $site_settings->watermark_x_pos . '%', $site_settings->watermark_y_pos . '%' );
            $watermark_img->save( $upl_dir . $new_name );
        }

        $upload                     =   UserUploads::create([
            'uid'                   =>  $user->id,
            'original_name'         =>  $new_name,
            'upl_name'              =>  $user->upl_dir . "/" . $new_name
        ]);

        $contentObj                     =   json_encode([
            "img"                       =>  $user->upl_dir . "/" . $new_name,
            "top_caption"               =>  $request->input('top_caption'),
            "bottom_caption"            =>  $request->input('bottom_caption'),
            "img_type"                  =>  $request->input( 'img_type' ),
            "meme_id"                   =>  $request->input( 'meme_id' ),
            "upl_img"                   =>  $uploaded_img
        ]);

        $media                          =   Media::create([
            "title"                     =>  e( $request->input('title') ),
            "media_desc"                =>  e( $request->input('desc') ),
            "content"                   =>  $contentObj,
            "media_type"                =>  5,
            "thumbnail"                 =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::thumbnail( $upload->id, '' ),
            "featured_img"              =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::featured_image( $upload->id, '' ),
            "share_img"                 =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::share_img( $upload->id, '', $request->input('title') ),
            "uid"                       =>  $user->id,
            "cid"                       =>  intval( $request->input('cid') ),
            "slug_url"                  =>  str_slug( $request->input('title') ),
            "status"                    =>  JaskoHelper::approve_media(),
            "page_content"              =>  Purifier::clean($request->input('page_content')),
            "nsfw"                      =>  intval( $request->input('nsfw') )
        ]);

        $media->slug_url                =   $media->slug_url . '-' . $media->id;
        $media->save();

        if($site_settings->send_approved_media_email == 2 & $media->status == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        if($site_settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . "/" . $new_name );
        }

        $output['status']               =   2;
        $output['url']              =   full_media_url($media);
        $output['is_approved']      =   $media->status;
        return response()->json($output);
    }

    public function page($name, Request $request){
        $media                      =   Media::where( 'slug_url', '=', $name );

        if(!$media->exists()){
            return redirect( '/' );
        }

        $settings                   =   SiteSettings::find(1);
        $media                      =   $media->first();
        $media->content             =   json_decode($media->content);
        $category                   =   Categories::find( $media->cid );
        $author                     =   User::find($media->uid);
        $next_media                 =   Media::where( 'id', '>', $media->id )->where('status', 2)->first();
        $prev_media                 =   Media::where( 'id', '<', $media->id )->where('status', 2)->orderBy('id', 'desc')->first();
        $related_media              =   Media::where([
            'cid'                   =>  $media->cid,
            'status'                =>  2,
            'media_type'            =>  5
        ])->orderBy('id', 'desc')->take(4)->get();
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();
        $like_check                 =   MediaLikes::where([
            'mid'                   =>  $media->id,
            'sid'                   =>  $sid
        ]);

        return view( 'media.memes.page' )->with([
            'site_title'            =>  $media->title . ' - ' . $settings->site_title,
            'site_desc'             =>  $media->media_desc,
            'media'                 =>  $media,
            'media_cat'             =>  $category,
            'author'                =>  $author,
            'next_media'            =>  $next_media,
            'prev_media'            =>  $prev_media,
            'related_media'         =>  $related_media,
            'mediaLiked'            =>  $like_check->exists()
        ]);
    }
}
