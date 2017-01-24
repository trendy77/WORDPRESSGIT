@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>E-mail Settings <small>Update the email settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">E-mail</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="settingsForm">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#basic_tab" data-toggle="tab">General</a></li>
                            <li><a href="#export_tab" data-toggle="tab">Export</a></li>
                            <li class="pull-left header"><i class="fa fa-th"></i> E-mail Settings Form</li>
                        </ul>
                        <div class="tab-content">
                            <div id="settingsStatus"></div>
                            <div class="tab-pane active" id="basic_tab">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Newsletter Subscription</label>
                                    <select class="form-control" id="inputNewsletterSub">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->enable_newsletter_subscribe == 2 ? 'SELECTED' : '' }}>Enable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>MailChimp API Key</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->mailchimp_api_key }}" id="inputMCAPIKey">
                                </div>
                                <div class="form-group">
                                    <label>MailChimp List ID</label>
                                    <input type="text" class="form-control" value="{{ $is_demo == 2 ? '' : $settings->mailchimp_list_id }}" id="inputMCListID">
                                </div>
                            </div>
                            <div class="tab-pane" id="export_tab">
                                <div class="alert alert-info text-center">
                                    <p>
                                        You can export all emails your users have provided when they registered.
                                        All emails are exported in CSV format. All data comes out as <strong>username,email</strong>
                                    </p>
                                    <button type="button" class="btn btn-default" id="exportEmailsBtn">
                                        <i class="fa fa-cloud-download"></i> Export & Download
                                    </button>
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
    <script src="{{ jasko_component('/components/core/admin/js/email-settings.js') }}"></script>
@endsection