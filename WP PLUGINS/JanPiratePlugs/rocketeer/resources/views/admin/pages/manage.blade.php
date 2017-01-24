@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Pages <small>Manage your pages here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Pages</li>
            <li class="active">Manage</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Pages</h3>
                        <a href="{{ route('adminAddPage') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        {!! csrf_field() !!}
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Page Title</td>
                                <td>Type</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>
                                        @if($page->page_type == 2)
                                            Contact
                                        @elseif($page->page_type == 3)
                                            Direct URL
                                        @else
                                            Normal
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route( 'adminUpdatePage', [ 'pid' => $page->id ] ) }}" class="btn btn-sm btn-info"><i class="fa fa-cogs"></i></a>
                                        @if($is_demo == 1)
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-page" data-pid="{{ $page->id }}"><i class="fa fa-remove"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/pages.js') }}"></script>
@endsection