/**
 * Created by jaskokoyn on 11/17/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    var vm                              =   new Vue({
        el: '#createNewsForm',
        data: {
            images: [],
            image_ids: []
        }
    });

    var dpz                             =   new Dropzone("#questionDropzone", {
        url: ajaxurl + "/process/upload-media-img",
        previewsContainer: "#questionImgPreviewCtr",
        acceptedFiles: 'image/*',
        paramName: 'img',
        previewTemplate: '<div class="dz-preview dz-file-preview">' +
        '<div class="dz-details">' +
        '<div class="dz-filename"><span data-dz-name></span></div>' +
        '<div class="progress">' +
        '<div class="progress-bar progress-bar-info progress-bar-striped active" data-dz-uploadprogress>' +
        '</div>' +
        '</div>' +
        '</div>'
    });

    dpz.on( "sending", function(file, xhr, formData){
        formData.append( '_token', $("input[name=_token]").val() );
    });

    dpz.on( "error", function(file, errorMessage, xhr ){
        console.log(errorMessage, xhr);
        toastr.error(img_upload_error_message);
    });

    dpz.on( "success", function(file, res){
        $(file.previewElement).remove();

        if(res.status == 1){
            toastr.error(img_upload_error_message);
            return;
        }

        vm.images.push({
            id: res.img.id,
            name: res.img.name
        });

        vm.image_ids.push(res.img.id);
        toastr.success(file_upload_success, simple_success_message);
    });

    $(document).on( "submit", "#createNewsForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">' + processing_message + '</div>');

        var formObj                     =   {
            _token:                             $("input[name=_token]").val(),
            title:                              $("#inputTitle").val(),
            desc:                               $("#inputDesc").val(),
            cid:                                $("#inputCid").val(),
            nsfw:                               $("#inputNSFW").val(),
            thumbnail:                          $("#inputThumbnail").val(),
            images:                             $("#inputMainImg").val(),
            page_content:                       CKEDITOR.instances.inputPageContent.getData(),
            image_ids:                          vm.$get("image_ids")
        };

        console.log(formObj);

        $(this).slideUp('fast', function(){
            $.post( '', formObj).always(function(response){
                console.log(response);

                if(response.status == 2){
                    if(response.is_approved == 2){
                        $("#alertStatus").html('<div class="alert alert-success">' + success_message + '</div>');
                        location.href           =   response.url;
                    }else{
                        $("#alertStatus").html('<div class="alert alert-success">' + pending_success_message + '</div>');
                    }
                }else{
                    $("#createNewsForm").slideDown('fast');
                    $("#alertStatus").html('<div class="alert alert-danger">' + unable_submission + ' <ul></ul></div>');
                    response.errors.forEach(function(ele,ind,arr){
                        $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                    });
                }
            });
        });
    });
})(jQuery, window);