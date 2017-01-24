/**
 * Created by jaskokoyn on 12/31/2015.
 */
(function($,w){
    $("#resetForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);

        $("#resetAlertStatus").html('<div class="alert alert-info">' + reset_wait + '</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            pass:                       $("#inputPass1").val(),
            pass_confirmation:          $("#inputPass2").val()
        };

        $.post( '', formObj).always(function(response){
            $("#resetForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#resetAlertStatus").html('<div class="alert alert-success">' + reset_success + '</div>');
            }else{
                $("#resetAlertStatus").html('<div class="alert alert-danger">' + reset_error + '</div>');
            }
        });
    });
})(jQuery, window);