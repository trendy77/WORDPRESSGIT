@extends( 'admin.layout' )

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Page <small>Add a page here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Pages</li>
            <li class="active">Add</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header"><h3 class="box-title">Add Pages</h3></div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="addPageStatus"></div>
                        <form id="addPageForm" novalidate="novalidate">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" placeholder="Enter Title" id="inputPageTitle">
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" id="inputPageType">
                                    <option value="1">Normal</option>
                                    <option value="2">Contact</option>
                                    <option value="3">Direct URL</option>
                                </select>
                            </div>
                            <div class="form-group display-type" id="displayContact" style="display: none;">
                                <label>Contact E-mail</label>
                                <input type="text" class="form-control" id="inputContactEmail">
                            </div>
                            <div class="form-group display-type" id="displayDirectURL" style="display: none;">
                                <label>URL</label>
                                <input type="text" class="form-control" id="inputDirectURL">
                            </div>
                            <div class="form-group display-type" id="displayPageContent">
                                <label>Page Content</label>
                                <textarea name="pageEditor" id="inputPageContent" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Add
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
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/core/admin/js/add-page.js') }}"></script>
@endsection