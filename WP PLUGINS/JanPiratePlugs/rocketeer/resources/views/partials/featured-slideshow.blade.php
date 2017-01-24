@if(count($slides) > 0)
    <div class="featured-slider">
        <div class="flexslider">
            <ul class="slides">
                @for($i = 0; ($i*5) < count($slides); $i++)
                <li>
                    @for($k = $i * 5; $k < ($i*5+5) && $k < count($slides); $k++)
                    <a href="{{ full_media_url($slides[$k]) }}" class="featured-item">
                        <img src="{{ featured_media_img_url($slides[$k]) }}">
                        <div class="featured-cover"></div>
                        <div class="featured-item-details">
                            <div class="category" style="background-color: {{ $slides[$k]->cat->bg_color }};">{{ $slides[$k]->cat->name }}</div>
                            <h2>{{ $slides[$k]->title }}</h2>
                            <div class="featured-item-time"><i class="fa fa-clock-o"></i> {{ $slides[$k]->created_at->diffForHumans() }}</div>
                        </div>
                    </a>
                    @endfor
                </li>
                @endfor
            </ul>
        </div>
        <button type="button" class="btn-slider-nav btn-prev {{ $settings->site_color }}-hover"><i class="fa fa-angle-left"></i></button>
        <button type="button" class="btn-slider-nav btn-next {{ $settings->site_color }}-hover"><i class="fa fa-angle-right"></i></button>
    </div>
@endif