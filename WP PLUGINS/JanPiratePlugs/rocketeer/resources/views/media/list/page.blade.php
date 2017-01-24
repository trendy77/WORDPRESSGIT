@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media-post-ctr">
                            @include( 'media.header' )

                            <div id="listApp">
                                @include( 'media.list.style-' . $media->content->style )
                            </div>

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
    <link rel="stylesheet" type="text/css" href="{{ jasko_component('/components/semantic/transition.min.css') }}">
@endsection

@section( 'scripts' )
    <script>
        var list_animation      =   '{{ $media->content->animation }}';
    </script>
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="//platform.vine.co/static/scripts/embed.js"></script>
    <script src="{{ jasko_component('/components/semantic/transition.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/list.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/comments.min.js') }}"></script>
@endsection