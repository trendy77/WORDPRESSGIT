@extends( 'admin.layout' )

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Media Settings <small>Update the media settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">Media</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs (Pulled to the right) -->
                <form id="settingsForm">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#general_tab" data-toggle="tab">General</a></li>
                            <li><a href="#od_tab" data-toggle="tab">Overrides & Defaults</a></li>
                            <li><a href="#user_tab" data-toggle="tab"> Users</a></li>
                            <li class="pull-left header"><i class="fa fa-th"></i> Media Settings Form</li>
                        </ul>
                        <div class="tab-content">
                            <div id="settingsStatus"></div>
                            <div class="tab-pane active" id="general_tab">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Max Image Size (mb)</label>
                                    <input type="text" class="form-control" value="{{ $settings->max_media_img_size }}" id="inputMaxImgSize">
                                </div>
                                <div class="form-group">
                                    <label>Preapprove Media</label>
                                    <select class="form-control" id="inputPreapproveMedia">
                                        <option value="1">Yes</option>
                                        <option value="2" {{ $settings->isPreapproved == 2 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Users can upload their own images for memes</label>
                                    <select class="form-control" id="inputAllowUserUploadedMemes">
                                        <option value="1">No</option>
                                        <option value="2" {{ $settings->allow_custom_memes == 2 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Send E-mail when media is approved</label>
                                    <select class="form-control" id="inputSendApprovedEmail">
                                        <option value="1">No</option>
                                        <option value="2" {{ $settings->send_approved_media_email == 2 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Infinite Pagination</label>
                                    <select class="form-control" id="inputInfinitePagination">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->infinite_pagination == 2 ? 'selected' : '' }}>Enable</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label>Users can duplicate lists</label>
                                    <select class="form-control" id="inputDuplicateLists">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->duplicate_list == 2 ? 'selected' : '' }}>Enable</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label>Notify User When Their Lists is duplicated</label>
                                    <select class="form-control" id="inputNotifyDuplicateList">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->notify_user_duplicate_list == 2 ? 'selected' : '' }}>Enable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Users must be logged in to vote</label>
                                    <select class="form-control" id="inputPollSignedInVote">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->poll_signed_in_votes == 2 ? 'selected' : '' }}>Enable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Allow Embedding</label>
                                    <select class="form-control" id="inputAllowEmbed">
                                        <option value="1">No</option>
                                        <option value="2" {{ $settings->allow_embeds == 2 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Autoscroll (Quizzes & Polls only)</label>
                                    <select class="form-control" id="inputAutoscroll">
                                        <option value="1">No</option>
                                        <option value="2" {{ $settings->auto_scroll == 2 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Autoscroll Timer</label>
                                    <input type="number" class="form-control" id="inputAutoscrollTimer" value="{{ $settings->auto_scroll_timer }}">
                                </div>
                                <div class="form-group">
                                    <label>Generate Special Sharing Images</label>
                                    <select class="form-control" id="inputGenerateSpecialShareImg">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->generate_special_share_img == 2 ? 'selected' : '' }}>Enable</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane" id="od_tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2>Overrides</h2>
                                        <p>Allow users to override the default settings when creating media items. Admin & Mods will always be allowed to override the default values.</p>
                                        <h3>Polls</h3>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkPollPageContent"
                                                       {{ $settings->media_overrides->poll_page_content == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Page Content</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkPollStyle"
                                                        {{ $settings->media_overrides->poll_style == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Style</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkPollAnimation"
                                                        {{ $settings->media_overrides->poll_animation == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Animation</label>
                                        </div>
                                        <h3>Quizzes</h3>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizPageContent"
                                                        {{ $settings->media_overrides->quiz_page_content == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Page Content</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizAnimation"
                                                        {{ $settings->media_overrides->quiz_animation == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Animation</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizStyle"
                                                        {{ $settings->media_overrides->quiz_style == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Style</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizTimedQuiz"
                                                        {{ $settings->media_overrides->quiz_timed == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Timed Quizzes</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizTimer"
                                                        {{ $settings->media_overrides->quiz_timer == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Timer</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizRandomizeQuestions"
                                                        {{ $settings->media_overrides->quiz_randomize_questions == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Randomize Questions</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizRandomizeAnswers"
                                                        {{ $settings->media_overrides->quiz_randomize_answers == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Randomize Answers</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkQuizShowCorrectAnswer"
                                                        {{ $settings->media_overrides->quiz_show_correct_answer == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Show Correct Answer</label>
                                        </div>
                                        <h3>Images</h3>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkImagePageContent"
                                                        {{ $settings->media_overrides->image_page_content == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Page Content</label>
                                        </div>
                                        <h3>Memes</h3>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkMemePageContent"
                                                        {{ $settings->media_overrides->meme_page_content == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Page Content</label>
                                        </div>
                                        <h3>Video</h3>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkVideoPageContent"
                                                        {{ $settings->media_overrides->video_page_content == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Page Content</label>
                                        </div>
                                        <h3>List</h3>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkListPageContent"
                                                        {{ $settings->media_overrides->list_page_content == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Page Content</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkListStyle"
                                                        {{ $settings->media_overrides->list_style == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Style</label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="flat-red" id="checkListAnimation"
                                                        {{ $settings->media_overrides->list_animation == 2 ? 'checked': '' }}>
                                            </label>
                                            <label>Animation</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2>Defaults</h2>
                                        <p>The default values for media items.</p>
                                        <h3>Polls</h3>
                                        <div class="form-group">
                                            <label>Style</label>
                                            <select class="form-control" id="inputPollStyle">
                                                <option value="1">Style 1</option>
                                                <option value="2" {{ $settings->media_defaults->poll_style == 2 ? 'selected' : '' }}>Style 2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Animation</label>
                                            <select class="form-control" id="inputPollAnimation">
                                                <option value="">None</option>
                                                @foreach($animations as $animation)
                                                    <option value="{{ $animation }}" {{ $settings->media_defaults->poll_animation == $animation ? 'selected' : '' }}>{{ $animation }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <h3>Quizzes</h3>
                                        <div class="form-group">
                                            <label>Animation</label>
                                            <select class="form-control" id="inputQuizAnimation">
                                                <option value="">None</option>
                                                @foreach($animations as $animation)
                                                    <option value="{{ $animation }}" {{ $settings->media_defaults->quiz_animation == $animation ? 'selected' : '' }}>{{ $animation }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Style</label>
                                            <select class="form-control" id="inputQuizStyle">
                                                <option value="1">Style 1</option>
                                                <option value="2" {{ $settings->media_defaults->quiz_style == 2 ? 'selected' : '' }}>Style 2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Timed Quiz</label>
                                            <select class="form-control" id="inputQuizTimed">
                                                <option value="1">No</option>
                                                <option value="2" {{ $settings->media_defaults->quiz_timed == 2 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Timer (Seconds)</label>
                                            <input type="number" class="form-control" id="inputQuizTimer" value="{{ $settings->media_defaults->quiz_timer }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Randomize Questions</label>
                                            <select class="form-control" id="inputQuizRandomizeQuestions">
                                                <option value="1">No</option>
                                                <option value="2" {{ $settings->media_defaults->quiz_randomize_questions == 2 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Randomize Answers</label>
                                            <select class="form-control" id="inputQuizRandomizeAnswers">
                                                <option value="1">No</option>
                                                <option value="2" {{ $settings->media_defaults->quiz_randomize_answers == 2 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Show Correct Answer</label>
                                            <select class="form-control" id="inputQuizShowCorrectAnswer">
                                                <option value="1">No</option>
                                                <option value="2" {{ $settings->media_defaults->quiz_show_correct_answer == 2 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                        <h3>List</h3>
                                        <div class="form-group">
                                            <label>Style</label>
                                            <select class="form-control" id="inputListStyle">
                                                <option value="1">Style 1</option>
                                                <option value="2" {{ $settings->media_defaults->list_style == 2 ? 'selected' : '' }}>Style 2</option>
                                                <option value="3" {{ $settings->media_defaults->list_style == 3 ? 'selected' : '' }}>Style 3</option>
                                                <option value="4" {{ $settings->media_defaults->list_style == 4 ? 'selected' : '' }}>Style 4</option>
                                                <option value="5" {{ $settings->media_defaults->list_style == 5 ? 'selected' : '' }}>Style 5</option>
                                                <option value="6" {{ $settings->media_defaults->list_style == 6 ? 'selected' : '' }}>Style 6</option>
                                                <option value="7" {{ $settings->media_defaults->list_style == 7 ? 'selected' : '' }}>Style 7</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Animation</label>
                                            <select class="form-control" id="inputListAnimation">
                                                <option value="">None</option>
                                                @foreach($animations as $animation)
                                                    <option value="{{ $animation }}" {{ $settings->media_defaults->list_animation == $animation ? 'selected' : '' }}>{{ $animation }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="user_tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Create</h3>
                                        <p>Decide whether or not users can create media. These limitations apply to regular users only. Admins & Mods will always be allowed to create media.</p>
                                        <div class="form-group">
                                            <label>Users can create Polls</label>
                                            <select class="form-control" id="inputCanCreatePolls">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreatePoll == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can create Trivia quizzes</label>
                                            <select class="form-control" id="inputCanCreatrTrivia">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreateTrivia == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can create Personality quizzes</label>
                                            <select class="form-control" id="inputCanCreatePersonality">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreatePersonality == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can create Images</label>
                                            <select class="form-control" id="inputCanCreateImages">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreateImage == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can create Memes</label>
                                            <select class="form-control" id="inputCanCreateMemes">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreateMeme == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can create Videos</label>
                                            <select class="form-control" id="inputCanCreateVideos">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreateVideo == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can create News</label>
                                            <select class="form-control" id="inputCanCreateArticles">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreateArticles == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can create Lists</label>
                                            <select class="form-control" id="inputCanCreateLists">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canCreateLists == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>View Main Pages</h3>
                                        <p>Disable certain media features. Individual media items will still be viewable, but their main pages will not.</p>
                                        <div class="form-group">
                                            <label>Users can view Polls</label>
                                            <select class="form-control" id="inputCanViewPolls">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canViewPoll == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can view Quizzes (Trivia & Personality)</label>
                                            <select class="form-control" id="inputCanViewQuiz">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canViewQuiz == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can view Images (Images & Memes)</label>
                                            <select class="form-control" id="inputCanViewImages">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canViewImage == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can view Videos</label>
                                            <select class="form-control" id="inputCanViewVideos">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canViewVideo == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can view News</label>
                                            <select class="form-control" id="inputCanViewArticles">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canViewArticles == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Users can view Lists</label>
                                            <select class="form-control" id="inputCanViewLists">
                                                <option value="1">Yes</option>
                                                <option value="2" {{ $settings->canViewLists == 2 ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section><!-- /.content -->
</div>
@endsection

@section( 'styles' )
    <link rel="stylesheet" href="{{ jasko_component('/components/adminlte/plugins/iCheck/all.css') }}">
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ jasko_component('/components/core/admin/js/media-settings.js') }}"></script>
@endsection