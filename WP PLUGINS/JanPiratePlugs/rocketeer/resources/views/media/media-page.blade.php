@extends( 'layout' )

@section( 'content' )
    <div class="push-top container" id="mediaPageApp">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-body">
                    @include( 'partials.featured-slideshow' )

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-8">
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
@endsection

@section( 'scripts' )
    <script>
        var media_token                 =   '{{ csrf_token() }}';
        var media_types                 =   {!! json_encode($types) !!};
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/flexslider/jquery.flexslider-min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/media-page.min.js') }}"></script>
@endsection