@extends( 'admin.layout' )

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Media <small>Manage your media here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Media</li>
            <li class="active">Manage</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Media</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        {!! csrf_field() !!}
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Title</td>
                                <td>Type</td>
                                <td>Status</td>
                                <td>Created By</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($media_items as $media)
                                <tr>
                                    <td>{{ $media->id }}</td>
                                    <td>{{ $media->title }}</td>
                                    <td>{{ ucfirst(get_media_type($media->media_type)) }}</td>
                                    <td>
                                        @if($media->status == 2)
                                            <span class="label label-success">Approved</span>
                                        @else
                                            <span class="label label-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $media->author->username }}</td>
                                    <td>
                                        @if($is_demo == 1)
                                            <a href="{{ full_media_url($media) }}" target="_blank" class="btn btn-sm btn-primary"
                                               data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></a>
                                        @endif
                                        <a href="{{ route('edit' . ucfirst(get_media_type($media->media_type)), [ 'id' => $media->id ] ) }}" class="btn btn-sm btn-info"
                                           data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-cogs"></i></a>
                                        @if($is_demo == 1)
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-media" data-mid="{{ $media->id }}"><i class="fa fa-remove"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $media_items->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/manage-media.js') }}"></script>
@endsection