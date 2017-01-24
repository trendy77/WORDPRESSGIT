<div class="clearfix"></div>
<footer class="container push-top site-footer">
    <div class="row">
        <div class="col-md-12">
            {!! $settings->footer_ad !!}

            @if( $settings->lang_switcher == 2 && ($settings->lang_switcher_loc == 3 || $settings->lang_switcher_loc == 4) )
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-globe"></i> {{ get_default_lang( $settings->default_lang, $settings->languages ) }}
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($settings->languages as $lang)
                            <li><a href="{{ route( 'setLang', [ 'locale' => $lang->locale ] ) }}">{{ $lang->readable_name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</footer>

@if( Auth::check() )
    @include( 'partials.create-modal' )
    @include( 'partials.new-badge' )
    @else
@endif

<!-- Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script>
    var uni_sub_pending                     =   "{!! trans('email.uni_sub_pending') !!}";
    var uni_sub_success                     =   "{!! trans('email.uni_sub_success') !!}";
    var uni_sub_error                       =   "{!! trans('email.uni_sub_error') !!}";
</script>

@if(!empty($settings->google_analytics_tracking_id))
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '{{ $settings->google_analytics_tracking_id }}', 'auto');
    ga('send', 'pageview');
</script>
@endif

@if(!empty($settings->fb_app_key))
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ $settings->fb_app_key }}',
                xfbml      : true,
                version    : 'v2.5'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endif

@yield( 'scripts' )

<!-- Custom -->
<script src="{{ jasko_component('/components/core/js/main.min.js') }}"></script>

</body>
</html>