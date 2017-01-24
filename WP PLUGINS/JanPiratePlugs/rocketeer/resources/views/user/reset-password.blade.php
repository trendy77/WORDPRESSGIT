@extends( 'layout' )

@section( 'content' )
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default {{ $settings->site_color }}-border-top push-top">
                    <div class="panel-body">
                        <h2 class="text-center">{{ trans('user.reset_pass') }}</h2>
                        <div id="resetAlertStatus"></div>
                        <form id="resetForm">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>{{ trans('user.pass') }}</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="{{ trans('user.pass') }}" id="inputPass1">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('user.confirm_pass') }}</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="{{ trans('user.confirm_pass') }}" id="inputPass2">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-blue btn-block"><i class="fa fa-user"></i> {{ trans('user.reset_pass') }}</button>
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
        var reset_wait              =   '{!! trans('user.reset_wait') !!}';
        var reset_success           =   '{!! trans('user.reset_success') !!}';
        var reset_error             =   '{!! trans('user.reset_error') !!}';
    </script>
    <script src="{{ jasko_component('/components/core/js/reset-pass.min.js') }}"></script>
@endsection