/**
 * Created by jaskokoyn on 12/18/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    $(document).on( "submit", "#mediaForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">Please wait</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            title:                          $("#inputTitle").val(),
            desc:                           $("#inputDesc").val(),
            cid:                            $("#inputCid").val(),
            nsfw:                           $("#inputNSFW").val(),
            type:                           $("#inputVideoType").val(),
            id:                             $("#inputVideoID").val(),
            page_content:                   CKEDITOR.instances.inputPageContent.getData(),
            status:                         $("#inputMediaStatus").val()
        };

        $.post( '', formObj).always(function(response){
            console.log(response);

            if(response.status == 2){
                $("#alertStatus").html('<div class="alert alert-success">Successfully updated!</div>');
            }else{
                $("#alertStatus").html('<div class="alert alert-danger">Error! Unable to update video. <ul></ul></div>');
                response.errors.forEach(function(ele,ind,arr){
                    $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                });
            }
        });
    });
})(jQuery, window);