@extends( 'media.embed.layout' )

@section( 'content' )

    <div id="quizApp" style="display: none;position: relative;">
        @if($media->content->is_timed == 2)
            <div class="timeStartCtr text-center">
                <h3>{{ $media->title }}</h3>
                <p>{{ trans('media.quiz_timer_intro', [ 'num' => $media->content->timer ]) }}</p>
                <button type="button" class="btn btn-success btn-start-quiz">{{ trans('media.begin') }}</button>
            </div>

            <div class="quiz-timer-ctr">{{ $media->content->timer }}</div>
        @endif
        <div class="quiz-main-questions-ctr" style="{{ $media->content->is_timed == 2 ? 'display: none;' : '' }}">
            <div class="quizProgressBarCtr">
                <div class="progressNav">
                    <button type="button" class="btn-prev btn-sky"><i class="fa fa-angle-left"></i></button>
                    <button type="button" class="btn-next btn-sky"><i class="fa fa-angle-right"></i></button>
                </div>
                <div class="progressTextCtr">
                    <div class="progressFinishedBar"></div>
                    <div class="progress-text">
                        <span>0</span> / {{ count($media->content->questions) }} {{ trans('media.questions_answered') }}
                    </div>
                </div>
            </div>

            <div class="questions-ctr">
                @foreach($media->content->questions as $qk => $qv)
                    <div class="question-ctr @if($qk == 0) active @endif">
                        @if($qv->media_type == 1)
                            <div class="question-img-ctr">
                                @if(count($qv->images) > 1)
                                    <div class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            @foreach($qv->images as $ik => $iv)
                                                <div class="item {{ $ik == 0 ? 'active': '' }}">
                                                    <img src="{{ jasko_component( '/uploads/' . $iv ) }}" style="height: 300px;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ jasko_component( '/uploads/' . $qv->images[0] )  }}" class="img-responsive">
                                @endif

                                @if(!empty($qv->question))
                                    <div class="question-txt" data-question="{{ $qv->question }}">{{ $qv->question }}</div>
                                @endif
                            </div>
                        @else
                            @if($qv->media_type == 2)
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $qv->yt_url }}"></iframe>
                                </div>
                            @elseif($qv->media_type == 3)
                                <div class="embed-responsive embed-responsive-1by1">
                                    <iframe class="embed-responsive-item" src="https://vine.co/v/{{ $qv->vine_url }}/embed/simple"></iframe>
                                </div>
                            @elseif($qv->media_type == 4)
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/{{ $qv->vimeo_url }}"></iframe>
                                </div>
                            @elseif($qv->media_type == 5)
                                <iframe width="100%" height="400" scrolling="no" frameborder="no" src="{{ $qv->soundcloud_url }}"></iframe>
                            @elseif($qv->media_type == 6)
                                <div class="center-block text-center">
                                    <div class="fb-post" data-href="{{ $qv->facebook_url }}" data-width="400"></div>
                                </div>
                            @elseif($qv->media_type == 7)
                                {!! $qv->tweet !!}
                            @elseif($qv->media_type == 8)
                                <div class="center-block text-center">{!! $qv->instagram_url !!}</div>
                            @elseif($qv->media_type == 9)
                                <blockquote class="media_blockquote">
                                    <i class="fa fa-quote-left fa-2x"></i>
                                    <i class="fa fa-quote-right fa-2x"></i>
                                    <p>{{ $qv->quote }}</p>
                                    <small>{{ $qv->quote_src }}</small>
                                </blockquote>
                            @endif

                            @if(!empty($qv->question))
                                <div class="question-txt" data-question="{{ $qv->question }}">{{ $qv->question }}</div>
                            @endif
                        @endif
                        <div class="explanation-ctr">{{ $qv->explanation }}</div>
                        <div class="answers-ctr question-unanswered">
                            @foreach($qv->answers as $ak => $av)
                                <div class="single-answer-ctr single-answer-style-{{ $qv->answer_display_type }}" data-is-correct="{{ $av->isCorrect }}">
                                    @if(!empty($av->img))<img src="{{ jasko_component( '/uploads/' . $av->img )  }}">@endif
                                    {{ $av->answer  }}
                                    <i class="fa fa-circle-thin"></i>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="results-ctr">
            @foreach($media->content->results as $rk => $rv)
                <div class="result-ctr" id="result-{{ $rk }}">
                    <div class="resultTitleCtr">{{ $rv->title }}</div>
                    @if(!empty($rv->main_img))
                        <div class="resultImgCtr">
                            <img class="img-responsive center-block" src="{{ jasko_component( '/uploads/' . $rv->main_img ) }}">
                            <div class="resultScoreCtr"><div class="resultScoreText"></div></div>
                        </div>
                    @else
                        <div class="resultImgCtr">
                            <div class="resultScoreCtr"><div class="resultScoreText"></div></div>
                        </div>
                    @endif

                    <div class="mediaShareCtr">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-block btn-success btn-retake-quiz">
                                <i class="fa fa-refresh"></i> {{ trans('media.retake_quiz') }}
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-block btn-primary btn-fb-share">
                                <i class="fa fa-facebook"></i> {{ trans('media.fb_share') }}
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-block btn-info btn-twitter-share">
                                <i class="fa fa-twitter"></i> {{trans('media.tweet_twitter') }}
                            </button>
                        </div>
                    </div>
                    <div class="resultDescCtr">
                        <h3>{{ trans('media.desc') }}</h3> {{ $rv->desc }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section( 'styles' )
    <link rel="stylesheet" type="text/css" href="{{ jasko_component('/components/semantic/transition.min.css') }}">
    <link rel="stylesheet" href="{{ jasko_component( '/components/core/css/embed.css' ) }}">
@endsection

@section( 'scripts' )
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
    <script src="{{ jasko_component('/components/semantic/transition.min.js') }}"></script>
    <script src="{{ jasko_component( '/components/core/js/embed-trivia.min.js' ) }}"></script>
@endsection