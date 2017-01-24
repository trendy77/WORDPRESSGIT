<?php

namespace App\Http\Middleware;

use Closure;
use App;
use App\SiteSettings;
use Carbon\Carbon;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $settings                   =   SiteSettings::find(1);
        $settings->languages        =   json_decode( $settings->languages );
        $available_locales          =   [];

        foreach($settings->languages as $lang){
            array_push($available_locales, $lang->locale);
        }

        if(!empty(session('locale')) && in_array(session('locale'), $available_locales) && $settings->lang_switcher == 2) {
            App::setLocale(session('locale'));
            Carbon::setLocale(session('locale'));
        }else{
            session([
                'locale'            =>  env('ROCKETEER_LOCALE', 'en')
            ]);
            Carbon::setLocale(session('locale'));
        }

        return $next($request);
    }
}