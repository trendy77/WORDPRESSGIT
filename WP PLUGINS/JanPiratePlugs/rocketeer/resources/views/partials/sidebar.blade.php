@foreach($widgets as $wk => $wv)
    <div class="widget">
        @if($wv->type == 1)
            <a class="ribbon-header ribbon-teal">
                <i class="fa fa-star fa-cat-icon"></i>
                {{ $wv->cat_info->name }}
                <i class="fa fa-angle-right"></i>
            </a>
            @foreach($wv->items as $mk => $mv)
                <div class="media-item-ctr-2">
                    <a class="media-item-thumbnail" href="{{ full_media_url($mv) }}">
                        <img src="{{ jasko_component( '/uploads/' . $mv->featured_img ) }}" class="img-responsive">
                        <div class="media-ribbon"><i class="fa fa-heart"></i> {{ $mv->like_count }}</div>
                    </a>
                    <div class="media-item-overview">
                        <h3><a href="{{ full_media_url($mv) }}">{{ $mv->title }}</a></h3>
                        <div class="media-meta-data">{{ $mv->author->display_name }} - {{ $mv->created_at->diffForHumans()  }}</div>
                    </div>
                </div>
            @endforeach
        @elseif($wv->type == 2)
            {!! $wv->html !!}
        @elseif($wv->type == 3)
            <h3 class="ribbon-header ribbon-{{ $settings->site_color }}">
                <i class="fa fa-user fa-cat-icon"></i> {{ strtoupper( trans('user.leaderboard') ) }}
            </h3>
            @foreach($wv->top_users as $uk => $uv)
                <div class="media topUserItem">
                    <div class="media-left media-middle">
                        <a href="{{ route('profile', [ 'username' => $uv->username ] ) }}"><img class="media-object img-circle" src="{{ user_profile_img( $uv ) }}"></a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="{{ route('profile', [ 'username' => $uv->username ] ) }}" class="text-{{ $settings->site_color }}">{{ $uv->display_name }}</a></h4>
                        <div class="media-user-points"><span>{{ $uv->points }}</span> PTS</div>
                    </div>
                </div>
            @endforeach
            <a href="{{ route('leaderboard') }}" class="btn btn-block btn-{{ $settings->site_color }}">{{ trans('general.view_leaderboard') }}</a>
        @elseif($wv->type == 4)
            <h3 class="ribbon-header ribbon-{{ $settings->site_color }}">
                <i class="fa fa-star fa-cat-icon"></i> {{ strtoupper( trans('general.trending') ) }}
            </h3>
            @foreach($wv->items as $mk => $mv)
                <div class="media-item-ctr-2">
                    <a class="media-item-thumbnail" href="{{ full_media_url($mv) }}">
                        <img src="{{ jasko_component( '/uploads/' . $mv->featured_img ) }}" class="img-responsive">
                        <div class="media-ribbon"><i class="fa fa-heart"></i> {{ $mv->like_count }}</div>
                    </a>
                    <div class="media-item-overview">
                        <h3><a href="{{ full_media_url($mv) }}">{{ $mv->title }}</a></h3>
                        <div class="media-meta-data">{{ $mv->author->display_name }} - {{ $mv->created_at->diffForHumans()  }}</div>
                    </div>
                </div>
            @endforeach
        @elseif($wv->type == 5)
            <div class="newsletter-widget bg-{{ $settings->site_color }}">
                <h2>{!! $wv->newsletter_action_call !!}</h2>
                <form id="universalSubscribeForm">
                    {!! csrf_field() !!}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ trans('email.enter_email') }}" id="inputSubscriberEmail">
                        <span class="input-group-btn"><button class="btn btn-black" type="submit">{{ trans('email.subscribe') }}</button></span>
                    </div><!-- /input-group -->
                </form>
            </div>
        @endif
    </div>
    <div class="clearfix"></div>
@endforeach