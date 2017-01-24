<?php

namespace App\Http\Controllers;

use App\SiteSettings;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use App\User;
use App\Media;
use App\UserNotification;
use Validator;
use Auth;

class CommentsController extends Controller
{
    public function get_media_comments(Request $request){
        $output                     =   [ 'status' => 1 ];
        $settings                   =   SiteSettings::find(1);
        $validator                  =   Validator::make($request->all(), [
            'mid'                   =>  'required|integer',
        ]);

        if($validator->fails()){
            return response()->json( $output );
        }

        $comments                   =   Comment::where('mid', '=', $request->input('mid'))->skip($request->input('offset'))->take($settings->display_count)->get();

        foreach($comments as $ck => $cv){
            $user_comment           =   User::find($cv->uid);
            $comments[$ck]->img     =   jasko_component( '/uploads/' . $user_comment->profile_img );
            $comments[$ck]->name    =   $user_comment->display_name;
            $comments[$ck]->username=   $user_comment->username;
            $comments[$ck]->time_posted =   $cv->created_at->diffForHumans();
        }

        $output['status']           =   2;
        $output['comments']         =   $comments;
        return response()->json( $output );
    }

    public function add_media_comment(Request $request){
        $output                     =   [ 'status' => 1 ];

        $validator                  =   Validator::make($request->all(), [
            'mid'                   =>  'required|integer',
            'comment'               =>  'required|min:3|max:1000'
        ]);

        if($validator->fails() || !Auth::check()){
            return response()->json( $output );
        }

        $media                      =   Media::find( $request->input('mid') );
        $comment                    =   Comment::create([
            'uid'                   =>  Auth::user()->id,
            'mid'                   =>  intval( $request->input('mid') ),
            'body'                  =>  e( $request->input('comment') )
        ]);

        UserNotification::create([
            'uid'                   =>  $media->uid,
            'message'               =>  trans( 'media.comment_notification', [
                'user'              =>  '<a href="' . route( 'profile', [ 'username' => Auth::user()->username ] ) . '">' . Auth::user()->display_name . '</a>',
                'post'              =>  '<a href="' . route( get_media_type($media->media_type), [ 'name' => $media->slug_url ] ) . '">' . $media->title . '</a>'
            ])
        ]);

        $output['status']           =   2;
        return response()->json( $output );
    }
}
