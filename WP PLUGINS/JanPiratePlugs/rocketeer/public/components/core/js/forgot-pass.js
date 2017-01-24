/**
 * Created by jaskokoyn on 12/30/2015.
 */
(function($,w){
    $("#forgotForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);

        $("#forgotAlertStatus").html('<div class="alert alert-info">' + forgot_wait + '</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            email:                      $("#inputEmail").val()
        };

        $.post( '', formObj).always(function(response){
            $("#forgotForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#forgotAlertStatus").html('<div class="alert alert-success">' + forgot_success + '</div>');
            }else{
                $("#forgotAlertStatus").html('<div class="alert alert-danger">' + forgot_error + '</div>');
            }
        });
    });
})(jQuery, window);