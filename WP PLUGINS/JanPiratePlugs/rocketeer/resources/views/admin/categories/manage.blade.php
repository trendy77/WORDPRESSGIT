@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Categories <small>Manage your categories here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Categories</li>
            <li class="active">Manage</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Categories</h3>
                        <button type="button" class="btn btn-success pull-right"
                                data-toggle="modal" data-target="#addCatModal"><i class="fa fa-plus"></i> Add</button>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Position</td>
                                <td>Color</td>
                                <td>Image</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->pos }}</td>
                                    <td>{{ $category->bg_color }}</td>
                                    <td>
                                        <img src="{{ jasko_component( '/uploads/' . $category->cat_img ) }}" style="width: 150px; height: auto;">
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info btn-edit-cat" data-toggle="modal" data-target="#editCatModal"
                                           data-name="{{ $category->name }}" data-pos="{{ $category->pos }}" data-color="{{ $category->bg_color }}"
                                           data-cid="{{ $category->id }}"><i class="fa fa-cogs"></i></a>
                                        @if($is_demo == 1)
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-cat" data-cid="{{ $category->id }}"><i class="fa fa-remove"></i></button>
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
<div class="modal fade" id="addCatModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Category</h4>
            </div>
            <div class="modal-body">
                <div id="addCatStatus"></div>
                <form novalidate="novalidate" id="addCatForm">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="inputCatName">
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="number" class="form-control" id="inputCatPos" value="1">
                    </div>
                    <div class="form-group">
                        <label>Color</label><br>
                        <input type="text" class="form-control" id="inputCatColor">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" id="inputCatImg">
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
<div class="modal fade" id="editCatModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
            </div>
            <div class="modal-body">
                <div id="editCatStatus"></div>
                <form novalidate="novalidate" id="editCatForm">
                    {!! csrf_field() !!}
                    <input type="hidden" id="inputEditCatID">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="inputEditCatName">
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="number" class="form-control" id="inputEditCatPos">
                    </div>
                    <div class="form-group">
                        <label>Color</label><br>
                        <input type="text" class="form-control" id="inputEditCatColor">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" id="inputEditCatImg">
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

@section( 'styles' )
    <link rel="stylesheet" href="{{ jasko_component('/components/spectrum/spectrum.css') }}">
@endsection
@section( 'scripts' )
    <script src="{{ jasko_component('/components/spectrum/spectrum.js') }}"></script>
    <script src="{{ jasko_component('/components/core/admin/js/categories.js') }}"></script>

@endsection