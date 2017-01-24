<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Media;
use App\UserUploads;
use Validator;
use Auth;
use App\Classes\UrlId;
use Purifier;
use App\Classes\JaskoHelper;
use App\Classes\Zebra_Image;
use App\Memes;
use App\SiteSettings;

class ManageMediaController extends Controller
{
    protected $settings;

    public function __construct(){
        $this->middleware('mod');
        $this->settings             =   SiteSettings::find(1);
    }

    public function manage(){
        $media                      =   Media::orderBy('id', 'desc')->paginate(30);
        return view( 'admin.media.manage' )->with([
            'media_items'           =>  $media,
            'is_demo'               =>  Auth::user()->is_demo
        ]);
    }

    public function delete(Request $request){
        $output             =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        Media::destroy( $request->input('mid') );

        $new_slides         =   [];
        $old_slides         =   json_decode($this->settings->slides);

        foreach($old_slides as $slide){
            if($slide->id == $request->input('mid') ) continue;
            array_push( $new_slides, $slide );
        }

        $this->settings->slides =   json_encode( $new_slides );
        $this->settings->save();

        $output['status']   =   2;
        return response()->json( $output );
    }

    public function edit_poll_page($id){
        $media              =   Media::find($id);
        $images             =   [];

        if(!$media){
            return redirect()->route('adminManageMedia');
        }

        $media->content     =   json_decode( $media->content );
        $media->uploads     =   json_decode( $media->uploads );

        foreach($media->uploads as $ik => $iv){
            array_push( $images, UserUploads::find($iv) );
        }

        return view('admin.media.edit-poll')->with([
            'media'         =>  $media,
            'images'        =>  $images
        ]);
    }

    public function edit_poll($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:10000',
            'questions'             =>  'required',
            'style'                 =>  'required|integer'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $page_content               =   Purifier::clean($request->input('page_content'));
        $questions                  =   $request->input( 'questions' );

        foreach($questions as $qk => $qv ){
            $qv['embed_url' ]       =   e( $qv['embed_url'] );
            $qv['embed_code' ]      =   $qv['media_type'] == 2 ? UrlId::parse( $qv['embed_url'] ) : '';
            $questions[$qk]         =   $qv;
        }

        $contentObj                 =   json_encode([
            "questions"             =>  $questions,
            "style"                 =>  intval($request->input('style')),
            "animation"             =>  e( $request->input('animation') )
        ]);

        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->content             =   $contentObj;
        $media->thumbnail           =   $request->input('thumbnail');
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->uploads             =   json_encode( $request->input('image_ids') );
        $media->save();

        $output['status']           =   2;
        return response()->json($output);
    }

    public function edit_trivia_page($id){
        $media              =   Media::find($id);
        $images             =   [];

        if(!$media){
            return redirect()->route('adminManageMedia');
        }

        $media->content     =   json_decode( $media->content );
        $media->uploads     =   json_decode( $media->uploads );

        foreach($media->uploads as $ik => $iv){
            array_push( $images, UserUploads::find($iv) );
        }

        array_push( $images, UserUploads::where( 'upl_name', '=', $media->thumbnail)->first() );

        return view('admin.media.edit-trivia')->with([
            'media'         =>  $media,
            'images'        =>  $images
        ]);
    }

    public function edit_trivia($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:10000',
            'questions'             =>  'required',
            'results'               =>  'required',
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $page_content               =   Purifier::clean($request->input('page_content'));
        $questions                  =   $request->input( 'questions' );

        foreach($questions as $qk => $qv ){
            $qv['embed_url' ]       =   e( $qv['embed_url'] );
            $qv['embed_code' ]      =   $qv['media_type'] == 2 ? UrlId::parse( $qv['embed_url'] ) : '';
            $questions[$qk]         =   $qv;
        }

        $contentObj                 =   json_encode([
            "questions"             =>  $questions,
            "results"               =>  $request->input( 'results' ),
            "is_timed"              =>  intval($request->input('timed_quiz')),
            "timer"                 =>  intval($request->input('timed_seconds')),
            "randomize_questions"   =>  intval($request->input('randomize_questions')),
            "randomize_answers"     =>  intval($request->input('randomize_answers')),
            "style"                 =>  intval($request->input('style')),
            "animation"             =>  e($request->input('animation')),
            "allow_retake"          =>  1
        ]);

        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->content             =   $contentObj;
        $media->thumbnail           =   $request->input('thumbnail');
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->uploads             =   json_encode( $request->input('image_ids') );
        $media->save();

        $output['status']           =   2;
        return response()->json($output);
    }

    public function edit_personality_page($id){
        $media              =   Media::find($id);
        $images             =   [];

        if(!$media){
            return redirect()->route('adminManageMedia');
        }

        $media->content     =   json_decode( $media->content );
        $media->uploads     =   json_decode( $media->uploads );
        $media->uploads     =   empty($media->uploads) ? [] : $media->uploads;

        foreach($media->uploads as $ik => $iv){
            array_push( $images, UserUploads::find($iv) );
        }

        array_push( $images, UserUploads::where( 'upl_name', '=', $media->thumbnail)->first() );

        return view('admin.media.edit-personality')->with([
            'media'         =>  $media,
            'images'        =>  $images
        ]);
    }

    public function edit_personality($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:10000',
            'questions'             =>  'required',
            'results'               =>  'required',
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $page_content               =   Purifier::clean($request->input('page_content'));
        $questions                  =   $request->input( 'questions' );

        foreach($questions as $qk => $qv ){
            $qv['embed_url' ]       =   e( $qv['embed_url'] );
            $qv['embed_code' ]      =   $qv['media_type'] == 2 ? UrlId::parse( $qv['embed_url'] ) : '';
            $questions[$qk]         =   $qv;
        }

        $contentObj                 =   json_encode([
            "questions"             =>  $questions,
            "results"               =>  $request->input( 'results' ),
            "randomize_questions"   =>  intval($request->input('randomize_questions')),
            "randomize_answers"     =>  intval($request->input('randomize_answers')),
            "style"                 =>  intval($request->input('style')),
            "animation"             =>  e($request->input('animation')),
            "allow_retake"          =>  1
        ]);

        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->content             =   $contentObj;
        $media->thumbnail           =   $request->input('thumbnail');
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->uploads             =   json_encode( $request->input('image_ids') );
        $media->save();

        $output['status']           =   2;
        return response()->json($output);
    }

    public function edit_image_page($id){
        $media              =   Media::find($id);

        if(!$media){
            return redirect()->route('adminManageMedia');
        }


        return view('admin.media.edit-image')->with([
            'media'         =>  $media
        ]);
    }

    public function edit_image($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:10000'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $page_content               =   Purifier::clean($request->input('page_content'));
        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $user                       =   Auth::user();

        if($request->hasFile('img')){
            $img                        =   $request->file('img');
            $upl_dir                    =   public_path() . '/uploads/' . $user->upl_dir . "/";
            $new_name                   =   str_random( mt_rand(6,16) ) . '.' . $img->getClientOriginalExtension();
            $img->move( $upl_dir, $new_name );

            // Thumbnail
            $thumbnail_name                 =   explode(".", $new_name);
            $image                          =   new Zebra_Image();
            $image->source_path             =   $upl_dir . $new_name;
            $image->target_path             =   base_path('public/uploads') . '/' . $user->upl_dir . '/' . $thumbnail_name[0] . '_thumbnail.' . $img->getClientOriginalExtension();
            $image->jpeg_quality            =   80;
            $image->preserve_aspect_ratio   = true;
            $image->enlarge_smaller_images  = true;
            $image->resize(200, 200, ZEBRA_IMAGE_CROP_CENTER);

            $media->content             =   $user->upl_dir . "/" . $new_name;
            $media->thumbnail           =   $user->upl_dir . '/' . $thumbnail_name[0] . '_thumbnail.' . $img->getClientOriginalExtension();
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->save();

        $output['status']           =   2;
        return response()->json($output);
    }

    public function edit_meme_page($id){
        $media              =   Media::find($id);

        if(!$media){
            return redirect()->route('adminManageMedia');
        }

        $media->content     =   json_decode( $media->content );
        $memes              =   Memes::all();

        return view('admin.media.edit-meme')->with([
            'media'         =>  $media,
            'memes'         =>  $memes
        ]);
    }

    public function edit_meme($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:10000',
            'meme_data'             =>  'required'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                           =   Auth::user();
        $page_content                   =   Purifier::clean($request->input('page_content'));
        $new_name                       =   str_random( mt_rand(6,16) ) . '.png';
        $img                            =   $request->input('meme_data');
        $img                            =   str_replace('data:image/png;base64,', '', $img);
        $img                            =   str_replace(' ', '+', $img);
        $data                           =   base64_decode($img);
        $upl_dir                        =   public_path() . '/uploads/' . $user->upl_dir . "/";
        $success                        =   file_put_contents( $upl_dir . $new_name, $data );
        $uploaded_img                   =   '';

        if(!$success){
            $output['errors']           =   [ 'Unable to create meme.' ];
            return response()->json( $output );
        }

        if( $request->input( 'img_type' ) == 2 && $request->hasFile('upl_img') ){
            $upl_img                    =   $request->file('upl_img');
            $upl_img_name               =   str_random( mt_rand(6,16) ) . '.' . $upl_img->getClientOriginalExtension();
            $upl_img->move( $upl_dir, $upl_img_name );
            $uploaded_img               =   jasko_component('/uploads/' . $user->upl_dir . '/' . $upl_img_name);
        }

        $contentObj                     =   json_encode([
            "img"                       =>  $user->upl_dir . "/" . $new_name,
            "top_caption"               =>  $request->input('top_caption'),
            "bottom_caption"            =>  $request->input('bottom_caption'),
            "img_type"                  =>  $request->input( 'img_type' ),
            "meme_id"                   =>  $request->input( 'meme_id' ),
            "upl_img"                   =>  $uploaded_img
        ]);

        // Thumbnail
        $thumbnail_name                 =   explode(".", $new_name);
        $image                          =   new Zebra_Image();
        $image->source_path             =   $upl_dir . $new_name;
        $image->target_path             =   base_path('public/uploads') . '/' . $user->upl_dir . '/' . $thumbnail_name[0] . '_thumbnail.png';
        $image->jpeg_quality            =   80;
        $image->preserve_aspect_ratio   = true;
        $image->enlarge_smaller_images  = true;
        $image->resize(200, 200, ZEBRA_IMAGE_CROP_CENTER);

        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->content             =   $contentObj;
        $media->thumbnail           =   $user->upl_dir . "/" . $thumbnail_name[0] . '_thumbnail.png';
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->save();

        $output['swag']             =   $new_name;
        $output['status']               =   2;
        return response()->json($output);
    }

    public function edit_video_page($id){
        $media              =   Media::find($id);

        if(!$media){
            return redirect()->route('adminManageMedia');
        }

        $media->content     =   json_decode( $media->content );

        return view('admin.media.edit-video')->with([
            'media'         =>  $media
        ]);
    }

    public function edit_video($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:10000',
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $page_content               =   Purifier::clean($request->input('page_content'));
        $contentObj                 =   json_encode([
            "type"                  =>  $request->input( 'type' ),
            "id"                    =>  $request->input( 'id' ),
        ]);

        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->content             =   $contentObj;
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->uploads             =   json_encode( $request->input('image_ids') );
        $media->save();

        $output['status']           =   2;
        return response()->json($output);
    }

    public function edit_news_page($id){
        $media              =   Media::find($id);
        $images             =   [];

        if(!$media){
            return redirect()->route('adminManageMedia');
        }

        $media->content     =   json_decode( $media->content );
        $media->uploads     =   json_decode( $media->uploads );

        foreach($media->uploads as $ik => $iv){
            array_push( $images, UserUploads::find($iv) );
        }

        array_push( $images, UserUploads::where( 'upl_name', '=', $media->thumbnail)->first() );

        return view('admin.media.edit-news')->with([
            'media'         =>  $media,
            'images'        =>  $images
        ]);
    }

    public function edit_news($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

        $validator                  =   Validator::make($request->all(), [
            'title'                 =>  'required|min:3|max:255',
            'desc'                  =>  'required|min:3|max:155',
            'cid'                   =>  'required|integer',
            'nsfw'                  =>  'required|integer',
            'page_content'          =>  'min:3|max:15000',
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $page_content               =   Purifier::clean($request->input('page_content'));
        $images                     =   json_encode($request->input('main_images'));

        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->content             =   $images;
        $media->thumbnail           =   $request->input('thumbnail');
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->uploads             =   json_encode( $request->input('image_ids') );
        $media->save();

        $output['status']           =   2;
        return response()->json($output);
    }

    public function edit_list_page($id){
        $media              =   Media::find($id);
        $images             =   [];

        if(!$media){
            return redirect()->route('adminManageMedia');
        }

        $media->content     =   json_decode( $media->content );
        $media->uploads     =   json_decode( $media->uploads );

        foreach($media->uploads as $ik => $iv){
            array_push( $images, UserUploads::find($iv) );
        }

        array_push( $images, UserUploads::where( 'upl_name', '=', $media->thumbnail)->first() );

        return view('admin.media.edit-list')->with([
            'media'         =>  $media,
            'images'        =>  $images
        ]);
    }

    public function edit_list($id, Request $request){
        $output                     =   [ 'status' => 1 ];

        if(Auth::user()->is_demo == 2){
            return response()->json($output);
        }

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

        $page_content               =   Purifier::clean($request->input('page_content'));

        $items                      =   $request->input( 'list_items' );

        foreach($items as $ik => $iv ){
            $iv['embed_url' ]       =   e( $iv['embed_url'] );
            $iv['embed_code' ]      =   $iv['media_type'] == 2 ? UrlId::parse( $iv['embed_url'] ) : '';
            $items[$ik]             =   $iv;
        }

        $contentObj                 =   json_encode([
            'items'                 =>  $items,
            'style'                 =>  intval( $request->input('list_style') ),
            'animation'             =>  e( $request->input('animation') )
        ]);

        $media                      =   Media::find($id);

        if($media->status != 2 && $request->input('status') == 2 && $this->settings->send_approved_media_email == 2){
            JaskoHelper::send_approved_medial_email($media);
        }

        $media->title               =   e($request->input('title'));
        $media->media_desc          =   e($request->input('desc'));
        $media->content             =   $contentObj;
        $media->thumbnail           =   $request->input('thumbnail');
        $media->cid                 =   intval( $request->input('cid') );
        $media->slug_url            =   str_slug( $request->input('title') ) . '-' . $media->id;
        $media->status              =   $request->input('status');
        $media->page_content        =   $page_content;
        $media->nsfw                =   intval( $request->input( 'nsfw' ) );
        $media->uploads             =   json_encode( $request->input('image_ids') );
        $media->save();

        $output['status']           =   2;
        return response()->json($output);
    }
}
