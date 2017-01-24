<div class="media-post-header">
    <div class="category" style="background-color: {{ $media_cat->bg_color }};">{{ $media_cat->name }}</div>
    <h1 class="media-title">{{ $media->title }}</h1>
    <div class="media-description">{{ $media->media_desc }}</div>
    <div class="media-meta-ctr">
        <div class="author-profile-img">
            <img class="img-responsive" src="{{ jasko_component( '/uploads/' . $author->profile_img )  }}">
        </div>
        <div class="media-meta-overview-ctr">
            <div class="media-meta-author-info">
                By <a href="{{ route('profile', ['username' => $author->username]) }}">{{ $author->display_name }}</a>
                @if(!empty($author->twitter))<a href="https://twitter.com/{{ $author->twitter }}" target="_blank" class="author-social-link"><i class="fa fa-twitter"></i></a>@endif
                @if(!empty($author->facebook))<a href="https://facebook.com/{{ $author->facebook }}" target="_blank" class="author-social-link"><i class="fa fa-facebook"></i></a>@endif
                @if(!empty($author->gplus))<a href="http://plus.google.com/{{ $author->gplus }}" target="_blank" class="author-social-link"><i class="fa fa-google-plus"></i></a>@endif
                @if(!empty($author->vk))<a href="https://vk.com/{{ $author->vk }}" target="_blank" class="author-social-link"><i class="fa fa-vk"></i></a>@endif
                @if(!empty($author->soundcloud))<a href="https://soundcloud.com/{{ $author->soundcloud }}" target="_blank" class="author-social-link"><i class="fa fa-soundcloud"></i></a>@endif
            </div>
            <div class="media-meta-post-info">{{ trans('media.posted') }} {{ $media->created_at->diffForHumans() }}</div>
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-default btn-like-media @if($mediaLiked) text-{{ $settings->site_color }} @endif" data-class="{{ $settings->site_color }}"
            data-mid="{{ $media->id }}" data-token="{{ csrf_token() }}"><i class="fa fa-heart"></i> {{ $media->like_count }}</button>
</div>
<div class="media-content-share hidden-xs">
    <button type="button" class="btn btn-block btn-facebook share-fb" data-url="{{ full_media_url($media) }}"><i class="fa fa-facebook"></i></button>
    <button type="button" class="btn btn-block btn-twitter share-twitter" data-url="{{ full_media_url($media) }}" data-txt="{{ $media->title }}"><i class="fa fa-twitter"></i></button>
    <button type="button" class="btn btn-block btn-googleplus share-google-plus" data-url="{{ full_media_url($media) }}"><i class="fa fa-google-plus"></i></button>
    <button type="button" class="btn btn-block btn-pinterest share-pinterest" data-url="{{ full_media_url($media) }}"
            data-txt="{{ $media->title }}" data-img="{{ featured_media_img_url($media) }}"><i class="fa fa-pinterest"></i></button>

    @if($settings->allow_embeds == 2 && ( $media->media_type == 1 || $media->media_type == 2 || $media->media_type == 3 ) )
        <button type="button" class="btn btn-block btn-black" data-target="#embedMediaModal" data-toggle="modal"><i class="fa fa-link"></i></button>
    @endif
</div>
<div class="media-content-share-mobile visible-xs">
    <div class="share-text"><i class="fa fa-paper-plane"></i> {{ trans('media.share') }}</div>
    <button type="button" class="btn btn-facebook share-fb" data-url="{{ full_media_url($media) }}"><i class="fa fa-facebook"></i></button>
    <button type="button" class="btn btn-twitter share-twitter" data-url="{{ full_media_url($media) }}" data-txt="{{ $media->title }}"><i class="fa fa-twitter"></i></button>
    <button type="button" class="btn btn-googleplus share-google-plus" data-url="{{ full_media_url($media) }}"><i class="fa fa-google-plus"></i></button>
    <button type="button" class="btn btn-pinterest share-pinterest" data-url="{{ full_media_url($media) }}"
            data-txt="{{ $media->title }}" data-img="{{ featured_media_img_url($media) }}"><i class="fa fa-pinterest"></i></button>
</div>