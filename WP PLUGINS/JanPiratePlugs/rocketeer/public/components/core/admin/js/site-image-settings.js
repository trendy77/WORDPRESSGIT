/**
 * Created by jaskokoyn on 11/11/2015.
 */
(function($, w){
    // Logo
    $("#inputLogoImg").on('change', function($e){
        $e.preventDefault();

        var file                =   $(this).prop('files')[0];

        if(!file){
            return null;
        }

        var reader              =   new FileReader();

        reader.onload           =   function(e){
            $("#logoImgSrc").attr( 'src', e.target.result );
        };

        reader.readAsDataURL(file);
    });

    $("#settingsLogoForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsLogoStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   new FormData();
        var file                        =   $("#inputLogoImg").prop('files')[0];

        formObj.append( 'logo_type', $("#inputLogoType").val() );
        if(file){
            formObj.append( 'logo_img', file );
        }

        $.ajax({
            url : ajaxurl + 'settings/logo',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
            },
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            $("#settingsLogoForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsLogoStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsLogoStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });

    // Watermark
    $("#inputWatermarkImg").on('change', function($e){
        $e.preventDefault();

        var file                =   $(this).prop('files')[0];

        if(!file){
            return null;
        }

        var reader              =   new FileReader();

        reader.onload           =   function(e){
            $("#watermarkImgSrc").attr( 'src', e.target.result );
        };

        reader.readAsDataURL(file);
    });

    $("#settingsWatermarkForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsWatermarkStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   new FormData();
        var file                        =   $("#inputWatermarkImg").prop('files')[0];

        formObj.append( 'enable_watermark', $("#inputEnableWatermark").val() );
        formObj.append( 'x_pos', $("#inputXPos").val() );
        formObj.append( 'y_pos', $("#inputYPos").val() );

        if(file){
            formObj.append( 'watermark_img', file );
        }

        $.ajax({
            url : ajaxurl + 'settings/watermark',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
            },
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            $("#settingsWatermarkForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsWatermarkStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsWatermarkStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });

    // NSFW
    $("#inputNSFWImg").on('change', function($e){
        $e.preventDefault();

        var file                =   $(this).prop('files')[0];

        if(!file){
            return null;
        }

        var reader              =   new FileReader();

        reader.onload           =   function(e){
            $("#nsfwImgSrc").attr( 'src', e.target.result );
        };

        reader.readAsDataURL(file);
    });

    $("#settingsNSFWForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsNSFWStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   new FormData();
        var file                        =   $("#inputNSFWImg").prop('files')[0];

        if(file){
            formObj.append( 'nsfw_img', file );
        }

        $.ajax({
            url : ajaxurl + 'settings/nsfw',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            $("#settingsNSFWForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsNSFWStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsNSFWStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });

    // Favicon
    $("#settingsFaviconForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsFaviconStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   new FormData();
        var file                        =   $("#inputFavicon").prop('files')[0];

        if(file){
            formObj.append( 'favicon', file );
        }

        $.ajax({
            url : ajaxurl + 'settings/favicon',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            $("#settingsFaviconForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsFaviconStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsFaviconStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);