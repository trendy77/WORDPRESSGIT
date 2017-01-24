@extends( 'layout' )

@section( 'content' )
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default {{ $settings->site_color }}-border-top push-top">
                    <div class="panel-body">
                        <h2 class="text-center">{{ trans('user.forgot_pass') }}</h2>
                        <div id="forgotAlertStatus"></div>
                        <form id="forgotForm">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>{{ trans('user.email') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('user.email') }}" id="inputEmail">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-blue btn-block"><i class="fa fa-user"></i> {{ trans('user.request_pass') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script>
        var forgot_wait              =   '{!! trans('user.forgot_wait') !!}';
        var forgot_success           =   '{!! trans('user.forgot_success') !!}';
        var forgot_error             =   '{!! trans('user.forgot_error') !!}';
    </script>
    <script src="{{ jasko_component('/components/core/js/forgot-pass.min.js') }}"></script>
@endsection