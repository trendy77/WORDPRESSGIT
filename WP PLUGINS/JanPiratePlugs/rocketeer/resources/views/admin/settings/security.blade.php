@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Security Settings <small>Update the security settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">Security</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="settingsForm">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#iframe_tab" data-toggle="tab">IFrame URLs</a></li>
                            <li class="pull-left header"><i class="fa fa-th"></i> Security Settings Form</li>
                        </ul>
                        <div class="tab-content">
                            <button type="button" class="btn btn-sm btn-success btn-add-url">
                                <i class="fa fa-plus"></i> Add URL
                            </button>
                            <div id="settingsStatus"></div>
                            <div class="tab-pane active" id="iframe_tab">
                                {!! csrf_field() !!}
                                <div id="urlCtr" class="form-horizontal">
                                    @foreach($iframe_urls as $url)
                                        <div class="urlGroup">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">URL</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control inputURL" value="{{ $url }}">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-url">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
<script type="text/x-handlebars-template" id="urlTpl">
    <div class="urlGroup">
        <div class="form-group">
            <label class="col-sm-2 control-label">URL</label>
            <div class="col-sm-8">
                <input type="text" class="form-control inputURL">
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-sm btn-danger btn-delete-url">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
    </div>
</script>
@endsection

@section( 'scripts' )
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.4/handlebars.min.js"></script>
    <script src="{{ jasko_component('/components/core/admin/js/security-settings.js') }}"></script>
@endsection