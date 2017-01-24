<!-- autoRunMode *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'automation',
	'id'    => 'autoRunMode',
	'label' => __( 'Enable AutoRun Mode', WPVR_LANG ),
	'desc'  => __( 'Disable this option to stop the plugin from working in background.', WPVR_LANG ) . '<br/>' .
	           '<div class="wpvr_switch_conditional_content">' . wpvr_render_automation_data() . '</div>',
), $wpvr_options['autoRunMode'] ); ?>


<!-- wakeUpHours *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'automation',
	'id'    => 'wakeUpHours',
	'label' => __( 'Automation Working Hours', WPVR_LANG ),
	'desc'  => __( 'Define the time range when the plugin should work.', WPVR_LANG ) . '<br/>' .
	           __( 'Turn this off if you want the plugin to work all the time.', WPVR_LANG ) . '<br/>' .
	           '<div class="wpvr_switch_conditional_content">' . wpvr_render_wake_up_hours() . '</div>',
), $wpvr_options['wakeUpHours'] ); ?>