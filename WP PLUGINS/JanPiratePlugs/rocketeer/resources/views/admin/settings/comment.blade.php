@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Comment Settings <small>Update the comment settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">Comment</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Settings Form</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="settingsStatus"></div>
                        <form id="settingsForm">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Site Comments</label>
                                <select class="form-control" id="inputSiteComments" >
                                    <option value="1">Disable</option>
                                    <option value="2" {{ $settings->system_comments == 2 ? 'SELECTED' : '' }}>Enable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Facebook Comments</label>
                                <select class="form-control" id="inputFBComments" >
                                    <option value="1">Disable</option>
                                    <option value="2" {{ $settings->fb_comments == 2 ? 'SELECTED' : '' }}>Enable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Disqus Comments</label>
                                <select class="form-control" id="inputDisqusComments" >
                                    <option value="1">Disable</option>
                                    <option value="2" {{ $settings->disqus_comments == 2 ? 'SELECTED' : '' }}>Enable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Disqus Shortname</label>
                                <input type="text" class="form-control" id="inputDisqusShortname" value="{{ $settings->disqus_shortname }}">
                            </div>
                            <div class="form-group">
                                <label>Main Comment System</label>
                                <select class="form-control" id="inputMainCommentSystem">
                                    <option value="1" {{ $settings->main_comment_system == 1 ? 'SELECTED' : '' }}>System</option>
                                    <option value="2" {{ $settings->main_comment_system == 2 ? 'SELECTED' : '' }}>Facebook</option>
                                    <option value="3" {{ $settings->main_comment_system == 3 ? 'SELECTED' : '' }}>Disqus</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/comment-settings.js') }}"></script>
@endsection