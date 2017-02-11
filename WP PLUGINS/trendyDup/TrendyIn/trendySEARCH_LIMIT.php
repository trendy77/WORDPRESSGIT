<?php
/*
Plugin Name: TrendySEARCH_LIMIT
Description: INSERT META INTO POSTS
*/
/* Start Adding Functions Below this Line */


//add_action( 'transition_post_status', 'dupcheck', 55, 3 );



function wpcodex_filter_main_search_post_limits( $limit, $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		return 'LIMIT 0, 20';
	}
	return $limit;
}

?>