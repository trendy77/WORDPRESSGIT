<?php

namespace App\Http\Controllers\Media;

use App\SiteSettings;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Media;
use App\PollVotes;
use Auth;

class EmbedController extends Controller
{
    protected $settings;

    public function main( Request $request, $id ){
        $media                      =   Media::find( $id );
        $this->settings             =   SiteSettings::find(1);

        if($this->settings->allow_embeds != 2){
            return redirect()->route('home');
        }

        if(!$media){
            return redirect()->route( 'home' );
        }

        if( $media->media_type == 1 ){
            return $this->poll( $request, $media );
        }else if( $media->media_type == 2){
            return $this->trivia( $request, $media );
        }else if( $media->media_type == 3){
            return $this->personality( $request, $media );
        }else{
            return redirect()->route( 'home' );
        }
    }

    private function poll( $request, $media ){
        $media->content             =   json_decode($media->content);
        $user                       =   Auth::user();
        $sid                        =   $user ? $user->id : $request->ip();
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

        return view( 'media.embed.poll' )->with([
            'media'                 =>  $media,
            'already_answered'      =>  $already_answered_count,
            'site_title'            =>  $this->settings->site_title
        ]);
    }

    private function trivia( $request, $media ){
        $media->content             =   json_decode( $media->content );

        return view( 'media.embed.trivia' )->with([
            'site_title'            =>  $media->title . ' - ' . $this->settings->site_title,
            'media'                 =>  $media,
        ]);
    }

    private function personality( $request, $media ){
        $media->content             =   json_decode( $media->content );

        return view( 'media.embed.personality' )->with([
            'site_title'            =>  $media->title . ' - ' . $this->settings->site_title,
            'media'                 =>  $media,
        ]);
    }
}
