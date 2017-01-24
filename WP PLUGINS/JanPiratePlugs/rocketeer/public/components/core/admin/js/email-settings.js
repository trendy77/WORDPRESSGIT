/**
 * Created by jaskokoyn on 2/14/2016.
 */
(function($, w){
    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            newsletter:                     $("#inputNewsletterSub").val(),
            mc_api_key:                     $("#inputMCAPIKey").val(),
            mc_list_id:                     $("#inputMCListID").val()
        };

        $.post( '', formObj).always(function(response){
            $("#settingsForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });

    $(document).on( 'click', '#exportEmailsBtn', function(e){
        e.preventDefault();

        $(this).find(".fa").removeClass("fa-cloud-download").addClass("fa-spin fa-spinner");
        $(this).attr( "disabled", true );

        $.post( ajaxurl + 'process/export-emails', { _token: $("input[name=_token]").val() }).always(function(data){
            $("#exportEmailsBtn").find(".fa").addClass("fa-cloud-download").removeClass("fa-spin fa-spinner");
            $("#exportEmailsBtn").attr( "disabled", false);

            if( data.status == 2){
                location.href               =   data.redirect_url;
            }
        });
    });
})(jQuery, window);