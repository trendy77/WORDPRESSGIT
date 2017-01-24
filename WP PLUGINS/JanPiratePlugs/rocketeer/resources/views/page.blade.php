@extends( 'layout' )

@section( 'content' )
    <div class="push-top container" id="homeApp">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-body">
                    <h1>{{ $page->title }}</h1>

                    @if($page->page_type == 2)
                        <p>{!! trans('email.contact_general') !!}</p>
                        <div id="alertStatus"></div>
                        <form id="contactForm">
                            {!! csrf_field() !!}
                            <input type="hidden" value="{{ $page->id }}" id="inputPID">
                            <div class="form-group">
                                <label>{!! trans('email.contact_subject') !!}</label>
                                <input type="text" class="form-control" id="inputSubject">
                            </div>
                            <div class="form-group">
                                <label>{!! trans('email.contact_description') !!}</label>
                                <textarea class="form-control" id="inputDesc"></textarea>
                            </div>
                            <div class="form-group">
                                <label>{!! trans('email.contact_name') !!}</label>
                                <input type="text" class="form-control" id="inputName">
                            </div>
                            <div class="form-group">
                                <label>{!! trans('email.contact_email') !!}</label>
                                <input type="text" class="form-control" id="inputEmail">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{!! trans('email.contact_submit') !!}</button>
                            </div>
                        </form>
                        @else
                        {!! $page->page_content !!}
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section( 'scripts' )
    <script>
        var contact_pending                 =   "{!! trans('email.contact_pending') !!}";
        var contact_success                 =   "{!! trans('email.contact_success') !!}";
        var contact_error                   =   "{!! trans('email.contact_error') !!}";
    </script>
    <script src="{{ jasko_component('/components/core/js/contact.min.js') }}"></script>
@endsection