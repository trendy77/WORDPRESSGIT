/**
 * Created by jaskokoyn on 12/19/2015.
 */
(function($, w){
    $(document).on( 'click', '.btn-delete-user', function(e){
        e.preventDefault();

        if( !confirm("Do you want to delete this user? This user's posts will be transferred over to you. This action can not be undone." ) ){
            return null;
        }

        var formObj                             =   {
            _token:                                 $("input[name=_token]").val(),
            uid:                                    $(this).data('uid')
        };

        $(this).closest("tr").remove();

        $.post( ajaxurl + "delete-user", formObj).always(function(response){
            console.log(response);
        });
    });
})(jQuery, window);