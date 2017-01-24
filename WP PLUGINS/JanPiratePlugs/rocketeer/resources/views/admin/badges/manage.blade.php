@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Badges <small>Manage your badges here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Badges</li>
            <li class="active">Manage</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Badges</h3>
                        <button type="button" class="btn btn-success pull-right"
                                data-toggle="modal" data-target="#addBadgeModal"><i class="fa fa-plus"></i> Add</button>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Badge Name</td>
                                <td>Image</td>
                                <td>Min. Points</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($badges as $badge)
                                <tr>
                                    <td>{{ $badge->id }}</td>
                                    <td>{{ $badge->title }}</td>
                                    <td><img src="{{ jasko_component( '/uploads/' . $badge->img ) }}" style="max-width: 100px;"></td>
                                    <td>{{ $badge->min_points }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info btn-edit-badge" data-toggle="modal" data-target="#editBadgeModal"
                                           data-name="{{ $badge->title }}" data-desc="{{ $badge->badge_desc }}" data-bid="{{ $badge->id }}"
                                           data-min="{{ $badge->min_points }}"><i class="fa fa-cogs"></i></a>
                                        @if($is_demo == 1)
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-badge" data-bid="{{ $badge->id }}"><i class="fa fa-remove"></i></button>
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
<div class="modal fade" id="addBadgeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Badge</h4>
            </div>
            <div class="modal-body">
                <div id="addStatus"></div>
                <form novalidate="novalidate" id="addForm">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="inputBadgeName">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="inputBadgeDesc"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Minimum Points</label>
                        <input type="number" class="form-control" id="inputBadgeMin">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" id="inputBadgeImg">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editBadgeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Badge</h4>
            </div>
            <div class="modal-body">
                <div id="editStatus"></div>
                <form novalidate="novalidate" id="editForm">
                    {!! csrf_field() !!}
                    <input type="hidden" id="inputEditBadgeID">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="inputEditBadgeName">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="inputEditBadgeDesc"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Minimum Points</label>
                        <input type="number" class="form-control" id="inputEditBadgeMin">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/badges.js') }}"></script>
@endsection