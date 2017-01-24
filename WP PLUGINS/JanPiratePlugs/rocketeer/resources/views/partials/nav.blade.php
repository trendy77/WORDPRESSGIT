<nav class="navbar navbar-{{ $settings->site_color }}">
    <div class="top-header">
        <div class="container">
            <p class="nav navbar-nav navbar-date hidden-sm hidden-xs">{{ $current_date }}</p>

            @if( $settings->lang_switcher == 2 && ($settings->lang_switcher_loc == 2 || $settings->lang_switcher_loc == 4) )
                <ul class="nav navbar-nav hidden-xs">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-weight: bold;"><i class="fa fa-globe"></i> {{ get_default_lang( $settings->default_lang, $settings->languages ) }}</a>
                        <ul class="dropdown-menu">
                            @foreach($settings->languages as $lang)
                                <li><a href="{{ route( 'setLang', [ 'locale' => $lang->locale ] ) }}">{{ $lang->readable_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endif

            <ul class="nav navbar-nav hidden-xs">
                @foreach($pages as $page)
                    @if($page->page_type == 3)
                        <li><a href="{{ $page->direct_url }}" target="_blank">{{ $page->title }}</a></li>
                        @else
                        <li><a href="{{ route( 'page', [ 'slug' => $page->slug_url ] ) }}">{{ $page->title }}</a></li>
                    @endif
                @endforeach
            </ul>

            <div class="nav navbar-nav navbar-right hidden-xs">
                <form class="input-group" method="get" action="{{ route('search') }}">
                    <input type="text" class="form-control" name="q" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-{{ $settings->site_color }}" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </form><!-- /input-group -->
            </div>

            <ul class="nav navbar-nav nav-social navbar-right">
                @if($settings->facebook)
                    <li><a href="http://facebook.com/{{ $settings->facebook }}" target="_blank" class="facebook-hover"><i class="fa fa-facebook"></i></a></li>
                @endif
                @if($settings->twitter)
                    <li><a href="http://twitter.com/{{ $settings->twitter }}" target="_blank" class="twitter-hover"><i class="fa fa-twitter"></i></a></li>
                @endif
                @if($settings->gp)
                    <li><a href="http://plus.google.com/{{ $settings->gp }}" target="_blank" class="googleplus-hover"><i class="fa fa-google-plus"></i></a></li>
                @endif
                @if($settings->youtube)
                    <li><a href="http://youtube.com/user/{{ $settings->youtube }}" target="_blank" class="youtube-hover"><i class="fa fa-youtube"></i></a></li>
                @endif
                @if($settings->soundcloud)
                    <li><a href="http://soundcloud.com/{{ $settings->soundcloud }}" target="_blank" class="soundcloud-hover"><i class="fa fa-soundcloud"></i></a></li>
                @endif
                @if($settings->instagram)
                    <li><a href="http://instagram.com/{{ $settings->instagram }}" target="_blank" class="instagram-hover"><i class="fa fa-instagram"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" id="btn-mobile-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </button>
            <a class="logo" href="{{ url('/') }}">
                @if( $settings->logo_type == 1)
                    {{ $settings->site_name }}
                @else
                    <img src="{{ jasko_component( '/uploads/' . $settings->logo_img ) }}">
                @endif
            </a>
            @if( $settings->header_ad )
                <div class="pull-right header-ad hidden-xs hidden-sm">{!! $settings->header_ad !!}</div>
            @endif
        </div>
    </div><!-- /.container -->
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="main-menu collapse navbar-collapse" id="rocketeer-main-menu">
        <div class="container">
            <div class="rel">
                <form class="navbar-form navbar-left visible-xs" method="get" action="{{ route('search') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search...">
                        <span class="input-group-btn"><button class="btn btn-{{ $settings->site_color }}" type="submit"><i class="fa fa-search"></i></button></span>
                    </div><!-- /input-group -->
                </form>
                <ul class="nav navbar-nav nav-media-items">
                    <li class="topic-dropdown hidden-xs hidden-sm">
                        <a href="#"><i class="fa fa-hashtag"></i> {{ trans('general.topics') }} <span class="caret"></span></a>
                        <div class="dropdown-menu">
                            <div class="row">
                                <div class="@if(count($categories) < 9) col-md-12 @else col-md-10 @endif">
                                    @for( $i = 0; $i < 8 && $i < count($categories); $i++ )
                                        <div class="category-image-links">
                                            <div class="cat-bg-img" style="background-image: url({{ jasko_component( '/uploads/' . $categories[$i]->cat_img ) }});"></div>
                                            <a href="{{ route( 'topic', [ 'slug' => $categories[$i]->slug_url ] ) }}">{{ $categories[$i]->name }}</a>
                                        </div>
                                    @endfor
                                </div>
                                @if(count($categories) > 8)
                                    <div class="col-md-2">
                                        <h4>{{ trans('general.more_topics') }}</h4>
                                        <ul class="list-unstyled">
                                            @for($i = 8; $i < count($categories); $i++)
                                                <li><a href="{{ route( 'topic', [ 'slug' => $categories[$i]->slug_url ] ) }}">{{ $categories[$i]->name }}</a></li>
                                            @endfor
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                    @if($settings->canViewPoll == 1)<li><a href="{{ route('polls') }}"><i class="fa fa-check-circle-o"></i> {{ trans('media.polls') }}</a></li>@endif
                    @if($settings->canViewQuiz == 1)<li><a href="{{ route('quizzes') }}"><i class="fa fa-gift"></i> {{ trans('media.quizzes') }}</a></li>@endif
                    @if($settings->canViewImage == 1)<li><a href="{{ route('images') }}"><i class="fa fa-image"></i> {{ trans('media.images') }}</a></li>@endif
                    @if($settings->canViewVideo == 1)<li><a href="{{ route('videos') }}"><i class="fa fa-video-camera"></i> {{ trans('media.videos') }}</a></li>@endif
                    @if($settings->canViewArticles == 1)<li><a href="{{ route('news_media_page') }}"><i class="fa fa-newspaper-o"></i> {{ trans('media.news') }}</a></li>@endif
                    @if($settings->canViewLists == 1)<li><a href="{{ route('lists') }}"><i class="fa fa-list-alt"></i> {{ trans('media.lists') }}</a></li>@endif
                    @if( Auth::check() )
                        @if( show_create($settings) )
                            <li class="visible-xs"><a data-toggle="collapse" data-target="#rocketeer-main-menu" class="openCreateModal"><i class="fa fa-plus"></i> {{ trans('media.create') }}</a></li>
                        @endif
                        @if(Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                            <li class="visible-xs"><a href="{{ route('admin_dashboard') }}"><i class="fa fa-shield"></i> {{ trans('general.admin') }}</a></li>
                        @endif
                        <li class="visible-xs"><a href="{{ route( 'profile', [ 'username' => Auth::user()->username ] ) }}"><i class="fa fa-user"></i> {{ trans('user.my_profile') }}</a></li>
                        <li class="visible-xs"><a href="{{ route('edit_profile') }}"><i class="fa fa-edit"></i> {{ trans('user.edit_profile') }}</a></li>
                        <li class="visible-xs"><a href="#"><i class="fa fa-star"></i> {{ trans('user.points') }}: {{ Auth::user()->points }}</a></li>
                        <li class="visible-xs">
                            <a href="{{ route('notifications') }}">
                                <i class="fa fa-exclamation-circle"></i> {{ trans('user.notifications') }}
                                <span class="badge pull-right">{{ $notification_count }}</span>
                            </a>
                        </li>
                        <li class="visible-xs"><a href="logout"><i class="fa fa-sign-out"></i> {{ trans('user.logout') }}</a></li>
                    @else
                        <li class="visible-xs"><a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> {{ trans('user.register') }}</a></li>
                        <li class="visible-xs"><a href="{{ route('login') }}"><i class="fa fa-star"></i> {{ trans('user.login') }}</a></li>
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right hidden-xs">
                    @if( Auth::check() )
                        @if( show_create($settings) )
                            <li>
                                <button type="button" class="btn btn-sky navbar-btn" data-toggle="modal" data-target="#createModal">
                                    <i class="fa fa-plus"></i> {{ trans('media.create') }}
                                </button>
                            </li>
                        @endif
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->display_name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route( 'profile', [ 'username' => Auth::user()->username ] ) }}"><i class="fa fa-user"></i> {{ trans('user.my_profile') }}</a></li>
                                <li><a href="{{ route('edit_profile') }}"><i class="fa fa-edit"></i> {{ trans('user.edit_profile') }}</a></li>
                                <li><a href="#"><i class="fa fa-star"></i> {{ trans('user.points') }}: {{ Auth::user()->points }}</a></li>
                                <li>
                                    <a href="{{ route('notifications') }}">
                                        <i class="fa fa-exclamation-circle"></i> {{ trans('user.notifications') }}
                                        <span class="badge pull-right">{{ $notification_count }}</span>
                                    </a>
                                </li>
                                @if(Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                                    <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-shield"></i> {{ trans('general.admin') }}</a></li>
                                @endif
                                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> {{ trans('user.logout') }}</a></li>
                            </ul>
                        </li>
                    @else
                        @if($settings->user_registration == 1)
                            <li><a href="{{ route('register') }}" class="btn btn-sky navbar-btn"><i class="fa fa-user-plus"></i> {{ trans('user.register') }}</a></li>
                        @endif
                        <li><a href="{{ route('login') }}" class="btn btn-sky navbar-btn"><i class="fa fa-star"></i> {{ trans('user.login') }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div><!-- /.navbar-collapse -->
</nav>
<nav class="rocketeer-mobile-nav-ctr border-{{ $settings->site_color }}">
    <form class="input-group" method="get" action="{{ route('search') }}">
        <input type="text" class="form-control" name="q" placeholder="Search...">
        <span class="input-group-btn"><button class="btn btn-{{ $settings->site_color }}" type="submit"><i class="fa fa-search"></i></button></span>
    </form><!-- /input-group -->

    <ul class="list-unstyled">
        @foreach($categories as $cat)
            <li class="{{ $settings->site_color }}-hover"><a href="{{ route( 'topic', [ 'slug' => $cat->slug_url ] ) }}">{{ $cat->name }}</a></li>
        @endforeach
        @if($settings->canViewPoll == 1)<li class="{{ $settings->site_color }}-hover"><a href="{{ route('polls') }}">{{ trans('media.polls') }}</a></li>@endif
        @if($settings->canViewQuiz == 1)<li class="{{ $settings->site_color }}-hover"><a href="{{ route('quizzes') }}">{{ trans('media.quizzes') }}</a></li>@endif
        @if($settings->canViewImage == 1)<li class="{{ $settings->site_color }}-hover"><a href="{{ route('images') }}">{{ trans('media.images') }}</a></li>@endif
        @if($settings->canViewVideo == 1)<li class="{{ $settings->site_color }}-hover"><a href="{{ route('videos') }}">{{ trans('media.videos') }}</a></li>@endif
        @if($settings->canViewArticles == 1)<li class="{{ $settings->site_color }}-hover"><a href="{{ route('news_media_page') }}">{{ trans('media.news') }}</a></li>@endif
        @if($settings->canViewLists == 1)<li class="{{ $settings->site_color }}-hover"><a href="{{ route('lists') }}">{{ trans('media.lists') }}</a></li>@endif
        @foreach($pages as $page)
            @if($page->page_type == 3)
                <li><a href="{{ $page->direct_url }}" target="_blank">{{ $page->title }}</a></li>
            @else
                <li><a href="{{ route( 'page', [ 'slug' => $page->slug_url ] ) }}">{{ $page->title }}</a></li>
            @endif
        @endforeach
        @if( Auth::check() )
            @if( show_create($settings) )
                <li class="{{ $settings->site_color }}-hover"><a href="#" class="openCreateModal"><i class="fa fa-plus"></i> {{ trans('media.create') }}</a></li>
            @endif
            @if(Auth::user()->isAdmin == 2 || Auth::user()->isMod == 2)
                <li class="{{ $settings->site_color }}-hover"><a href="{{ route('admin_dashboard') }}"><i class="fa fa-shield"></i> {{ trans('general.admin') }}</a></li>
            @endif
            <li class="{{ $settings->site_color }}-hover"><a href="{{ route( 'profile', [ 'username' => Auth::user()->username ] ) }}"><i class="fa fa-user"></i> {{ trans('user.my_profile') }}</a></li>
            <li class="{{ $settings->site_color }}-hover"><a href="{{ route('edit_profile') }}"><i class="fa fa-edit"></i> {{ trans('user.edit_profile') }}</a></li>
            <li class="{{ $settings->site_color }}-hover">
                <a href="{{ route('notifications') }}">
                    <i class="fa fa-exclamation-circle"></i> {{ trans('user.notifications') }}
                    <span class="badge pull-right">{{ $notification_count }}</span>
                </a>
            </li>
            <li class="{{ $settings->site_color }}-hover"><a href="logout"><i class="fa fa-sign-out"></i> {{ trans('user.logout') }}</a></li>
        @else
            <li class="{{ $settings->site_color }}-hover"><a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> {{ trans('user.register') }}</a></li>
            <li class="{{ $settings->site_color }}-hover"><a href="{{ route('login') }}"><i class="fa fa-star"></i> {{ trans('user.login') }}</a></li>
        @endif
    </ul>
</nav>