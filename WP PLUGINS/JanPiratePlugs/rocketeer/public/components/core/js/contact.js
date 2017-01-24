/**
 * Created by jaskokoyn on 2/22/2016.
 */
(function($, w){
    $("#contactForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);

        $("#alertStatus").html('<div class="alert alert-info">' + contact_pending + '</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            pid:                        $("#inputPID").val(),
            subject:                    $("#inputSubject").val(),
            desc:                       $("#inputDesc").val(),
            name:                       $("#inputName").val(),
            email:                      $("#inputEmail").val()
        };

        $.post( ajaxurl + "/process/contact", formObj).always(function(response){
            $("#contactForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#alertStatus").html('<div class="alert alert-success">' + contact_success + '</div>');
            }else{
                $("#alertStatus").html('<div class="alert alert-danger">' + contact_error + '</div>');
            }
        });
    });
})(jQuery, window);