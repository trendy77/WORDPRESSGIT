@extends( 'layout' )

@section( 'content' )
    <div class="push-top container" id="topicApp">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-body">
                    @include( 'partials.trending' )

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-8">
                            <h2>{{ $topic->name }}</h2>
                            @include( 'partials.homepage-' . $settings->homepage_type )
                        </div>
                        <div class="col-md-4 gray-border-left hidden-xs">
                            @include( 'partials.sidebar' )
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'styles' )
    <link rel="stylesheet" href="{{ jasko_component( '/components/flexslider/flexslider.css' ) }}">
    <link rel="stylesheet" href="{{ jasko_component( '/components/owl-carousel/owl-carousel/owl.carousel.css' ) }}">
    <link rel="stylesheet" href="{{ jasko_component( '/components/owl-carousel/owl-carousel/owl.theme.css' ) }}">
@endsection

@section( 'scripts' )
    <script>
        var media_token                 =   '{{ csrf_token() }}';
        var topic_id                    =   {{ $topic->id }};
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/flexslider/jquery.flexslider-min.js') }}"></script>
    <script src="{{ jasko_component('/components/owl-carousel/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/topic.min.js') }}"></script>
@endsection