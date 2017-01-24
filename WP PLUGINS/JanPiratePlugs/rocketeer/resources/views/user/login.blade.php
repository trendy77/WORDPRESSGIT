@extends( 'layout' )

@section( 'content' )
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default {{ $settings->site_color }}-border-top push-top">
                    <div class="panel-body">
                        <h2 class="text-center">{{ trans('user.login') }}</h2>
                        <div id="loginStatus"></div>
                        <form id="loginForm">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>{{ trans('user.username') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('user.username') }}" id="inputUsername">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('user.pass') }}</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="{{ trans('user.pass') }}" id="inputPassword">
                                    <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                </div>
                            </div>
                            <div class="checkbox">
                                <a href="{{ route('forgot_password') }}" class="pull-right">{{ trans('user.forgot_pass') }}</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-blue btn-block"><i class="fa fa-user"></i> {{ trans('user.login') }}</button>
                            </div>
                        </form>
                        <div class="social-login">
                            @if(!empty($settings->fb_app_key))<a href="{{ route('auth_facebook') }}" class="btn btn-lg btn-facebook"><i class="fa fa-facebook"></i></a>@endif
                            @if(!empty($settings->twitter_client_id))<a href="{{ route('auth_twitter') }}" class="btn btn-lg btn-twitter"><i class="fa fa-twitter"></i></a>@endif
                            @if(!empty($settings->google_client_id))<a href="{{ route('auth_google_plus') }}" class="btn btn-lg btn-googleplus"><i class="fa fa-google-plus"></i></a>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script>
        var login_wait              =   '{!! trans('user.login_wait') !!}';
        var login_success           =   '{!! trans('user.login_success') !!}';
        var login_error             =   '{!! trans('user.login_error') !!}';
    </script>
    <script src="{{ jasko_component('/components/core/js/login.min.js') }}"></script>
@endsection