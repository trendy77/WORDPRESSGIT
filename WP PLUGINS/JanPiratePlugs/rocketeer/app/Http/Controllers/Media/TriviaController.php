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

class TriviaController extends Controller
{
    public function create_page(){
        $settings                   =   SiteSettings::find(1);

        return view( 'media.trivia.create' )->with([
            'site_title'            =>  trans('media.create_trivia_quiz') . ' - ' . $settings->site_title,
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
            'questions'             =>  'required',
            'results'               =>  'required',
            'style'                 =>  'required|integer'
        ]);

        if($validator->fails()){
            $output['errors']       =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                       =   Auth::user();
        $questions                  =   $request->input( 'questions' );
        $results                    =   $request->input( 'results' );
        $site_settings              =   SiteSettings::find(1);

        // Questions
        foreach($questions as $qk => $qv ){
            $qv['question']         =   e( $qv['question'] );
            $qv['explanation']      =   e( $qv['explanation'] );
            $qv['media_type']       =   intval( $qv['media_type'] );
            $qv['answer_display_type']  =   intval( $qv['answer_display_type'] );
            $qv['embed_url']        =   e( $qv['embed_url'] );
            $qv['embed_code' ]      =   $qv['media_type'] == 2 ? UrlId::parse( $qv['embed_url'] ) : '';
            $qv['quote']            =   e( $qv['quote'] );
            $qv['quote_src']        =   e( $qv['quote_src'] );

            if( $qv['media_type'] == 1 && isset($qv['images']) ){
                foreach($qv['images'] as $ik => $iv){
                    $upload         =   UserUploads::where( 'id', '=', $iv);

                    if(!$upload->exists()){
                        $output['errors']   =   [ trans('media.question_invalid_img', [ 'num' => $qk+1 ]) ];
                        return response()->json($output);
                    }

                    $upload         =   $upload->first();
                    $qv['images'][$ik]=   $upload->upl_name;
                }
            }

            foreach( $qv['answers'] as $ak => $av ){
                $av['answer']       =   e( $av['answer'] );
                $av['isCorrect']    =   intval( $av['isCorrect'] );

                if(!empty($av['img'])){
                    $upload         =   UserUploads::where( 'id', '=', $av['img']);

                    if(!$upload->exists()){
                        $output['errors']   =   [ trans('media.question_answer_invalid_img', [ 'q' => $qk+1, 'a' => $ak+1 ]) ];
                        return response()->json($output);
                    }

                    $upload         =   $upload->first();
                    $av['img']      =   $upload->upl_name;
                }

                $qv['answers'][$ak] =   $av;
            }

            $questions[$qk]         =   $qv;
        }

        // Results
        foreach( $results as $rk => $rv ){
            $rv['title']            =   e( $rv['title'] );
            $rv['desc']             =   e( $rv['desc'] );
            $rv['min']              =   intval( $rv['min'] );
            $rv['max']              =   intval( $rv['max'] );

            if(!empty( $rv['main_img'])){
                $upload             =   UserUploads::where( 'id', '=',  $rv['main_img']);

                if(!$upload->exists()){
                    $output['errors']=   [ trans('media.result_invalid_img', [ 'r' => $rk+1 ]) ];
                    return response()->json($output);
                }

                $upload             =   $upload->first();
                $rv['main_img']     =   $upload->upl_name;
            }

            $results[$rk]           =   $rv;
        }

        $contentObj                 =   json_encode([
            "questions"             =>  $questions,
            "results"               =>  $results,
            "is_timed"              =>  intval($request->input('timed_quiz')),
            "timer"                 =>  intval($request->input('timed_seconds')),
            "randomize_questions"   =>  intval($request->input('randomize_questions')),
            "randomize_answers"     =>  intval($request->input('randomize_answers')),
            "style"                 =>  intval($request->input('style')),
            "animation"             =>  e($request->input('animation')),
            "allow_retake"          =>  1,
            "show_correct_answer"   =>  intval( $request->input("show_correct_answer") )
        ]);

        $media                      =   Media::create([
            "title"                 =>  e($request->input('title')),
            "media_desc"            =>  e($request->input('desc')),
            "content"               =>  $contentObj,
            "media_type"            =>  2,
            "thumbnail"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::thumbnail( $request->input('thumbnail'),  'trivia' ),
            "featured_img"          =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::featured_image( $request->input('thumbnail'),  'trivia' ),
            "share_img"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::share_img( $request->input('thumbnail'), 'trivia', $request->input('title') ),
            "uid"                   =>  $user->id,
            "cid"                   =>  intval($request->input('cid')),
            "slug_url"              =>  str_slug($request->input('title') ),
            "status"                =>  JaskoHelper::approve_media(),
            "page_content"          =>  Purifier::clean($request->input('page_content')),
            "nsfw"                  =>  intval($request->input('nsfw')),
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
            'media_type'            =>  2
        ])->orderBy('id', 'desc')->take(4)->get();
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();
        $like_check                 =   MediaLikes::where([
            'mid'                   =>  $media->id,
            'sid'                   =>  $sid
        ]);
        $share_title                =   $media->title . ' - ' . $settings->site_title;
        $share_desc                 =   $media->media_desc;
        $share_img                  =   $media->share_img;

        if(!empty( $request->query('r') ) ){
            $r_index                =   intval($request->query('r')) - 1;
            $share_title            =   isset($media->content->results[$r_index]) ? trans('media.i_got') . ' ' . $media->content->results[$r_index]->title . ' - ' . $media->title: $share_title ;
            $share_desc             =   isset($media->content->results[$r_index]) ? $media->content->results[$r_index]->desc : $share_desc ;
            $share_img              =   isset($media->content->results[$r_index]) ? $media->content->results[$r_index]->main_img : $share_img ;
        }

        return view( 'media.trivia.page' )->with([
            'site_title'            =>  $media->title . ' - ' . $settings->site_title,
            'site_desc'             =>  $media->media_desc,
            'share_title'           =>  $share_title,
            'share_desc'            =>  $share_desc,
            'share_img'             =>  $share_img,
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

            if($slides[$sk]->media_type != 2 && $slides[$sk]->media_type != 3){
                unset($slides[$sk]);
                continue;
            }
        }

        $slides                         =   array_values($slides);

        return view( 'media.media-page' )->with([
            'site_title'                =>  trans('media.quizzes') . ' - ' . $site_settings->site_title,
            'site_desc'                 =>  $site_settings->site_desc,
            'slides'                    =>  $slides,
            'types'                     =>  [ 2, 3 ]
        ]);
    }
}
