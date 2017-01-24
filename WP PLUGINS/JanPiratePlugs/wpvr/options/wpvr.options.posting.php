<!-- autoPublish *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'autoPublish',
	'label' => __( 'Auto Publish', WPVR_LANG ),
	'desc'  => __( 'Automatically publish imported videos. If you sety this option to off, imported videos will get pending status until you review them.', WPVR_LANG ),
), $wpvr_options['autoPublish'] ); ?>

<!-- getPostDate -->
<?php wpvr_render_select_option( array(
	'tab'     => 'posting',
	'id'      => 'getPostDate',
	'label'   => __( 'Default Post Date', WPVR_LANG ),
	'desc'    => __( 'The default date to use when publishing improted videos.', WPVR_LANG ),
	'options' => array(
		'original' => __( 'Use Original Post Date', WPVR_LANG ),
		'new'      => __( 'Use Import Date ', WPVR_LANG ),
	),
), $wpvr_options['getPostDate'] ); ?>


<!-- postContent -->
<?php wpvr_render_select_option( array(
	'tab'     => 'posting',
	'id'      => 'postContent',
	'label'   => __( 'Default Post Content', WPVR_LANG ),
	'desc'    => __( 'Default post video text content for imported videos.', WPVR_LANG ),
	'options' => array(
		'on'  => __( 'Import & Post Video Text Content', WPVR_LANG ),
		'off' => __( 'Skip Video Text Content', WPVR_LANG ),
	),
), $wpvr_options['postContent'] ); ?>


<!-- postFormat -->
<?php if ( WPVR_ENABLE_POST_FORMATS ) { ?>
	<?php wpvr_render_select_option( array(
		'tab'     => 'posting',
		'id'      => 'postFormat',
		'label'   => __( 'Default Post Format', WPVR_LANG ),
		'desc'    => __( 'Default post format to apply to all the imported videos.', WPVR_LANG ),
		'options' => array(
			'0'       => __( 'Standard', WPVR_LANG ),
			'aside'   => __( 'Aside', WPVR_LANG ),
			'image'   => __( 'Image', WPVR_LANG ),
			'video'   => __( 'Video', WPVR_LANG ),
			'audio'   => __( 'Audio', WPVR_LANG ),
			'quote'   => __( 'Quote', WPVR_LANG ),
			'link'    => __( 'Link', WPVR_LANG ),
			'gallery' => __( 'Gallery', WPVR_LANG ),
		),
	), $wpvr_options['postFormat'] ); ?>
<?php } ?>

<!-- postTags *** -->
<?php wpvr_render_input_option( array(
	'tab'   => 'posting',
	'id'    => 'postTags',
	'label' => __( 'Default Post Tags', WPVR_LANG ),
	'desc'  => __( 'Tags to add automatically to imported videos.', WPVR_LANG ) . ' <br/>' .
	           __( 'Comma separated.', WPVR_LANG ),
), $wpvr_options['postTags'] ); ?>


<!-- postAuthor -->
<?php $authorsArray = wpvr_get_authors( $invert = true, $default = false, $restrict = false ); ?>
<?php wpvr_render_select_option( array(
	'tab'     => 'posting',
	'id'      => 'postAuthor',
	'label'   => __( 'Default Posting Author', WPVR_LANG ),
	'desc'    => __( 'Define the default author to assign imported videos to.', WPVR_LANG ),
	'options' => $authorsArray,
), $wpvr_options['postAuthor'] ); ?>




<!-- startWithServiceViews *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'startWithServiceViews',
	'label' => __( 'Start local views count with Video Service views count ?', WPVR_LANG ),
	'desc'  => __( 'Enable this option to start your imported views count with the real video service views count.', WPVR_LANG ) . '<br/>' .
	           __( 'If you disable this option, the local views count will start at 0.', WPVR_LANG ),
), $wpvr_options['startWithServiceViews'] ); ?>


