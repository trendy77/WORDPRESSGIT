<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 12/6/2015
 * Time: 12:40 PM
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\SiteSettings;

function get_media_type( $type ){
    if ($type == 1) {
        return 'poll';
    } else if ($type == 2) {
        return 'trivia';
    } else if ($type == 3) {
        return 'personality';
    } else if ($type == 4) {
        return 'image';
    } else if ($type == 5) {
        return 'meme';
    } else if ($type == 6) {
        return 'video';
    } else if ($type == 7) {
        return 'news';
    } else if ($type == 8) {
        return 'list';
    }else{
        return false;
    }
}

function full_media_url($mediaObj){
    $url                =  get_media_type( $mediaObj->media_type ) . '/';
    $url                .=  $mediaObj->slug_url;
    $url                =   url($url);

    return $url;
}

function full_media_thumbnail_url($mediaObj, $width = 1200, $height = 630){
    $url                =   jasko_component( '/uploads/' . $mediaObj->thumbnail ) ;
    return $url;
}

function featured_media_img_url($mediaObj){
    $url                =   jasko_component( '/uploads/'. $mediaObj->featured_img );
    return $url;
}

function user_profile_img( $userObj ){
    $url                =   jasko_component( '/uploads/' . $userObj->profile_img );
    return $url;
}

function show_create($s){
    if(Auth::user()->isAdmin == 2 || Auth::user()->isMod){
        return true;
    }

    if( $s->canCreatePoll == 1 || $s->canCreateTrivia == 1 || $s->canCreatePersonality == 1 || $s->canCreateImage == 1 || $s->canCreateMeme == 1 || $s->canCreateVideo == 1 || $s->canCreateArticles == 1 || $s->canCreateLists == 1 ){
        return true;
    }

    return false;
}

function full_media_share_img_url($mediaObj){
    $url                =   jasko_component( '/uploads/' . $mediaObj->share_img );
    return $url;
}

function jasko_component( $path ){
    $settings                       =   SiteSettings::find(1);
    if($settings->aws_s3 == 2 && ( strpos($path, "png") > 0 || strpos($path, "gif") > 0 || strpos($path, "jpeg") > 0 ) ){
        if( !Storage::disk('s3')->exists($path) ){
            Storage::disk('s3')->put(
                $path,
                file_get_contents( public_path( $path ) )
            );
        }

        return 'https://s3-' . env("AWS_S3_REGION") . '.amazonaws.com/' . env("AWS_S3_BUCKET") .  $path;
    }

    return asset( "/public" . $path );
}

function get_default_lang( $default, $languages ){
    $user_lang                      =   session('locale');
    $readable                       =   '';

    foreach( $languages as $lang ){
        if( $lang->locale != $user_lang ) continue;
        $readable                   =   $lang->readable_name;
    }

    return $readable;
}
function strip_swag($t){
    $t                              =   str_replace("\r", "", $t);
    $t                              =   str_replace("\n", "", $t);
    return $t;
}