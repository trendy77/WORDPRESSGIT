<?php
	
	
	//Defining wantedValues PArams
	if ( ! defined( 'WPVR_MAX_WANTED_VIDEOS' ) || WPVR_MAX_WANTED_VIDEOS === false ) {
		$wanted_limit   = __( 'Unlimited', WPVR_LANG );
		$wanted_maximum = '';
	} else {
		$wanted_limit   = __( 'Limited to', WPVR_LANG ) . ' : ' . WPVR_MAX_WANTED_VIDEOS;
		$wanted_maximum = WPVR_MAX_WANTED_VIDEOS;
	}


?>


<!-- wantedVideos *** -->
<?php wpvr_render_input_option( array(
	'tab'        => 'fetching',
	'id'         => 'wantedVideos',
	'class'         => 'small',
	'label'      => __( 'Default Wanted Videos', WPVR_LANG ),
	'desc'       => __( 'Number of videos to get by default per source.', WPVR_LANG ) .
	                ' (<i>' . $wanted_limit . '</i>)',
	'attributes' => array(
		'max_value' => $wanted_maximum,
	),
), $wpvr_options['wantedVideos'] ); ?>


<!-- orderVideos -->
<?php wpvr_render_select_option( array(
	'tab'     => 'fetching',
	'id'      => 'orderVideos',
	'label'   => __( 'Default Order criterion', WPVR_LANG ),
	'desc'    => __( 'Default criterion for ordering fetched videos.', WPVR_LANG ) .
	             '(<i>' . $wanted_limit . '</i>)',
	'options' => array(
		'relevance' => __( 'Relevance', WPVR_LANG ),
		'date'      => __( 'Date', WPVR_LANG ),
		'viewCount' => __( 'Views', WPVR_LANG ),
		'title'     => __( 'title', WPVR_LANG ),
	),
), $wpvr_options['orderVideos'] ); ?>

<!-- publishedAfter *** -->
<?php wpvr_render_input_option( array(
	'tab'         => 'fetching',
	'id'          => 'publishedAfter',
	'label'       => __( 'Default Published After Date', WPVR_LANG ),
	'desc'        => __( 'Import only videos published after this date.', WPVR_LANG ) . ' ' .
	                 __( 'Leave empty to ignore this criterion.', WPVR_LANG ) .
	                 '<br/><strong>' . __( 'Supported only by Youtube and Dailymotion.', WPVR_LANG ) . '</strong>
	                <br/>Format : mm/dd/YYYY',
	'placeholder' => 'Format : mm/dd/YYYY',
), $wpvr_options['publishedAfter'] ); ?>

<!-- publishedBefore *** -->
<?php wpvr_render_input_option( array(
	'tab'         => 'fetching',
	'id'          => 'publishedBefore',
	'label'       => __( 'Default Published Before Date', WPVR_LANG ),
	'desc'        => __( 'Import only videos published before this date.', WPVR_LANG ) . ' ' .
	                 __( 'Leave empty to ignore this criterion.', WPVR_LANG ) .
	                 '<br/><strong>' . __( 'Supported only by Youtube and Dailymotion.', WPVR_LANG ) . '</strong>
	                <br/>Format : mm/dd/YYYY',
	'placeholder' => 'Format : mm/dd/YYYY',
), $wpvr_options['publishedBefore'] ); ?>

<!-- videoQuality -->
<?php wpvr_render_select_option( array(
	'tab'     => 'fetching',
	'id'      => 'videoQuality',
	'label'   => __( 'Default Video Quality', WPVR_LANG ),
	'desc'    => __( 'Choose what quality should sources filter by default.', WPVR_LANG ),
	'options' => array(
		'any'      => __( 'All Videos', WPVR_LANG ),
		'high'     => __( 'Only High Definition Videos', WPVR_LANG ),
		'standard' => __( 'Only Standard Definitions Videos', WPVR_LANG ),
	),
), $wpvr_options['videoQuality'] ); ?>

<!-- videoDuration -->
<?php wpvr_render_select_option( array(
	'tab'     => 'fetching',
	'id'      => 'videoDuration',
	'label'   => __( 'Default Video Duration', WPVR_LANG ),
	'desc'    => __( 'Choose what duration should sources filter by default.', WPVR_LANG ),
	'options' => array(
		'any'    => __( 'All Videos', WPVR_LANG ),
		'short'  => __( 'Videos less than 4min.', WPVR_LANG ),
		'medium' => __( 'Videos between 4min. and 20min.', WPVR_LANG ),
		'long'   => __( 'Videos longer than 20min.', WPVR_LANG ),
	),
), $wpvr_options['videoDuration'] ); ?>

<!-- onlyNewVideos *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'onlyNewVideos',
	'label' => __( 'Skip Duplicates', WPVR_LANG ),
	'desc'  => __( 'Enable this option to import only new videos. Duplicates will be skipped.', WPVR_LANG ),
), $wpvr_options['onlyNewVideos'] ); ?>

<!-- getStats *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'getStats',
	'label' => __( 'Get Video Stats', WPVR_LANG ),
	'desc'  => __( 'Grab Youtube views, duration and likes. You can improve performances by setting this option to off.', WPVR_LANG ),
), $wpvr_options['getStats'] ); ?>

<!-- getTags *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'getTags',
	'label' => __( 'Get Video Tags', WPVR_LANG ),
	'desc'  => __( 'Grab Official Youtube tags (meta keywords). You can improve performances by setting this option to off.', WPVR_LANG ),
), $wpvr_options['getTags'] ); ?>

<!-- getFullDesc *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'getFullDesc',
	'label' => __( 'Get Video Full Desc.', WPVR_LANG ),
	'desc'  => __( 'Grab the video full description ? You can improve performances by setting this option to off.', WPVR_LANG ),
), $wpvr_options['getFullDesc'] ); ?>

<!-- enableAsync *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'enableAsync',
	'label' => __( 'Asynchronous Execution', WPVR_LANG ),
	'desc'  => __( 'Once enabled, this feature allows WPVR to execute several sources at once.', WPVR_LANG ) . '<br/>' .
	           __( 'Unfortunately, it does not work on all server configurations. Turn it off if you have any troubles while executing sources.', WPVR_LANG ),
), $wpvr_options['enableAsync'] ); ?>



