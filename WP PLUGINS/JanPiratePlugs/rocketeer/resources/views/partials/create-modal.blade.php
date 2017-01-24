<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> {{ trans('media.create') }}</h4>
            </div>
            <div class="modal-body">
                @if($settings->canCreatePoll == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createPoll') }}" class="rocketeer-btn btn-block btn poll text-center">
                        <span class="icon-bg"></span><i class="fa fa-list-ol button-icon"></i> {{ trans('media.poll') }}
                    </a>
                @endif
                @if($settings->canCreateTrivia == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createTrivia') }}" class="rocketeer-btn btn-block btn quiz text-center">
                        <span class="icon-bg"></span><i class="fa fa-question-circle button-icon"></i> {{ trans('media.trivia_quiz') }}
                    </a>
                @endif
                @if($settings->canCreatePersonality == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createPersonality') }}" class="rocketeer-btn btn-block btn quiz text-center">
                        <span class="icon-bg"></span><i class="fa fa-slideshare button-icon"></i> {{ trans('media.personality_quiz') }}
                    </a>
                @endif
                @if($settings->canCreateImage == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createImage') }}" class="rocketeer-btn btn-block btn images text-center">
                        <span class="icon-bg"></span><i class="fa fa-image button-icon"></i> {{ trans('media.upload_image') }}
                    </a>
                @endif
                @if($settings->canCreateMeme == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createMeme') }}" class="rocketeer-btn btn-block btn images text-center">
                        <span class="icon-bg"></span><i class="fa fa-smile-o button-icon"></i> {{ trans('media.meme') }}
                    </a>
                @endif
                @if($settings->canCreateVideo == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createVideo') }}" class="rocketeer-btn btn-block btn videos text-center">
                        <span class="icon-bg"></span><i class="fa fa-video-camera button-icon"></i> {{ trans('media.video') }}
                    </a>
                @endif
                @if($settings->canCreateArticles == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createNews') }}" class="rocketeer-btn btn-block btn article text-center">
                        <span class="icon-bg"></span><i class="fa fa-file-text-o button-icon"></i> {{ trans('media.news') }}
                    </a>
                @endif
                @if($settings->canCreateLists == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                    <a href="{{ route('createList') }}" class="rocketeer-btn btn-block btn list text-center">
                        <span class="icon-bg"></span><i class="fa fa-sort button-icon"></i> {{ trans('media.list') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>