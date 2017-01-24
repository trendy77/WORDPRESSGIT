@extends( 'layout' )

@section( 'content' )
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>{{ trans('media.create_news') }}</h2>
                        <div id="alertStatus"></div>
                        <form id="createNewsForm" novalidate="novalidate">
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
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
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
                            <div class="form-group">
                                <label>{{ trans('media.main_image') }}</label>
                                <select class="form-control" id="inputMainImg" multiple>
                                    <option v-for="image in images" v-bind:value="image.id">@{{ image.name }}</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{ trans('media.upload_images') }}</label>
                                    <div id="questionDropzone" class="dropzone"><i class="fa fa-cube fa-3x"></i></div>
                                    <div id="questionImgPreviewCtr"></div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{ trans('media.page_content') }}</label>
                                        <textarea id="inputPageContent"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-right">
                                    <i class="fa fa-plus"></i> {{ trans('media.submit') }}
                                </button>
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
    <script src="{{ jasko_component('/components/core/js/create-news.min.js') }}"></script>
@endsection