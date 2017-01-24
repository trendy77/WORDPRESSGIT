/**
 * Created by jaskokoyn on 11/14/2015.
 */
(function($, w){
    $("#loginForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#loginStatus").html('<div class="alert alert-info text-center"><strong>' + login_wait + '</strong></div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            username:                       $("#inputUsername").val(),
            pass:                           $("#inputPassword").val()
        };

        $.post( '', formObj).always(function(response){
            $("#loginForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#loginStatus").html('<div class="alert alert-success text-center"><strong>' + login_success + '</strong></div>');
                location.reload();
            }else{
                $("#loginStatus").html('<div class="alert alert-warning text-center">' + login_error + ' <ul></ul></div>');
                response.errors.forEach(function(ele,ind,arr){
                    $("#loginStatus").find("ul").append("<li>" + ele + "</li>");
                });
            }
        });
    });
})(jQuery, window);