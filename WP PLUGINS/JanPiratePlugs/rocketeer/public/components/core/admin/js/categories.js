/**
 * Created by jaskokoyn on 11/12/2015.
 */
(function($, w){
    $("#inputCatColor").spectrum({
        color: '#424242',
        showInput: true,
        showAlpha: true,
        preferredFormat: "hex3"
    });

    $("#inputEditCatColor").spectrum({
        color: '#424242',
        showInput: true,
        showAlpha: true,
        preferredFormat: "hex3"
    });

    $("#addCatForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#addCatStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                 =   new FormData();
        var file                    =   $("#inputCatImg").prop("files")[0];

        if(!file){
            alert("Please upload a image.");
            return null;
        }

        formObj.append( "_token", $("input[name=_token]").val() );
        formObj.append( "name", $("#inputCatName").val() );
        formObj.append( "pos", $("#inputCatPos").val() );
        formObj.append( "color", $("#inputCatColor").spectrum("get").toHexString() );
        formObj.append( "img", file );

        $.ajax({
            url : ajaxurl + "categories/add",
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            $("#addCatForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#addCatStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
                location.reload();
            }else{
                $("#addCatStatus").html('<div class="alert alert-warning">Unable to add category. Please try again later.</div>');
            }
        });
    });

    $(".btn-delete-cat").click(function(e){
        e.preventDefault();

        if(!confirm("Are you sure you want to do this? This can not be undone.")){
            return null;
        }

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            cid:                            $(this).data('cid')
        };

        $(this).closest('tr').remove();

        $.post( ajaxurl + "categories/delete", formObj).always(function(response){
            console.log(response);
        });
    });

    $(".btn-edit-cat").click(function(e){
        e.preventDefault();

        $("#inputEditCatID").val( $(this).data('cid') );
        $("#inputEditCatName").val( $(this).data('name') );
        $("#inputEditCatPos").val( $(this).data('pos') );
        $("#inputEditCatColor").spectrum( "set", $(this).data('color') );
    });

    $("#editCatForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#editCatStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                 =   new FormData();
        var file                    =   $("#inputEditCatImg").prop("files")[0];
        formObj.append( "_token", $("input[name=_token]").val() );
        formObj.append( "cid", $("#inputEditCatID").val() );
        formObj.append( "name", $("#inputEditCatName").val() );
        formObj.append( "pos", $("#inputEditCatPos").val() );
        formObj.append( "color", $("#inputEditCatColor").spectrum("get").toHexString() );

        if(file){
            formObj.append( "img", file );
        }

        $.ajax({
            url : ajaxurl + "categories/update",
            type: 'POST',
            data: formObj,
            cache : false,
            contentType: false,
            processData: false
        }).always(function(response) {
            console.log(response);

            $("#editCatForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#editCatStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
                location.reload();
            }else{
                $("#editCatStatus").html('<div class="alert alert-warning">Unable to update category. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);