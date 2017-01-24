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
                            {!! $qv->embed_code !!}
                        @elseif($qv->media_type == 3)
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
                        <button type="button" class="btn btn-block btn-facebook btn-fb-share">
                            <i class="fa fa-facebook"></i> {{ trans('media.fb_share') }}
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-block btn-twitter btn-twitter-share">
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