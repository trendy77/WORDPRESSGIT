/**
 * Created by jaskokoyn on 2/26/2016.
 */
(function($, w){
    $("#addForm").submit(function(e){
        e.preventDefault();

        var file                        =   $("#inputBadgeImg").prop('files')[0];

        if(!file){
            return null;
        }

        $(this).find(":input").prop("disabled", true);
        $("#addStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   new FormData();
        formObj.append( 'name', $("#inputBadgeName").val() );
        formObj.append( 'desc', $("#inputBadgeDesc").val() );
        formObj.append( 'min', $("#inputBadgeMin").val() );
        formObj.append( 'img', file );

        $.ajax({
            url : ajaxurl + 'badges/add',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            $("#addForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#addStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
                location.reload();
            }else{
                $("#addStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });

    $(".btn-delete-badge").click(function(e){
        e.preventDefault();

        if(!confirm("Are you sure you want to do this? This can not be undone.")){
            return null;
        }

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            bid:                            $(this).data('bid')
        };

        $(this).closest('tr').remove();

        $.post( ajaxurl + "badges/delete", formObj).always(function(response){
            console.log(response);
        });
    });

    $(".btn-edit-badge").click(function(e){
        e.preventDefault();

        $("#inputEditBadgeID").val( $(this).data('bid') );
        $("#inputEditBadgeName").val( $(this).data('name') );
        $("#inputEditBadgeDesc").val( $(this).data('desc') );
        $("#inputEditBadgeMin").val( $(this).data('min') );
    });

    $("#editForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#editStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                 =   {
            _token:                     $("input[name=_token]").val(),
            bid:                        $("#inputEditBadgeID").val(),
            name:                       $("#inputEditBadgeName").val(),
            desc:                       $("#inputEditBadgeDesc").val(),
            min:                        $("#inputEditBadgeMin").val()
        };

        $.post( ajaxurl + "badges/update", formObj).always(function(response){
            $("#editForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#editStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
                location.reload();
            }else{
                $("#editStatus").html('<div class="alert alert-warning">Unable to update category. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);