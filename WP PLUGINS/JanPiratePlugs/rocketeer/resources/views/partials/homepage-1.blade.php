<div class="media-item-ctr-1" v-for="(ik, iv) in media_items">
    <div class="col-xs-5 col-sm-3">
        <a class="media-item-thumbnail" href="@{{ iv.full_url }}">
            <img v-bind:src="iv.thumbnail" class="img-responsive">
            <div class="media-ribbon"><i class="fa fa-heart"></i> @{{ iv.like_count }}</div>
        </a>
    </div>
    <div class="col-xs-7 col-sm-9 media-item-overview">
        <div class="media-item-cat" style="color: @{{ getCategory(iv.cid).bg_color }};">@{{ getCategory(iv.cid).name }}</div>
        <h3><a href="@{{ iv.full_url }}">@{{{ iv.title }}}</a></h3>
        <p>@{{{ iv.media_desc }}}</p>
        <div class="media-meta-data">
            <a href="@{{ iv.author.profile_url }}">@{{{ iv.author.display_name }}}</a>
            - @{{ iv.diff_for_humans  }}
        </div>
    </div>
    <div class="social-share-ctr hidden-xs">
        <button type="button" class="share-media btn-facebook" v-on:click="shareFB(iv)"><i class="fa fa-facebook"></i></button>
        <button type="button" class="share-media btn-twitter" v-on:click="shareTwitter(iv)"><i class="fa fa-twitter"></i></button>
    </div>
</div>
<div class="clearfix"></div>
<hr>
<button type="button" class="btn btn-block btn-lg center-block btn-border-{{ $settings->site_color }}" v-on:click="getMediaItems">{{ trans('general.load_more') }}</button>