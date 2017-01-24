@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media-post-ctr">
                            @include( 'media.header' )

                            @include( 'media.trivia.style-' . $media->content->style )

                            <div class="media-page-content">{!! $media->page_content !!} </div>

                            @include( 'media.additional-media' )

                            @include( 'media.comments' )
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-xs">
                <div class="panel panel-default">
                    <div class="panel-body">@include( 'partials.sidebar' )</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resultModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ trans('media.you_got') }} <span id="modalQuizResultTxt"></span>
                    </h4>
                </div>
                <div class="modal-body">
                    <img class="img-responsive center-block" id="modalQuizResultImg">
                    <p id="modalQuizResultDesc" class="text-center" style="margin:20px 0;"></p>
                    <p class="text-center">
                        <button type="button" class="btn btn-lg btn-facebook btn-rect btn-fb-share">
                            <i class="fa fa-facebook"></i> {{ trans('media.fb_share') }}
                        </button>
                        <button type="button" class="btn btn-lg btn-twitter btn-rect btn-twitter-share">
                            <i class="fa fa-twitter"></i> {{trans('media.tweet_twitter') }}
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'styles' )
    <link rel="stylesheet" type="text/css" href="{{ jasko_component('/components/semantic/transition.min.css') }}">
@endsection

@section( 'scripts' )
    @if( $settings->allow_embeds == 2 )
        @include( 'media.embed-modal' )
    @endif
    <script>
        var i_got           =   '{{ trans('media.i_got') }}';
        var correct_i18n    =   '{{ trans('media.correct') }}';
        var incorrect_i18n  =   '{{ trans('media.incorrect') }}';
        var the_correct_answer_is   =   '{{ trans('media.the_correct_answer_is') }}';
        var mid             =   {!! $media->id !!};
        var point_token     =   '{!! csrf_token() !!}';
        var auto_scroll                 =   {{ $settings->auto_scroll }};
        var auto_scroll_timer           =   {{ $settings->auto_scroll_timer }};
        triviaObj           =   {!! json_encode($media->content) !!};
    </script>
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="//platform.vine.co/static/scripts/embed.js"></script>
    <script src="{{ jasko_component('/components/semantic/transition.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/trivia.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/comments.min.js') }}"></script>
@endsection