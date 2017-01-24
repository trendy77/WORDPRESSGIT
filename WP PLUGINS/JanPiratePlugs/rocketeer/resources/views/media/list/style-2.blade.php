@foreach( $media->content->items as $ik => $iv)
    @if(isset($iv->is_ad))
        <div class="list-item-ctr-2">{!! $settings->list_ad !!}</div>
    @else
        <div class="list-item-ctr-2">
            @if($iv->media_type == 1)
                <div class="list-item-header list-item-header-{{ $settings->site_color }}">
                    <div class="list-item-num">{{ $ik+1 }}</div>
                    @if(count($iv->images) > 1)
                        <div id="list-carousel-{{ $ik }}" class="carousel slide" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                @foreach($iv->images as $imgk => $imgv)
                                    <div class="item @if($imgk ===0) active @endif">
                                        <img src="{{ jasko_component( '/uploads/' . $imgv ) }}">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#list-carousel-{{ $ik }}" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#list-carousel-{{ $ik }}" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    @else
                        <img src="{{ jasko_component( '/uploads/' . $iv->images[0] ) }}" class="img-responsive">
                    @endif
                    <div class="list-item-title">{{ $iv->title }}</div>
                </div>
            @elseif($iv->media_type == 2)
                <div class="list-item-header isiFrame list-item-header-{{ $settings->site_color }}">
                    <div class="list-item-num">{{ $ik+1 }}</div>
                    {!! $iv->embed_code !!}
                    <div class="list-item-title">{{ $iv->title }}</div>
                </div>
            @elseif($iv->media_type == 3)
                <div class="list-item-header list-item-header-{{ $settings->site_color }}">
                    <div class="list-item-num">{{ $ik+1 }}</div>
                    <blockquote class="media_blockquote">
                        <i class="fa fa-quote-left fa-2x"></i>
                        <i class="fa fa-quote-right fa-2x"></i>
                        <p>{{ $iv->quote }}</p>
                        <small>{{ $iv->quote_src }}</small>
                    </blockquote>
                    <div class="list-item-title">{{ $iv->title }}</div>
                </div>
            @endif
            <p>{{ $iv->desc }}</p>
        </div>
    @endif
@endforeach