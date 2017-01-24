/**
 * Created by jaskokoyn on 11/13/2015.
 */
(function($, w){
    var vm                              =   new Vue({
        el: '#registerForm',
        data: {
            captcha:                        captcha_required,
            terms:                          false
        }
    });

    w.verifyCaptcha                     =   function(t){
        vm.captcha                      =   true;
    };

    $("#registerForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#registerStatus").html('<div class="alert alert-info text-center"><strong>' + register_wait + '</strong></div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            username:                       $("#inputUsername").val(),
            email:                          $("#inputEmail").val(),
            pass:                           $("#inputPassword").val(),
            pass_confirmation:              $("#inputConfirmPassword").val(),
            newsletter_subscribe:           $("#inputSubscribeNewsletter").prop("checked") ? 2 : 1
        };

        $.post( '', formObj).always(function(response){
            $("#registerForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#registerStatus").html('<div class="alert alert-success"><strong>' + response.msg + '</strong></div>');

                if(response.reload == 2){
                    location.reload();
                }
            }else{
                $("#registerStatus").html('<div class="alert alert-warning">' + register_error + '</div>');
            }
        });
    });
})(jQuery, window);