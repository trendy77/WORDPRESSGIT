/**
 * Created by jaskokoyn on 11/12/2015.
 */
(function($, w){
    CKEDITOR.replace('pageEditor');

    $("#addPageForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        CKEDITOR.instances.inputPageContent.setReadOnly(true);
        $("#addPageStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            title:                      $("#inputPageTitle").val(),
            page_type:                  $("#inputPageType").val(),
            content:                    CKEDITOR.instances.inputPageContent.getData(),
            contact_email:              $("#inputContactEmail").val(),
            direct_url:                 $("#inputDirectURL").val()
        };

        $.post( '', formObj).always(function(response){
            console.log(response);

            $("#addPageForm").find(":input").prop("disabled", false);
            CKEDITOR.instances.inputPageContent.setReadOnly(false);

            if(response.status == 2){
                $("#addPageStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
                location.href       =   ajaxurl + 'pages'
            }else{
                $("#addPageStatus").html('<div class="alert alert-warning">Unable to add page. Please try again later.</div>');
            }
        });
    });

    $(document).on( 'change', '#inputPageType', function(e){
        e.preventDefault();

        $(".display-type").hide();

        if($(this).val() == 1){
            $("#displayPageContent").show();
        }else if($(this).val() == 2){
            $("#displayContact").show();
        }else if($(this).val() == 3){
            $("#displayDirectURL").show();
        }
    });
})(jQuery, window);