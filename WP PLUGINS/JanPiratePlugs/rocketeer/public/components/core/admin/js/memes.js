/**
 * Created by jaskokoyn on 11/12/2015.
 */
(function($, w){
    $("#addMemeForm").submit(function(e){
        e.preventDefault();

        var file                        =   $("#inputMemeImg").prop('files')[0];

        if(!file){
            return null;
        }

        $(this).find(":input").prop("disabled", true);
        $("#addMemeStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   new FormData();
        formObj.append( 'name', $("#inputMemeName").val() );
        formObj.append( 'meme_img', file );

        $.ajax({
            url : ajaxurl + 'memes/add',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            $("#addMemeForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#addMemeStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
                location.reload();
            }else{
                $("#addMemeStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });

    $(".btn-delete-meme").click(function(e){
        e.preventDefault();

        if(!confirm("Are you sure you want to do this? This can not be undone.")){
            return null;
        }

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            mid:                            $(this).data('mid')
        };

        $(this).closest('tr').remove();

        $.post( ajaxurl + "memes/delete", formObj).always(function(response){
            console.log(response);
        });
    });

    $(".btn-edit-meme").click(function(e){
        e.preventDefault();

        $("#inputEditMemeID").val( $(this).data('mid') );
        $("#inputEditMemeName").val( $(this).data('name') );
    });

    $("#editMemeForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#editMemeStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            mid:                        $("#inputEditMemeID").val(),
            name:                       $("#inputEditMemeName").val()
        };

        $.post( ajaxurl + "memes/update", formObj).always(function(response){
            console.log(response);

            $("#editMemeForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#editMemeStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
                location.reload();
            }else{
                $("#editMemeStatus").html('<div class="alert alert-warning">Unable to update category. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);