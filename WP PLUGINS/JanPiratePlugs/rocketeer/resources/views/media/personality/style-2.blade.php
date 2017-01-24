<div id="quizApp" style="display: none;">
    <div class="questions-ctr">
        @foreach($media->content->questions as $qk => $qv)
            <div class="question-ctr active">
                @if($qv->media_type == 1)
                    <div class="question-img-ctr">
                        <div class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                @foreach($qv->images as $ik => $iv)
                                    <div class="item {{ $ik == 0 ? 'active': '' }}">
                                        <img src="{{ jasko_component( '/uploads/' . $iv ) }}" style="max-height: 500px;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="question-txt" data-question="{{ $qv->question }}">{{ $qv->question }}</div>
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
                    <div class="question-txt">{{ $qv->question }}</div>
                @endif
                <div class="pers-answers-ctr question-unanswered">
                    @foreach($qv->answers as $ak => $av)
                        <div class="single-answer-ctr single-answer-style-{{ $qv->answer_display_type }}" data-points="{{ $av->points }}">
                            @if(!empty($av->img))<img src="{{ jasko_component( '/uploads/' . $av->img )  }}">@endif
                            {{ $av->answer  }}
                            <i class="fa fa-circle-thin"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="results-ctr">
        @foreach($media->content->results as $rk => $rv)
            <div class="result-ctr" id="result-{{ $rk }}">
                <div class="resultTitleCtr">{{ $rv->title }}</div>
                @if(!empty($rv->main_img))
                    <img class="img-responsive center-block" src="{{ jasko_component( '/uploads/' . $rv->main_img ) }}">
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