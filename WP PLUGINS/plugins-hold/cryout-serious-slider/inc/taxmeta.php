		<table class="form-table serious-table">
			<?php
				echo $this->selectfield(
					'term_meta[cryout_serious_slider_sort]',
					array( 'date' => __('by date','cryout-serious-slider'), 'order' => __('by order value','cryout-serious-slider') ),
					$the_meta['cryout_serious_slider_sort'],
					__('Sort Order','cryout-serious-slider'),
					'',
					'short'									
				);
				echo $this->selectfield(
					'term_meta[cryout_serious_slider_sizing]',
					array( 0 => __('Adapt to images','cryout-serious-slider'), 1 => __('Force constraints','cryout-serious-slider') ),
					$the_meta['cryout_serious_slider_sizing'],
					__('Slider Size','cryout-serious-slider'),
					'',
					'short'									
				);
			?>

			<?php
				echo $this->inputfield(
					'term_meta[cryout_serious_slider_width]',
					$the_meta['cryout_serious_slider_width'],
					__('Width','cryout-serious-slider'),
					'',
					'short',
					'px'
				);
				echo $this->inputfield(
					'term_meta[cryout_serious_slider_height]',
					$the_meta['cryout_serious_slider_height'],
					__('Height','cryout-serious-slider'),
					'',
					'short',
					'px'
				);
				echo $this->selectfield(
					'term_meta[cryout_serious_slider_theme]',
					array( 'light' => __('Light','cryout-serious-slider'), 
							'dark' => __('Dark','cryout-serious-slider'), 
							'theme' => __('Cryout Theme','cryout-serious-slider'), 
							'boots' => __('Bootstrap','cryout-serious-slider') ),
					$the_meta['cryout_serious_slider_theme'],
					__('Color Scheme','cryout-serious-slider'),
					'',
					'short'									
				);
				echo $this->inputfield(
					'term_meta[cryout_serious_slider_textsize]',
					$the_meta['cryout_serious_slider_textsize'],
					__('Base Font Size','cryout-serious-slider'),
					'',
					'short',
					'em',
					'step="0.1"'
				);
				echo $this->selectfield(
					'term_meta[cryout_serious_slider_overlay]',
					array( 0 => __('Always hidden', 'cryout-serious-slider'), 1 => __('Appear on hover','cryout-serious-slider'), 2 => __('Always visible','cryout-serious-slider') ),
					$the_meta['cryout_serious_slider_overlay'],
					__('Bullets and Navigation','cryout-serious-slider'),
					'',
					'short'									
				);
				echo $this->selectfield(
					'term_meta[cryout_serious_slider_animation]',
					array( 
						'fade' => __('Fade','cryout-serious-slider'), 
						'slide' => __('Slide','cryout-serious-slider'), 
						'overslide' => __('Overslide','cryout-serious-slider'),
						'underslide' => __('Underslide','cryout-serious-slider'),
						'parallax' => __('Parallax','cryout-serious-slider'), 
						'hflip' => __('Horizontal Flip','cryout-serious-slider'), 
						'vflip' => __('Vertical Flip','cryout-serious-slider'), 
					),
					$the_meta['cryout_serious_slider_animation'],
					__('Transition Effect','cryout-serious-slider'),
					'',
					'short'									
				);
				echo $this->selectfield(
					'term_meta[cryout_serious_slider_hover]',
					array( 'hover' => __('Enabled','cryout-serious-slider'), 'false' => __('Disabled','cryout-serious-slider') ),
					$the_meta['cryout_serious_slider_hover'],
					__('Transition Pause on Hover','cryout-serious-slider'),
					'',
					'short'									
				);
				
				echo $this->inputfield(
					'term_meta[cryout_serious_slider_delay]',
					$the_meta['cryout_serious_slider_delay'],
					__('Transition Delay','cryout-serious-slider'),
					'',
					'short',
					'ms'
				);
				echo $this->inputfield(
					'term_meta[cryout_serious_slider_transition]',
					$the_meta['cryout_serious_slider_transition'],
					__('Transition Duration','cryout-serious-slider'),
					'',
					'short',
					'ms'
				); ?>
				
		</table> 
		<br>