@extends( 'admin.layout' )

@section('content')
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Dashboard <small>An overview of your site.</small></h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> Home</li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active Users</span>
                            <span class="info-box-number">{{ $active_users }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active Media Items</span>
                            <span class="info-box-number">{{ $active_media_items }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-clock-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending Media Items</span>
                            <span class="info-box-number">{{ $pending_media_items }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Likes</span>
                            <span class="info-box-number">{{ $like_count }}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border"><h3 class="box-title">Pending Media Items</h3></div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>Media ID</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Submitted</th>
                                        <td>Actions</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pending_media as $pk => $pv)
                                        <tr>
                                            <td>{{ $pv->id }}</td>
                                            <td>{{ $pv->title }}</td>
                                            <td><span class="label label-warning">{{ strtoupper(get_media_type( $pv->media_type )) }}</span></td>
                                            <td>{{ $pv->author->display_name }}</td>
                                            <td>{{ $pv->cat->name }}</td>
                                            <td>{{ $pv->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('edit' . ucfirst(get_media_type($pv->media_type)), [ 'id' => $pv->id ] ) }}" class="btn btn-info btn-xs"><i class="fa fa-cogs"></i></a>
                                                <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                    <!-- USERS LIST -->
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Latest Members</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding">
                            <ul class="users-list clearfix">
                                @foreach($latest_users as $latest_user)
                                    <li>
                                        <img src="{{ jasko_component('/uploads/' . $latest_user->profile_img)  }}" width="100" height="100">
                                        <a class="users-list-name" href="{{ route('profile', [ 'username' => $latest_user->username ] ) }}">{{ $latest_user->display_name }}</a>
                                        <span class="users-list-date">{{ $latest_user->created_at->diffForHumans() }}</span>
                                    </li>
                                @endforeach
                            </ul><!-- /.users-list -->
                        </div><!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{ route('adminManageUsers') }}" class="uppercase">View All Users</a>
                        </div><!-- /.box-footer -->
                    </div><!--/.box -->
                </div><!-- /.col -->

                <div class="col-md-4">
                    <!-- PRODUCT LIST -->
                    <div class="box box-primary">
                        <div class="box-header with-border"><h3 class="box-title">Recently Approved Media</h3></div>
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                @foreach($approved_media as $ak => $av)
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="{{ jasko_component('/uploads/' . $av->thumbnail) }}" alt="Product Image">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route(get_media_type($av->media_type), [ 'name' => $av->slug_url ] ) }}" class="product-title">{{ $av->title }} <span class="label label-warning pull-right">{{ strtoupper(get_media_type( $av->media_type )) }}</span></a>
                                        <span class="product-description">{{ $av->media_desc }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{ route('adminManageMedia') }}" class="uppercase">View All Media</a>
                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection