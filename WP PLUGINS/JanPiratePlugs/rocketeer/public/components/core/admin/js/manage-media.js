/**
 * Created by jaskokoyn on 11/12/2015.
 */
(function($, w){
    $(document).on( 'click', '.btn-delete-media', function(e){
        e.preventDefault();

        if( !confirm("Are you sure you want to do this? THis action can not be undone." ) ){
            return null;
        }

        var formObj                             =   {
            _token:                                 $("input[name=_token]").val(),
            mid:                                    $(this).data('mid')
        };

        $(this).closest("tr").remove();

        $.post( ajaxurl + "delete-media", formObj, function(response){
            console.log(response);
        });
    });
})(jQuery, window);