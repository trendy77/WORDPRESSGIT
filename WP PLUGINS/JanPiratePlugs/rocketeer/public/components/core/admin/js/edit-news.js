/**
 * Created by jaskokoyn on 12/18/2015.
 */
(function($, w){
    Dropzone.autoDiscover = false;
    CKEDITOR.replace('inputPageContent');

    var vm                              =   new Vue({
        el: '#editMediaApp',
        data: {
            thumbnail: thumbnail,
            main_images: main_images,
            images: user_uploads,
            image_ids: image_ids
        }
    });

    var dpz                             =   new Dropzone("#dpz", {
        url: ajaxurl + "process/upload-media-img",
        previewsContainer: "#dpzImgPreviewCtr",
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
        toastr.error("Unable to upload image. Try again later.", "Uh Oh!");
    });

    dpz.on( "success", function(file, res){
        $(file.previewElement).remove();

        if(res.status == 1){
            toastr.error('Invalid File Upload', 'Uh Oh!');
            return;
        }

        vm.images.push({
            id: res.img.id,
            upl_name: res.img.new_name,
            original_name: res.img.name
        });

        vm.image_ids.push(res.img.id);

        toastr.success("File uploaded!", "Success!");
    });

    $(document).on( "submit", "#mediaForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">Please wait</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            title:                          $("#inputTitle").val(),
            desc:                           $("#inputDesc").val(),
            cid:                            $("#inputCid").val(),
            nsfw:                           $("#inputNSFW").val(),
            page_content:                   CKEDITOR.instances.inputPageContent.getData(),
            status:                         $("#inputMediaStatus").val(),
            thumbnail:                      $("#inputThumbnail").val(),
            image_ids:                      vm.$get("image_ids"),
            main_images:                    vm.$get("main_images")
        };

        $.post( '', formObj).always(function(response){
            console.log(response);

            if(response.status == 2){
                $("#alertStatus").html('<div class="alert alert-success">Successfully updated!</div>');
            }else{
                $("#alertStatus").html('<div class="alert alert-danger">Error! Unable to update news. <ul></ul></div>');
                response.errors.forEach(function(ele,ind,arr){
                    $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                });
            }
        });
    });
})(jQuery, window);