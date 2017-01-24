<div class="modal fade" id="embedMediaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('media.embed') }}</h4>
            </div>
            <div class="modal-body text-center">
                <p>{{ trans('media.embed_modal_body') }}</p>
                <div class="form-group">
                    <input type="text" class="form-control" readonly
                           value='<iframe src="{{ route('embed' , [ 'id' => $media->id ]) }}" width="100%" height="500" frameborder="0"></iframe>'>
                </div>
            </div>
        </div>
    </div>
</div>