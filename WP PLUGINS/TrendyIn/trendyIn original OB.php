<?php
/*
Plugin Name: TrendyIn
Description: Contains - inserts Adverts!** 'add meta_desc' to wp_head 
LIMIT QUERIES - CUT OUT DUPLICATES? COMING SOOON? ++ CATCH THAT IMAGE!
*/
/* Start Adding Functions Below this Line */


//add_action( 'transition_post_status', 'dupcheck', 55, 3 );

add_filter( 'post_limits', 'wpcodex_filter_main_search_post_limits', 15, 2 );
add_filter('the_content', 'wpse_ad_content');
add_filter('the_content', 'catch_that_image');
add_action('wp_head', 'create_meta_desc');
add_action('content_save_pre', 'create_meta_desc'); 
   

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

//put in the loop
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

function wpcodex_filter_main_search_post_limits( $limit, $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		return 'LIMIT 0, 20';
	}
	return $limit;
}

function create_meta_desc() {
    global $post;
if (!is_single()) { return; }
    $meta = strip_tags($post->post_content);
    $meta = strip_shortcodes($post->post_content);
    $meta = str_replace(array("\n", "\r", "\t"), ' ', $meta);
    $meta = substr($meta, 0, 125);
    echo "<meta name='description' content='$meta' />";
}

function wpse_ad_content($content)
{
    if (!is_single()) return $content;
    $paragraphAfter = 2; //Enter number of paragraphs to display ad after.
 $paragraph4After = 8;
   $content = explode("</p>", $content);
    $new_content = '';
    for ($i = 0; $i < count($content); $i++) {
        if ($i == ($paragraphAfter || $paragraph4After)) {
            $new_content.= '<div style="width: 320px; height: 100px; padding: 0px 0px 0px 0; float: left; margin-left: 0; margin-right: 18px;">';
            $new_content.= '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- mob lg banner -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-4943462589133750"
     data-ad-slot="5993932022"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
            $new_content.= '</div>';
        }

        $new_content.= $content[$i] . "</p>";
    }

	$paragraphAfterT = 4; //Enter number of paragraphs to display ad after.
    $new_content = explode("</p>", $new_content);
    $new_contentT = '';
    for ($i = 0; $i < count($new_content); $i++) {
        if ($i == $paragraphAfterT) {
            $new_contentT.= '<div style="width: 336px; height: 280px; padding: 0px 0px 0px 0; float: right; margin-left: 18px; margin-right: 0;">';
            $new_contentT.= '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- tinyhands -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-4943462589133750"
     data-ad-slot="1808495228"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
            $new_contentT.= '</div>';
        }

        $new_contentT.= $new_content[$i] . "</p>";
    }

	
	return $new_contentT;
}

?>