/**
 * Created by jaskokoyn on 12/19/2015.
 */
(function($, w){
    $(document).on( "submit", "#userForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">Please wait</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            username:                          $("#inputUsername").val(),
            display_name:                           $("#inputDisplayName").val(),
            location:                            $("#inputLocation").val(),
            gender:                           $("#inputGender").val(),
            about:                         $("#inputAbout").val(),
            is_mod:                     $("#inputIsMod").val(),
            autoapprove:                  $("#inputAutoapprove").val(),
            email_confirmed:            $("#inputEmailConfirmed").val()
        };

        $.post( '', formObj).always(function(response){
            console.log(response);

            if(response.status == 2){
                $("#alertStatus").html('<div class="alert alert-success">Successfully updated!</div>');
            }else{
                $("#alertStatus").html('<div class="alert alert-danger">Error! Unable to update user. <ul></ul></div>');
                response.errors.forEach(function(ele,ind,arr){
                    $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                });
            }
        });
    });
})(jQuery, window);