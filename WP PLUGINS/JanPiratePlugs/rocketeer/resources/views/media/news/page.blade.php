@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media-post-ctr">
                            @include( 'media.header' )

                            @if(count($media->content) > 1)
                                <div id="article-carousel" class="carousel slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">
                                        @foreach($media->content as $ik => $iv)
                                            <div class="item @if($ik ===0) active @endif">
                                                <img src="{{ jasko_component( '/uploads/' . $iv ) }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#article-carousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    </a>
                                    <a class="right carousel-control" href="#article-carousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    </a>
                                </div>
                            @else
                                <img src="{{ jasko_component( '/uploads/' . $media->content[0] ) }}" class="img-responsive">
                            @endif


                            <div class="media-page-content">{!! $media->page_content !!} </div>

                            @include( 'media.additional-media' )

                            @include( 'media.comments' )
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-xs">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include( 'partials.sidebar' )
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script async defer src="//platform.instagram.com/en_US/embeds.js"></script>
    <script src="//platform.vine.co/static/scripts/embed.js"></script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/js/comments.min.js') }}"></script>
@endsection