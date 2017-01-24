/**
 * Created by jaskokoyn on 2/25/2016.
 */
(function($, w){
    $(".btn-add-url").click(function(e){
        e.preventDefault();

        var source                  =   $("#urlTpl").html();
        var template                =   Handlebars.compile(source);
        var html                    =   template({});
        $("#urlCtr").append(html);
    });

    $(document).on("click", ".btn-delete-url", function(e){
        e.preventDefault();
        $(this).closest('.urlGroup').remove();
    });

    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            urls:                           []
        };

        $(".urlGroup").each(function(){
            formObj.urls.push( $(this).find(".inputURL").val() );
        });

        $.post( '', formObj).always(function(response){
            $("#settingsForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);