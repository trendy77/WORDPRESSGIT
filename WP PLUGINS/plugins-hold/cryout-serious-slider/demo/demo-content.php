<?php

class Cryout_Serious_Slider_DemoContent { 
	
	private $sample_slides = array(
		array(
			'post_title' => 'Are You Looking At Me?',
			'post_content' => 'More Lorem ipsum.....',
			'post_status' => 'publish',
			'post_type' => 'cryout_serious_slide',
			'menu_order' => 3,
			'image' => '/demo/sample-slide-3.jpg', 
		),
		array(
			'post_title' => 'Another Sample Slide',
			'post_content' => "Serious Slider takes your slides seriously.\n\n<a href=\"#\">First Link</a> <a href=\"#\">Second Link</a>",
			'post_status' => 'publish',
			'post_type' => 'cryout_serious_slide',
			'menu_order' => 2,
			'image' => '/demo/sample-slide-2.jpg', 
		),
		array(
			'post_title' => 'Why So Serious?',
			'post_content' => "Lorem Ipsum dolor ist atmet...\n\n<a href=\"#\">Seriously!</a>",
			'post_status' => 'publish',
			'post_type' => 'cryout_serious_slide',
			'menu_order' => 1,
			'image' => '/demo/sample-slide-1.jpg',
		),
	); // sample_slides
	
	function __construct() {
	
		// create sample slider ('category')
		$term = wp_insert_term(
			'Sample Slider',   // the term 
			'cryout_serious_slider_category', // the taxonomy
			array(
				'description' => '',
				'slug'        => 'sample-slider',
			)
		);		
		
		// create the slides
		foreach ($this->sample_slides as $post) {
			// create sample slide
			$pid = wp_insert_post( $post );
			// add featured image
			$post['image'] = plugins_url( $post['image'], dirname(__FILE__) );
			$this->image_helper($pid, $post['image']);
			unset($post['image']);
			// assign slide to slider 'category'
			wp_set_object_terms($pid, 'Sample Slider', 'cryout_serious_slider_category', true);
		}
	} // __construct()
	
	
	function image_helper($id, $image) {
		// magic sideload image returns an HTML image, not an ID
		$media = media_sideload_image($image, $id);

		// therefore we must find it so we can set it as featured ID
		if(!empty($media) && !is_wp_error($media)){
			$args = array(
				'post_type' => 'attachment',
				'posts_per_page' => -1,
				'post_status' => 'any',
				'post_parent' => $id
			);

			// reference new image to set as featured
			$attachments = get_posts($args);

			if(isset($attachments) && is_array($attachments)){
				foreach($attachments as $attachment){
					// grab source of full size images (so no 300x150 nonsense in path)
					$image = wp_get_attachment_image_src($attachment->ID, 'full');
					// determine if in the $media image we created, the string of the URL exists
					if(strpos($media, $image[0]) !== false){
						// if so, we found our image. set it as thumbnail
						set_post_thumbnail($id, $attachment->ID);
						// only want one image
						break;
					}
				}
			}
		}

	} // image_helper()
	
} // class Cryout_Serious_Slider_DemoContent
	
new Cryout_Serious_Slider_DemoContent;