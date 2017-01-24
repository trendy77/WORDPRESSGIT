<div class="media-post-comments-ctr">
    <h3>{{ trans('media.what_do_you_think') }}</h3>

    <ul class="nav nav-tabs nav-tab-{{ $settings->site_color }}">
        @if($settings->system_comments == 2)
            <li @if($settings->main_comment_system == 1) class="active" @endif><a href="#system_comments" data-toggle="tab">{{ $settings->site_name }} {{ trans('media.comments') }}</a></li>
        @endif
        @if($settings->fb_comments == 2)
            <li @if($settings->main_comment_system == 2) class="active" @endif><a href="#facebook_convo" data-toggle="tab">{{ trans('media.fb_convo') }}</a></li>
        @endif
        @if($settings->disqus_comments == 2)
            <li @if($settings->main_comment_system == 3) class="active" @endif><a href="#disqus" data-toggle="tab">Disqus</a></li>
        @endif
    </ul>
    <div class="tab-content">
        @if($settings->system_comments == 2)
            <div class="tab-pane @if($settings->main_comment_system == 1) active @endif" id="system_comments">
                <form>
                    <input type="hidden" value="{{ $media->id }}" v-model="mid">
                    <div class="input-group">
                        <textarea class="form-control custom-control" rows="3" style="resize:none" v-model="comment_body"></textarea>
                        <span class="input-group-addon btn btn-{{ $settings->site_color }}" v-on:click="add_comment()"><i class="fa fa-paper-plane"></i></span>
                    </div>
                </form>
                {!! csrf_field() !!}
                <div class="comments-ctr">
                    <div class="media" v-for="comment in comments">
                        <div class="media-left">
                            <a href="#"><img class="media-object" src="@{{ comment.img }}"></a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">@{{{ comment.name }}} <span>@{{ comment.time_posted }}</span></h4>
                            @{{{ comment.body }}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($settings->fb_comments == 2)
            <div class="tab-pane @if($settings->main_comment_system == 2) active @endif" id="facebook_convo">
                <div class="fb-comments" data-href="{{ full_media_url($media) }}" data-numposts="8" data-width="100%"></div>
            </div>
        @endif
        @if($settings->disqus_comments == 2)
            <div class="tab-pane @if($settings->main_comment_system == 3) active @endif" id="disqus">
                <div id="disqus_thread"></div>
                <script>
                    /**
                     * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                     * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
                     */
                     var disqus_config          = function () {
                     this.page.url              = '{{ full_media_url($media) }}'; // Replace PAGE_URL with your page's canonical URL variable
                     this.page.identifier       = {{ $media->id }}; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                     };
                    (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document, s = d.createElement('script');

                        s.src = '//{{ $settings->disqus_shortname }}.disqus.com/embed.js';

                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
            </div>
        @endif
    </div>
</div>
<script>
    var comment_fail_i18n                   =   "{!! trans('media.comment_fail') !!}";
</script>