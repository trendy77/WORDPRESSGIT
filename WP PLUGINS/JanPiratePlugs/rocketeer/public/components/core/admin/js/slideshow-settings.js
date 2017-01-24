/**
 * Created by jaskokoyn on 11/11/2015.
 */
(function($, w){
    $(".btn-add-slide").click(function(e){
        e.preventDefault();

        var source                  =   $("#slideItemTpl").html();
        var template                =   Handlebars.compile(source);
        var html                    =   template({});
        $("#slidesCtr").append(html);
    });

    $(document).on("click", ".btn-delete-slide", function(e){
        e.preventDefault();
        $(this).closest('.slideGroup').remove();
    });

    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            slides:                         []
        };

        $(".slideGroup").each(function(){
            formObj.slides.push({
                id:                         $(this).find(".inputMediaID").val(),
                img:                        $(this).find(".inputMediaImg").val()
            });
        });

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