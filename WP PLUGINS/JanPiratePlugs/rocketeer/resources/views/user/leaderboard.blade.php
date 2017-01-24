@extends( 'layout' )

@section( 'content' )
    <div class="push-top container" id="homeApp">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h1>{{ trans('general.leaderboard') }}</h1>
                            @foreach($users as $uk => $uv)
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
                        </div>
                        <div class="col-md-4 gray-border-left hidden-xs">
                            @include( 'partials.sidebar' )
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection