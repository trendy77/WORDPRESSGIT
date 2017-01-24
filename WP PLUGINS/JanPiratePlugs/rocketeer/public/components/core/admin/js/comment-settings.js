/**
 * Created by jaskokoyn on 12/5/2015.
 */
(function($, w){
    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            site_comments:                  $("#inputSiteComments").val(),
            fb_comments:                    $("#inputFBComments").val(),
            disqus_comments:                $("#inputDisqusComments").val(),
            disqus_shortname:               $("#inputDisqusShortname").val(),
            main_comment_system:            $("#inputMainCommentSystem").val()
        };

        console.log(formObj);

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