<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>{{ $site_title }}</title>
    <meta name="description" content="{{ $site_desc }}">
    <link rel="icon" href="{{ jasko_component( '/uploads/' . $settings->favicon ) }}" type="image/x-icon">

    <!-- Social Media -->
    @if(isset($media))
        <meta property="fb:app_id" content="{{ $settings->fb_app_key }}">
        <meta property="og:url" content="{{ full_media_url($media) }}" />
        <meta property="og:type" content="article" />

        @if(isset($share_title))
            <meta property="og:title" content="{{ $share_title }}" />
            <meta property="og:description" content="{{ $share_desc }}" />
            <meta name="twitter:title" content="{{ $share_title }}">
            <meta name="twitter:description" content="{{ $share_desc }}">
        @else
            <meta property="og:title" content="{{ $media->title }}" />
            <meta property="og:description" content="{{ $media->media_desc }}" />
            <meta name="twitter:title" content="{{ $media->title }}">
            <meta name="twitter:description" content="{{ $media->media_desc }}">
        @endif

        @if(isset($share_img))
            <meta property="og:image" content="{{ jasko_component( '/uploads/' . $share_img) }}" />
            <meta name="twitter:image" content="{{ jasko_component( '/uploads/' . $share_img) }}">
        @else
            <meta property="og:image" content="{{ full_media_share_img_url($media) }}" />
            <meta name="twitter:image" content="{{ full_media_share_img_url($media) }}">
        @endif

        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="{{ '@' . $settings->twitter }}">
        <meta name="twitter:creator" content="{{ '@' . $settings->twitter }}">
    @endif

    <!-- Libraries -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Montserrat:400,700' >
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family={{ $settings->google_font }}'>
    <link rel="stylesheet" type="text/css" href="{{ jasko_component('/components/core/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ jasko_component('/components/loaders/loaders.min.css') }}">

    <style>
        body{ font-family: {!! $settings->site_font !!}; }
    </style>

    @yield( 'styles' )

    <style>{!! $settings->custom_css !!}</style>
</head>
<body style="background-image: url('{{ jasko_component('/components/core/img/bg.png') }}');">
<div id="fb-root"></div>
<script>
    var ajaxurl                     =   '{{ url('/') }}';
    var categories                  =    {!! json_encode( $categories ) !!};
    var infinite_pagination         =   {!! $settings->infinite_pagination !!};
    var user_locale                 =   '{!! session('locale') !!}';
</script>
<header>
    @include( 'partials.nav' )
</header>