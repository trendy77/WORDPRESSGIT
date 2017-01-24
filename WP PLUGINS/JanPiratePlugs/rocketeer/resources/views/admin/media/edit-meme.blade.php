@extends( 'admin.layout' )

@section('content')
<div class="content-wrapper" id="editMediaApp">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Meme <small>Edit any meme here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Media</li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="mediaForm">
                    {!! csrf_field() !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#basic_tab" data-toggle="tab">Basic</a></li>
                            <li class="pull-left header"><i class="fa fa-th"></i> Edit Media Form</li>
                        </ul>
                        <div class="tab-content">
                            <div id="alertStatus"></div>
                            <div class="tab-pane active" id="basic_tab">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" placeholder="Enter Title" id="inputTitle" value="{{ $media->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" placeholder="Enter Description" maxlength="150" id="inputDesc">{{ $media->media_desc }}</textarea>
                                    <small class="pull-right">/150</small>
                                </div>
                                <div class="form-group">
                                    <label for="inputCid">Category</label>
                                    <select class="form-control" id="inputCid">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $media->cid == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputNSFW">NSFW</label>
                                    <select class="form-control" id="inputNSFW">
                                        <option value="1">No</option>
                                        <option value="2" {{ $media->nsfw == 2 ? 'selected': '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <canvas id="memeCanvas" width="350" height="50" class="responsive-canvas"></canvas>
                                        <input type="file" id="inputImgSrc" style="display: none;">
                                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#selectMemeModal">
                                            <i class="fa fa-smile-o"></i> Select Meme
                                        </button>
                                        <button type="button" class="btn btn-block btn-info" id="uplImgBtn">
                                            <i class="fa fa-cloud-upload"></i> Upload Image
                                        </button>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>Top Caption</label>
                                            <input type="text" class="form-control" v-model="top_caption" v-on:keyup="updateMemeTxt | debounce 100">
                                        </div>
                                        <div class="form-group">
                                            <label>Bottom Caption</label>
                                            <input type="text" class="form-control" v-model="bottom_caption" v-on:keyup="updateMemeTxt | debounce 100">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPageContent">Page Content</label>
                                    <textarea id="inputPageContent">{!! $media->page_content !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" id="inputMediaStatus">
                                        <option value="1">Pending</option>
                                        <option value="2" {{ $media->status == 2 ? 'selected': '' }}>Approved</option>
                                        <option value="3" {{ $media->status == 3 ? 'selected': '' }}>Denied</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section><!-- /.content -->
    <div class="modal fade" id="selectMemeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-smile-o"></i> Select Meme</h4>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 450px;">
                    @foreach( $memes as $meme )
                        <div class="memeSelectCtr" data-dismiss="modal" data-mid="{{ $meme->id }}">
                            <div style="width: 100px;"><img src="{{ jasko_component( '/uploads/' .  $meme->upl_name ) }}" class="img-responsive"></div>
                            <div>{{ $meme->meme_name  }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div><!-- /.content-wrapper -->
@endsection

@section( 'styles' )
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.css">
@endsection

@section( 'scripts' )
    <script>
        var thumbnail       =   '{!! $media->thumbnail !!}';
        var mediaObj        =   {!! json_encode($media->content) !!};
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.8/vue.min.js"></script>
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/meme/meme.js') }}"></script>
    <script src="{{ jasko_component('/components/core/admin/js/edit-meme.js') }}"></script>
@endsection