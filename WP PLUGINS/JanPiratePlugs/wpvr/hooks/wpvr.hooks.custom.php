<?php
	
	add_action( 'wpvr_event_add_video_done', 'wpvr_add_notice_trigger_function', 10, 1 );
	function wpvr_add_notice_trigger_function( $count_videos ) {
		if ( WPVR_ASK_TO_RATE_TRIGGER === false ) {
			return false;
		}
		global $current_user;
		$user_id = $current_user->ID;
		
		//update_option('koko' , $count_videos );
		
		if ( get_user_meta( $user_id, 'wpvr_user_has_voted', true ) == 1 ) {
			return false;
		}
		$level_reached = wpvr_is_reaching_level( $count_videos );
		if ( $level_reached != false ) {
			$message = "<p class='wpvr_dialog_icon'><i class='fa fa-trophy'></i></p>" .
			           "<div class='wpvr_dialog_msg'>" .
			           "<p>Hey, you just have crossed <strong>$count_videos</strong> videos imported with WPVR. That's Awesome !</p>" .
			           "<p>Could you please do us a big favor and give WP Video Robot a 5-star rating on Codecanyon ?" .
			           "<br/>That will help us spread the word and boost our motivation.</p>" .
			           "<strong>~pressaholic</strong>" .
			           "</div>";
			
			//$token = bin2hex( openssl_random_pseudo_bytes( 16 ) );
			
			
			wpvr_add_notice( array(
				'slug'               => "rating_notice_" . $level_reached,
				'title'              => 'Congratulations !',
				'class'              => 'updated', //updated or warning or error
				'content'            => $message,
				'hidable'            => true,
				'is_dialog'          => true,
				'dialog_modal'       => false,
				'dialog_delay'       => 1500,
				//'dialog_ok_button' => '',
				'dialog_ok_button'   => ' <i class="fa fa-heart"></i> RATE WPVR NOW',
				'dialog_hide_button' => '<i class="fa fa-close"></i> DISMISS ',
				'dialog_class'       => ' askToRate ',
				'dialog_ok_url'      => 'http://codecanyon.net/downloads#item-8619739',
			) );
			
		}
		
	}
	
	add_action( 'wp_trash_post', 'wpvr_add_unwanted_on_trash' );
	function wpvr_add_unwanted_on_trash( $post_id ) {
		global $wpvr_options;
		if ( get_post_type( $post_id ) == WPVR_VIDEO_TYPE && $wpvr_options['unwantOnTrash'] === true ) {
			wpvr_unwant_videos( array( $post_id ) );
		}
	}
	
	add_action( 'before_delete_post', 'wpvr_add_unwanted_on_delete' );
	function wpvr_add_unwanted_on_delete( $post_id ) {
		global $wpvr_options;
		if ( get_post_type( $post_id ) == WPVR_VIDEO_TYPE && $wpvr_options['unwantOnDelete'] === true ) {
			wpvr_unwant_videos( array( $post_id ) );
		}
	}
	
	add_action( 'admin_init', 'wpvr_demo_message_ignore' );
	function wpvr_demo_message_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['wpvr_show_demo_notice'] ) && '0' == $_GET['wpvr_show_demo_notice'] ) {
			add_user_meta( $user_id, 'wpvr_show_demo_notice', 'true', true );
		}
		
		if ( isset( $_GET['wpvr_hide_notice'] ) && $_GET['wpvr_hide_notice'] != '' ) {
			add_user_meta( $user_id, $_GET['wpvr_hide_notice'], 'true', true );
		}
		
	}
	
	/* Define Custom Dashboard Widgets */
	add_action( 'wp_dashboard_setup', 'wpvr_custom_dashboard_widget' );
	function wpvr_custom_dashboard_widget() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget(
			'home_dashboard_widget', //ID of the dashboard Widgets
			'WP Video Robot - Global Activity', //Title of the dashboard Widgets
			'wpvr_custom_dashboard_function',
			'side',
			'high'
		);
	}
	
	
	/* Function to prevent from showing content on loops */
	add_action( 'the_content', 'wpvr_remove_flow_content' );
	function wpvr_remove_flow_content( $html ) {
		global $post;
		if ( ! wpvr_is_imported_video( $post->ID ) ) {
			return $html;
		}
		
		if (
			is_admin()
			|| ! defined( 'WPVR_REMOVE_FLOW_CONTENT' )
			|| WPVR_REMOVE_FLOW_CONTENT === false
			|| get_post_type() != WPVR_VIDEO_TYPE
		) {
			return $html;
		} else {
			if ( ! is_singular() ) {
				return '';
			} else {
				return $html;
			}
		}
	}
	
	/* Function to prevent from showing tags on loops */
	add_action( 'term_links-post_tag', 'wpvr_remove_flow_tags' );
	function wpvr_remove_flow_tags( $tags ) {
		if (
			is_admin()
			|| ! defined( 'WPVR_REMOVE_FLOW_TAGS' )
			|| WPVR_REMOVE_FLOW_TAGS === false
			|| get_post_type() != WPVR_VIDEO_TYPE
		) {
			return $tags;
		} else {
			if ( ! is_singular() ) {
				return array();
			} else {
				return $tags;
			}
		}
	}
	
	/* Function for whether to show thumbnail on single */
	add_action( 'post_thumbnail_html', 'wpvr_remove_thumb_single_function' );
	function wpvr_remove_thumb_single_function( $html ) {
		if (
			is_admin()
			|| ! is_singular()
			|| ! defined( 'WPVR_REMOVE_THUMB_SINGLE' )
			|| WPVR_REMOVE_THUMB_SINGLE === false
			|| get_post_type() != WPVR_VIDEO_TYPE
		) {
			return $html;
		} else {
			return '';
		}
	}
	
	/* Function for replacing post thumbnail by embeded video player */
	add_action( 'post_thumbnail_html', 'wpvr_video_thumbnail_embed', 20, 2 );
	function wpvr_video_thumbnail_embed( $html, $post_id ) {
		global $wpvr_options, $wpvr_is_admin;
		if ( get_post_type() != WPVR_VIDEO_TYPE ) {
			return $html;
		}
		if ( $wpvr_is_admin === true || is_admin() || $wpvr_options['videoThumb'] === false ) {
			return $html;
		} else {
			if ( is_singular() ) {
				return $html;
			} else {
				$wpvr_video_id = get_post_meta( $post_id, 'wpvr_video_id', true );
				$wpvr_service  = get_post_meta( $post_id, 'wpvr_video_service', true );
				$player        = wpvr_video_embed(
					$wpvr_video_id,
					$post_id,
					$autoPlay = false,
					$wpvr_service
				);
				$embedCode     = '<div class="wpvr_embed">' . $player . '</div>';
				
				return $embedCode;
			}
		}
	}
	
	/* Function for replacing post thumbnail by embeded video player */
	add_filter( 'post_thumbnail_html', 'wpvr_video_thumbnail_use_service_thumb', 20, 2 );
	function wpvr_video_thumbnail_use_service_thumb( $html, $post_id ) {
		global $wpvr_options, $wpvr_is_admin;
		if ( get_post_type() != WPVR_VIDEO_TYPE ) {
			return $html;
		}
		if ( ! WPVR_DISABLE_THUMBS_DOWNLOAD ) {
			return $html;
		}
		
		if ( get_post_meta( $post_id, '_thumbnail_id', true ) == '' ) {
			$service_image_url = get_post_meta( $post_id, 'wpvr_video_service_thumb', true );
			
			return '<img src="' . $service_image_url . '" />';
		} else {
			return $html;
			//return get_post_meta( $post_id , '_thumbnail_id' );
		}
	}
	
	/* Add EG FIX content trick */
	add_action( 'the_content', 'wpvr_eg_content_hook_fix' );
	function wpvr_eg_content_hook_fix( $content ) {
		global $post;
		if ( ! wpvr_is_imported_video( $post->ID ) ) {
			return $content;
		}
		
		if ( get_post_type() == WPVR_VIDEO_TYPE && WPVR_EG_FIX === true ) {
			$content = preg_replace_callback( "/<iframe (.+?)<\/iframe>/", function ( $matches ) {
				return str_replace( $matches[1], '>', $matches[0] );
			}, $content );
		}
		
		return $content;
	}
	
	add_filter( 'the_content', 'wpvr_video_autoembed_function', 100 );
	function wpvr_video_autoembed_function( $content ) {
		global $post, $wpvr_options, $wpvr_dynamics;
		
		if ( isset( $wpvr_dynamics['autoembed_done'] ) && $wpvr_dynamics['autoembed_done'] == 1 ) {
			return $content;
		}
		if ( ! wpvr_is_imported_video( $post->ID ) ) {
			return $content;
		}
		$disableAutoEmbed = get_post_meta( $post->ID, 'wpvr_video_disableAutoEmbed', true );
		if ( $disableAutoEmbed == 'default' || $disableAutoEmbed == '' ) {
			$disableAutoEmbed = $wpvr_options['autoEmbed'] ? 'off' : 'on';
		}
		
		if ( is_singular() && get_post_type() == WPVR_VIDEO_TYPE ) {
			//d( $disableAutoEmbed );
			
			if ( $disableAutoEmbed == 'on' ) {
				return $content;
			}
			
			$embedCode = wpvr_render_modified_player( $post->ID );
			//d( $embedCode );
			$views = get_post_meta( $post->ID, 'wpvr_video_views', true );
			update_post_meta( $post->ID, 'wpvr_video_views', $views + 1 );
			
			wpvr_update_dynamic_video_views( $post->ID, $views + 1 );
			$text_content = '';
			$text_content .= stripslashes( $wpvr_dynamics['content_tags']['before'] );
			$text_content .= $content;
			$text_content .= stripslashes( $wpvr_dynamics['content_tags']['after'] );
			
			
			if ( $wpvr_options['autoEmbed'] ) {
				//$wpvr_dynamics[ 'autoembed_done' ] = 1;
				if ( $wpvr_options['removeVideoContent'] ) {
					return $embedCode . ' <br/> ';
				} else {
					return $embedCode . ' <br/> ' . $text_content;
				}
			} else {
				return $text_content;
			}
			
		} else {
			return $content;
		}
		
	}
	
	add_filter( 'wpvr_extend_found_item_author_data', 'wpvr_add_video_author_data', 100, 5 );
	function wpvr_add_video_author_data( $videoItem, $channel_title = null, $channel_id = null, $thumbnail = null, $link = null ) {
		
		
		$title_length        = 18;
		$videoItem['author'] = false;
		if ( $channel_title == '' || $channel_id == '' ) {
			return $videoItem;
		}
		if ( strlen( $channel_title ) > $title_length ) {
			$channel_title_cut = mb_substr( $channel_title, 0, $title_length ) . '...';
		} else {
			$channel_title_cut = $channel_title;
		}
		
		$videoItem['author'] = array(
			'id'        => $channel_id,
			'title'     => $channel_title,
			'title_cut' => $channel_title_cut,
			'thumbnail' => $thumbnail,
			'link'      => $link,
		);
		
		//d( $videoItem );
		return $videoItem;
	}
	
	add_filter( 'wpvr_extend_define_videos_columns', 'wpvr_vptf_define_videos_columns', 1 );
	function wpvr_vptf_define_videos_columns() {
		global $wpvr_options;
		if ( $wpvr_options['adminOverride'] === true ) {
			return true;
		} else {
			return false;
		}
		
		
	}
	
	/*************************************/
	
	//add_action( 'add_meta_boxes' , 'wpvr_adapt_cpt_meta_boxes' , 1000 );
	function wpvr_adapt_cpt_meta_boxes() {
		
		global $wp_meta_boxes, $post;
		$wpvr_mb = get_option( 'wpvr_mb' );
		if ( $wpvr_mb == '' || $wpvr_mb == array() ) {
			return false;
		}
		if ( $post->post_type != WPVR_VIDEO_TYPE ) {
			return false;
		}
		
		$theme = wp_get_theme(); // gets the current theme
		if ( $theme->parent_theme == '' ) {
			$theme_name = $theme->name;
		} else {
			$theme_name = $theme->parent_theme;
		}
		if ( ! isset( $wpvr_mb[ $theme_name ] ) ) {
			return false;
		}
		$mbs = $wpvr_mb[ $theme_name ];
		
		foreach ( (array) $mbs['side'] as $id => $mb ) {
			$wp_meta_boxes[ WPVR_VIDEO_TYPE ]['side'][ $mb['level'] ][ $mb['id'] ] = $mb;
		}
		
		foreach ( (array) $mbs['normal'] as $id => $mb ) {
			$wp_meta_boxes[ WPVR_VIDEO_TYPE ]['normal'][ $mb['level'] ][ $mb['id'] ] = $mb;
		}
	}
	
	add_action( 'add_meta_boxes', 'wpvr_update_cpt_meta_boxes', 1000 );
	function wpvr_update_cpt_meta_boxes() {
		global $wp_meta_boxes, $wpvr_getmb_unsupported_themes;
		
		//d( $_GET );
		
		$theme = wp_get_theme(); // gets the current theme
		if ( $theme->parent_theme == '' ) {
			$theme_name = $theme->name;
		} else {
			$theme_name = $theme->parent_theme;
		}
		
		
		if ( in_array( $theme_name, $wpvr_getmb_unsupported_themes ) ) {
			return false;
		}
		//d( $theme_name );
		
		
		//if( isset( $_GET[ 'wpvr_reset_mb' ] ) && $_GET[ 'wpvr_reset_mb' ] == '1' ) $wpvr_mb = array();
		if ( isset( $_GET['wpvr_clear_mb'] ) && $_GET['wpvr_clear_mb'] == 1 ) {
			update_option( 'wpvr_mb', array() );
			
			return false;
		}
		if ( ! isset( $_GET['wpvr_get_mb'] ) || $_GET['wpvr_get_mb'] != 1 ) {
			return false;
		}
		//d( $_GET );
		
		$wpvr_mb = get_option( 'wpvr_mb' );
		if ( $wpvr_mb == '' ) {
			$wpvr_mb = array();
		}
		if ( isset( $_GET['wpvr_reset_mb'] ) && $_GET['wpvr_reset_mb'] == 1 ) {
			$wpvr_mb = array();
		}
		
		//if( isset( $wpvr_mb[ $theme_name ] ) ) return FALSE;
		$wpvr_mb[ $theme_name ] = array(
			'theme'  => $theme,
			'normal' => array(),
			'side'   => array(),
		);
		
		$mb_post_types = apply_filters( 'wpvr_extend_mb_post_types', array( 'post' ) );
		
		
		foreach ( (array) $mb_post_types as $post_type ) {
			
			//d( $post_type );
			if ( ! isset( $wp_meta_boxes[ $post_type ] ) ) {
				continue;
			}
			//Cloning Normal metaboxes
			foreach ( (array) $wp_meta_boxes[ $post_type ]['normal'] as $level => $mbs ) {
				//d( $mbs );
				foreach ( (array) $mbs as $mb ) {
					
					$mb['level'] = $level;
					
					$wpvr_mb[ $theme_name ]['normal'][ $mb['id'] ] = $mb;
				}
			}
			//Cloning Side metaboxes
			foreach ( (array) $wp_meta_boxes[ $post_type ]['side'] as $level => $mbs ) {
				//d( $mbs );
				foreach ( (array) $mbs as $mb ) {
					$mb['level'] = $level;
					
					$wpvr_mb[ $theme_name ]['side'][ $mb['id'] ] = $mb;
				}
			}
		}
		//d( $wpvr_mb );
		update_option( 'wpvr_mb', $wpvr_mb );
		
		$msg  = __( 'New Theme Metaboxes detected and added.', WPVR_LANG ) . '<br/>' .
		        __( 'You can now handle your imported videos as any regular Wordpress post.' ) . '<br/><br/>' .
		        '<a id="wpvr_get_mb_close" href="#">' . __( 'Close', WPVR_LANG ) . '</a>';
		$slug = wpvr_add_notice( array(
			'title'     => 'WP Video Robot : ',
			'class'     => 'updated', //updated or warning or error
			'content'   => $msg,
			'hidable'   => false,
			'is_dialog' => false,
			'show_once' => true,
			'color'     => '#27A1CA',
			'icon'      => 'fa-cube',
		) );
		wpvr_render_notice( $slug );
		wpvr_remove_notice( $slug );
		
		?>
        <style>
            #poststuff {
                display: none;
            }

            .wrap h1 {
                visibility: hidden;
            }
        </style>
		<?php
	}
	
	add_filter( 'wpvr_show_silence_is_golden', 'wpvr_define_silence_message', 100, 1 );
	function wpvr_define_silence_message( $message ) {
		ob_start();
		
		?>
        <style>
            body {
                background: #f0f0f0;
                margin: 1em;
                font-family: Arial;
                color: #222222;
                font-size: 14px;
            }
        </style>
        <div style="background: #FFF;padding: 1em 2em;width: 300px;border-radius: 3px;margin: 50px auto;">
            <strong><?php echo __( 'WP Video Robot is working properly.', WPVR_LANG ); ?></strong>
            <br/>
            <br/>
			<?php echo __( 'Enable CRON Debug Mode to have more details about the automation process.', WPVR_LANG ); ?>
        </div>
		<?php
		
		$output = ob_get_contents();
		ob_get_clean();
		
		return $output;
	}


// add_filter( 'wpvr_extend_found_item', 'wpvr_dm_add_sprite_url_to_video_item', 100, 2 );
// function wpvr_dm_add_sprite_url_to_video_item( $videoItem, $item ) {
// 	if ( $videoItem['service'] != 'dailymotion' ) {
// 		return $videoItem;
// 	}
//
// 	if ( ! isset( $item['sprite_320x_url'] ) || empty( $item['sprite_320x_url'] ) ) {
// 		return $videoItem;
// 	}
//
// 	$videoItem['sprite'] = $item['sprite_320x_url'];
//
// 	return $videoItem;
//
// }

// add_filter( 'wpvr_extend_video_metas', 'wpvr_dm_extend_video_metas', 100, 2 );
// function wpvr_dm_extend_video_metas( $metas, $videoItem ) {
// 	if ( $videoItem['service'] != 'dailymotion' ) {
// 		return $metas;
// 	}
//
// 	$metas['wpvr_video_service_sprite'] = $videoItem['sprite'];
//
// 	return $metas;
// }

// function wpvr_dm_get_sprite_cropped_raw_content( $sprite_url ) {
// 	$filename = WPVR_PATH . '/tmp/' . rand( 0, 500 ) . '.jpg';
// 	file_put_contents( $filename, @file_get_contents( $sprite_url ) );
//
// 	list( $current_width, $current_height ) = getimagesize( $filename );
//
// 	$left = 0;
// 	$top  = 0;
//
// 	$crop_width  = $current_width;
// 	$crop_height = 180;
//
// 	$canvas        = imagecreatetruecolor( $crop_width, $crop_height );
// 	$current_image = imagecreatefromjpeg( $filename );
// 	imagecopy( $canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height );
// 	imagejpeg( $canvas, $filename, 100 );
// 	$raw_content = @file_get_contents( $filename );
//
// 	//delete tmp
//
// 	return $raw_content;
// }

// add_filter( 'wpvr_extend_featured_image_raw_content', 'wpvr_dm_extend_featured_raw_content', 100, 2 );
// function wpvr_dm_extend_featured_raw_content( $raw_content, $post_id ) {
// 	$metas = get_post_meta( $post_id );
//
// 	if ( ! isset( $metas['wpvr_video_service'] ) || $metas['wpvr_video_service'][0] != 'dailymotion' ) {
// 		return $raw_content;
// 	}
//
// 	if ( ! isset( $metas['wpvr_video_service_sprite'] ) || empty( $metas['wpvr_video_service_sprite'][0] ) ) {
// 		return $raw_content;
// 	}
// 	$sprite_url = $metas['wpvr_video_service_sprite'][0];
// 	return wpvr_dm_get_sprite_cropped_raw_content( $sprite_url );
// }
	
	
	add_action( 'init', 'wpvr_show_loading' );
	function wpvr_show_loading() {
		global $wpvr_global_loading;
		
		if ( $wpvr_global_loading === true ) {
			return false;
		}
		
		if ( ! isset( $_GET['page'] ) || $_GET['page'] != 'wpvr' ) {
			return false;
		}
		
		if (
			! isset( $_GET['test_sources'] )
			&& ! isset( $_GET['run_sources'] )
		) {
			return false;
		}
		
		$wpvr_global_loading = true;
		
		?>
        <div class="wpvr_global_loading wpvr_hide_when_loaded">
            <div class="wpvr_global_loading_inner">
                <img class="" src="<?php echo WPVR_URL . 'assets/images/spinner.white.gif' ?>">
                <span><?php echo __( 'Please Wait ...', WPVR_LANG ); ?></span>
            </div>
        </div>
        <style>

            .wpvr_global_loading {
                position: fixed;
                background: rgba(0, 0, 0, 0.6);
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                z-index: 1000;
                color: #FFF;
                text-align: center;
                padding-top: 70px;
            }

            .wpvr_global_loading_inner {
                background: rgb(255, 255, 255);
                width: 200px;
                margin: 0 auto;
                padding: 10px;
                border-radius: 3px;
                color: #999;
                text-align: center;

            }

            .wpvr_global_loading img {
                display: block;
                margin: 0 auto 5px auto;
            }
        </style>
		<?php
	}