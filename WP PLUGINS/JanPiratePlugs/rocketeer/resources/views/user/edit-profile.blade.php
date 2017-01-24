@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>{{ trans('user.edit_profile') }}</h2>
                        <ul class="nav nav-tabs nav-justified nav-tab-{{ $settings->site_color }}">
                            <li class="active"><a href="#basics" data-toggle="tab">{{ trans('user.basic_details') }}</a></li>
                            <li><a href="#images" data-toggle="tab">{{ trans('user.profile_images') }}</a></li>
                            <li><a href="#pass" data-toggle="tab">{{ trans('user.update_password') }}</a></li>
                            @if($settings->enable_newsletter_subscribe == 2) <li><a href="#newsletter" data-toggle="tab">{{ trans('email.newsletter_subscription') }}</a></li> @endif
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="basics">
                                <h3>{{ trans('user.basic_details') }}</h3>
                                <div id="basicAlertStatus"></div>
                                <form id="basicForm" novalidate>
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>{{ trans('user.display_name') }}</label>
                                        <input type="text" class="form-control" id="inputDisplayName" value="{{ $user->display_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.location') }}</label>
                                        <select class="form-control" id="inputLocation">
                                            <option value="">----- {{ trans('user.select_country') }}-----</option>
                                            @foreach($countries as $code => $country)
                                                <option value="{{$code}}" {{ $user->location == $code ? 'SELECTED': '' }}>{{$country}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.gender') }}</label>
                                        <select class="form-control" id="inputGender">
                                            <option value="1">{{ trans('user.private') }}</option>
                                            <option value="2" {{ $user->gender == 2 ? 'SELECTED': '' }}>{{ trans('user.male') }}</option>
                                            <option value="3" {{ $user->gender == 3 ? 'SELECTED': '' }}>{{ trans('user.female') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.intro_text') }}</label>
                                        <input type="text" class="form-control" id="inputIntroText" value="{{ $user->display_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.about') }}</label>
                                        <textarea class="form-control" id="inputAbout">{{ $user->about }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.twitter') }}</label>
                                        <input type="text" class="form-control" id="inputTwitter" value="{{ $user->twitter }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.facebook') }}</label>
                                        <input type="text" class="form-control" id="inputFacebook" value="{{ $user->facebook }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.google') }}</label>
                                        <input type="text" class="form-control" id="inputGP" value="{{ $user->gplus }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.vk') }}</label>
                                        <input type="text" class="form-control" id="inputVK" value="{{ $user->vk }}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.soundcloud') }}</label>
                                        <input type="text" class="form-control" id="inputSoundcloud" value="{{ $user->soundcloud }}">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('user.save_profile') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="images">
                                <h3>{{ trans('user.upload_profile_img') }}</h3>
                                <img class="img-responsive center-block" src="{{ $user->profile_img }}" id="profileImgTag">
                                <input type="file" style="display:none;" id="inputProfileImg">
                                <button type="button" class="btn btn-purple center-block" style="margin-top: 10px;" id="uplProfileImgBtn">
                                    <i class="fa fa-image"></i> {{ trans('user.upload_profile_img') }}
                                </button>
                                <h3>{{ trans('user.upload_header_img') }}</h3>
                                <img class="img-responsive center-block" src="{{ $user->header_img }}" id="headerImgTag">
                                <input type="file" style="display:none;" id="inputHeaderImg">
                                <button type="button" class="btn btn-purple center-block" style="margin-top: 10px;" id="uplHeaderImgBtn">
                                    <i class="fa fa-image"></i> {{ trans('user.upload_header_img') }}
                                </button>
                            </div>
                            <div class="tab-pane" id="pass">
                                <h3>{{ trans('user.update_password') }}</h3>
                                <div id="passwordStatus"></div>
                                <form id="editPassForm" novalidate>
                                    <div class="form-group">
                                        <label>{{ trans('user.new_pass') }}</label>
                                        <input type="password" class="form-control" id="inputPass1">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('user.new_pass_2') }}</label>
                                        <input type="password" class="form-control" id="inputPass2">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-save"></i> {{ trans('user.update_password') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane text-center" id="newsletter">
                                <h3>{{ trans('email.newsletter_subscription') }}</h3>
                                <div id="newsletterStatus"></div>
                                <button type="button" class="btn btn-{{ $settings->site_color }}" id="subscribeNewsletterBtn">
                                    {{ trans('email.subscribe_newsletter') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'styles' )
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.css">
@endsection

@section( 'scripts' )
    <script>
        var basic_pending               =   '{!! trans('user.basic_pending') !!}';
        var basic_success               =   '{!! trans('user.basic_success') !!}';
        var basic_error                 =   '{!! trans('user.basic_error') !!}';
        var img_uploading               =   '{!! trans('user.img_uploading') !!}';
        var img_error                   =   '{!! trans('user.img_error') !!}';
        var img_success                 =   '{!! trans('user.img_success') !!}';
        var pass_pending                =   '{!! trans('user.pass_pending') !!}';
        var pass_success                =   '{!! trans('user.pass_success') !!}';
        var pass_error                  =   '{!! trans('user.pass_error') !!}';
        var email_sub_pending           =   '{!! trans('email.sub_pending') !!}';
        var email_sub_success           =   '{!! trans('email.sub_success') !!}';
        var email_sub_error             =   '{!! trans('email.sub_error') !!}';
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.js"></script>
    <script src="{{ jasko_component('/components/core/js/edit-profile.min.js') }}"></script>
@endsection
