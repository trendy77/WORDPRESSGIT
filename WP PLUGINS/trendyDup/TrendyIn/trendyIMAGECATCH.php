<?php
/*
Plugin Name: TrendyIMAGECATCH
Description: INSERT META INTO POSTS
*/
/* Start Adding Functions Below this Line */


//add_action( 'transition_post_status', 'dupcheck', 55, 3 );

add_filter('the_content', 'catch_that_image');
add_action('wp_head', 'create_meta_desc');
  

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];
  if(empty($first_img)) {
    $first_img = "/path/to/default.png";
  }
  return $first_img;
}

/***put in the loop
if ( get_the_post_thumbnail($post_id) != '' ) {
  echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   the_post_thumbnail();
  echo '</a>';
} else {
 echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
 echo '<img src="';
 echo catch_that_image();
 echo '" alt="" />';
 echo '</a>';
}
****/

?>