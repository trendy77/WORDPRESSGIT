@extends( 'admin.layout' )

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="widgetApp">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Widget Settings <small>Update the widget settings settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">Widget</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-7">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Widgets</h3>
                        <button type="button" class="btn btn-primary btn-xs pull-right" v-on:click="addWidget()">
                            <i class="fa fa-plus"></i> Add Widget
                        </button>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        {!! csrf_field() !!}
                        <div v-show="show_alert" class="alert @{{ alert_class }}">@{{ alert_message }}</div>
                        <div class="widget-ctr" v-for="($index, widget) in widgets">
                            @{{ widget.title }}
                            <button type="button" class="pull-right btn btn-xs btn-danger" v-on:click="removeWidget($index)">
                                <i class="fa fa-remove"></i>
                            </button>
                            <button type="button" class="pull-right btn btn-xs btn-info" v-on:click="showEditor($index)">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button type="button" class="pull-right btn btn-xs btn-warning" v-on:click="moveDown($index)">
                                <i class="fa fa-arrow-down"></i>
                            </button>
                            <button type="button" class="pull-right btn btn-xs btn-warning" v-on:click="moveUp($index)">
                                <i class="fa fa-arrow-up"></i>
                            </button>
                        </div>
                        <button type="button" class="btn btn-success" v-on:click="save_widgets()">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-5" v-show="show_editor">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Widget Editor</h3>
                    </div>
                    <div class="box-body">
                        <form>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="widgets[edit_index].title">
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" v-model="widgets[edit_index].type">
                                    <option value="1">Category</option>
                                    <option value="2">HTML</option>
                                    <option value="3">Leaderboard</option>
                                    <option value="4">Trending</option>
                                    <option value="5">Newsletter</option>
                                </select>
                            </div>
                            <div class="form-group" v-show="widgets[edit_index].type == 1">
                                <label>Category</label>
                                <select class="form-control" v-model="widgets[edit_index].category">
                                    <option value="0">----- SELECT A CATEGORY -----</option>
                                    @foreach($categories as $ck => $cv)
                                        <option value="{{ $cv->id }}">{{ $cv->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" v-show="widgets[edit_index].type == 1">
                                <label>Category</label>
                                <input type="number" class="form-control" v-model="widgets[edit_index].category_item_count">
                            </div>
                            <div class="form-group" v-show="widgets[edit_index].type == 2">
                                <label>HTML</label>
                                <textarea class="form-control" v-model="widgets[edit_index].html"></textarea>
                            </div>
                            <div class="form-group" v-show="widgets[edit_index].type == 3">
                                <label>Leaderboard User Count</label>
                                <input type="number" class="form-control" v-model="widgets[edit_index].leaderboard_count">
                            </div>
                            <div class="form-group" v-show="widgets[edit_index].type == 4">
                                <label>Trending Count</label>
                                <input type="number" class="form-control" v-model="widgets[edit_index].trending_count">
                            </div>
                            <div class="form-group" v-show="widgets[edit_index].type == 5">
                                <label>Newsletter Action Call</label>
                                <input type="text" class="form-control" v-model="widgets[edit_index].newsletter_action_call">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" v-on:click="closeEditor()">
                                    <i class="fa fa-save"></i> Save & Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection

@section( 'scripts' )
    <script>
        var widgetsObj          =   {!! json_encode($settings->widgets) !!};
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/admin/js/widget-settings.js') }}"></script>
@endsection