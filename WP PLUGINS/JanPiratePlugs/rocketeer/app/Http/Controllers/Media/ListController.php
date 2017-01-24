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
use stdClass;

class ListController extends Controller
{
    public function create_page(){
        $settings                   =   SiteSettings::find(1);

        return view( 'media.list.create' )->with([
            'site_title'            =>  trans('media.create_list') . ' - ' . $settings->site_title,
            'site_desc'             =>  $settings->site_desc,
            'user'                  =>  Auth::user()
        ]);
    }

    public function create(Request $request){
        $output                     =   [ 'status' => 1 ];

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'list_style'            =>  'required|integer',
            'list_items'            =>  'required',
            'page_content'          =>  'min:3|max:10000'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                       =   Auth::user();
        $list_items                 =   $request->input( 'list_items' );
        $site_settings              =   SiteSettings::find(1);

        foreach( $list_items as $lk => $lv ){
            $lv['title']            =   e( $lv['title'] );
            $lv['desc']             =   e( $lv['desc'] );
            $lv['media_type']       =   intval( $lv['media_type'] );
            $lv['embed_url' ]       =   e( $lv['embed_url'] );
            $lv['embed_code' ]      =   $lv['media_type'] == 2 ? UrlId::parse( $lv['embed_url'] ) : '';
            $lv['quote']            =   e( $lv['quote'] );
            $lv['quote_src']        =   e( $lv['quote_src'] );

            if( $lv['media_type'] == 1 ){
                foreach($lv['images'] as $ik => $iv){
                    $upload         =   UserUploads::where( 'id', '=', $iv);

                    if(!$upload->exists()){
                        $output['errors']   =   [ trans('media.list_item_invalid_img', [ 'i' => $ik+1 ]) ];
                        return response()->json($output);
                    }

                    $upload         =   $upload->first();
                    $lv['images'][$ik]=   $upload->upl_name;
                }
            }
            $list_items[$lk]           =   $lv;
        }

        $contentObj                 =   json_encode([
            'items'                 =>  $list_items,
            'style'                 =>  intval( $request->input('list_style') ),
            'animation'             =>  e( $request->input('animation') )
        ]);

        $media                      =   Media::create([
            "title"                 =>  e( $request->input('title') ),
            "media_desc"            =>  e( $request->input('desc') ),
            "content"               =>  $contentObj,
            "media_type"            =>  8,
            "thumbnail"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::thumbnail( $request->input('thumbnail'), 'list' ),
            "featured_img"          =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::featured_image( $request->input('thumbnail'),  'list' ),
            "share_img"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::share_img( $request->input('thumbnail'), 'list', $request->input('title') ),
            "uid"                   =>  $user->id,
            "cid"                   =>  intval( $request->input('cid') ),
            "slug_url"              =>  str_slug( $request->input('title') ),
            "status"                =>  JaskoHelper::approve_media(),
            "page_content"          =>  Purifier::clean($request->input('page_content')),
            "nsfw"                  =>  intval( $request->input('nsfw') ),
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
            'media_type'            =>  8
        ])->orderBy('id', 'desc')->take(4)->get();

        foreach($related_media as $rk => $rv){
            $related_media[$rk]->author =   User::find($rv->uid);
        }

        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();
        $like_check                 =   MediaLikes::where([
            'mid'                   =>  $media,
            'sid'                   =>  $sid
        ]);

        if( $settings->list_ad_type == 2 || $settings->list_ad_type == 3){
            $ad_count               =   $settings->list_ad_type == 2 ? mt_rand( 1, count($media->content->items) ) : $settings->list_ad_nth_count;
            $object                 =   new stdClass();
            $object->is_ad          =   true;
            array_splice( $media->content->items, $ad_count, 0, [ $object ] );
        }

        return view( 'media.list.page' )->with([
            'site_title'            =>  $media->title . ' - ' . $settings->site_title,
            'site_desc'             =>  $media->media_desc,
            'media'                 =>  $media,
            'media_cat'             =>  $category,
            'author'                =>  $author,
            'next_media'            =>  $next_media,
            'prev_media'            =>  $prev_media,
            'related_media'         =>  $related_media,
            'mediaLiked'            =>  $like_check->exists(),
            'item_count'            =>  1
        ]);
    }

    public function media_page(){
        $site_settings                  =   SiteSettings::find(1);
        $slides                         =   json_decode($site_settings->slides);

        foreach($slides as $sk => $sv){
            $slides[$sk]                =   Media::find($sv->id);

            if($slides[$sk]->media_type != 8){
                unset($slides[$sk]);
                continue;
            }
        }

        $slides                         =   array_values($slides);

        return view( 'media.media-page' )->with([
            'site_title'                =>  trans('media.lists') . ' - ' . $site_settings->site_title,
            'site_desc'                 =>  $site_settings->site_desc,
            'slides'                    =>  $slides,
            'types'                     =>  [ 8, 8 ]
        ]);
    }

    public function duplicate_page( $id, Request $request ){
        $settings                   =   SiteSettings::find(1);
        $post                       =   Media::find($id);
        $images                     =   [];

        if(!$post){
            return redirect()->route('home');
        }

        $post->content              =   json_decode( $post->content );
        $post->uploads              =   json_decode( $post->uploads );

        foreach($post->uploads as $ik => $iv){
            array_push( $images, UserUploads::find($iv) );
        }

        array_push( $images, UserUploads::where( 'upl_name', '=', $post->thumbnail)->first() );

        return view( 'media.list.duplicate' )->with([
            'site_title'            =>  trans('media.duplicate_list') . ' - ' . $settings->site_title,
            'site_desc'             =>  $settings->site_desc,
            'user'                  =>  Auth::user(),
            'post'                  =>  $post,
            'images'                =>  $images
        ]);
    }
}
