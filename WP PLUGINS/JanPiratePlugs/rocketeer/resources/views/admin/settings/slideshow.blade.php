@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Slideshow Settings <small>Update the slideshow settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">Slideshow</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Settings Form</h3>
                        <button type="button" class="btn btn-sm btn-success pull-right btn-add-slide">
                            <i class="fa fa-plus"></i> Add Slide
                        </button>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="settingsStatus"></div>
                        <form id="settingsForm" class="form-horizontal">
                            {!! csrf_field() !!}
                            <div id="slidesCtr">
                                @foreach($settings->slides as $slide)
                                    <div class="slideGroup">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Media ID</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control inputMediaID" value="{{ $slide->id }}">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-sm btn-danger btn-delete-slide">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/x-handlebars-template" id="slideItemTpl">
    <div class="slideGroup">
        <div class="form-group">
            <label class="col-sm-2 control-label">Media ID</label>
            <div class="col-sm-8">
                <input type="text" class="form-control inputMediaID">
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-sm btn-danger btn-delete-slide">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
    </div>
</script>
@endsection

@section( 'scripts' )
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.4/handlebars.min.js"></script>
    <script src="{{ jasko_component('/components/core/admin/js/slideshow-settings.js') }}"></script>
@endsection