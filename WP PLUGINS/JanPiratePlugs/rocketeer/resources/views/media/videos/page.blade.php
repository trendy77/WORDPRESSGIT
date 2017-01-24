@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media-post-ctr">
                            @include( 'media.header' )

                            @if($media->content->type == 1)
                                <!-- 16:9 aspect ratio -->
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $media->content->id }}"></iframe>
                                </div>
                            @elseif($media->content->type == 2)
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/{{ $media->content->id }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>
                            @elseif($media->content->type == 3)
                                <div class="embed-responsive embed-responsive-1by1">
                                    <iframe src="https://vine.co/v/{{ $media->content->id }}/embed/simple" frameborder="0"></iframe>
                                </div>
                            @endif

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

@section( 'scripts' )
    <script src="//platform.vine.co/static/scripts/embed.js"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/js/comments.min.js') }}"></script>
@endsection