@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>{{ trans('media.create_video') }}</h2>
                        <div id="alertStatus"></div>
                        <form id="createVideoForm" novalidate="novalidate">
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
                                <label>{{ trans('media.video_url') }}</label>
                                <input type="text" class="form-control" placeholder="Enter URL" id="inputVideo">
                            </div>
                            <div class="form-group"
                                 @if($settings->media_overrides->video_page_content == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
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
@endsection

@section( 'scripts' )
    <script>
        var processing_message      =   '{!! trans('media.submission_processing') !!}';
        var success_message         =   '{!! trans('media.submission_success_approved') !!}';
        var pending_success_message =   '{!! trans('media.submission_success_pending') !!}';
        var unable_submission       =   '{!! trans('media.submission_unable') !!}';
    </script>
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/create-video.min.js') }}"></script>
@endsection