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
use App\Categories;
use App\User;
use App\SiteSettings;
use App\MediaLikes;

class NewsController extends Controller
{
    public function create_page(){
        $settings                   =   SiteSettings::find(1);

        return view( 'media.news.create' )->with([
            'site_title'            =>  trans('media.create_news') . ' - ' . $settings->site_title,
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
            'page_content'          =>  'min:3|max:15000',
            'images'                =>  'required'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                       =   Auth::user();
        $images                     =   $request->input('images');
        $site_settings              =   SiteSettings::find(1);

        foreach( $images as $ik => $iv ) {
            $upload = UserUploads::where('id', '=', $iv);

            if (!$upload->exists()) {
                continue;
            }

            $upload                 =   $upload->first();
            $images[$ik]            =   $upload->upl_name;
        }

        $page_content               =   Purifier::clean($request->input('page_content'));

        $media                      =   Media::create([
            "title"                 =>  $request->input('title'),
            "media_desc"            =>  $request->input('desc'),
            "content"               =>  json_encode($images),
            "media_type"            =>  7,
            "thumbnail"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::thumbnail( $request->input('thumbnail'), 'news' ),
            "featured_img"          =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::featured_image( $request->input('thumbnail'), 'news' ),
            "share_img"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::share_img( $request->input('thumbnail'), 'news', $request->input('title') ),
            "uid"                   =>  $user->id,
            "cid"                   =>  $request->input('cid'),
            "slug_url"              =>  str_slug( $request->input('title') ),
            "status"                =>  JaskoHelper::approve_media(),
            "page_content"          =>  $page_content,
            "page_content_filtered" =>  JaskoHelper::clean($page_content),
            "nsfw"                  =>  $request->input('nsfw'),
            "uploads"               =>  json_encode( $request->input('image_ids') )
        ]);

        $media->slug_url            =   $media->slug_url . '-' . $media->id;
        $media->save();

        if($site_settings->send_approved_media_email == 2 & $media->status == 2){
            JaskoHelper::send_approved_medial_email($media);
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
        $media->content             =   json_decode( $media->content );
        $category                   =   Categories::find( $media->cid );
        $author                     =   User::find($media->uid);
        $next_media                 =   Media::where( 'id', '>', $media->id )->where('status', 2)->first();
        $prev_media                 =   Media::where( 'id', '<', $media->id )->where('status', 2)->orderBy('id', 'desc')->first();
        $related_media              =   Media::where([
            'cid'                   =>  $media->cid,
            'status'                =>  2,
            'media_type'            =>  6
        ])->orderBy('id', 'desc')->take(4)->get();
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();
        $like_check                 =   MediaLikes::where([
            'mid'                   =>  $media->id,
            'sid'                   =>  $sid
        ]);

        return view( 'media.news.page' )->with([
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

            if($slides[$sk]->media_type != 7){
                unset($slides[$sk]);
                continue;
            }
        }

        $slides                         =   array_values($slides);

        return view( 'media.media-page' )->with([
            'site_title'                =>  trans('media.news') . ' - ' . $site_settings->site_title,
            'site_desc'                 =>  $site_settings->site_desc,
            'slides'                    =>  $slides,
            'types'                     =>  [ 7, 7 ]
        ]);
    }
}
