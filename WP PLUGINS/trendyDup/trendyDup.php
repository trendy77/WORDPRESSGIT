<?php
/*
Plugin Name: trendyDup
Description: Check Duplicates and stop from being posted
*/
 
if( is_admin() ) {
    add_action( 'save_post', 'wpse_54258_check_for_duplicate_title', 11, 2 );
    add_action( 'admin_head-post.php', 'wpse_54258_check_for_notice' );
}
/*
 * Checks for more than one post with the same title
 * * Adds filter redirect_post_location if duplicate title found
 * */
function wpse_54258_check_for_duplicate_title( $post_id, $post ){
    // HERE, FURTHER FILTERING CAN BE DONE, RESTRICT USERS, POST_TYPES, ETC
    if ( 
        ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        or ! current_user_can( 'edit_post', $post_id )
        or wp_is_post_revision( $post )
        // ADD OTHER FILTERS, LIKE post_type
    ){ // Noting to do.
        return;
		}
    $termid = get_post_meta($post_id, '_is_dup', true);
    if ( '' != $termid ) 				  // it's a new record
    {
        $count_dups = 0;
        update_post_meta($post_id, '_is_dup', 'new-post-check');
    } 
    else 
    {
        $count_dups = 1;
    }
    // NO CHECKING IS BEING DONE REGARDING UPPER AND LOWERCASES, NOR FOR HTML TAGS
    global $wpdb;
    $title_exists = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = '$post->post_title' AND post_status = 'publish'") );
    if( count($title_exists) > $count_dups ) 
        add_filter('redirect_post_location','wpse_54258_add_error_query_var');
}
function wpse_54258_add_error_query_var( $loc ) {
    remove_filter( 'redirect_post_location','wpse_54258_add_error_query_var' );
    return add_query_arg( 'duplicated_title', 123, $loc );
}

/** Error checking after saving the post**/
function wpse_54258_check_for_notice(){
    if( isset( $_GET['duplicated_title'] ) )
        add_action( 'admin_notices', 'wpse_54258_display_error_message' );
}

/** Actual error message for duplicated post titles* */
function wpse_54258_display_error_message(){ ?>
    <div class="error fade">ERROR</div>
    <?php
    remove_action( 'admin_notices', 'wpse_54258_display_error_message' );
}

/*
 * Update ALL PUBLISHED posts and pages with the controller post_meta required by the main code
 *
 * Important: Run Only Once 
 * -> Paste in functions.php
 * -> Remove the comment to add_action
 * -> Visit any administrative page
 * -> Delete or disable this code
 * 
 */
//add_action('admin_init','wpse_54258_run_only_once');

function wpse_54258_run_only_once(){   
    global $wpdb;
    $allposts = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_status = 'published'" );
    foreach( $allposts as $pt )    {
        update_post_meta( $pt->ID, '_is_dup', 'new-post-check');
    }
}

?>