<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\SiteSettings;
use App\Pages;
use App\Categories;
use App\User;
use App\Media;
use App\UserBadge;
use App\Badge;
use App\UserNotification;
use Carbon\Carbon;
use Auth;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function( $view ){
            $settings                               =   SiteSettings::find(1);
            $settings->slides                       =   json_decode($settings->slides);
            $settings->widgets                      =   json_decode($settings->widgets);
            $settings->media_overrides              =   json_decode($settings->media_overrides);
            $settings->media_defaults               =   json_decode($settings->media_defaults);
            $settings->languages                    =   json_decode($settings->languages);
            $animations                             =   [
                'scale', 'fade', 'fade up', 'fade down', 'fade left', 'fade right',
                'horizontal flip', 'vertical flip', 'drop', 'fly left', 'fly right',
                'fly up', 'fly down', 'swing left', 'swing right', 'swing up',
                'swing down', 'browse', 'browse right', 'slide down', 'slide up',
                'slide left', 'slide right'
            ];
            $widgets                                =   [];

            // Process Widgets
            foreach($settings->widgets as $wk => $wv){
                $widgets[$wk]                       =   $wv;

                if($wv->type == 1){
                    $category                       =   Categories::find($wv->category);
                    $media_items                    =   Media::where([
                        'cid'                       =>  $wv->category,
                        'status'                    =>  2
                    ])->orderBy('id', 'desc')->take($wv->category_item_count)->get();

                    foreach($media_items as $ik => $iv){
                        $media_items[$ik]->author   =   User::find($iv->uid);
                    }

                    $widgets[$wk]->cat_info         =   $category;
                    $widgets[$wk]->items            =   $media_items;
                }else if($wv->type == 3){
                    $widgets[$wk]->top_users        =   User::orderBy('points', 'desc')->take($wv->leaderboard_count)->get();
                }else if($wv->type == 4){
                    $media_items                    =   Media::orderBy('weekly_like_count', 'desc')->take($wv->trending_count)->get();

                    foreach($media_items as $ik => $iv){
                        $media_items[$ik]->author   =   User::find($iv->uid);
                    }

                    $widgets[$wk]->items            =   $media_items;
                }
            }

            if(empty(session('locale'))) {
                session([
                    'locale'            =>  env('ROCKETEER_LOCALE', 'en')
                ]);
            }

            setlocale(LC_TIME, session('locale'));

            $response_arr                           =   [
                'settings'                          =>  $settings,
                'pages'                             =>  Pages::all(),
                'categories'                        =>  Categories::orderBy('pos', 'asc')->get(),
                'animations'                        =>  $animations,
                'widgets'                           =>  $widgets,
                'current_date'                      =>  Carbon::now()->formatLocalized('%A, %B %e %Y')
            ];

            // Check if user is logged in
            if( Auth::check() ){
                // Check for badges
                $badge_check                        =   UserBadge::where([
                    'user_checked'                  =>  1,
                    'uid'                           =>  Auth::user()->id
                ]);

                if($badge_check->exists()){
                    $badge                          =   $badge_check->first();
                    $user_badge                     =   Badge::find($badge->bid);
                    $response_arr['has_badge']      =   true;
                    $response_arr['user_badge']     =   $user_badge;

                    $badge->user_checked            =   2;
                    $badge->save();
                }

                $response_arr['notification_count'] =   UserNotification::where([
                    'uid'                           =>  Auth::user()->id,
                    'is_read'                       =>  1
                ])->count();
            }

            $view->with($response_arr);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
