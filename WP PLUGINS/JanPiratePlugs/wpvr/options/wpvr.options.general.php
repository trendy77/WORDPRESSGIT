<!-- timeZone -->
<?php wpvr_render_hybrid_option( array(
	'tab'        => 'general',
	'id'         => 'timeZone',
	'label'      => __( 'Default Time Zone', WPVR_LANG ),
	'desc'       => __( 'Choose your default timezone.', WPVR_LANG ),
	'render_fct' => function () {
		global $wpvr_timezones, $wpvr_options;
		$wpvr_timezones_array = array();
		foreach ( (array) $wpvr_timezones as $g => $gZone ) {
			foreach ( (array) $gZone as $gValue => $gLabel ) {
				$wpvr_timezones_array[ $gValue ] = $gLabel;
			}
		}
		
		wpvr_render_selectized_field( array(
			'name'        => 'timeZone',
			'placeholder' => __( 'Pick your timezone', WPVR_LANG ),
			'values'      => $wpvr_timezones_array,
			'maxItems'    => 1,
		
		), $wpvr_options['timeZone'] );
	},
), $wpvr_options['timeZone'] ); ?>

<!-- deferAdding *** -->
<?php wpvr_render_switch_option( array(
	'tab'          => 'general',
	'id'           => 'deferAdding',
	'label'        => __( 'Defer video adding', WPVR_LANG ),
	'desc'         => __( 'Limit the the number of added videos at once. Enable this option to improve performances.', WPVR_LANG ),
	'function_out' => function () {
		global $wpvr_options;
		?>
		<div class="wpvr_switch_conditional_content">
			<div class="wpvr_sub_option pull-right">
				<label class="wpvr_conditional_label">
					<?php echo __( 'Defer Adding Buffer', WPVR_LANG ); ?>
				</label>
				<input
					type="text"
					class="wpvr_options_input"
					name="deferBuffer"
					style="margin-top: 7px;"
					value="<?php echo $wpvr_options['deferBuffer']; ?>"
				/>
			
			</div>
		</div>
		
		<div class="wpvr_clearfix"></div>
		<?php
	},
), $wpvr_options['deferAdding'] ); ?>

<!-- enableManualAdding -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'enableManualAdding',
	'label' => __( 'Enable manual video adding', WPVR_LANG ),
	'desc'  => __( 'Enable grabbing a single video by its id.', WPVR_LANG ),
), $wpvr_options['enableManualAdding'] ); ?>

<!-- restrictVideos *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'restrictVideos',
	'label' => __( 'Restrict videos to their authors', WPVR_LANG ),
	'desc'  => __( 'Restrict edition and listing of imported videos to admin and respective authors.', WPVR_LANG ),
), $wpvr_options['restrictVideos'] ); ?>


<!-- unwantOnTrash *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'unwantOnTrash',
	'label' => __( 'Auto unwant when trashed', WPVR_LANG ),
	'desc'  => __( 'Choose whether to automatically add videos to unwanted when you trash them.', WPVR_LANG ),
), $wpvr_options['unwantOnTrash'] ); ?>

<!-- unwantOnDelete *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'unwantOnDelete',
	'label' => __( 'Auto unwant when deleted', WPVR_LANG ),
	'desc'  => __( 'Choose whether to automatically add videos to unwanted when you delete them permanently.', WPVR_LANG ),
), $wpvr_options['unwantOnDelete'] ); ?>


<!-- logsPerPage *** -->
<?php wpvr_render_input_option( array(
	'tab'   => 'general',
	'id'    => 'logsPerPage',
	'class' => 'small',
	'label' => __( 'Logs per page', WPVR_LANG ),
	'desc'  => __( 'Number of log lines to display per page.', WPVR_LANG ),
), $wpvr_options['logsPerPage'] ); ?>

<!-- videosPerPage *** -->
<?php wpvr_render_input_option( array(
	'tab'   => 'general',
	'id'    => 'videosPerPage',
	'class' => 'small',
	'label' => __( 'Videos per page', WPVR_LANG ),
	'desc'  => __( 'Number of videos to display per page.', WPVR_LANG ) . '<br/>' .
	           __( 'Works on Manage Videos, Duplicates, Deferred Videos, Unwanted Videos screens.', WPVR_LANG ),
), $wpvr_options['videosPerPage'] ); ?>

<!-- showMenuFor -->
<?php wpvr_addon_option_render( array(
	'id'          => 'showMenuFor',
	'order'       => 10,
	'label'       => __( 'User roles with enabled WPVR links', WPVR_LANG ),
	'maxItems'    => '255',
	'placeholder' => __( 'Pick one or more user roles.', WPVR_LANG ),
	'values'      => $wpvr_roles['available'],
	'desc'        => __( 'Choose which user roles will have WPVR menu links enabled.', WPVR_LANG ),
	'type'        => 'multiselect',
	'default'     => '',
	'tab_class'   => 'tab_a',
), $wpvr_options['showMenuFor'] );
?>

