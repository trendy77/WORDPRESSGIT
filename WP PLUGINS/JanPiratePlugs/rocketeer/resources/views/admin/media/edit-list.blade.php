@extends( 'admin.layout' )

@section('content')
    <div class="content-wrapper" id="editMediaApp">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Edit List <small>Edit any list here.</small></h1>
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

                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <select class="form-control" id="inputThumbnail" v-model="thumbnail">
                                            <option value="">----- SELECT THUMBNAIL -----</option>
                                            <option v-for="image in images" v-bind:value="image.upl_name">@{{ image.original_name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Style</label>
                                        <select class="form-control" id="inputListStyle">
                                            <option value="1">Style 1</option>
                                            <option value="2" {{ $media->content->style == 2 ? 'selected': '' }}>Style 2</option>
                                            <option value="3" {{ $media->content->style == 3 ? 'selected': '' }}>Style 3</option>
                                            <option value="4" {{ $media->content->style == 4 ? 'selected': '' }}>Style 4</option>
                                            <option value="5" {{ $media->content->style == 5 ? 'selected': '' }}>Style 5</option>
                                            <option value="6" {{ $media->content->style == 6 ? 'selected': '' }}>Style 6</option>
                                            <option value="7" {{ $media->content->style == 7 ? 'selected': '' }}>Style 7</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAnimation">Animation (Only Applies to styles 4 - 7)</label>
                                        <select class="form-control" id="inputAnimation">
                                            <option value="">None</option>
                                            @foreach($animations as $a)
                                                <option value="{{ $a }}" {{ $media->content->animation == $a ? 'selected': '' }}>{{ $a }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Upload Images</label>
                                            <div id="dpz">
                                                <i class="fa fa-cube fa-3x"></i><br><em>(Drag & drop image here)</em>
                                            </div>
                                            <div id="dpzImgPreviewCtr"></div>
                                        </div>
                                        <div class="col-md-8">
                                            <h3>
                                                Items
                                                <button type="button" class="btn btn-info pull-right" v-on:click="addItem">
                                                    <i class="fa fa-plus"></i> Add
                                                </button>
                                            </h3>
                                            <div>
                                                <div v-for="(index, item) in list_items" class="mediaEditItemOverviewCtr">
                                                    <span>@{{ item.title }}</span>
                                                    <button type="button" class="btn btn-xs btn-danger pull-right"
                                                            v-on:click="removeItem(index, $event)"><i class="fa fa-remove"></i></button>
                                                    <button type="button" class="btn btn-xs btn-info pull-right"
                                                            data-toggle="modal" data-target="#editListItemModal"
                                                            v-on:click="updateItemIndex(index, $event)"><i class="fa fa-cogs"></i></button>
                                                </div>
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

        <div class="modal fade" id="editListItemModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Edit List Item</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="list_items[list_item_index].title">
                        </div>
                        <div class="form-group">
                            <label>Description (Optional)</label>
                            <textarea class="form-control" v-model="list_items[list_item_index].desc"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Media Type</label>
                            <select class="form-control" v-model="list_items[list_item_index].media_type">
                                <option value="1">Images</option>
                                <option value="2">Embed</option>
                                <option value="3">Quote</option>
                            </select>
                        </div>
                        <div class="form-group" v-show="list_items[list_item_index].media_type == 1">
                            <label>Image (optional)</label>
                            <select class="form-control" v-model="list_items[list_item_index].images" multiple>
                                <option v-for="image in images" v-bind:value="image.upl_name">@{{ image.original_name }}</option>
                            </select>
                        </div>
                        <div class="form-group" v-show="list_items[list_item_index].media_type == 2">
                            <label>URL</label>
                            <input type="text" class="form-control" v-model="list_items[list_item_index].embed_url">
                        </div>
                        <div class="form-group" v-show="list_items[list_item_index].media_type == 3">
                            <label>Quote</label>
                            <input type="text" class="form-control" v-model="list_items[list_item_index].quote">
                        </div>
                        <div class="form-group" v-show="list_items[list_item_index].media_type == 3">
                            <label>Quote Source</label>
                            <input type="text" class="form-control" v-model="list_items[list_item_index].quote_src">
                        </div>
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
        var user_uploads    =   {!! json_encode($images) !!};
        var image_ids       =   {!! json_encode($media->uploads) !!};
        var mediaObj        =   {!! json_encode($media->content) !!};
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.8/vue.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.js"></script>
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/core/admin/js/edit-list.js') }}"></script>
@endsection