/**
 * Created by jaskokoyn on 12/7/2015.
 */
(function($,w){
    $("#basicForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);

        $("#basicAlertStatus").html('<div class="alert alert-info">' + basic_pending + '</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            display_name:               $("#inputDisplayName").val(),
            location:                   $("#inputLocation").val(),
            gender:                     $("#inputGender").val(),
            intro:                      $("#inputIntroText").val(),
            about:                      $("#inputAbout").val(),
            twitter:                    $("#inputTwitter").val(),
            facebook:                   $("#inputFacebook").val(),
            gp:                         $("#inputGP").val(),
            vk:                         $("#inputVK").val(),
            soundcloud:                 $("#inputSoundcloud").val()
        };

        $.post( ajaxurl + "/update-basic-details", formObj).always(function(response){
            $("#basicForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#basicAlertStatus").html('<div class="alert alert-success">' + basic_success + '</div>');
            }else{
                $("#basicAlertStatus").html('<div class="alert alert-danger">' + basic_error + '</div>');
        }
        });
    });

    $(document).on('click', '#uplProfileImgBtn', function(e){
        e.preventDefault();
        $("#inputProfileImg").click();
    });

    $(document).on('change', '#inputProfileImg', function(e){
        e.preventDefault();

        var file                    =   $("#inputProfileImg").prop("files")[0];

        if(!file){
            return null;
        }

        var formData                =   new FormData();
        formData.append( "img", file );
        formData.append( "_token", $("input[name=_token]").val());

        toastr.info(img_uploading);

        $.ajax({
            url : ajaxurl + '/upload-profile-img',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            data: formData,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            if(response.status == 2){
                toastr.success(img_success);
                $("#profileImgTag").attr( 'src', ajaxurl + '/public/uploads/' + response.img );
            }else{
                toastr.error(img_error);
            }
        });
    });

    $(document).on('click', '#uplHeaderImgBtn', function(e){
        e.preventDefault();
        $("#inputHeaderImg").click();
    });

    $(document).on('change', '#inputHeaderImg', function(e){
        e.preventDefault();

        var file                    =   $("#inputHeaderImg").prop("files")[0];

        if(!file){
            return null;
        }

        var formData                =   new FormData();
        formData.append( "img", file );
        formData.append( "_token", $("input[name=_token]").val());

        toastr.info(img_uploading);

        $.ajax({
            url : ajaxurl + '/upload-header-img',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            data: formData,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            if(response.status == 2){
                toastr.success(img_success);
                $("#headerImgTag").attr( 'src', ajaxurl + '/public/uploads/' + response.img );
            }else{
                toastr.error(img_error);
            }
        });
    });

    $("#editPassForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);

        $("#passwordStatus").html('<div class="alert alert-info">' + pass_pending + '</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            pass:                       $("#inputPass1").val(),
            pass_confirmation:          $("#inputPass2").val()
        };

        $.post( ajaxurl + "/update-password", formObj).always(function(response){
            $("#editPassForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#passwordStatus").html('<div class="alert alert-success">' + pass_success + '</div>');
            }else{
                $("#passwordStatus").html('<div class="alert alert-danger">' + pass_error + '</div>');
            }
        });
    });

    $(document).on( 'click', '#subscribeNewsletterBtn', function(e){
        e.preventDefault();

        $("#newsletterStatus").html('<div class="alert alert-info">' + email_sub_pending + '</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val()
        };

        $.post( ajaxurl + "/user-newsletter-subscribe", formObj).always(function(response){
            if(response.status == 2){
                $("#newsletterStatus").html('<div class="alert alert-success">' + email_sub_success + '</div>');
            }else{
                $("#newsletterStatus").html('<div class="alert alert-danger">' + email_sub_error + '</div>');
            }
        });
    });
})(jQuery, window);