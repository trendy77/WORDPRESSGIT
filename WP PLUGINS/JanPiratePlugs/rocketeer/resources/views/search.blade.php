@extends( 'layout' )

@section( 'content' )
    <div class="push-top container" id="searchApp">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="montserrat">
                                {{ trans('general.search_results_for') }} <span class="text-{{ $settings->site_color }}">{{ $search_term }}</span>
                            </h2>
                            <form method="get" action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" value="{{ $search_term }}" placeholder="Refine Results">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div><!-- /input-group -->
                            </form>
                            <div class="media-item-ctr-1" v-for="(ik, iv) in media_items">
                                <div class="col-xs-5 col-sm-3">
                                    <a class="media-item-thumbnail" href="@{{ iv.full_url }}">
                                        <img src="{{ url('/public/uploads/') }}/@{{ iv.thumbnail }}" class="img-responsive">
                                        <div class="media-ribbon"><i class="fa fa-heart"></i> @{{ iv.like_count }}</div>
                                    </a>
                                </div>
                                <div class="col-xs-7 col-sm-9 media-item-overview">
                                    <div class="media-item-cat" style="color: @{{ getCategory(iv.cid).bg_color }};">@{{ getCategory(iv.cid).name }}</div>
                                    <h3><a href="@{{ iv.full_url }}">@{{{ iv.title }}}</a></h3>
                                    <p>@{{{ iv.media_desc }}}</p>
                                    <div class="media-meta-data">
                                        <a href="@{{ iv.author.profile_url }}">@{{ iv.author.display_name }}</a> - @{{ iv.diff_for_humans }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 hidden-xs">
                            @include( 'partials.sidebar' )
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script>
        var media_items     =   {!! json_encode($media_items) !!};
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/js/search.min.js') }}"></script>
@endsection