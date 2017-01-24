/**
 * Created by jaskokoyn on 11/17/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    $(document).on( 'click', '#uplImgBtn', function(e){
        e.preventDefault();
        $("#inputImgSrc").click();
    });

    $(document).on( 'change', '#inputImgSrc', function(e){
        e.preventDefault();

        var file                    =   $(this).prop('files')[0];

        if(!file){
            return null;
        }


        var reader                  =   new FileReader();

        reader.onload = function (e) {
            $("#imgPreviewSrc").attr( 'src', e.target.result );
        };

        reader.readAsDataURL(file);
    });

    $(document).on( "submit", "#createImageForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">' + processing_message + '</div>');

        var formData                    =   new FormData();
        formData.append( "_token", $("input[name=_token]").val() );
        formData.append( "title", $("#inputTitle").val() );
        formData.append( "desc", $("#inputDesc").val() );
        formData.append( "cid", $("#inputCid").val() );
        formData.append( "nsfw", $("#inputNSFW").val() );
        formData.append( "page_content", CKEDITOR.instances.inputPageContent.getData() );
        formData.append( "img", $("#inputImgSrc").prop('files')[0] );

        $(this).slideUp('fast', function(){
            $.ajax({
                url : '',
                type: 'POST',
                data: formData,
                cache : false,
                contentType: false,
                processData: false
            }).always(function(response) {
                console.log(response);

                if(response.status == 2){
                    if(response.is_approved == 2){
                        $("#alertStatus").html('<div class="alert alert-success">' + success_message + '</div>');
                        location.href           =   response.url;
                    }else{
                        $("#alertStatus").html('<div class="alert alert-success">' + pending_success_message + '</div>');
                    }
                }else{
                    $("#createImageForm").slideDown('fast');
                    $("#alertStatus").html('<div class="alert alert-danger">' + unable_submission + ' <ul></ul></div>');
                    response.errors.forEach(function(ele,ind,arr){
                        $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                    });
                }
            });
        });
    });
})(jQuery, window);