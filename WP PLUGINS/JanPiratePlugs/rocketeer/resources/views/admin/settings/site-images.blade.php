@extends( 'admin.layout' )

@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Site Image Settings <small>Update the site image settings here.</small></h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Settings</li>
            <li class="active">Site Images</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                {!! csrf_field() !!}
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#logo_tab" data-toggle="tab">Logo</a></li>
                        <li><a href="#watermark_tab" data-toggle="tab">Watermark</a></li>
                        <li><a href="#nsfw_tab" data-toggle="tab"> NSFW</a></li>
                        <li><a href="#favicon_tab" data-toggle="tab"> Favicon</a></li>
                        <li class="pull-left header"><i class="fa fa-th"></i> Site Images Form</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="logo_tab">
                            <div id="settingsLogoStatus"></div>
                            <form id="settingsLogoForm">
                                <div class="form-group">
                                    <label>Logo Type</label>
                                    <select class="form-control" id="inputLogoType">
                                        <option value="1">Text</option>
                                        <option value="2" {{ $settings->logo_type == 2 ? 'SELECTED' : '' }}>Image</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Logo Image</label>
                                    <input type="file" class="form-control" id="inputLogoImg">
                                </div>
                                <div class="form-group">
                                    @if(!empty($settings->logo_img))
                                        <img src="{{ jasko_component( '/uploads/' . $settings->logo_img )  }}" class="img-responsive" id="logoImgSrc">
                                    @else
                                        <img class="img-responsive" id="logoImgSrc" id="logoImgSrc">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="watermark_tab">
                            <div id="settingsWatermarkStatus"></div>
                            <form id="settingsWatermarkForm">
                                <div class="form-group">
                                    <label>Enable Watermark</label>
                                    <select class="form-control" id="inputEnableWatermark">
                                        <option value="1">No</option>
                                        <option value="2" {{ $settings->watermark_enabled == 2 ? 'SELECTED' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Watermark X Position (px from bottom right)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{ $settings->watermark_x_pos }}" id="inputXPos">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Watermark Y Position (px from bottom right)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{ $settings->watermark_y_pos }}" id="inputYPos">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Watermark Image</label>
                                    <input type="file" class="form-control" id="inputWatermarkImg">
                                </div>
                                <div class="form-group">
                                    @if(!empty($settings->watermark_img_url))
                                        <img src="{{ jasko_component( '/uploads/' . $settings->watermark_img_url ) }}" class="img-responsive" id="watermarkImgSrc">
                                    @else
                                        <img class="img-responsive" id="watermarkImgSrc">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="nsfw_tab">
                            <div id="settingsNSFWStatus"></div>
                            <form id="settingsNSFWForm">
                                <div class="form-group">
                                    <label>NSFW Image</label>
                                    <input type="file" class="form-control" id="inputNSFWImg">
                                </div>
                                <div class="form-group">
                                    @if(!empty($settings->nsfw_img))
                                        <img src="{{ jasko_component('/uploads/' . $settings->nsfw_img) }}" class="img-responsive" id="nsfwImgSrc">
                                    @else
                                        <img class="img-responsive" id="nsfwImgSrc">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="favicon_tab">
                            <div id="settingsFaviconStatus"></div>
                            <form id="settingsFaviconForm">
                                <div class="form-group">
                                    <label>Favicon</label>
                                    <input type="file" class="form-control" id="inputFavicon">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section( 'scripts' )
    <script src="{{ jasko_component('/components/core/admin/js/site-image-settings.js') }}"></script>
@endsection