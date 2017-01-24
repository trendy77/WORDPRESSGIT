@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media-post-ctr">
                            @include( 'media.header' )

                            <img class="img-responsive center-block" src="{{ jasko_component( '/uploads/' . $media->content ) }}">

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
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/js/comments.min.js') }}"></script>
@endsection