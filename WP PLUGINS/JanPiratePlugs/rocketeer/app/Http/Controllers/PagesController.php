<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Media;
use App\User;
use App\Categories;
use App\SiteSettings;
use App\Pages;
use App;
use Carbon\Carbon;

class PagesController extends Controller
{
    public function home(){
        $trending                       =   Media::where( 'status', 2 )->orderBy( 'weekly_like_count', 'desc' )->take(15)->get();
        $site_settings                  =   SiteSettings::find(1);
        $slides                         =   json_decode($site_settings->slides);
        $slides                         =   array_slice( $slides, 0, 10 );

        foreach($slides as $sk => $sv){
            $slides[$sk]                =   Media::find($sv->id);
        }

        return view( 'home' )->with([
            'site_title'                =>  $site_settings->site_title,
            'site_desc'                 =>  $site_settings->site_desc,
            'trending_items'            =>  $trending,
            'slides'                    =>  $slides
        ]);
    }

    public function topic_page($slug){
        $topic                          =   Categories::where( 'slug_url', '=', $slug )->first();
        $site_settings                  =   SiteSettings::find(1);

        if(!$topic){
            return redirect()->route('home');
        }

        $trending                       =   Media::where([
            'status'                    =>  2,
            'cid'                       =>  $topic->id
        ])->orderBy( 'weekly_like_count', 'desc' )->take(15)->get();

        return view( 'topic' )->with([
            'site_title'                =>  $topic->name . ' - ' . $site_settings->site_title,
            'site_desc'                 =>  $site_settings->site_desc,
            'topic'                     =>  $topic,
            'trending_items'            =>  $trending
        ]);
    }

    public function page($slug){
        $settings                   =   SiteSettings::find(1);
        $page                       =   Pages::where( 'slug_url', '=', $slug );

        if(!$page->exists()){
            return redirect()->route('home');
        }

        $page                       =   $page->first();

        return view( 'page' )->with([
            'site_title'            =>  $page->title . ' - ' . $settings->site_title,
            'site_desc'             =>  $settings->site_desc,
            'page'                  =>  $page
        ]);
    }

    public function sitemap(){
        // create new sitemap object
        $sitemap                                =   App::make("sitemap");

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        $sitemap->setCache('laravel.sitemap', 360);

        // check if there is cached sitemap. Reuse old cache if it is.
        if ($sitemap->isCached()){
            return $sitemap->render('xml');
        }

        // add item to the sitemap (url, date, priority, freq)
        $sitemap->add( route('home'), Carbon::now(), '1.0', 'daily' );
        $sitemap->add( route('polls'), Carbon::now(), '1.0', 'daily' );
        $sitemap->add( route('quizzes'), Carbon::now(), '1.0', 'daily' );
        $sitemap->add( route('images'), Carbon::now(), '1.0', 'daily' );
        $sitemap->add( route('videos'), Carbon::now(), '1.0', 'daily' );
        $sitemap->add( route('news_media_page'), Carbon::now(), '1.0', 'daily' );
        $sitemap->add( route('lists'), Carbon::now(), '1.0', 'daily' );
        $sitemap->add( route('leaderboard'), Carbon::now(), '1.0', 'monthly' );

        // Loop Through All Pages
        $pages                                  =   Pages::all();
        foreach($pages as $page){
            $sitemap->add( route( 'page',[
                'slug'                          =>  $page->slug_url
            ]), $page->updated_at, '1.0', 'monthly' );
        }

        // Loop Through All Topics
        $topics                                 =   Categories::all();
        foreach($topics as $topic){
            $sitemap->add( route( 'topic',[
                'slug'                          =>  $topic->slug_url
            ]), $topic->updated_at, '1.0', 'daily' );
        }

        // Loop Through All Media Items
        $media_items                            =   Media::where('status', 2)->get();
        foreach($media_items as $item){
            $sitemap->add( route( get_media_type( $item->media_type ),[
                'name'                          =>  $item->slug_url
            ]), $item->updated_at, '1.0', 'monthly' );
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
    }
}
