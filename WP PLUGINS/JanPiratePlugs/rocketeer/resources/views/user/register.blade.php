@extends( 'layout' )

@section( 'content' )
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default {{ $settings->site_color }}-border-top push-top">
                    <div class="panel-body">
                        <h3 class="text-center">{{ trans('user.register') }}</h3>
                        <div id="registerStatus"></div>
                        <form id="registerForm">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>{{ trans('user.username') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('user.username') }}" id="inputUsername">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('user.email') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('user.email') }}" id="inputEmail">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('user.pass') }}</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="{{ trans('user.pass') }}" id="inputPassword">
                                    <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('user.confirm_pass') }}</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="{{ trans('user.confirm_pass') }}" id="inputConfirmPassword">
                                    <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                </div>
                            </div>

                            @if(!empty($settings->recaptcha_public_key))
                                <div class="form-group">
                                    <script src='https://www.google.com/recaptcha/api.js'></script>
                                    <div class="g-recaptcha"
                                         data-sitekey="{{ $settings->recaptcha_public_key }}"
                                         data-callback="verifyCaptcha"></div>
                                </div>
                            @endif

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="terms"> {{ trans('user.agree') }}
                                    <a href="#" data-toggle="modal" data-target="#termsModal">{{ trans('user.tos') }}</a>.
                                </label>
                            </div>

                            <div class="checkbox" @if($settings->enable_newsletter_subscribe == 1) style="display:none;" @endif>
                                <label><input type="checkbox" value="1" id="inputSubscribeNewsletter"> {{ trans('email.subscribe_newsletter') }}</label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-blue btn-block" v-bind:disabled="!captcha || !terms"><i class="fa fa-plus"></i> {{ trans('user.create_acc') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include( 'partials.terms-modal' )
@endsection

@section( 'scripts' )
    <script>
        var captcha_required        =   {{ empty($settings->recaptcha_public_key) ? '1' : '0' }};
        var register_wait           =   '{{ trans('user.register_wait') }}';
        var register_error          =   '{{ trans('user.register_error') }}';
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/js/register.min.js') }}"></script>
@endsection