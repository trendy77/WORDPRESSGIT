<div class="row">
    <div class="col-sm-4  col-xs-6 three-column-clear" v-for="(ik, iv) in media_items">
        <div class="media-item-ctr-2">
            <a class="media-item-thumbnail" href="@{{ iv.full_url }}">
                <img v-bind:src="iv.thumbnail"  class="img-responsive">
                <div class="media-ribbon"><i class="fa fa-heart"></i> @{{ iv.like_count }}</div>
            </a>
            <div class="media-item-overview">
                <h3><a href="@{{ iv.full_url }}">@{{{ iv.title }}}</a></h3>
                <div class="media-meta-data hidden-xs"><a href="@{{ iv.author.profile_url }}">@{{{ iv.author.display_name }}}</a> - @{{ iv.diff_for_humans }} }} {{ trans('general.ago') }}</div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<hr>
<button type="button" class="btn btn-block btn-lg center-block btn-border-{{ $settings->site_color }}" v-on:click="getMediaItems">{{ trans('general.load_more') }}</button>