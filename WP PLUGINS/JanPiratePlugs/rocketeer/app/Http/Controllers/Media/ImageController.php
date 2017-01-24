<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\UserUploads;
use App\Media;
use App\Classes\UrlId;
use Purifier;
use App\Classes\JaskoHelper;
use App\Classes\Zebra_Image;
use App\Categories;
use App\User;
use App\SiteSettings;
use App\MediaLikes;
use App\Classes\PHPImage;

class ImageController extends Controller
{
    public function create_page(){
        $settings                   =   SiteSettings::find(1);

        return view( 'media.images.create' )->with([
            'site_title'            =>  trans('media.create_image') . ' - ' . $settings->site_title,
            'site_desc'             =>  $settings->site_desc,
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
            'img'                   =>  'required|image'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                       =   Auth::user();
        $img                        =   $request->file('img');
        $site_settings              =   SiteSettings::find(1);
        $max_img_size               =   $site_settings->max_media_img_size * ( 1024 * 1024 );

        if($img->getClientSize() > $max_img_size){
            return response()->json($output);
        }

        $upl_dir                    =   public_path() . '/uploads/' . $user->upl_dir . "/";
        $new_name                   =   str_random( mt_rand(6,16) ) . '.' . $img->getClientOriginalExtension();
        $img->move( $upl_dir, $new_name );

        if( $img->getClientOriginalExtension() == "jpg" ){
            JaskoHelper::check_img_orientation( $upl_dir . $new_name );
        }
        
        if( $site_settings->watermark_enabled == 2 ){
            // Create Watermark Image
            $watermark_img          =   new PHPImage();
            $watermark_img->setDimensionsFromImage( $upl_dir . $new_name );
            $watermark_img->draw( $upl_dir . $new_name );
            $watermark_img->draw( public_path() . '/uploads/' . $site_settings->watermark_img_url, $site_settings->watermark_x_pos . '%', $site_settings->watermark_y_pos . '%' );
            $watermark_img->save( $upl_dir . $new_name );
        }

        $upload                     =   UserUploads::create([
            'uid'                   =>  $user->id,
            'original_name'         =>  $img->getClientOriginalName(),
            'upl_name'              =>  $user->upl_dir . "/" . $new_name
        ]);

        $media                      =   Media::create([
            "title"                 =>  e( $request->input('title') ),
            "media_desc"            =>  e( $request->input('desc') ),
            "content"               =>  $user->upl_dir . "/" . $new_name,
            "media_type"            =>  4,
            "thumbnail"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::thumbnail( $upload->id, '' ),
            "featured_img"          =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::featured_image( $upload->id, '' ),
            "share_img"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::share_img( $upload->id, '', $request->input('title') ),
            "uid"                   =>  $user->id,
            "cid"                   =>  intval( $request->input('cid') ),
            "slug_url"              =>  str_slug( $request->input('title') ),
            "status"                =>  JaskoHelper::approve_media(),
            "page_content"          =>  Purifier::clean($request->input('page_content')),
            "nsfw"                  =>  intval( $request->input('nsfw') )
        ]);

        $media->slug_url            =   $media->slug_url . '-' . $media->id;
        $media->save();

        if($site_settings->send_approved_media_email == 2 & $media->status == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        if($site_settings->aws_s3 == 2){
            JaskoHelper::aws_s3_upload( $user->upl_dir . "/" . $new_name );
        }

        $output['status']           =   2;
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
        $category                   =   Categories::find( $media->cid );
        $author                     =   User::find($media->uid);
        $next_media                 =   Media::where( 'id', '>', $media->id )->where('status', 2)->first();
        $prev_media                 =   Media::where( 'id', '<', $media->id )->where('status', 2)->orderBy('id', 'desc')->first();
        $related_media              =   Media::where([
            'cid'                   =>  $media->cid,
            'status'                =>  2,
            'media_type'            =>  4
        ])->orderBy('id', 'desc')->take(4)->get();
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();
        $like_check                 =   MediaLikes::where([
            'mid'                   =>  $media->id,
            'sid'                   =>  $sid
        ]);

        return view( 'media.images.page' )->with([
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

    public function media_page(){
        $site_settings                  =   SiteSettings::find(1);
        $slides                         =   json_decode($site_settings->slides);
        foreach($slides as $sk => $sv){
            $slides[$sk]                =   Media::find($sv->id);

            if($slides[$sk]->media_type != 4 && $slides[$sk]->media_type != 5){
                unset($slides[$sk]);
                continue;
            }
        }

        $slides                         =   array_values($slides);

        return view( 'media.media-page' )->with([
            'site_title'                =>  trans('media.images') . ' - ' . $site_settings->site_title,
            'site_desc'                 =>  $site_settings->site_desc,
            'slides'                    =>  $slides,
            'types'                     =>  [ 4, 5 ]
        ]);
    }
}
