<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Media;
use App\User;
use App\SiteSettings;

class SearchController extends Controller
{
    public function page(Request $request){
        $settings                       =   SiteSettings::find(1);
        $search_term                    =   $request->query('q');

        $media_items                    =   Media::where( 'title', 'LIKE', '%' . $search_term . '%' )
            ->where( 'media_desc', 'LIKE', '%' . $search_term . '%' )
            ->where( 'status', 2 )
            ->take( $settings->display_count * 3 )
            ->get();

        foreach($media_items as $mk => $mv){
            $media_items[$mk]->author;
            $media_items[$mk]->cat;
            $media_items[$mk]->author->profile_url    =   url('/profile/') .  $mv->author->username;
            $media_items[$mk]->full_url       =   full_media_url( $mv );
            $media_items[$mk]->diff_for_humans        =   $media_items[$mk]->created_at->diffForHumans();
        }

        return view( 'search' )->with([
            'site_title'                =>  trans('general.search') . ' - ' . $settings->site_title,
            'site_desc'                 =>  $settings->site_desc,
            'media_items'               =>  $media_items,
            'search_term'               =>  $search_term
        ]);
    }
}
