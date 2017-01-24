@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media-post-ctr">
                            @include( 'media.header' )

                            {!! csrf_field() !!}

                            @include( 'media.polls.style-' . $media->content->style )

                            <div class="media-page-content">{!! $media->page_content !!} </div>

                            @include( 'media.additional-media' )

                            @include( 'media.comments' )
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-xs">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include( 'partials.sidebar' )
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'styles' )
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ jasko_component('/components/semantic/transition.min.css') }}">
@endsection

@section( 'scripts' )
    @if( $settings->allow_embeds == 2 )
        @include( 'media.embed-modal' )
    @endif

    <script>
        var signin_required             =   {!! $settings->poll_signed_in_votes !!};
        var user_signed_in              =   {!! Auth::check() ? 2 : 1 !!};
        var auto_scroll                 =   {{ $settings->auto_scroll }};
        var auto_scroll_timer           =   {{ $settings->auto_scroll_timer }};
        var mid                         =   {!! $media->id !!};
        var poll_style                  =   {{ $media->content->style }};
        var point_token                 =   '{!! csrf_token() !!}';
        var i18n_votes                  =   '{!! trans('media.votes') !!}';
    </script>
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="//platform.vine.co/static/scripts/embed.js"></script>
    <script src="{{ jasko_component('/components/semantic/transition.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/poll.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/comments.min.js') }}"></script>
@endsection