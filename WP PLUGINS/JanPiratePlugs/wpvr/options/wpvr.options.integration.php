<?php
	$rewrite_helper = '
		<div class="wpvr_switch_conditional_content">
			<br />
			<strong>No Permalink Base </strong> : domain.com/my-imported-video-title <br/>
			<strong>Category Permalink Base </strong> : domain.com/my-category/my-imported-video-title <br/>
			<strong>Custom Permalink Base </strong> : domain.com/my-custom-text/my-imported-video-title <br/>
		</div>
	';


?>
	<!-- videoType -->
<?php wpvr_addon_option_render( array(
	'id'          => 'videoType',
	'order'       => 11,
	'label'       => __( 'Imported Videos Post Type', WPVR_LANG ),
	'placeholder' => __( 'Pick one post type', WPVR_LANG ),
	'values'      => wpvr_get_available_post_types(),
	'desc'        => __( 'Select the post type you want to use to create your imported videos.', WPVR_LANG ),
	'type'        => 'select',
	'tab_class'   => 'tab_d',
), $wpvr_options['videoType'] ); ?>
	
	<!-- addVideoType *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'addVideoType',
	'label' => __( 'Auto-include videos in your site queries', WPVR_LANG ),
	'desc'  => __( 'Enable this option to subjoin imported videos to all your existant wordpress queries without changing your theme files.', WPVR_LANG ),
), $wpvr_options['addVideoType'] ); ?>
	
	<!-- enableVideoComments *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'enableVideoComments',
	'label' => __( 'Enable Comments on Imported Videos', WPVR_LANG ),
	'desc'  => __( 'Enable this option to add comments support to the imported videos.', WPVR_LANG ),
), $wpvr_options['enableVideoComments'] ); ?>
	
	<!-- enableVideoControls *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'enableVideoControls',
	'label' => __( 'Enable Player Controls on Imported Videos', WPVR_LANG ),
	'desc'  => __( 'Enable this option to show up or hide player controls on imported videos.', WPVR_LANG ) . '<br/>' .
	           __( 'Works only for Youtube videos.', WPVR_LANG ),
), $wpvr_options['enableVideoControls'] ); ?>
	
	
	<!-- enableRewriteRule *** -->
<?php wpvr_render_switch_option( array(
	'tab'         => 'integration',
	'id'          => 'enableRewriteRule',
	'function_in' => function () {
		
		global $wpvr_options;
		
		$isSelected = array(
			'none'     => '',
			'category' => '',
			'custom'   => '',
		);
		
		$isSelected[ $wpvr_options['permalinkBase'] ] = ' selected="selected" ';
		
		$hideIt = $wpvr_options['permalinkBase'] != 'custom' ? 'display:none;' : '';
		
		
		?>
		
		<div class="wpvr_switch_conditional_content wpvr_rewrite_mode">
			
			<select
				class="wpvr_option_select pull-right "
				name="permalinkBase"
				id="permalinkBase"
			>
				<option value="none" <?php echo $isSelected['none']; ?>>
					<?php _e( 'No Permalink Base', WPVR_LANG ); ?>
				</option>
				<option value="category" <?php echo $isSelected['category']; ?>>
					<?php _e( 'Category Permalink Base', WPVR_LANG ); ?>
				</option>
				<option value="custom" <?php echo $isSelected['custom']; ?>>
					<?php _e( 'Custom Permalink Base', WPVR_LANG ); ?>
				</option>
			</select>
			
			<div class="wpvr_clearfix"><br/></div>
			
			<input
				type="text"
				class="wpvr_options_input wpvr_large pull-right"
				id="customPermalinkBase"
				name="customPermalinkBase"
				value="<?php echo $wpvr_options['customPermalinkBase']; ?>"
				style="<?php echo $hideIt; ?>"
				placeholder="Custom Permalink Base"
			/>
			
			<div class="wpvr_clearfix"><br/></div>
		
		</div>
		<?php
	},
	'label'       => __( 'Enable Permalink Rewrite', WPVR_LANG ),
	'desc'        => __( 'Enable this option to activate videos permalink rewrite.', WPVR_LANG ) . '<br/>' .
	                 __( 'Turn off this option to handle permalinks from the WP Permalink Settings screen.', WPVR_LANG ) . $rewrite_helper,
), $wpvr_options['enableRewriteRule'] ); ?>
	
	<!-- videoThumb *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'videoThumb',
	'label' => __( 'Embed Video Instead of Image Thumbnail', WPVR_LANG ),
	'desc'  => __( 'Enable this option to replace in the loop the post thumbnails by embeded video players.', WPVR_LANG ),
), $wpvr_options['videoThumb'] ); ?>
	
	<!-- autoEmbed *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'autoEmbed',
	'label' => __( 'AutoEmbed Videos Player in Content', WPVR_LANG ),
	'desc'  => __( 'Turn this off to embed the player manually so you can customize it.', WPVR_LANG ),
), $wpvr_options['autoEmbed'] ); ?>
	
	<!-- removeVideoContent *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'removeVideoContent',
	'label' => __( 'Remove Video Text Content', WPVR_LANG ),
	'desc'  => __( 'Turn this on to disable rendering the video text content below the video player.', WPVR_LANG ),
), $wpvr_options['removeVideoContent'] ); ?>
	
	<!-- playerAutoPlay *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'playerAutoPlay',
	'label' => __( 'AutoPlay Embedded Player in Content', WPVR_LANG ),
	'desc'  => __( 'Automatically play videos on single view.', WPVR_LANG ),
), $wpvr_options['playerAutoPlay'] ); ?>

    <!-- adminOverride *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'adminOverride',
	'label' => __( 'Override videos admin columns', WPVR_LANG ),
	'desc'  => __( 'Choose whether to use the WPVR or WordPress admin columns for WPVR imported videos.', WPVR_LANG ),
), $wpvr_options['adminOverride'] ); ?>
	
	
	<!-- privateCPT -->
<?php wpvr_addon_option_render( array(
	'id'          => 'privateCPT',
	'order'       => 11,
	'label'       => __( 'Private Custom Post Types', WPVR_LANG ),
	'maxItems'    => '255',
	'placeholder' => __( 'Pick one or more custom post type.', WPVR_LANG ),
	'values'      => array(),
	'source'      => 'post_types_ext',
	'desc'        => __( 'Choose which other custom post types the plugin should not conflict with.', WPVR_LANG ),
	'type'        => 'multiselect',
	'tab_class'   => 'tab_d',
), $wpvr_options['privateCPT'] ); ?>