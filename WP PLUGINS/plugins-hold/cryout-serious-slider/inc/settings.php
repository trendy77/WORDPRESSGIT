	<div class="wrap" id="serious-slider-about">
		<h2><?php //echo $this->title; ?></h2>
		
		<?php
		
		//$options = $this->get_settings();
		//$this->save_settings(); 
		
		if ( ! isset( $_REQUEST['add_sample_content'] ) )
			$_REQUEST['add_sample_content'] = false;
		
		if ( $_REQUEST['add_sample_content'] ) { 
		/* because wp doesn't auto display saved notice on non-options pages */ ?>
		<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
			<p><strong><?php _e('Sample slider created.', 'cryout-serious-slider');?></strong><br>
			<?php _e('Navigate to Slider and Slides sections to see the sample content.') ?></p>
			<button class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'cryout-serious-slider' ) ?></span></button>
		</div> 
		<?php } ?>	
			
		<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
			
				<div class="postbox" id="serious-slider-header">
					<img src="<?php echo plugins_url('../resources/images/serious-slider-header.png', __FILE__); ?>" />
					<div id="serious-slider-description">
						<p>Responsive slider, built on Bootstrap Carousel, uses core WordPress functionality, easy to use, seriously.</p>
						<h3> Features: </h3>

						<ul>
							<li>Unlimited sliders with unlimited slides</li>
							<li>Seriously configurable </li>
							<li>Fully responsive </li>
							<li>Touch Swipe Navigation </li>
							<li>Customization options for each individual slider </li>
							<li>Slide attributes: image, caption title, caption text (with HTML support), target link</li>
							<li>Easy to use - uses WordPress custom post types</li>
							<li>Translation ready and compatible with translation plugins </li>
							<li>Accessibility ready</li>
							<li>Lightweight (uses CSS and iconfont only)</li>
							<li>CSS transitions – fast and powerful hardware accelerated CSS3 3D transforms </li>
							<li>HTML5 valid</li>
							<li>Sample content</li>
						</ul>
						
					</div>
				</div>			
						
			</div> <!-- post-body-content-->

			<div class="postbox-container" id="postbox-container-1">

						<div class="meta-box-sortables">

							<div class="postbox">
								<h3 style="text-align: center;" class="hndle">
									<span><strong><?php echo $this->title; ?></strong></span>
								</h3>

								<div class="inside">
									<div style="text-align: center; margin: auto">
										<strong><?php printf( __('version: %s','cryout-serious-slider'), $this->version ); ?></strong><br>
										<?php _e('by','cryout-serious-slider') ?> Cryout Creations<br>
										<a target="_blank" href="http://www.cryoutcreations.eu/cryout-serious-slider/">www.cryoutcreations.eu</a>
									</div>
								</div>
							</div>

							<div class="postbox">
								<h3 style="text-align: center;" class="hndle">
									<span><?php _e('Support','cryout-serious-slider') ?></span>
								</h3><div class="inside">
									<div style="text-align: center; margin: auto">
										<?php printf ( '%1$s <a target="_blank" href="http://www.cryoutcreations.eu/forum">%2$s</a>.',
											__('For support questions please use', 'cryout-serious-slider'),
											__('our forum', 'cryout-serious-slider')
											);
										?>
									</div>
								</div>
							</div>
							
							<div class="postbox">
								<div class="inside">		
								<p class="description"><?php _e('Automatically set up a sample slider with 3 slides to use as a guide for your own content.', 'cryout-serious-slider') ?></p>
								<a class="button-primary" href="<?php echo $this->aboutpage . '&add_sample_content=1' ?>" style="float:left; margin-right: 20px;">
									<?php _e('Create Sample Slider', 'cryout-serious-slider');?>
								</a>
								</div> <!--inside-->
							</div> <!--postbox-->
							
						</div>
			</div> <!-- postbox-container -->

		</div> <!-- post-body -->
		<br class="clear">
		</div> <!-- poststuff -->

	</div><!--end wrap-->
