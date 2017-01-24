/**
 * Created by jaskokoyn on 11/12/2015.
 */
(function($, w){
    $(".btn-delete-page").click(function(e){
        e.preventDefault();

        if(!confirm("Are you sure you want to do this? This can not be undone.")){
            return null;
        }

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            pid:                            $(this).data('pid')
        };

        $(this).closest('tr').remove();

        $.post( ajaxurl + "pages/delete", formObj).always(function(response){
            console.log(response);
        });
    });
})(jQuery, window);