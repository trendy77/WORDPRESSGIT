@extends( 'admin.layout' )

@section('content')
    <div class="content-wrapper" id="editMediaApp">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Edit User <small>Edit any user here.</small></h1>
            <ol class="breadcrumb">
                <li>Home</li>
                <li>Media</li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form id="userForm">
                        {!! csrf_field() !!}
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                                <li class="active"><a href="#basic_tab" data-toggle="tab">Basic</a></li>
                                <li class="pull-left header"><i class="fa fa-th"></i> Edit User Form</li>
                            </ul>
                            <div class="tab-content">
                                <div id="alertStatus"></div>
                                <div class="tab-pane active" id="basic_tab">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" value="{{ $edit_user->username }}" id="inputUsername">
                                    </div>
                                    <div class="form-group">
                                        <label>Display Name</label>
                                        <input type="text" class="form-control" value="{{ $edit_user->display_name }}" id="inputDisplayName">
                                    </div>
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select class="form-control" id="inputLocation">
                                            <option value="">----- SELECT COUNTRY -----</option>
                                            @foreach($countries as $code => $country)
                                                <option value="{{$code}}" {{ $edit_user->location == $code ? 'SELECTED': '' }}>{{$country}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" id="inputGender">
                                            <option value="0">None</option>
                                            <option value="1" {{ $edit_user->gender == 2 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $edit_user->gender == 3 ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>About</label>
                                        <textarea class="form-control" id="inputAbout">{{ $edit_user->about }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Mod</label>
                                        <select class="form-control" id="inputIsMod">
                                            <option value="1">No</option>
                                            <option value="2" {{ $edit_user->isMod == 2 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Auto Approve Media Items</label>
                                        <select class="form-control" id="inputAutoapprove">
                                            <option value="1">No</option>
                                            <option value="2" {{ $edit_user->autoapprove == 2 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Confirmed</label>
                                        <select class="form-control" id="inputEmailConfirmed">
                                            <option value="1">No</option>
                                            <option value="2" {{ $edit_user->email_confirmed == 2 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/edit-user.js') }}"></script>
@endsection