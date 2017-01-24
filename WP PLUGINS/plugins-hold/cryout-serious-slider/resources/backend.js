
jQuery(document).ready( function() {
	jQuery('div.row-actions a.editinline').on('click', function( event ) {
		setTimeout( function() {
			jQuery('#the-list').find('input[name="post_name"]').parents('label').hide();
			jQuery('#the-list').find('input[name="post_password"]').parents('label').parent().hide();
		}, 3);	
	});
} );