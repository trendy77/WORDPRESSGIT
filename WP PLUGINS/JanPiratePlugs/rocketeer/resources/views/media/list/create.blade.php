@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>{{ trans('media.create_list') }}</h2>
                        <div id="alertStatus"></div>
                        <form id="createListForm"  novalidate="novalidate">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>{{ trans('media.title') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('media.title') }}" id="inputTitle">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('media.description') }}</label>
                                <textarea class="form-control" placeholder="{{ trans('media.description') }}" maxlength="150" id="inputDesc"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputCid">{{ trans('media.category') }}</label>
                                <select class="form-control" id="inputCid">
                                    <option value="0">----- {{ trans('media.select_category') }} -----</option>
                                    @foreach($categories as $cat)
                                        <option  value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputNSFW">{{ trans('media.nsfw') }}</label>
                                <select class="form-control" id="inputNSFW">
                                    <option value="1">{{ trans('general.no') }}</option>
                                    <option value="2">{{ trans('general.yes') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('media.thumbnail') }}</label>
                                <select class="form-control" id="inputThumbnail">
                                    <option value="">----- {{ trans('media.select_thumbnail') }} -----</option>
                                    <option v-for="image in images" v-bind:value="image.id">@{{ image.name }}</option>
                                </select>
                            </div>
                            <div class="form-group"
                                 @if($settings->media_overrides->list_style == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                <label>{{ trans('media.style') }}</label>
                                <select class="form-control" id="inputListStyle">
                                    <option value="1">{{ trans('media.style') }} 1</option>
                                    <option value="2" {{ $settings->media_defaults->list_style == 2 ? 'selected': '' }}>{{ trans('media.style') }} 2</option>
                                    <option value="3" {{ $settings->media_defaults->list_style == 3 ? 'selected': '' }}>{{ trans('media.style') }} 3</option>
                                    <option value="4" {{ $settings->media_defaults->list_style == 4 ? 'selected': '' }}>{{ trans('media.style') }} 4</option>
                                    <option value="5" {{ $settings->media_defaults->list_style == 5 ? 'selected': '' }}>{{ trans('media.style') }} 5</option>
                                    <option value="6" {{ $settings->media_defaults->list_style == 6 ? 'selected': '' }}>{{ trans('media.style') }} 6</option>
                                    <option value="7" {{ $settings->media_defaults->list_style == 7 ? 'selected': '' }}>{{ trans('media.style') }} 7</option>
                                </select>
                            </div>
                            <div class="form-group"
                                 @if($settings->media_overrides->list_animation == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                <label for="inputAnimation">{{ trans('media.animation_applies_styles') }}</label>
                                <select class="form-control" id="inputAnimation">
                                    <option value="">{{ trans('general.none') }}</option>
                                    @foreach($animations as $a)
                                        <option value="{{ $a }}" {{ $settings->media_defaults->list_animation == $a ? 'selected': '' }}>{{ $a }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{ trans('media.upload_images') }}</label>
                                    <div id="imgDropzone" class="dropzone"><i class="fa fa-cube fa-3x"></i></div>
                                    <div id="imgPreviewCtr"></div>
                                </div>
                                <div class="col-md-8">
                                    <h3>
                                        {{ trans('media.items') }}
                                        <button type="button" class="btn btn-purple pull-right" v-on:click="addItem">
                                            <i class="fa fa-plus"></i> {{ trans('general.add') }}
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
                            <div class="form-group"
                                 @if($settings->media_overrides->list_page_content == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                <label>{{ trans('media.page_content') }}</label>
                                <textarea id="inputPageContent"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-right">
                                    <i class="fa fa-plus"></i> {{ trans('media.submit') }}
                                </button>
                            </div>
                            <div class="modal fade" id="editListItemModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            <h4 class="modal-title"><i class="fa fa-plus"></i> {{ trans('media.edit_list_item') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>{{ trans('media.title') }}</label>
                                                <input type="text" class="form-control" v-model="list_items[list_item_index].title">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('media.description_optional') }}</label>
                                                <textarea class="form-control" v-model="list_items[list_item_index].desc"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('media.media_type') }}</label>
                                                <select class="form-control" v-model="list_items[list_item_index].media_type">
                                                    <option value="1">{{ trans('media.images') }}</option>
                                                    <option value="2">{{ trans('media.embed_long') }}</option>
                                                    <option value="3">{{ trans('media.quote') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" v-show="list_items[list_item_index].media_type == 1">
                                                <label>{{ trans('media.image_optional') }}</label>
                                                <select class="form-control" v-model="list_items[list_item_index].images" multiple>
                                                    <option v-for="image in images" v-bind:value="image.id">@{{ image.name }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" v-show="list_items[list_item_index].media_type == 2">
                                                <label>URL</label>
                                                <input type="text" class="form-control" v-model="list_items[list_item_index].embed_url">
                                            </div>
                                            <div class="form-group" v-show="list_items[list_item_index].media_type == 3">
                                                <label>{{ trans('media.quote') }}</label>
                                                <input type="text" class="form-control" v-model="list_items[list_item_index].quote">
                                            </div>
                                            <div class="form-group" v-show="list_items[list_item_index].media_type == 3">
                                                <label>{{ trans('media.quote_src') }}</label>
                                                <input type="text" class="form-control" v-model="list_items[list_item_index].quote_src">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'styles' )
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.css">
@endsection


@section( 'scripts' )
    <script>
        var are_you_sure_message    =   '{!! trans('media.are_you_sure') !!}';
        var img_upload_error_message=   '{!! trans('media.unable_upload_img') !!}';
        var simple_success_message  =   '{!! trans('media.success') !!}';
        var file_upload_success     =   '{!! trans('media.file_upload_success') !!}';
        var processing_message      =   '{!! trans('media.submission_processing') !!}';
        var success_message         =   '{!! trans('media.submission_success_approved') !!}';
        var pending_success_message =   '{!! trans('media.submission_success_pending') !!}';
        var unable_submission       =   '{!! trans('media.submission_unable') !!}';
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.js"></script>
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/create-list.min.js') }}"></script>
@endsection