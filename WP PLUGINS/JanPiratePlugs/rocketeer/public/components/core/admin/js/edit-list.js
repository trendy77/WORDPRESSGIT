/**
 * Created by jaskokoyn on 12/18/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    var vm                              =   new Vue({
        el: '#editMediaApp',
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
                    embed_url: null,
                    embed_code: null,
                    quote: null,
                    quote_src: null
                });
            },
            removeItem: function(index, $event){
                $event.preventDefault();

                if(!confirm( "Are you sure you want to do this? This action can not be undone." )){
                    return null;
                }

                this.list_items.splice(index, 1);
            },
            updateItemIndex: function(index, event){
                event.preventDefault();
                this.list_item_index    =   index;
            }
        }
    });

    var dpz                             =   new Dropzone("#dpz", {
        url: ajaxurl + "/process/upload-media-img",
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
    });

    dpz.on( "success", function(file, res){
        $(file.previewElement).remove();

        if(res.status == 1){
            toastr.error('Invalid File Upload', 'Uh Oh!');
            return;
        }

        vm.images.push({
            id: res.img.id,
            name: res.img.name
        });

        vm.image_ids.push(res.img.id);
    });

    $(document).on( "submit", "#mediaForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">Please wait</div>');

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
            status:                             $("#inputMediaStatus").val(),
            image_ids:                          vm.$get("image_ids")
        };

        console.log(formObj);

        $.post( '', formObj).always(function(response){
            console.log(response);

            if(response.status == 2){
                $("#alertStatus").html('<div class="alert alert-success">Successfully updated!</div>');
            }else{
                $("#alertStatus").html('<div class="alert alert-danger">Error! Unable to update list. <ul></ul></div>');
                response.errors.forEach(function(ele,ind,arr){
                    $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                });
            }
        });
    });
})(jQuery, window);