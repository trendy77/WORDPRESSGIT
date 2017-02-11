<?php
/*
Plugin Name: TrendyMETA
Description: INSERT META INTO POSTS
*/
/* Start Adding Functions Below this Line */

//add_action( 'transition_post_status', 'dupcheck', 55, 3 );


add_action('wp_head', 'create_meta_desc');
  
function create_meta_desc() {
    global $post;
if (!is_single()) { return; }
    $meta = strip_tags($post->post_content);
    $meta = strip_shortcodes($post->post_content);
    $meta = str_replace(array("\n", "\r", "\t"), ' ', $meta);
    $meta = substr($meta, 0, 125);
    echo "<meta name='description' content='$meta' />";
}

function wpcodex_filter_main_search_post_limits( $limit, $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		return 'LIMIT 0, 20';
	}
	return $limit;
}

?>