@extends( 'layout' )

@section( 'content' )
    <div class="push-top container" id="homeApp">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h1>{{ trans('user.notifications') }}</h1>
                            <ul class="list-group">
                                @foreach($notifications as $nk => $nv)
                                    <li class="list-group-item">
                                        {!! $nv->message !!}
                                        <span class="pull-right">{{ $nv->created_at->diffForHumans() }}</span>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                        <div class="col-md-4 gray-border-left hidden-xs">
                            @include( 'partials.sidebar' )
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection