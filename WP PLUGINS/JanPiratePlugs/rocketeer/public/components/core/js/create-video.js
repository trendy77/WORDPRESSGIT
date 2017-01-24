/**
 * Created by jaskokoyn on 11/17/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    $(document).on( "submit", "#createVideoForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">' + processing_message + '</div>');

        var formObj                     =   {
            _token:                             $("input[name=_token]").val(),
            title:                              $("#inputTitle").val(),
            desc:                               $("#inputDesc").val(),
            cid:                                $("#inputCid").val(),
            nsfw:                               $("#inputNSFW").val(),
            video:                              $("#inputVideo").val(),
            page_content:                       CKEDITOR.instances.inputPageContent.getData()
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
                    $("#createVideoForm").slideDown('fast');
                    $("#alertStatus").html('<div class="alert alert-danger">' + unable_submission + ' <ul></ul></div>');
                    response.errors.forEach(function(ele,ind,arr){
                        $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                    });
                }
            });
        });
    });
})(jQuery, window);