@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>{{ trans('media.upload_images') }}</h3>
                        <div id="imgDropzone" class="dropzone"><i class="fa fa-cube fa-3x"></i></div>
                        <div id="imgPreviewCtr"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>{{ trans('media.create_trivia_quiz') }}</h2>
                        <div id="alertStatus"></div>
                        <form id="createTriviaForm" novalidate="novalidate">
                            {!! csrf_field() !!}
                            <div class="form-steps-ctr">
                                <div class="form-steps-group">
                                    <div class="form-step form-step-active"><h4><i class="fa fa-coffee"></i> 1</h4><span>{{ trans('media.basic_details') }}</span></div>
                                    <div class="form-step"><h4><i class="fa fa-puzzle-piece"></i> 2</h4><span>{{ trans('media.questions_and_results') }}</span></div>
                                    <div class="form-step"><h4><i class="fa fa-map-signs"></i> 3</h4><span>{{ trans('media.finalize') }}</span></div>
                                </div>
                                <div class="single-step-ctr" id="basic-details-step">
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
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_page_content == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label for="inputPageContent">{{ trans('media.page_content') }}</label>
                                        <textarea id="inputPageContent"></textarea>
                                    </div>
                                    <button type="button" class="btn btn-sky pull-right btn-step" data-dir="forward">
                                        {{ trans('media.next_step') }} <i class="fa fa-angle-double-right"></i>
                                    </button>
                                </div>
                                <div class="single-step-ctr" id="questions-step" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>
                                                {{ trans('media.questions') }}
                                                <button type="button" class="btn btn-purple btn-sm pull-right" v-on:click="addQuestion">
                                                    <i class="fa fa-plus"></i> {{ trans('general.add') }}
                                                </button>
                                                <br><small><em>({{ trans('media.add_images_items_optional') }})</em></small>
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
                                        <div class="col-md-6">
                                            <h3>
                                                {{ trans('media.results') }}
                                                <button type="button" class="btn btn-purple btn-sm pull-right" v-on:click="addResult">
                                                    <i class="fa fa-plus"></i> {{ trans('general.add') }}
                                                </button>
                                                <br><small><em>({{ trans('media.add_images_items_optional') }})</em></small>
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
                                    <button type="button" class="btn btn-sky pull-right btn-step" data-dir="forward">
                                        {{ trans('media.next_step') }} <i class="fa fa-angle-double-right"></i>
                                    </button>
                                    <button type="button" class="btn btn-sky pull-right btn-step" data-dir="backward">
                                        <i class="fa fa-angle-double-left"></i> {{ trans('media.previous_step') }}
                                    </button>
                                </div>
                                <div class="single-step-ctr" id="advanced-step" style="display: none;">
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_style == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label>{{ trans('media.style') }}</label>
                                        <select class="form-control" id="inputStyle">
                                            <option value="1">{{ trans('media.style') }} 1</option>
                                            <option value="2" {{ $settings->media_defaults->quiz_style == 2 ? 'selected': '' }}>{{ trans('media.style') }} 2</option>
                                        </select>
                                    </div>
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_animation == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label for="inputAnimation">{{ trans('media.animation') }}</label>
                                        <select class="form-control" id="inputAnimation">
                                            <option value="">{{ trans('general.none') }}</option>
                                            @foreach($animations as $a)
                                                <option value="{{ $a }}" {{ $settings->media_defaults->quiz_animation == $a ? 'selected': '' }}>{{ $a }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ trans('media.thumbnail') }}</label>
                                        <select class="form-control" id="inputThumbnail">
                                            <option value="0">----- {{ trans('media.generate_thumbnail') }} -----</option>
                                            <option v-for="image in images" v-bind:value="image.id">@{{ image.name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_timed == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label>{{ trans('media.timed_quiz') }}</label>
                                        <select class="form-control" id="inputTimedQuiz">
                                            <option value="1">{{ trans('general.no') }}</option>
                                            <option value="2" {{ $settings->media_defaults->quiz_timed == 2 ? 'selected': '' }}>{{ trans('general.yes') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_timer == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label>{{ trans('media.timer_seconds') }}</label>
                                        <input type="number" class="form-control" id="inputTimedSeconds" value="{{ $settings->media_defaults->quiz_timer }}">
                                    </div>
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_randomize_questions == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label>{{ trans('media.randomize_questions') }}</label>
                                        <select class="form-control" id="inputRandomizeQuestions">
                                            <option value="1">{{ trans('general.no') }}</option>
                                            <option value="2" {{ $settings->media_defaults->quiz_randomize_questions == 2 ? 'selected': '' }}>{{ trans('general.yes') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_randomize_answers == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label>{{ trans('media.randomize_answers') }}</label>
                                        <select class="form-control" id="inputRandomizeAnswers">
                                            <option value="1">{{ trans('general.no') }}</option>
                                            <option value="2" {{ $settings->media_defaults->quiz_randomize_answers == 2 ? 'selected': '' }}>{{ trans('general.yes') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group"
                                         @if($settings->media_overrides->quiz_show_correct_answer == 2 || $user->isAdmin == 2 || $user->isMod == 2) style="display:block;" @else style="display:none;" @endif>
                                        <label>{{ trans('media.show_correct_answer') }}</label>
                                        <select class="form-control" id="inputShowCorrectAnswer">
                                            <option value="1">{{ trans('general.no') }}</option>
                                            <option value="2" {{ $settings->media_defaults->quiz_show_correct_answer == 2 ? 'selected': '' }}>{{ trans('general.yes') }}</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success pull-right">
                                        <i class="fa fa-plus"></i> {{ trans('media.submit') }}
                                    </button>
                                    <button type="button" class="btn btn-sky pull-right btn-step" data-dir="backward">
                                        <i class="fa fa-angle-double-left"></i> {{ trans('media.previous_step') }}
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" id="editQuestionModal">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            <h4 class="modal-title"><i class="fa fa-plus"></i> {{ trans('media.edit_question') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>{{ trans('media.question') }}</label>
                                                <input type="text" class="form-control" v-model="questions[question_index].question">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('media.answer_display_type') }}</label>
                                                <select class="form-control" v-model="questions[question_index].answer_display_type">
                                                    <option value="1">{{ trans('media.single_column') }}</option>
                                                    <option value="2">{{ trans('media.two_columns') }}</option>
                                                    <option value="3">{{ trans('media.three_columns') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans( 'media.explanation_optional' ) }}</label>
                                                <textarea class="form-control" v-model="questions[question_index].explanation"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('media.media_type') }}</label>
                                                <select class="form-control" v-model="questions[question_index].media_type">
                                                    <option value="0">{{ trans('general.none') }}</option>
                                                    <option value="1">{{ trans('media.images') }}</option>
                                                    <option value="2">{{ trans('media.embed_long') }}</option>
                                                    <option value="3">{{ trans('media.quote') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" v-show="questions[question_index].media_type == 1">
                                                <label>{{ trans('media.image_optional') }}</label>
                                                <select class="form-control" v-model="questions[question_index].images" multiple>
                                                    <option v-for="image in images" v-bind:value="image.id">@{{ image.name }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" v-show="questions[question_index].media_type == 2">
                                                <label>URL</label>
                                                <input type="text" class="form-control" v-model="questions[question_index].embed_url">
                                            </div>
                                            <div class="form-group" v-show="questions[question_index].media_type == 3">
                                                <label>{{ trans('media.quote') }}</label>
                                                <input type="text" class="form-control" v-model="questions[question_index].quote">
                                            </div>
                                            <div class="form-group" v-show="questions[question_index].media_type == 3">
                                                <label>{{ trans('media.quote_src') }}</label>
                                                <input type="text" class="form-control" v-model="questions[question_index].quote_src">
                                            </div>
                                            <h4 style="margin-bottom: 25px;">
                                                {{ trans('media.answers') }}
                                                <button type="button" class="btn btn-purple pull-right" v-on:click="addAnswer">
                                                    <i class="fa fa-plus"></i> {{ trans('general.add') }}
                                                </button>
                                            </h4>
                                            <div v-for="(index, answer) in questions[question_index].answers" class="answerCtr form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">{{ trans('media.answer') }}</label>
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
                                                    <label class="col-sm-2 control-label">{{ trans('media.image_optional') }}</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" v-model="answer.img">
                                                            <option value="0">----- {{ trans('media.no_image') }} -----</option>
                                                            <option v-for="image in images" v-bind:value="image.id">@{{ image.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">{{ trans('media.correct_answer') }}</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" v-model="answer.isCorrect">
                                                            <option value="1">{{ trans('general.no') }}</option>
                                                            <option value="2">{{ trans('general.yes') }}</option>
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
                                            <h4 class="modal-title"><i class="fa fa-plus"></i> {{ trans('media.edit_result') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>{{ trans('media.title') }}</label>
                                                <input type="text" class="form-control" v-model="results[result_index].title">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('media.description') }}</label>
                                                <textarea class="form-control" v-model="results[result_index].desc"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ trans('media.main_question_image') }}</label>
                                                <select class="form-control" v-model="results[result_index].main_img">
                                                    <option value="0">----- {{ trans('media.no_image') }} -----</option>
                                                    <option v-for="image in images" v-bind:value="image.id">@{{ image.name }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('media.min_score') }}</label>
                                                <input type="number" class="form-control" v-model="results[result_index].min">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('media.max_score') }}</label>
                                                <input type="number" class="form-control" v-model="results[result_index].max">
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-color/2.1.2/jquery.color.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.2/toastr.min.js"></script>
    <script src="{{ jasko_component('/components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ jasko_component('/components/core/js/create-trivia.min.js') }}"></script>
@endsection