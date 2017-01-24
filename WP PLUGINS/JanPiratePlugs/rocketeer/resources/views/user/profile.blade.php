@extends( 'layout' )

@section( 'content' )
    <div class="container push-top" id="profileApp">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="profileHeader" style="background-image: url({{ jasko_component( '/uploads/' . $user->header_img) }});">
                            <div class="profileHeaderOverlay"></div>
                            <img class="img-circle border-{{ $settings->site_color }}" src="{{ jasko_component( '/uploads/' . $user->profile_img ) }}">
                            <div class="profileHeaderInfo">
                                <h3>{{ $user->display_name }}</h3>
                                <p>{{ $user->intro_text }}</p>
                                <div class="profileHeaderBasicDetails">
                                    @if(!empty($user->location))
                                        <img src="{{ jasko_component( '/components/flags/' . strtolower($user->location) . '.png' ) }}">
                                    @endif
                                    @if($user->gender == 2)
                                        <span>{{ trans('user.male') }} &#9679;</span>
                                    @elseif($user->gender == 3)
                                        <span>{{ trans('user.female') }} &#9679;</span>
                                    @endif
                                    <span>{{ trans('user.joined') }} {{ $user->created_at->diffForHumans() }} &#9679; </span>
                                    <span>{{ trans('user.points') }}: {{ $user->points }}</span>
                                    <div class="profileSocialIcons">
                                        @if(!empty($user->twitter))<a href="http://twitter.com/{{ $user->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>@endif
                                        @if(!empty($user->facebook))<a href="http://facebook.com/{{ $user->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>@endif
                                        @if(!empty($user->gplus))<a href="http://plus.google.com/{{ $user->gplus }}" target="_blank"><i class="fa fa-google-plus"></i></a>@endif
                                        @if(!empty($user->vk))<a href="http://vk.com/{{ $user->vk }}" target="_blank"><i class="fa fa-vk"></i></a>@endif
                                        @if(!empty($user->soundcloud))<a href="http://soundcloud.com/{{ $user->soundcloud }}" target="_blank"><i class="fa fa-soundcloud"></i></a>@endif
                                    </div>
                                    <button type="button" class="btn btn-sm"
                                            v-bind:class="{ 'btn-success': following, 'btn-{{ $settings->site_color }}': !following }"
                                            v-on:click="toggleFollow( '{{ csrf_token() }}', '{{ $user->id }}', $event )">
                                        <i class="fa" v-bind:class="{ 'fa-check': following, 'fa-circle-o': !following }"></i>
                                        @{{ following ? 'Following' : 'Follow' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row push-top">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs nav-tab-{{ $settings->site_color }}">
                                    <li class="active"><a href="#liked_posts" data-toggle="tab">{{ trans('user.posts_i_like') }}</a></li>
                                    <li><a href="#created_posts" data-toggle="tab">{{ trans('user.submitted') }}</a></li>
                                    <li><a href="#badges" data-toggle="tab">{{ trans('badge.badges') }}</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="liked_posts">
                                        <div class="row">
                                            <div class="col-sm-6 two-column-clear" v-for="(ik, iv) in liked_media_items">
                                                <div class="media-item-ctr-2">
                                                    <a class="media-item-thumbnail" href="@{{ iv.full_url }}">
                                                        <img src="@{{ iv.thumbnail }}" class="img-responsive">
                                                        <div class="media-ribbon"><i class="fa fa-heart"></i> @{{ iv.like_count }}</div>
                                                    </a>
                                                    <div class="media-item-overview">
                                                        <h3><a href="@{{ iv.full_url }}">@{{{ iv.title }}}</a></h3>
                                                        <div class="media-meta-data">@{{ iv.author.display_name }} - @{{ iv.diff_for_humans }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="created_posts">
                                        <div class="row">
                                            <div class="col-sm-6 two-column-clear" v-for="(ik, iv) in created_media_items">
                                                <div class="media-item-ctr-2">
                                                    <a class="media-item-thumbnail" href="@{{ iv.full_url }}">
                                                        <img src="@{{ iv.thumbnail }}" class="img-responsive">
                                                        <div class="media-ribbon"><i class="fa fa-heart"></i> @{{ iv.like_count }}</div>
                                                    </a>
                                                    <div class="media-item-overview">
                                                        <h3><a href="@{{ iv.full_url }}">@{{{ iv.title }}}</a></h3>
                                                        <div class="media-meta-data">@{{ iv.author.display_name }} - @{{ iv.diff_for_humans }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="badges">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td></td>
                                                <td>Name</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user_badges as $badge)
                                                <tr>
                                                    <td><img src="{{ jasko_component('/uploads/' . $badge->img) }}" style="width:100px;"></td>
                                                    <td><strong>{{ $badge->title }}</strong></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 hidden-xs">
                                <h3 class="ribbon-header ribbon-{{ $settings->site_color }}">{{ trans('user.about_me') }}</h3>
                                @if(empty($user->about))
                                    <p class="text-center"><small><em>{{ trans('user.no_bio') }}</em></small></p>
                                @else
                                    <p>{{ $user->about }}</p>
                                @endif

                                <h3 class="ribbon-header ribbon-{{ $settings->site_color }}">{{ trans('user.followers') }} <em>({{ $user_sub_count }})</em></h3>

                                <div class="followers-preview">
                                    @foreach($users_subbed as $sk => $sv)
                                        <a href="{{ route( 'profile', [ 'username' => $sv->subscriber->username ]) }}"><img src="{{ jasko_component('/uploads/' . $sv->subscriber->profile_img)  }}"></a>
                                    @endforeach
                                </div>

                                <div class="clearfix"></div>

                                <h3 class="ribbon-header ribbon-{{ $settings->site_color }}">{{ trans('user.following') }} <em>({{ $user_follow_count }})</em></h3>

                                <div class="followers-preview">
                                    @foreach($users_following as $fk => $fv)
                                        <a href="{{ route( 'profile', [ 'username' => $fv->following->username ]) }}"><img src="{{ jasko_component( '/uploads/' . $fv->following->profile_img ) }}"></a>
                                    @endforeach
                                </div>

                                <div class="clearfix"></div>

                                {!! $settings->sidebar_ad !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script>
        var follow_fail_i18n    =   "{!! trans('user.follow_fail') !!}";
        var profile_id          =   {{ $user->id }};
        var following           =   {!! $following ? 1 : 0 !!};
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/js/profile.min.js') }}"></script>
@endsection
