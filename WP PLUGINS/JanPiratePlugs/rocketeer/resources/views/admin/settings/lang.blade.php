@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="settingsApp">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Language Settings <small>Update the language settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">Language</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form id="settingsForm">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#basic_tab" data-toggle="tab">Basic</a></li>
                            <li><a href="#lang_tab" data-toggle="tab">Languages</a></li>
                            <li class="pull-left header"><i class="fa fa-th"></i> Language Settings Form</li>
                        </ul>
                        <div class="tab-content">
                            <div id="settingsStatus"></div>
                            <div class="tab-pane active" id="basic_tab">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Default Language</label>
                                    <input type="text" class="form-control" value="{{ $settings->default_lang }}" id="inputLang">
                                </div>
                                <div class="form-group">
                                    <label>Language Switcher</label>
                                    <select class="form-control" id="inputLangSwitcher">
                                        <option value="1">Disable</option>
                                        <option value="2" {{ $settings->lang_switcher == 2 ? 'SELECTED' : '' }}>Enable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Language Switcher Location</label>
                                    <select class="form-control" id="inputLangSwitcherLoc">
                                        <option value="1">None</option>
                                        <option value="2" {{ $settings->lang_switcher_loc == 2 ? 'SELECTED' : '' }}>Header</option>
                                        <option value="3" {{ $settings->lang_switcher_loc == 3 ? 'SELECTED' : '' }}>Footer</option>
                                        <option value="4" {{ $settings->lang_switcher_loc == 4 ? 'SELECTED' : '' }}>Both</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane" id="lang_tab">
                                <button type="button" class="btn btn-warning pull-right" v-on:click="addLang">
                                    <i class="fa fa-plus"></i> Add Language
                                </button>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="form-horizontal">
                                    <div class="form-group" v-for="lang in langs">
                                        <label class="col-sm-2 control-label">Locale</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" v-model="lang.locale">
                                        </div>
                                        <label class="col-sm-2 control-label">Readable Name</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" v-model="lang.readable_name">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-danger btn-sm" v-on:click="removeLang($index)"><i class="fa fa-remove"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Update
                                </button>
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
    <script>
        var languages                       =   {!! json_encode($settings->languages) !!};
    </script>
    <script src="//cdn.jsdelivr.net/vue/1.0.15/vue.min.js"></script>
    <script src="{{ jasko_component('/components/core/admin/js/lang-settings.js') }}"></script>
@endsection