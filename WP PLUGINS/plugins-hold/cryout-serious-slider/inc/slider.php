		<style type="text/css">
			#Serious-Slider-<?php echo $cid ?> { max-width: <?php echo $width; ?>px; <?php if ($sizing) { ?>max-height: <?php echo $height; ?>px;<?php } ?> }
			#Serious-Slider-<?php echo $cid ?> .seriousslider-caption-title { font-size: <?php echo round($textsize*2,2) ?>em; }
			#Serious-Slider-<?php echo $cid ?> .seriousslider-caption-text { font-size: <?php echo round($textsize,2) ?>em; }
			#Serious-Slider-<?php echo $cid ?> .seriousslider-caption-text a { font-size: <?php echo round($textsize*0.8,2) ?>em; }
			<?php if ($sizing) { ?> #Serious-Slider-<?php echo $cid ?> .seriousslider-inner img.item-image { height: <?php echo $height; ?>px; } <?php } ?>

			#Serious-Slider-<?php echo $cid ?> .seriousslider-inner > .item {
				-webkit-transition-duration: <?php echo round($transition/1000,2) ?>s;
				-o-transition-duration: <?php echo round($transition/1000,2) ?>s;
				transition-duration: <?php echo round($transition/1000,2) ?>s; }
		</style>
		<!-- cryout serious slider -->
		<?php if ( $the_query->have_posts() ): ?>
		<div id="Serious-Slider-<?php echo $cid ?>" class="cryout-serious-slider seriousslider <?php echo $slider_classes ?>" data-ride="seriousslider">
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
				<a <?php echo $meta_link; ?> <?php echo $meta_target; ?>>
					<img src="<?php echo $image_data[0] ?>" alt="<?php the_title(); ?>" <?php echo $sizes ?> class="item-image">
				</a>
				<div class="seriousslider-caption">
					<h3 class="seriousslider-caption-title">
						<a <?php echo $meta_link?> <?php echo $meta_target ?>><?php the_title(); ?></a>
					</h3>
					<div class="seriousslider-caption-text"><?php the_content() ?></div>
				</div>
			</div>
				
			<?php endwhile; ?>
			</div>
			
			<ol class="seriousslider-indicators">
				<?php for ($i=0;$i<$counter;$i++) { ?>
				<li data-target="#Serious-Slider-<?php echo $cid ?>" data-slide-to="<?php echo $i?>" <?php if ($i==0) echo 'class="active"' ?>></li>
				<?php } ?>
			</ol>

			<a class="left seriousslider-control" href="#Serious-Slider-<?php echo $cid ?>" role="button" data-slide="prev">
			  <span class="sicon-prev" aria-hidden="true"></span>
			  <span class="sr-only"><?php _e('Previous','cryout-serious-slider') ?></span>
			</a>
			<a class="right seriousslider-control" href="#Serious-Slider-<?php echo $cid; ?>" role="button" data-slide="next">
			  <span class="sicon-next" aria-hidden="true"></span>
			  <span class="sr-only"><?php _e('Next','cryout-serious-slider') ?></span>
			</a>
		  </div>
		<script type='text/javascript'>
		jQuery('#Serious-Slider-<?php echo $cid ?>').carousel({
			interval: <?php echo $delay ?>,
			pause: '<?php echo $hover ?>',
			stransition: <?php echo $transition ?>
		})
		</script>
		<?php endif; ?>
		<!-- end cryout serious slider -->