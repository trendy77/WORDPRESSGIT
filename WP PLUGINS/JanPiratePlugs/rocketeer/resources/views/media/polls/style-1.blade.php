<div class="poll-ctr style-1" data-question-count="{{ count($media->content->questions) }}">
    @foreach($media->content->questions as $qk => $qv)
        <div class="poll-question-ctr @if(isset($qv->already_answered)) poll-answered @else poll-unanswered @endif"
             data-total-votes="{{ $qv->total_votes }}">
            @if($qv->media_type == 1)
                <div class="poll-question-img">
                    @if(count($qv->images) > 1)
                        <div id="poll-carousel" class="carousel slide" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                @foreach($qv->images as $ik => $iv)
                                    <div class="item @if($ik ===0) active @endif">
                                        <img src="{{ jasko_component( '/uploads/' . $iv ) }}">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#poll-carousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            </a>
                            <a class="right carousel-control" href="#poll-carousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            </a>
                        </div>
                    @else
                        <img src="{{ jasko_component( '/uploads/' . $qv->images[0] ) }}" class="img-responsive">
                    @endif
                    <div class="poll-txt">
                        @if(isset($qv->already_answered))
                            {{ trans('media.you_voted') }} {{ $qv->answers[$qv->answer_key]->answer }}
                        @else
                            {{ $qv->question }}
                        @endif
                    </div>
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
                <div class="poll-txt">
                    @if(isset($qv->already_answered))
                        {{ trans('media.you_voted') }} {{ $qv->answers[$qv->answer_key]->answer }}
                    @else
                        {{ $qv->question }}
                    @endif
                </div>
            @endif

            @include( 'media.polls.answer-style-' . $qv->answer_display_type )

            <div class="clearfix"></div>
        </div>
    @endforeach
</div>
