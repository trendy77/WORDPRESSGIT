@extends( 'admin.layout' )

@section('content')
<div class="content-wrapper" id="editMediaApp">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Trivia <small>Edit any trivia here.</small></h1>
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
                            <li><a href="#questions_tab" data-toggle="tab">Quiz Details</a></li>
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
                            <div class="tab-pane" id="questions_tab">
                                <div class="form-group">
                                    <label>Style</label>
                                    <select class="form-control" id="inputStyle">
                                        <option value="1">Style 1</option>
                                        <option value="2" {{ $media->content->style == 2 ? 'selected': '' }}>Style 2</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputAnimation">{{ trans('media.animation') }}</label>
                                    <select class="form-control" id="inputAnimation">
                                        <option value="">{{ trans('general.none') }}</option>
                                        @foreach($animations as $a)
                                            <option value="{{ $a }}" {{ $media->content->animation == $a ? 'selected': '' }}>{{ $a }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Thumbnail</label>
                                    <select class="form-control" id="inputThumbnail" v-model="thumbnail">
                                        <option v-for="image in images" v-bind:value="image.upl_name">@{{ image.original_name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Timed Quiz</label>
                                    <select class="form-control" id="inputTimedQuiz">
                                        <option value="1">No</option>
                                        <option value="2" {{ $media->content->is_timed == 2 ? 'selected': '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Timer (Seconds)</label>
                                    <input type="number" class="form-control" id="inputTimedSeconds" value="{{ $media->content->timer }}">
                                </div>
                                <div class="form-group">
                                    <label>Randomize Questions</label>
                                    <select class="form-control" id="inputRandomizeQuestions">
                                        <option value="1">No</option>
                                        <option value="2" {{ $media->content->randomize_questions == 2 ? 'selected': '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Randomize Answers</label>
                                    <select class="form-control" id="inputRandomizeAnswers">
                                        <option value="1">No</option>
                                        <option value="2" {{ $media->content->randomize_answers == 2 ? 'selected': '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3>Upload Images</h3>
                                        <div id="dpz">
                                            <i class="fa fa-cube fa-3x"></i><br><em>(Drag & drop image here)</em>
                                        </div>
                                        <div id="dpzImgPreviewCtr"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>
                                            Questions
                                            <button type="button" class="btn btn-info btn-sm pull-right" v-on:click="addQuestion">
                                                <i class="fa fa-plus"></i> Add
                                            </button>
                                            <br><small><em>(Adding images to answers is optional)</em></small>
                                        </h3>
                                        <div>
                                            <div v-for="(index, question) in questions" class="mediaEditItemOverviewCtr">
                                                <span>@{{ question.question }}</span>
                                                <button type="button" class="btn btn-xs btn-danger pull-right" v-on:click="removeQuestion(index)">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-info pull-right"
                                                        data-toggle="modal" data-target="#editQuestionModal"
                                                        v-on:click="updateQuestionIndex(index, $event)"><i class="fa fa-cogs"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>
                                            Results
                                            <button type="button" class="btn btn-info btn-sm pull-right" v-on:click="addResult">
                                                <i class="fa fa-plus"></i> Add
                                            </button>
                                            <br><small><em>(Adding images to answers is optional)</em></small>
                                        </h3>
                                        <div>
                                            <div v-for="(index, result) in results" class="mediaEditItemOverviewCtr">
                                                <span>@{{ result.title }}</span>
                                                <button type="button" class="btn btn-xs btn-danger pull-right" v-on:click="removeResult(index)">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-info pull-right"
                                                        data-toggle="modal" data-target="#editResultModal"
                                                        v-on:click="updateResultIndex(index, $event)"><i class="fa fa-cogs"></i></button>
                                            </div>
                                        </div>
                                    </div>
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

    <div class="modal fade" id="editQuestionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Question</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Question</label>
                        <input type="text" class="form-control" v-model="questions[question_index].question">
                    </div>
                    <div class="form-group">
                        <label>Answer Display Type</label>
                        <select class="form-control" v-model="questions[question_index].answer_display_type">
                            <option value="1">Single Column</option>
                            <option value="2">2 Columns</option>
                            <option value="3">3 Columns</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Explanation (Optional)</label>
                        <textarea class="form-control" v-model="questions[question_index].explanation"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Media Type</label>
                        <select class="form-control" v-model="questions[question_index].media_type">
                            <option value="0">None</option>
                            <option value="1">Images</option>
                            <option value="2">Embed</option>
                            <option value="3">Quote</option>
                        </select>
                    </div>
                    <div class="form-group" v-show="questions[question_index].media_type == 1">
                        <label>Image (optional)</label>
                        <select class="form-control" v-model="questions[question_index].images" multiple>
                            <option v-for="image in images" v-bind:value="image.upl_name">@{{ image.original_name }}</option>
                        </select>
                    </div>
                    <div class="form-group" v-show="questions[question_index].media_type == 2">
                        <label>URL</label>
                        <input type="text" class="form-control" v-model="questions[question_index].embed_url">
                    </div>
                    <div class="form-group" v-show="questions[question_index].media_type == 3">
                        <label>Quote</label>
                        <input type="text" class="form-control" v-model="questions[question_index].quote">
                    </div>
                    <div class="form-group" v-show="questions[question_index].media_type == 3">
                        <label>Quote Source</label>
                        <input type="text" class="form-control" v-model="questions[question_index].quote_src">
                    </div>
                    <h4 style="margin-bottom: 25px;">
                        Answers
                        <button type="button" class="btn btn-info pull-right" v-on:click="addAnswer">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </h4>
                    <div v-for="(index, answer) in questions[question_index].answers" class="answerCtr form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Answer</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Answer" v-model="answer.answer">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-sm btn-danger" v-on:click="removeAnswer(index, $event)">
                                    <i class="fa fa-remove"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Image (optional)</label>
                            <div class="col-sm-8">
                                <select class="form-control" v-model="answer.img">
                                    <option value="0">----- NO IMAGE -----</option>
                                    <option v-for="image in images" v-bind:value="image.upl_name">@{{ image.original_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Correct Answer</label>
                            <div class="col-sm-8">
                                <select class="form-control" v-model="answer.isCorrect">
                                    <option value="1">No</option>
                                    <option value="2">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editResultModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Question</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="results[result_index].title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="results[result_index].desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Main Question Image</label>
                        <select class="form-control" v-model="results[result_index].main_img">
                            <option value="0">----- NO IMAGE -----</option>
                            <option v-for="image in images" v-bind:value="image.upl_name">@{{ image.original_name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Minimum Score</label>
                        <input type="number" class="form-control" v-model="results[result_index].min">
                    </div>
                    <div class="form-group">
                        <label>Maximum Score</label>
                        <input type="number" class="form-control" v-model="results[result_index].max">
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
        var mediaObj        =   {!! json_encode($media->content) !!};
        var user_uploads    =   {!! json_encode($images) !!};
        var image_ids       =   {!! json_encode($media->uploads) !!};
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.8/vue.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.js"></script>
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/core/admin/js/edit-trivia.js') }}"></script>
@endsection