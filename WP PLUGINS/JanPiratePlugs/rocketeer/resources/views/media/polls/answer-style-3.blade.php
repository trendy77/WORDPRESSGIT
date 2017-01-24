@foreach($qv->answers as $ak => $av)
    @if(isset($qv->already_answered))
        <div class="poll-answer-ctr poll-answer-style-3 @if($qv->answer_key == $ak) poll-answer-selected @endif">
            @if(!empty($av->img))<img src="{{ jasko_component( '/uploads/' . $av->img ) }}">@endif
            {{ $av->answer }}
            <small><em>({{ $av->total_votes }} {{ trans('media.votes') }})</em></small>
            <span class="pull-right" style="margin-right: 10px;">{{ $av->vote_percentage }}%</span>
        </div>
    @else
        <div class="poll-answer-ctr poll-answer-style-3" data-total-votes="{{ $av->total_votes }}">
            @if(!empty($av->img))<img src="{{ jasko_component( '/uploads/' . $av->img ) }}">@endif
            {{ $av->answer }}
        </div>
    @endif
@endforeach