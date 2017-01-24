/**
 * Created by jaskokoyn on 11/11/2015.
 */
(function($, w){
    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            registration:                   $("#inputRegistration").val(),
            confirm_reg:                    $("#inputConfirmRegistration").val(),
            profile_img_size:               $("#inputMaxProfileImgSize").val()
        };

        $.post( '', formObj).always(function(response){
            console.log(response);

            $("#settingsForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);