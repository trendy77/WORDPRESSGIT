/**
 * Created by jaskokoyn on 11/11/2015.
 */
(function($, w){
    CKEDITOR.replace('inputTos');


    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            name:                           $("#inputSiteName").val(),
            title:                          $("#inputSiteTitle").val(),
            desc:                           $("#inputSiteDesc").val(),
            display_count:                  $("#inputDisplayCount").val(),
            google_font:                    $("#inputGoogleFont").val(),
            site_font:                      $("#inputSiteFont").val(),

            aws_s3:                         $("#inputAWSS3").val(),
            aws_s3_key:                     $("#inputAWSKey").val(),
            aws_s3_secret:                  $("#inputAWSSecret").val(),
            aws_s3_region:                  $("#inputAWSRegion").val(),
            aws_s3_bucket:                  $("#inputAWSBucket").val(),


            sidebar_ad:                     $("#inputSidebarAd").val(),
            header_ad:                      $("#inputHeaderAd").val(),
            footer_ad:                      $("#inputFooterAd").val(),
            list_ad:                        $("#inputListAd").val(),
            list_ad_type:                   $("#inputListAdType").val(),
            ad_nth_count:                   $("#inputListAdNthCount").val(),
            color:                          $("#inputSiteColor").val(),
            cache_enabled:                  $("#inputEnableCache").val(),
            homepage_type:                  $("#inputHomepageType").val(),
            custom_css:                     $("#inputCustomCSS").val(),
            facebook:                       $("#inputFacebook").val(),
            twitter:                        $("#inputTwitter").val(),
            gp:                             $("#inputGP").val(),
            youtube:                        $("#inputYoutube").val(),
            soundcloud:                     $("#inputSoundcloud").val(),
            instagram:                      $("#inputInstagram").val(),
            fb_key:                         $("#inputFBKey").val(),
            fb_secret:                      $("#inputFBSecret").val(),
            twitter_key:                    $("#inputTwitterKey").val(),
            twitter_secret:                 $("#inputTwitterSecret").val(),
            google_key:                     $("#inputGoogleKey").val(),
            google_secret:                  $("#inputGoogleSecret").val(),
            sc_client_id:                   $("#inputSoundcloudClientID").val(),
            sc_client_secret:               $("#inputSoundcloudClientSecret").val(),
            ga_tracking_id:                 $("#inputGATrackingID").val(),
            recaptcha_public_key:           $("#inputReCaptchaPublicKey").val(),
            tos:                            CKEDITOR.instances.inputTos.getData()
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