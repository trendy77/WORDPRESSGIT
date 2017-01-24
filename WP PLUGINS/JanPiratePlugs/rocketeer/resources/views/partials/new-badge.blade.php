@if( isset($user_badge) )
    <div class="modal fade" id="newBadgeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-star"></i> {{ trans('badge.congrats') }}</h4>
                </div>
                <div class="modal-body">
                    <h1 class="text-center" style="margin: 0 0 15px;">{{ trans('badge.you_earned_the') }} {{ $user_badge->title }} {{ trans('badge.badge') }}</h1>
                    <img src="{{ jasko_component( '/uploads/' . $user_badge->img ) }}" class="img-responsive center-block">
                    <p class="text-center" style="margin-top: 15px;">{{ $user_badge->badge_desc }}</p>
                </div>
            </div>
        </div>
    </div>
@endif