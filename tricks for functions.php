
//** remove login errors to protect wp-admin **//
add_filter('login_errors',create_function('$a', "return null;"));
//** thumbs**//
add_theme_support( 'post-thumbnails' );

//function to call first uploaded image in functions file
	function main_image() {
	$files = get_children('post_parent='.get_the_ID().'&post_type=attachment
	&post_mime_type=image&order=desc');
	  if($files) :
	    $keys = array_reverse(array_keys($files));
	    $j=0;
	    $num = $keys[$j];
	    $image=wp_get_attachment_image($num, 'large', true);
	    $imagepieces = explode('"', $image);
	    $imagepath = $imagepieces[1];
		$main=wp_get_attachment_url($num);
	$template=get_template_directory();
$the_title=get_the_title();
print "<img src='$main' alt='$the_title' class='frame' />";
endif;
	}
//open the theme file where you are displaying the WordPress post thumbnail, this can be (home.php, single.php, loop.php, index.php, archive.php, etc) and paste the following code:
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
  echo get_the_post_thumbnail($post->ID);
} else {
   echo main_image();
} ?>

	
	// backup default image
function my_custom_featured_image_column_image( $image ) {
	    if ( !has_post_thumbnail() )
	        return trailingslashit( get_stylesheet_directory_uri() ) . 'images/no-featured-image';
	}
	add_filter( 'featured_image_column_default_image', 'my_custom_featured_image_column_image' );








All folders on your WordPress site should have a file permission of 744 or 755.

All files on your WordPress site should have a file permission of 644 or 640. 



metaWeblog.newPost
Function: Creates a new post on your blog.
Parameters:

Blog ID – For use in multisite installations, typically 0 for single sites
Username – WordPress username
Password – WordPress password
Content – Your blog post defined as an associate array with the following fields
‘post_type’ – ‘post’ or ‘page’
‘wp_slug’ – Post slug (optional)
‘wp_password’ – Post password (optional)
‘wp_page_parent_id’ – ID of the parent post (optional)
‘wp_page_order’ – Menu order (optional)
‘wp_author_id’ – Identify an author other than the user posting the request (optional)
‘title’ – Post title
‘description – Post body content
post-type_status – Set the post/page/custom status to draft, private, publish, publish, or pending
‘mt_excerpt’ – Post excerpt
‘mt_text_more’ – Text for the Read More link
‘mt_keywords’ – Tags
‘mt_allow_comments’ – Set whether comments are open or closed
‘mt_allow_pings’ – Same settings as ‘mt_allow_comments’
‘mt_tb_ping_urls’ – An array of the URLs you want to ping on publication
‘date_created_gmt’ – The publication date for the post
‘dateCreated’ – Same as above … use one or the other
‘categories’ – An array of categories for the post.
Publish – The status you want the post to have, either publish or draft