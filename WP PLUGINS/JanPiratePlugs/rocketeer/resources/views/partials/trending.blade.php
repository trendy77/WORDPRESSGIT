<section class="trending">
    <div class="trending-ribbon">
        <a href="#trending"><i class="fa fa-smile-o hidden-xs"></i><p>{{ trans('pages.trending') }}</p></a>
    </div>
    <div id="trending-carousel" class="owl-carousel">
        @foreach($trending_items as $item)
            <div class="trending-item">
                <a href="{{ full_media_url( $item ) }}">
                    <img src="{{ full_media_thumbnail_url( $item ) }}">
                    <div class="trending-item-info">
                        <div class="category" style="background-color: {{ $item->cat->bg_color }};">{{ $item->cat->name }}</div>
                        <div class="title">{{ $item->title }}</div>
                        <div class="meta"><span>{{ $item->author->display_name }}</span> - {{ $item->created_at->diffForHumans() }}</div>
                    </div>
                </a>
            </div>
        @endforeach
        <div class="trending-item"><a href="#"></a></div>
    </div>
    <div class="carousel-options hidden-xs"><i class="fa fa-angle-right"></i></div>
</section>