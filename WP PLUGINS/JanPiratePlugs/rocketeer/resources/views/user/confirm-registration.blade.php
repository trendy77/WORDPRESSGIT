@extends( 'layout' )

@section( 'content' )
    <div class="container push-top">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h1 class="text-center">
                            <i class="fa fa-smile-o fa-5x"></i><br>
                            {{ trans( 'user.confirm_email_success' ) }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script>
        setTimeout(function(){
            location.href   =   '{{ route('home') }}';
        }, 10000);
    </script>
@endsection
