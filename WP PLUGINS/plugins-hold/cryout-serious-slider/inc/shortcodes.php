<?php

/* The shortcode class */
class Cryout_Serious_Slider_Shortcode {

	public $shortcode_tag = 'serious-slider';
	private $id = 0;
	private $cid = 0;
	private $custom_style = array();

	function __construct($args = array()){
		//register shortcode
		add_shortcode( $this->shortcode_tag, array( $this, 'shortcode_render' ) );
	}
	
	function shortcode_style() {
		$sid = $this->id;
		$cid = $this->cid;
		$options = $this->shortcode_options($sid);
		foreach ($options as $id => $opt) ${$id} = $opt;
		
		ob_start();
		?><style type="text/css">
			<!-- cryout serious slider -->
		<?php echo implode("\n", $this->custom_style); ?>
		</style><?php
		$custom_style = ob_get_clean();
		
		echo $custom_style;
	} // shortcode_slyle()
	
	function shortcode_render($attr) {
		
		global $cryout_serious_slider;

		if (!empty($attr['id'])) {

		$options = $this->shortcode_options($attr['id']);
		foreach ($options as $id => $opt) ${$id} = $opt;
		
		$slider_classes = array();
		$slider_classes[] = 'seriousslider-overlay' . $overlay;
		$slider_classes[] = 'seriousslider-' . $theme;
		$slider_classes[] = 'seriousslider-' . $animation; 
		$slider_classes[] = 'seriousslider-sizing' . $sizing;
		$slider_classes = implode(' ', $slider_classes); 
		
		if (!empty($attr['count'])) $count = esc_attr($attr['count']); else $count = -1;
		
		if ($sort == 'order'):
			// sort by order param
			$s1 = 'menu_order';
			$s2 = 'ASC';
		else:
			// sort by publish date (default)
			$s1 = 'date';
			$s2 = 'DESC';
		endif;
		
		$cid = abs($attr['id']).'_'.rand(1000,9999); 

		$the_query = new WP_Query( 
			array( 
				'post_type' => array( $cryout_serious_slider->posttype ),
				'order' => $s2,
				'orderby' => $s1,
				'showposts' => $count,
					'tax_query' => array(
					array(
						'taxonomy' => $cryout_serious_slider->taxonomy,
						'field'    => 'id',
						'terms'    => array( $cid ),
					),
				),
			)
		);
		
		$counter = 0; 
		$this->id = $attr['id'];
		$this->cid = $cid;
		
		ob_start(); ?>	
			.serious-slider-<?php echo $cid ?> { max-width: <?php echo $width; ?>px; max-height: <?php echo $height; ?>px;  }
			.serious-slider-<?php echo $cid ?>.seriousslider-sizing1 img { max-height: <?php echo $height; ?>px;  }
			.serious-slider-<?php echo $cid ?> .seriousslider-caption-title { font-size: <?php echo round($textsize*2,2) ?>em; }
			.serious-slider-<?php echo $cid ?> .seriousslider-caption-text { font-size: <?php echo round($textsize,2) ?>em; }
			.serious-slider-<?php echo $cid ?> .seriousslider-caption-text a { font-size: <?php echo round($textsize*0.8,2) ?>em; }

			.serious-slider-<?php echo $cid ?> .seriousslider-inner > .item {
				-webkit-transition-duration: <?php echo round($transition/1000,2) ?>s;
				-o-transition-duration: <?php echo round($transition/1000,2) ?>s;
				transition-duration: <?php echo round($transition/1000,2) ?>s; } 
		<?php
		$this->custom_style[] = ob_get_clean();
		add_action( 'wp_footer', array($this, 'shortcode_style') );
	
		if ( $the_query->have_posts() ): ?>
		<div id="serious-slider-<?php echo $cid ?>" class="cryout-serious-slider seriousslider serious-slider-<?php echo $cid ?> cryout-serious-slider-<?php echo $attr['id'] ?> <?php echo $slider_classes ?>" data-ride="seriousslider">
			<div class="seriousslider-inner" role="listbox">

			<?php while ($the_query->have_posts()): 
				$the_query->the_post(); 
				$counter++; 
				
				// default parameters
				$meta_link = ''; 
				$meta_target = '';
				$sizes = '';
				
				// retrieve parameters
				$slide_link = get_post_meta( get_the_ID(), 'cryout_serious_slider_link' );
				$slide_target = get_post_meta( get_the_ID(), 'cryout_serious_slider_target' );
				if ( !empty($slide_link) ) $meta_link = ' href="' . $slide_link[0] . '"'; 
				if ( !empty($slide_target) ) $meta_target = 'target="_blank"';
				
				$image_data = wp_get_attachment_image_src (get_post_thumbnail_ID( get_the_ID() ), 'full' );
				
				if ( !empty($sizing) && $sizing ) $sizes = 'width="' . $width . '" height="' . $height . '"';

				?>

			<div class="item slide-<?php echo $counter ?> <?php if ($counter==1) echo 'active' ?>">
				<?php if (!empty($image_data[0])): ?>
				<a <?php echo $meta_link; ?> <?php echo $meta_target; ?>>
					<img src="<?php echo $image_data[0] ?>" alt="<?php the_title(); ?>" <?php echo $sizes ?>>
				</a>
				<?php endif; ?>
				<div class="seriousslider-caption">
					<h3 class="seriousslider-caption-title">
						<?php the_title(); ?>
					</h3>
					<div class="seriousslider-caption-text"><?php the_content() ?></div>
				</div>
			</div>
				
			<?php endwhile; ?>
			</div>
			
			<ol class="seriousslider-indicators">
				<?php for ($i=0;$i<$counter;$i++) { ?>
				<li data-target="#serious-slider-<?php echo $cid ?>" data-slide-to="<?php echo $i?>" <?php if ($i==0) echo 'class="active"' ?>></li>
				<?php } ?>
			</ol>

			<button class="left seriousslider-control" data-target="#serious-slider-<?php echo $cid ?>" role="button" data-slide="prev">
			  <span class="sicon-prev" aria-hidden="true"></span>
			  <span class="sr-only"><?php _e('Previous','cryout-serious-slider') ?></span>
			</button>
			<button class="right seriousslider-control" data-target="#serious-slider-<?php echo $cid; ?>" role="button" data-slide="next">
			  <span class="sicon-next" aria-hidden="true"></span>
			  <span class="sr-only"><?php _e('Next','cryout-serious-slider') ?></span>
			</button>
		  </div>
		<script type='text/javascript'>
		jQuery('#serious-slider-<?php echo $cid ?>').carousel({
			interval: <?php echo $delay ?>,
			pause: '<?php echo $hover ?>',
			stransition: <?php echo $transition ?>
		})
		</script>
		<?php endif; ?>
		<?php wp_reset_query(); /* clean up the query */ ?>
		<!-- end cryout serious slider -->
		<?php
		} // if id defined

	} // shortcode_render()
	
	function shortcode_options($sid) {
		
		global $cryout_serious_slider;
	
		if (is_numeric($sid)) {
			$data = get_option( "cryout_serious_slider_${sid}_meta" ); 
			if ( empty($data) ) $data = $cryout_serious_slider->defaults;
		} else {
			$data = $cryout_serious_slider->defaults;		
		}
		foreach ($data as $id=>$value){
			$options[str_replace('cryout_serious_slider_','',$id)] = $value;
		}
		return $options;
	} // shortcode_options()
			
} // class

/* Initialize the shortcode class */
$cryout_serious_slider_shortcode = new Cryout_Serious_Slider_Shortcode;

/* END */