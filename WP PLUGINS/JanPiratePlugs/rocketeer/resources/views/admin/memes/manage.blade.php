@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Memes <small>Manage your memes here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Memes</li>
            <li class="active">Manage</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Memes</h3>
                        <button type="button" class="btn btn-success pull-right"
                                data-toggle="modal" data-target="#addMemeModal"><i class="fa fa-plus"></i> Add</button>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Meme Name</td>
                                <td>Image</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($memes as $meme)
                                <tr>
                                    <td>{{ $meme->id }}</td>
                                    <td>{{ $meme->meme_name }}</td>
                                    <td><img src="{{ jasko_component( '/uploads/' . $meme->upl_name ) }}" style="max-width: 100px;"></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info btn-edit-meme" data-toggle="modal" data-target="#editMemeModal"
                                           data-name="{{ $meme->meme_name }}" data-mid="{{ $meme->id }}"><i class="fa fa-cogs"></i></a>
                                        @if($is_demo == 1)
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-meme" data-mid="{{ $meme->id }}"><i class="fa fa-remove"></i></button>
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
<div class="modal fade" id="addMemeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Meme</h4>
            </div>
            <div class="modal-body">
                <div id="addMemeStatus"></div>
                <form novalidate="novalidate" id="addMemeForm">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="inputMemeName">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" id="inputMemeImg">
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
<div class="modal fade" id="editMemeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Meme</h4>
            </div>
            <div class="modal-body">
                <div id="editMemeStatus"></div>
                <form novalidate="novalidate" id="editMemeForm">
                    {!! csrf_field() !!}
                    <input type="hidden" id="inputEditMemeID">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="inputEditMemeName">
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
    <script src="{{ jasko_component('/components/core/admin/js/memes.js') }}"></script>
@endsection