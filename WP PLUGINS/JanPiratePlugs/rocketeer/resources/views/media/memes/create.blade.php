@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>{{ trans('media.create_meme') }}</h2>
                        <div id="alertStatus"></div>
                        <form id="createMemeForm" novalidate="novalidate">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="memeCanvas" width="350" height="50" class="responsive-canvas"></canvas>
                                    <input type="file" id="inputImgSrc" style="display: none;">
                                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#selectMemeModal">
                                        <i class="fa fa-smile-o"></i> {{ trans('media.select_meme') }}
                                    </button>
                                    <button type="button" class="btn btn-block btn-info" id="uplImgBtn"
                                            @if($settings->allow_custom_memes == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <i class="fa fa-cloud-upload"></i> {{ trans('media.upload_image') }}
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('media.top_caption') }}</label>
                                        <input type="text" class="form-control" v-model="top_caption" v-on:keyup="updateMemeTxt | debounce 100">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('media.bottom_caption') }}</label>
                                        <input type="text" class="form-control" v-model="bottom_caption" v-on:keyup="updateMemeTxt | debounce 100">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"
                                 @if($settings->media_overrides->meme_page_content == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                <label>{{ trans('media.page_content') }}</label>
                                <textarea id="inputPageContent"></textarea>
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
    <div class="modal fade" id="selectMemeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-smile-o"></i> {{ trans('media.select_meme') }}</h4>
                </div>
                <div class="modal-body" style="overflow-y: scroll; max-height: 450px;">
                    @foreach( $memes as $meme )
                        <div class="memeSelectCtr" data-dismiss="modal" data-mid="{{ $meme->id }}">
                            <div style="width: 100px;"><img src="{{ jasko_component( '/uploads/' . $meme->upl_name ) }}" class="img-responsive"></div>
                            <div>{{ $meme->meme_name  }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script>
        var processing_message      =   '{!! trans('media.submission_processing') !!}';
        var success_message         =   '{!! trans('media.submission_success_approved') !!}';
        var pending_success_message =   '{!! trans('media.submission_success_pending') !!}';
        var unable_submission       =   '{!! trans('media.submission_unable') !!}';
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/meme/meme.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/create-meme.min.js') }}"></script>
@endsection