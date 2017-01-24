<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 11/15/2015
 * Time: 5:56 PM
 */
namespace App\Classes;

class UrlId {
    public static function parse ($url, &$type=false) {
        // Youtube Vimeo Vine Facebook Instagram
        if(substr_count($url, 'yout') > 0) {
            $type = 'youtube';
            return self::youtube($url);
        }elseif (substr_count($url, 'vimeo') > 0) {
            $type = 'vimeo';
            return self::vimeo($url);
        }elseif (substr_count($url, 'vine') > 0) {
            $type = 'vine';
            return self::vine($url);
        }elseif (substr_count($url, 'soundcloud') > 0) {
            $type = 'soundcloud';
            return self::soundcloud($url);
        }elseif (substr_count($url, 'twitter') > 0) {
            $type = 'twitter';
            return self::twitter($url);
        }elseif (substr_count($url, 'facebook') > 0) {
            $type = 'facebook';
            return self::facebook($url);
        }elseif (substr_count($url, 'instagram') > 0) {
            $type = 'instagram';
            return self::instagram($url);
        }
        $type = 'unknown';
        return null;
    }
    public static function parse_id($url, &$type=false) {
        // Youtube Vimeo Vine Facebook Instagram
        if(substr_count($url, 'yout') > 0) {
            $type = 'youtube';
            return self::youtube_id($url);
        }elseif (substr_count($url, 'vimeo') > 0) {
            $type = 'vimeo';
            return self::vimeo_id($url);
        }elseif (substr_count($url, 'vine') > 0) {
            $type = 'vine';
            return self::vine_id($url);
        }
        $type = 'unknown';
        return null;
    }
    public static function getType($url){
        if(substr_count($url, 'yout') > 0) {
            return 1;
        }elseif (substr_count($url, 'vimeo') > 0) {
            return 2;
        }elseif (substr_count($url, 'vine') > 0) {
            return 3;
        }elseif (substr_count($url, 'soundcloud') > 0) {
            return 4;
        }elseif (substr_count($url, 'twitter') > 0) {
            return 5;
        }
        return false;
    }
    private static function youtube ($url) {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            if (!empty($match[1])) {
                return '<div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $match[1] . '"></iframe>
                        </div>';
            }
        }
        return null;
    }
    public static function youtube_id($url){
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            if (!empty($match[1])) {
                return $match[1];
            }
        }
        return null;
    }
    private static function vimeo ($url) {
        if (is_numeric($url)) {
            return $url;
        }
        if (substr_count($url, '?')) {
            $url = explode('?', $url, 2);
            $url = $url[0];
        }
        $url = explode('/', str_replace('http://', '', $url));
        return ' <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/' . array_pop($url) . '"></iframe>
                </div>';
    }
    private static function vimeo_id($url) {
        if (is_numeric($url)) {
            return $url;
        }
        if (substr_count($url, '?')) {
            $url = explode('?', $url, 2);
            $url = $url[0];
        }
        $url = explode('/', str_replace('http://', '', $url));
        return array_pop($url);
    }
    private static function vine($url) {
        preg_match("#(?<=vine.co/v/)[0-9A-Za-z]+#", $url, $matches);
        if (isset($matches[0])) {
            return '<div class="embed-responsive embed-responsive-1by1">
                        <iframe class="embed-responsive-item" src="https://vine.co/v/' . $matches[0] . '/embed/simple"></iframe>
                    </div>';
        }
        return false;
    }
    private static function vine_id($url) {
        preg_match("#(?<=vine.co/v/)[0-9A-Za-z]+#", $url, $matches);
        if (isset($matches[0])) {
            return $matches[0];
        }
        return false;
    }
    private static function soundcloud ($url) {
        //Get the JSON data of song details with embed code from SoundCloud oEmbed
        $getValues          =   file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url.'&iframe=true');
        //Clean the Json to decode
        $decodeiFrame       =   substr($getValues, 1, -2);
        //json decode to convert it as an array
        $jsonObj            =   json_decode($decodeiFrame);
        $iframe             =   $jsonObj->html;

        preg_match('/src="([^"]+)"/', $iframe, $match);

        $url                =   '<iframe width="100%" height="400" scrolling="no" frameborder="no" src="' . $match[1] . '"></iframe>';

        return $url;
    }
    private static function twitter($url) {
        $arr                =   explode("/", $url);
        $id                 =   end($arr);
        $tweetObj           =   file_get_contents("https://api.twitter.com/1/statuses/oembed.json?id=" . $id . "&omit_script=true");
        $tweetObj           =   json_decode($tweetObj);
        return $tweetObj->html;
    }
    private static function facebook($url) {
        return '<div class="center-block text-center">
                    <div class="fb-post" data-href="' . $url . '" data-width="400"></div>
                </div>';
    }
    private static function instagram($url) {
        $url                        =   preg_replace('/\?.*/', '', $url);
        $contents                   =   file_get_contents( 'http://api.instagram.com/publicapi/oembed/?url=' . $url . '&omitscript=false&maxwidth=650&align=center' );
        $contents                   =   @json_decode($contents);

        if(!$contents){
            return false;
        }
        return $contents->html;
    }
}