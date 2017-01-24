@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Users <small>Manage your users here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Users</li>
            <li class="active">Manage</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Users</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        {!! csrf_field() !!}
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Status</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->status == 1)
                                            <span class="label label-success">Active</span>
                                        @else
                                            <span class="label label-danger">Banned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('adminEditUser', ['id' => $user->id]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-cogs"></i></a>
                                        @if($is_demo == 1)
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-user"
                                                    data-uid="{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-remove"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $users->render() !!}
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/manage-users.js') }}"></script>
@endsection