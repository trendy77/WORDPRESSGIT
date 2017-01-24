@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Update Page <small>Update your page here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Pages</li>
            <li class="active">Update</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header"><h3 class="box-title">Update Page - {{ $page->title }}</h3></div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="updatePageStatus"></div>
                        <form id="updatePageForm" novalidate="novalidate">
                            {!! csrf_field() !!}
                            <input type="hidden" id="inputPageID" value="{{ $page->id }}">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" placeholder="Enter Title" id="inputPageTitle" value="{{ $page->title }}">
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" id="inputPageType">
                                    <option value="1">Normal</option>
                                    <option value="2" @if($page->page_type == 2) SELECTED @endif>Contact</option>
                                    <option value="3" @if($page->page_type == 3) SELECTED @endif>Direct URL</option>
                                </select>
                            </div>
                            <div class="form-group display-type" id="displayContact" @if($page->page_type != 2) style="display: none;" @endif>
                                <label>Contact E-mail</label>
                                <input type="text" class="form-control" id="inputContactEmail" value="{!! $page->contact_email !!}">
                            </div>
                            <div class="form-group display-type" id="displayDirectURL" @if($page->page_type != 3) style="display: none;" @endif>
                                <label>URL</label>
                                <input type="text" class="form-control" id="inputDirectURL" value="{!! $page->direct_url !!}">
                            </div>
                            <div class="form-group display-type" id="displayPageContent" @if($page->page_type != 1) style="display: none;" @endif>
                                <label>Page Content</label>
                                <textarea name="pageEditor" id="inputPageContent" class="form-control">{{ $page->page_content }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Update
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
    <script src="{{ jasko_component('/components/core/admin/js/update-page.js') }}"></script>
@endsection