@extends( 'layout' )

@section( 'content' )
    <div class="push-top container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <h1 class="text-danger">
                            <i class="fa fa-frown-o fa-5x"></i><br>
                            {{ trans( 'errors.404_header_message' ) }}
                        </h1>
                        <hr>
                        <a href="{{ route('home') }}" class="btn btn-warning text-center">
                            <i class="fa fa-reply"></i> {{ trans('errors.take_back_home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection