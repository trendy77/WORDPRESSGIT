<div class="media-neighbors-ctr">
    <div class="media-neighbors-items-ctr">
        @if($prev_media)
            <a href="{{ full_media_url($prev_media) }}" class="neighbor-link prev-media-link">
                <h5>{{ trans('media.previous') }}</h5>
                <h3>{{ $prev_media->title }}</h3>
                <i class="fa fa-angle-double-left"></i>
            </a>
        @endif
        @if($next_media)
            <a href="{{ full_media_url($next_media) }}" class="neighbor-link next-media-link">
                <h5>{{ trans('media.next') }}</h5>
                <h3>{{ $next_media->title }}</h3>
                <i class="fa fa-angle-double-right"></i>
            </a>
        @endif
    </div>
</div>

<div class="related-media-wrapper">
    <h3 class="title">{{ trans('media.check_this_out') }}</h3>
    @foreach($related_media as $rk => $rv)
        <a class="related-content-ctr" href="{{ full_media_url($rv) }}">
            <div class="related-inner">
                <h4>
                    {{ $rv->title }}
                    <span class="date">{{ $rv->created_at->diffForHumans() }} | {{ $rv->author->display_name }}</span>
                </h4>
                <img src="{{ full_media_thumbnail_url($rv) }}">
            </div>
        </a>
    @endforeach
</div>
