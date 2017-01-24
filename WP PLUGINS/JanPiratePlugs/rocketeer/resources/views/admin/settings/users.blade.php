@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>User Settings <small>Update the user settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Settings Form</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="settingsStatus"></div>
                        <form id="settingsForm">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Registration</label>
                                <select class="form-control" id="inputRegistration">
                                    <option value="1">Enable</option>
                                    <option value="2" {{ $settings->user_registration == 2 ? 'SELECTED' : '' }}>Disable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Confirm Registration</label>
                                <select class="form-control" id="inputConfirmRegistration">
                                    <option value="1">No</option>
                                    <option value="2" {{ $settings->confirm_registration == 2 ? 'SELECTED' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Max Profile Image Size (mb)</label>
                                <input type="text" class="form-control" value="{{ $settings->profile_img_size }}" id="inputMaxProfileImgSize">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/user-settings.js') }}"></script>
@endsection