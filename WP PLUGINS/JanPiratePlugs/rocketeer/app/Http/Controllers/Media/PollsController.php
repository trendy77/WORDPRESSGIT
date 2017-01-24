<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\UserUploads;
use App\Media;
use Purifier;
use App\Classes\JaskoHelper;
use App\Categories;
use App\PollVotes;
use App\User;
use App\SiteSettings;
use App\MediaLikes;
use App\Classes\UrlId;

class PollsController extends Controller
{
    public function create_page(){
        $settings                   =   SiteSettings::find(1);

        return view( 'media.polls.create' )->with([
            'site_title'            =>  trans('media.create_poll') . ' - ' . $settings->site_title,
            'site_desc'             =>  $settings->site_desc,
            'user'                  =>  Auth::user()
        ]);
    }
    public function create(Request $request){
        $output                         =   [ 'status' => 1 ];

        $validator                      =   Validator::make($request->all(), [
            'title'                     =>  'required|min:3|max:255',
            'desc'                      =>  'required|min:3|max:155',
            'cid'                       =>  'required|integer|min:1',
            'nsfw'                      =>  'required|integer',
            'page_content'              =>  'min:3|max:10000',
            'questions'                 =>  'required',
            'style'                     =>  'required|integer',
            'thumbnail'                 =>  'integer'
        ]);

        if($validator->fails()){
            $output['errors']           =   $validator->errors()->all();
            return response()->json( $output );
        }

        $user                           =   Auth::user();
        $questions                      =   $request->input( 'questions' );
        $site_settings                  =   SiteSettings::find(1);

        foreach($questions as $qk => $qv ){
            $qv['question']             =   e( $qv['question'] );
            $qv['media_type']           =   intval( $qv['media_type'] );
            $qv['answer_display_type']  =   intval( $qv['answer_display_type'] );
            $qv['embed_url' ]           =   e( $qv['embed_url'] );
            $qv['embed_code' ]          =   $qv['media_type'] == 2 ? UrlId::parse( $qv['embed_url'] ) : '';
            $qv['quote']                =   e( $qv['quote'] );
            $qv['quote_src']            =   e( $qv['quote_src'] );
            $qv['total_votes']          =   0;

            if( $qv['media_type'] == 1 ){
                foreach($qv['images'] as $ik => $iv){
                    $upload             =   UserUploads::where( 'id', '=', $iv);

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
                $av['total_votes']      =   0;
                $av['vote_percentage']  =   0;

                if(!empty($av['img'])){
                    $upload         =   UserUploads::where( 'id', '=', $av['img']);

                    if(!$upload->exists()){
                        $output['errors']   =   [ trans('media.question_invalid_img', [ 'q' => $qk+1, 'a' => $ak+1 ]) ];
                        return response()->json($output);
                    }

                    $upload         =   $upload->first();
                    $av['img']      =   $upload->upl_name;
                }

                $qv['answers'][$ak]   =   $av;
            }

            $questions[$qk]         =   $qv;
        }

        $contentObj                 =   json_encode([
            "questions"             =>  $questions,
            "style"                 =>  intval($request->input('style')),
            "animation"             =>  e( $request->input('animation') )
        ]);

        $media                      =   Media::create([
            "title"                 =>  e($request->input('title')),
            "media_desc"            =>  e($request->input('desc')),
            "content"               =>  $contentObj,
            "media_type"            =>  1,
            "thumbnail"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::thumbnail( $request->input( 'thumbnail' ), 'poll' ),
            "featured_img"          =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::featured_image( $request->input('thumbnail'), 'poll' ),
            "share_img"             =>  $request->input('nsfw') == 2 ? $site_settings->nsfw_img : JaskoHelper::share_img( $request->input('thumbnail'), 'poll', $request->input('title') ),
            "uid"                   =>  $user->id,
            "cid"                   =>  intval( $request->input('cid') ),
            "slug_url"              =>  str_slug( $request->input('title') ),
            "status"                =>  JaskoHelper::approve_media(),
            "page_content"          =>  Purifier::clean($request->input('page_content')),
            "nsfw"                  =>  intval( $request->input( 'nsfw' ) ),
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
        $media->content             =   json_decode($media->content);
        $category                   =   Categories::find( $media->cid );
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();
        $author                     =   User::find($media->uid);
        $next_media                 =   Media::where( 'id', '>', $media->id )->where('status', 2)->first();
        $prev_media                 =   Media::where( 'id', '<', $media->id )->where('status', 2)->orderBy('id', 'desc')->first();
        $related_media              =   Media::where([
            'cid'                   =>  $media->cid,
            'status'                =>  2,
            'media_type'            =>  1
        ])->orderBy('id', 'desc')->take(4)->get();

        foreach($related_media as $rk => $rv){
            $related_media[$rk]->author =   User::find($rv->uid);
        }

        $already_answered_count     =   0;

        // Check if Previously Voted
        $voteCheck                  =   PollVotes::where([
            'pid'                   =>  $media->id,
            'sid'                   =>  $sid
        ]);

        if($voteCheck->exists()){
            $voteCheck              =   $voteCheck->first();
            $voteCheck->vote_keys   =   json_decode( $voteCheck->vote_keys );

            foreach( $voteCheck->vote_keys as $key => $value ){
                if(!isset( $media->content->questions[$value->question_key] )){
                    continue;
                }

                $media->content->questions[$value->question_key]->already_answered  =   true;
                $media->content->questions[$value->question_key]->answer_key        =   $value->answer_key;
                $already_answered_count++;
            }
        }

        $like_check                 =   MediaLikes::where([
            'mid'                   =>  $media->id,
            'sid'                   =>  $sid
        ]);

        return view( 'media.polls.page' )->with([
            'site_title'            =>  $media->title . ' - ' . $settings->site_title,
            'site_desc'             =>  $media->media_desc,
            'media'                 =>  $media,
            'media_cat'             =>  $category,
            'author'                =>  $author,
            'already_answered'      =>  $already_answered_count,
            'next_media'            =>  $next_media,
            'prev_media'            =>  $prev_media,
            'related_media'         =>  $related_media,
            'mediaLiked'            =>  $like_check->exists()
        ]);
    }
    public function vote(Request $request, $name){
        $output                     =   [ 'status' => 1 ];
        $media                      =   Media::where( 'slug_url', '=', $name );

        if(!$media->exists()){
            return response()->json( $output );
        }

        $answer_key                 =   intval( $request->input('answer_key') );
        $question_key               =   intval( $request->input('question_key') );
        $media                      =   $media->first();
        $media->content             =   json_decode($media->content);
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();

        // Process Votes
        $voteCheck                  =   PollVotes::where([
            'pid'                   =>  $media->id,
            'sid'                   =>  $sid
        ]);

        if($voteCheck->exists()){
            $voteCheck              =   $voteCheck->first();
            $keyObj                 =   json_decode( $voteCheck->vote_keys );
            array_push( $keyObj, [
                'question_key'      =>  $question_key,
                'answer_key'        =>  $answer_key
            ]);
            $keyObj                 =   json_encode( $keyObj );
            $voteCheck->vote_keys   =   $keyObj;
            $voteCheck->save();
        }else{
            $keyObj                 =   [[
                'question_key'      =>  $question_key,
                'answer_key'        =>  $answer_key
            ]];
            $vote                   =   PollVotes::create([
                'pid'               =>  $media->id,
                'vote_keys'         =>  json_encode( $keyObj ),
                'sid'               =>  $sid
            ]);
        }

        // Update Media
        $media->content->questions[$question_key]->total_votes++;
        $media->content->questions[$question_key]->answers[$answer_key]->total_votes++;

        foreach($media->content->questions[$question_key]->answers as $ak => $av){
            $av->vote_percentage   =   round($av->total_votes / $media->content->questions[$question_key]->total_votes * 100, 2);
            $media->content->questions[$question_key]->answers[$ak]     =   $av;
        }

        $media->content             =   json_encode( $media->content );
        $media->save();


        $output['status']           =   2;
        return response()->json($output);
    }
    public function media_page(){
        $site_settings                  =   SiteSettings::find(1);
        $slides                         =   json_decode($site_settings->slides);

        foreach($slides as $sk => $sv){
            $slides[$sk]                =   Media::find($sv->id);

            if($slides[$sk]->media_type != 1){
                unset($slides[$sk]);
                continue;
            }
        }

        $slides                         =   array_values($slides);

        return view( 'media.media-page' )->with([
            'site_title'                =>  trans('media.polls') . ' - ' . $site_settings->site_title,
            'site_desc'                 =>  $site_settings->site_desc,
            'slides'                    =>  $slides,
            'types'                     =>  [ 1, 1 ]
        ]);
    }
}