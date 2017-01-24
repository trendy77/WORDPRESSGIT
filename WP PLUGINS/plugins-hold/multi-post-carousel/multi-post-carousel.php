<?php
/*
Plugin Name: Multi Post Carousel
Plugin URI: https://wordpress.org/plugins/multi-post-carousel/
Description: WordPress multipost carousel to show post in the count of 4,8,12 and vice-versa in one slide
Version: 1.1
Author: GBS Team
Author URI: http://globalbizsol.com/
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
/*
Copyright 2012  GBS  (email : info@demo.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('MU_PC_VERSION', '1.0');
define('MU_PC_FILE', basename(__FILE__));
define('MU_PC_NAME', str_replace('.php', '', MU_PC_FILE));
define('MU_PC_PATH', plugin_dir_path(__FILE__));
define('MU_PC_URL', plugin_dir_url(__FILE__));


function multi_post_carousel_activate() {
   $ps_option =  array(
                        'slide_speed'     => '500',
                        'pause'           => '2000',
                        'auto_start'      => 'true',
                        'enable_loop'     => 'true',
                        'pause_on_hover'  => 'false',
                        'enable_keypress' => 'false',
                        'next_previous_controls' => 'true',
                        'navigation'      => 'true',
                        'enable_touch'    => 'true',
                        'enable_drag'     => 'true'
                     );

   add_option( 'post_slides_option_name', $ps_option );
}
register_activation_hook( __FILE__, 'multi_post_carousel_activate' );



// Add style and script
add_action('init', 'multi_post_carousel_styles');
add_action('init', 'multi_post_carousel_scripts');
/* Calling Style */
function multi_post_carousel_styles() {
  wp_enqueue_style('ps_css_style', MU_PC_URL . 'css/ps-style.css', null, MU_PC_VERSION);
}// END public function multi_post_carousel_styles()

/* Calling Script*/
function multi_post_carousel_scripts() {
    wp_enqueue_script('ps_plugin_js', MU_PC_URL . 'js/jquery.psslider.js', null, MU_PC_VERSION, array( 'jquery' ), MU_PC_VERSION, true);
}// END public function multi_post_carousel_scripts()

/* Add Menu */     
include(sprintf("%s/multi-post-carousel-settings.php", dirname(__FILE__))); 


// Add Shortcode
function post_slides_shortcode( $atts ) {

  // Attributes
  extract( shortcode_atts(
    array(
      'cat_id' => '1',
      'slides' => '4',
      'totalpost' => '12',
    ), $atts )
  );

  $ps_options = get_option( 'post_slides_option_name' );
$
$slide_count = '';
$total_post = '';
$mpc_cat_title = 'mpc-cat-title';
$mpc_outer = 'mpc-outer';
$mpc_category_name = get_cat_name( $cat_id );
  // WP_Query arguments
  $args = array (
    'post_type'              => array( 'post' ),
    'post_status'            => array( 'publish' ),
    'cat'                    => $cat_id,
    'posts_per_page'         => -1,
    'order'                  => 'DESC',
    'orderby'                => 'date',
  );

  $output = '';
  // The Query
  $ps_query = new WP_Query( $args );

 // start Loop
  if ( $ps_query->have_posts() ) { 

    while ( $ps_query->have_posts() ) : $ps_query->the_post();

      $total_post = $ps_query->post_count;
      $slide_count = ceil($total_post / $totalpost);

    endwhile;

  }
	

    $output .= '<div class="clearfix" style="">
    <ul id="image-gallery" class="gallery list-unstyled cS-hidden">';
	
    $skip = 0;
	
    //echo 'slide_count === '.$slide_count;
	if($ps_options['enable_title']== 'true'){ $display_title = 'block';}else{ $display_title = 'none';}
	if($ps_options['enable_content'] == 'true'){ $display_content = 'block';}else{ $display_content = 'none';}
	if($ps_options['enable_read_more'] == 'true'){ $display_read_more = 'block';}else{ $display_read_more = 'none';}	
	
	
    for ($i=1; $i <=$slide_count; $i++) :

       $output .= '<li>';
       $output .= '<div class="all-slides-wrap">';

      // WP_Query arguments
      $args2 = array (
        'post_type'              => array( 'post' ),
        'post_status'            => array( 'publish' ),
        'cat'                    => $cat_id,
        'posts_per_page'         => $totalpost,
        'order'                  => 'DESC',
        'orderby'                => 'date',
        'offset'                 => $skip
      );

      //echo 'skip === '.$skip;

      $ps_query = new WP_Query( $args2 );
		
      // start Loop
      if ( $ps_query->have_posts() ) { 
        
        while ( $ps_query->have_posts() ) : $ps_query->the_post();

         // Get thubnail Image 
        $thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
        $thumb_img_url = $thumb_img['0'];

         // Get Full Image
        $full_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
        $full_img_url = $full_img['0'];
        
		$output .= '<div class="mpc-content-area"><div class="single-slide-img"><a href="'.get_permalink().'"><img src="'.$full_img_url.'" /></a></div><div class="mpc-title" style="display:'.$display_title.'"><a href="'.get_permalink().'">'.wp_trim_words( get_the_title(), $ps_options['title_word_limit'], " " ).'</a></div><div class="mpc-contnet" style="display:'.$display_content.'">'.wp_trim_words( get_the_excerpt(), $ps_options['content_word_limit'], " " ).'</div><div class="mpc-read-btn" style="display:'.$display_read_more.'"><a href="'.get_permalink().'">Read More</a></div></div>';
  
        $skip++;

        endwhile;// while end

         $output .= '</div>';
         $output .= '</li>';

        

        }

    endfor;

    $output .= '</ul>';


   $output .= "<script>
               jQuery(document).ready(function() {
                jQuery('#content-slider').lightSlider({
                        loop:true,
                        keyPress:true
                    });
                    jQuery('#image-gallery').lightSlider({
                        item:1,
                        slideMargin: 0,
                        thumbItem: ".$slides.",
                        pause:".$ps_options['pause'].",
                        auto:".$ps_options['auto_start'].",
                        loop:".$ps_options['enable_loop'].",
                        keyPress: ".$ps_options['enable_keypress'].",
                        controls: ".$ps_options['next_previous_controls'].",
                        enableTouch:".$ps_options['enable_touch'].",
                        enableDrag:".$ps_options['enable_drag'].",
                        pauseOnHover:".$ps_options['pause_on_hover'].",
                        onSliderLoad: function() {
                            jQuery('#image-gallery').removeClass('cS-hidden');
                        }  
                    });
					jQuery('.lSAction').wrap('<div class=".$mpc_outer."></div>');
					jQuery('.mpc-outer').prepend('<div class=".$mpc_cat_title.">".$mpc_category_name."</div>');
            });
            </script>";
   return  $output;
}
add_shortcode( 'post-slides', 'post_slides_shortcode' );