@extends( 'media.embed.layout' )

@section( 'content' )

    @include( 'media.polls.style-2' )

@endsection

@section( 'styles' )
    <link rel="stylesheet" type="text/css" href="{{ jasko_component('/components/semantic/transition.min.css') }}">
    <link rel="stylesheet" href="{{ jasko_component( '/components/core/css/embed.css' ) }}">
@endsection

@section( 'scripts' )
    <script>
        var signin_required             =   {!! $settings->poll_signed_in_votes !!};
        var user_signed_in              =   {!! Auth::check() ? 2 : 1 !!};
        var auto_scroll                 =   {{ $settings->auto_scroll }};
        var auto_scroll_timer           =   {{ $settings->auto_scroll_timer }};
        var poll_style                  =   {{ $media->content->style }};
        var i18n_votes                  =   '{!! trans('media.votes') !!}';
        var poll_vote_url               =   '{!! route('poll_vote_url', [ 'name' => $media->slug_url ] ) !!}';
        var poll_token                  =   '{!! csrf_token() !!}';
    </script>
    <script src="{{ jasko_component( '/components/semantic/transition.min.js' ) }}"></script>
    <script src="{{ jasko_component( '/components/core/js/embed-poll.min.js' ) }}"></script>
@endsection