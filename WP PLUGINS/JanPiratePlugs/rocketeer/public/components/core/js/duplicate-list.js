/**
 * Created by jaskokoyn on 2/1/2016.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    var vm                              =   new Vue({
        el: '#createListForm',
        data: {
            thumbnail: thumbnail,
            list_items: mediaObj.items,
            list_item_index: 0,
            images: user_uploads,
            image_ids: image_ids
        },
        methods: {
            addItem: function(event){
                event.preventDefault();
                this.list_items.push({
                    title: 'List Item',
                    desc: null,
                    media_type: 1,
                    images: [],
                    yt_url: null,
                    vine_url: null,
                    vimeo_url: null,
                    soundcloud_url: null,
                    facebook_url: null,
                    tweet: null,
                    instagram_url: null,
                    quote: null,
                    quote_src: null
                });
            },
            updateItemIndex: function(index, event){
                event.preventDefault();
                this.list_item_index    =   index;
            }
        }
    });

    var dpz                             =   new Dropzone("#imgDropzone", {
        url: ajaxurl + "/process/upload-media-img",
        previewsContainer: "#imgPreviewCtr",
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

    $(document).on( "submit", "#createListForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">' + processing_message + '</div>');

        var formObj                     =   {
            _token:                             $("input[name=_token]").val(),
            title:                              $("#inputTitle").val(),
            desc:                               $("#inputDesc").val(),
            cid:                                $("#inputCid").val(),
            nsfw:                               $("#inputNSFW").val(),
            thumbnail:                          $("#inputThumbnail").val(),
            list_style:                         $("#inputListStyle").val(),
            animation:                          $("#inputAnimation").val(),
            list_items:                         vm.$get("list_items"),
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
                    $("#createListForm").slideDown('fast');
                    $("#alertStatus").html('<div class="alert alert-danger">' + unable_submission + ' <ul></ul></div>');
                    response.errors.forEach(function(ele,ind,arr){
                        $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                    });
                }
            });
        });
    });
})(jQuery, window);