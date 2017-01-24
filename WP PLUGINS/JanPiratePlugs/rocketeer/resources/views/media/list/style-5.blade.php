@foreach( $media->content->items as $ik => $iv)
    @if(isset($iv->is_ad))
        <div class="list-item-ctr-5" v-show="{{ $ik }} === current_item" transition="listTrans">
            <div>
                <button type="button" class="btn btn-{{ $settings->site_color }}" v-on:click="prevItem()"
                        v-bind:disabled="current_item === 0"><i class="fa fa-chevron-left"></i></button>
                <button type="button" class="btn btn-{{ $settings->site_color }} pull-right" v-on:click="nextItem()"
                        v-bind:disabled="current_item === {{ count($media->content->items) }}-1"><i class="fa fa-chevron-right"></i></button>
            </div>
            {!! $settings->list_ad !!}
        </div>
    @else
        <div class="list-item-ctr-5" v-show="{{ $ik }} === current_item" transition="listTrans">
            <div>
                <button type="button" class="btn btn-{{ $settings->site_color }}" v-on:click="prevItem()"
                        v-bind:disabled="current_item === 0"><i class="fa fa-chevron-left"></i></button>
                <button type="button" class="btn btn-{{ $settings->site_color }} pull-right" v-on:click="nextItem()"
                        v-bind:disabled="current_item === {{ count($media->content->items) }}-1"><i class="fa fa-chevron-right"></i></button>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="list-item-header list-item-header-{{ $settings->site_color }}">
                        <div class="list-item-num">{{ $ik+1 }}</div>
                        <div class="list-item-title">{{ $iv->title }}</div>
                    </div>
                    @if($iv->media_type == 1)
                        @if(count($iv->images) > 1)
                            <div id="list-carousel-{{ $ik }}" class="carousel slide visible-xs" data-ride="carousel">
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
                                </a>
                                <a class="right carousel-control" href="#list-carousel-{{ $ik }}" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                </a>
                            </div>
                        @else
                            <img src="{{ jasko_component( '/uploads/' . $iv->images[0] ) }}" class="img-responsive visible-xs">
                        @endif
                    @elseif($iv->media_type == 2)
                        <div class="visible-xs">{!! $iv->embed_code !!}</div>
                    @elseif($iv->media_type == 3)
                        <blockquote class="media_blockquote visible-xs">
                            <i class="fa fa-quote-left fa-2x"></i>
                            <i class="fa fa-quote-right fa-2x"></i>
                            <p>{{ $iv->quote }}</p>
                            <small>{{ $iv->quote_src }}</small>
                        </blockquote>
                    @endif
                    <p>{{ $iv->desc }}</p>
                </div>
                <div class="col-sm-6 hidden-xs">
                    @if($iv->media_type == 1)
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
                                </a>
                                <a class="right carousel-control" href="#list-carousel-{{ $ik }}" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                </a>
                            </div>
                        @else
                            <img src="{{ jasko_component( '/uploads/' . $iv->images[0] ) }}" class="img-responsive">
                        @endif
                    @elseif($iv->media_type == 2)
                        {!! $iv->embed_code !!}
                    @elseif($iv->media_type == 3)
                        <blockquote class="media_blockquote">
                            <i class="fa fa-quote-left fa-2x"></i>
                            <i class="fa fa-quote-right fa-2x"></i>
                            <p>{{ $iv->quote }}</p>
                            <small>{{ $iv->quote_src }}</small>
                        </blockquote>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endforeach