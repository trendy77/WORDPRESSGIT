@extends( 'admin.layout' )

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>General Settings <small>Update the general settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">General</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="settingsForm">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#basic_tab" data-toggle="tab">Basic</a></li>
                            <li><a href="#storage_tab" data-toggle="tab">Storage</a></li>
                            <li><a href="#ad_tab" data-toggle="tab">Advertisements</a></li>
                            <li><a href="#social_tab" data-toggle="tab">Social</a></li>
                            <li><a href="#api_tab" data-toggle="tab">3rd Party API</a></li>
                            <li><a href="#tos" data-toggle="tab">Terms of Service</a></li>
                            <li class="pull-left header"><i class="fa fa-th"></i> General Settings Form</li>
                        </ul>
                        <div class="tab-content">
                            <div id="settingsStatus"></div>
                            <div class="tab-pane active" id="basic_tab">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Site Name</label>
                                    <input type="text" class="form-control" value="{{ $settings->site_name }}" id="inputSiteName">
                                </div>
                                <div class="form-group">
                                    <label>Site Title</label>
                                    <input type="text" class="form-control" value="{{ $settings->site_title }}" id="inputSiteTitle">
                                </div>
                                <div class="form-group">
                                    <label>Site Description</label>
                                    <textarea class="form-control" id="inputSiteDesc">{{ $settings->site_desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Display Count</label>
                                    <input type="text" class="form-control" value="{{ $settings->display_count }}" id="inputDisplayCount">
                                </div>
                                <div class="form-group">
                                    <label>Site Color</label>
                                    <select class="form-control" id="inputSiteColor">
                                        @foreach($colors as $color)
                                            <option value="{{ $color }}"
                                                    {{ $settings->site_color == $color ? 'SELECTED' : '' }}>{{ $color }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Enable Cache</label>
                                    <div class="form-group">
                                        <select class="form-control" id="inputEnableCache">
                                            <option value="1">Disable</option>
                                            <option value="2" {{ $settings->cache_enabled == 2 ? 'SELECTED' : '' }}>Enable</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Homepage Type</label>
                                    <select class="form-control" id="inputHomepageType">
                                        <option value="1">Single Column</option>
                                        <option value="2" {{ $settings->homepage_type == 2 ? 'SELECTED' : '' }}>Two Column</option>
                                        <option value="3" {{ $settings->homepage_type == 3 ? 'SELECTED' : '' }}>Three Column</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Custom CSS</label>
                                    <textarea class="form-control" id="inputCustomCSS">{!! $settings->custom_css !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Primary Google Font URI Parameters</label>
                                    <input type="text" class="form-control" value="{{ $settings->google_font }}" id="inputGoogleFont">
                                    <span class="help-block">
                                        You can find a list of all google fonts available by <a href="https://www.google.com/fonts" target="_blank">clicking here</a>.
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label>Site Font</label>
                                    <input type="text" class="form-control" value="{{ $settings->site_font }}" id="inputSiteFont">
                                </div>
                            </div>
                            <div class="tab-pane" id="storage_tab">
                                <div class="form-group">
                                    <label>Amazon Storage</label>
                                    <select class="form-control" id="inputAWSS3">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->aws_s3 == 2 ? 'SELECTED' : '' }}>Enable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>AWS S3 Key</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->aws_s3_key }}" id="inputAWSKey">
                                </div>
                                <div class="form-group">
                                    <label>AWS S3 Secret</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->aws_s3_secret }}" id="inputAWSSecret">
                                </div>
                                <div class="form-group">
                                    <label>AWS S3 Region</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->aws_s3_region }}" id="inputAWSRegion">
                                </div>
                                <div class="form-group">
                                    <label>AWS S3 Bucket</label>
                                    <input type="text" class="form-control" value="{{$is_demo == 2 ? '' :  $settings->aws_s3_bucket }}" id="inputAWSBucket">
                                </div>

                            </div>
                            <div class="tab-pane" id="ad_tab">
                                <div class="form-group">
                                    <label>Profile Sidebar Ad</label>
                                    <textarea class="form-control" id="inputSidebarAd">{{ $settings->sidebar_ad }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Header Ad</label>
                                    <textarea class="form-control" id="inputHeaderAd">{{ $settings->header_ad }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Footer Ad</label>
                                    <textarea class="form-control" id="inputFooterAd">{{ $settings->footer_ad }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>List Ad</label>
                                    <textarea class="form-control" id="inputListAd">{{ $settings->list_ad }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>List Ad Type</label>
                                    <select class="form-control" id="inputListAdType">
                                        <option value="1">No Ads</option>
                                        <option value="2" {{ $settings->list_ad_type == 2 ? 'SELECTED' : '' }}>Random</option>
                                        <option value="3" {{ $settings->list_ad_type == 3 ? 'SELECTED' : '' }}>Display After Every nth Item in List</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>List Ad Nth Count</label>
                                    <input type="text" class="form-control" value="{{ $settings->list_ad_nth_count }}" id="inputListAdNthCount">
                                </div>
                            </div>
                            <div class="tab-pane" id="social_tab">
                                <div class="form-group">
                                    <label>Facebook Handle</label>
                                    <input type="text" class="form-control" value="{{ $settings->facebook }}" id="inputFacebook">
                                </div>
                                <div class="form-group">
                                    <label>Twitter Handle</label>
                                    <input type="text" class="form-control" value="{{ $settings->twitter }}" id="inputTwitter">
                                </div>
                                <div class="form-group">
                                    <label>Google Plus Handle</label>
                                    <input type="text" class="form-control" value="{{ $settings->gp }}" id="inputGP">
                                </div>
                                <div class="form-group">
                                    <label>Youtube Handle</label>
                                    <input type="text" class="form-control" value="{{ $settings->youtube }}" id="inputYoutube">
                                </div>
                                <div class="form-group">
                                    <label>Soundcloud Handle</label>
                                    <input type="text" class="form-control" value="{{ $settings->soundcloud }}" id="inputSoundcloud">
                                </div>
                                <div class="form-group">
                                    <label>Instagram Handle</label>
                                    <input type="text" class="form-control" value="{{ $settings->instagram }}" id="inputInstagram">
                                </div>
                            </div>
                            <div class="tab-pane" id="api_tab">
                                <div class="form-group">
                                    <label>Facebook API Key</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->fb_app_key }}" id="inputFBKey">
                                </div>
                                <div class="form-group">
                                    <label>Facebook API Secret</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->fb_app_secret }}" id="inputFBSecret">
                                </div>
                                <div class="form-group">
                                    <label>Twitter API Key</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->twitter_client_id }}" id="inputTwitterKey">
                                </div>
                                <div class="form-group">
                                    <label>Twitter API Secret</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->twitter_client_secret }}" id="inputTwitterSecret">
                                </div>
                                <div class="form-group">
                                    <label>Google API Key</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->google_client_id }}" id="inputGoogleKey">
                                </div>
                                <div class="form-group">
                                    <label>Google API Secret</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->google_client_secret }}" id="inputGoogleSecret">
                                </div>
                                <div class="form-group">
                                    <label>Soundcloud Client ID</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->soundcloud_client_id }}" id="inputSoundcloudClientID">
                                </div>
                                <div class="form-group">
                                    <label>Soundcloud Client Secret</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->soundcloud_client_secret }}" id="inputSoundcloudClientSecret">
                                </div>
                                <div class="form-group">
                                    <label>Google Analytics Tracking ID</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->google_analytics_tracking_id }}" placeholder="UA-XXXXXXXX-X" id="inputGATrackingID">
                                </div>
                                <div class="form-group">
                                    <label>ReCaptcha Public Key</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->recaptcha_public_key }}" id="inputReCaptchaPublicKey">
                                </div>
                            </div>
                            <div class="tab-pane" id="tos">
                                <p>You are provided the placeholder <strong>[site_name]</strong> for the name of your site.</p>
                                <div class="form-group">
                                    <textarea id="inputTos">{!! $tos !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/core/admin/js/general-settings.js') }}"></script>
@endsection