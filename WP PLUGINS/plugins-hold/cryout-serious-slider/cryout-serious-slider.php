<?php
/*
    Plugin Name: Cryout Serious Slider
    Plugin URI: http://www.cryoutcreations.eu/serious-slider
    Description: Responsive slider, built on Bootstrap Carousel, uses core WordPress functionality, easy to use, seriously.
    Version: 0.6
    Author: Cryout Creations
    Author URI: http://www.cryoutcreations.eu
	Text Domain: cryout-serious-slider
	License: GPLv3
	License URI: http://www.gnu.org/licenses/gpl.html
*/

class Cryout_Serious_Slider {
	
	public $version = "0.5.1";
	public $options = array();
	public $shortcode_tag = 'serious-slider';
	public $mce_tag = 'serious_slider';
	
	public $slug = 'cryout-serious-slider';
	public $posttype = 'cryout_serious_slide';  // 20 chars!
	public $taxonomy = 'cryout_serious_slider_category';
	private $title = '';
	private $thepage = '';
	private $aboutpage = '';
	private $addnewpage = '';
	public $defaults = array(
		'cryout_serious_slider_sort' => 'date', 		// date, order
		'cryout_serious_slider_sizing' => 0, 			// 1 = force slider size
		'cryout_serious_slider_width' => '1920', 		// px
		'cryout_serious_slider_height' => '700', 		// px
		'cryout_serious_slider_theme' => 'light',		// light, dark, theme, bootstrap
		'cryout_serious_slider_textsize' => '1.0', 		// em
		'cryout_serious_slider_overlay' => 1, 			// 1 = autohide, 2 = visible
		'cryout_serious_slider_animation' => 'slide', 	// fade, slide, overslide, underslide, parallax, hflip, vflip
		'cryout_serious_slider_hover' => 'hover', 		// hover, false
		'cryout_serious_slider_delay' => 5000,			// ms
		'cryout_serious_slider_transition' => 1000		// ms
	);

	public function __construct(){
		require_once( plugin_dir_path( __FILE__ ) . 'inc/shortcodes.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'inc/widgets.php' );
		add_action( 'init', array( $this, 'register' ) );	
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ), 0 );
		add_action( 'setup_theme', array( $this, 'register_taxonomies' ), 0 );
	} // __construct()

	
	/**********************
	* main class registration function
	***********************/
	public function register(){
	
		$this->title = __( 'Serious Slider', 'cryout-serious-slider' );
		$this->aboutpage = 'edit.php?post_type=' . $this->posttype . '&page=' . $this->slug . '-about';
		$this->addnewpage = 'post-new.php?post_type=' . $this->posttype;
	
		//$this->options = $this->get_settings();		
		
		if (! is_admin() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) ); 	
		} // if (! is_admin())
		
		if (is_admin() ) {

			//add_action( 'admin_init', array( $this, 'register_settings' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'actions_links' ), -10 );
			add_filter( 'plugin_row_meta', array( $this, 'meta_links' ), 10, 2 );
			add_action( 'admin_menu', array( $this, 'settings_menu' ) );
			
			// slides list page columns customizations
			add_filter( 'manage_edit-'.$this->posttype.'_columns', array($this, 'columns_edit' ) );
			add_action( 'manage_'.$this->posttype.'_posts_custom_column', array($this, 'columns_content'), 10, 2 );
			add_filter( 'manage_edit-'.$this->posttype.'_sortable_columns', array($this, 'order_column_register_sortable') );
			//add_action( 'admin_head-edit.php', array($this, 'custom_list_css') );
			//add_action( 'admin_head-edit-tags.php', array($this, 'custom_list_css') );
			//add_action( 'admin_head-post-new.php', array($this, 'custom_list_css') );
			add_action( 'restrict_manage_posts', array($this, 'add_taxonomy_filters') );
			add_action( 'save_post', array($this, 'metabox_save') );

			// shortcode button
			add_action( 'admin_head', array( $this, 'admin_head') );
			add_action( 'admin_enqueue_scripts', array($this , 'admin_enqueue_scripts' ) );
			
			$localized_mce_strings = array(
				'text_retrieving_sliders' => __('Retrieving sliders...', 'cryout-serious-slider'),
				'text_retrieving_sliders_error' => __('Error retrieving sliders', 'cryout-serious-slider'),
				'text_serious_slider' => __('Cryout Serious Slider', 'cryout-serious-slider'),
				'text_serious_slider_tooltip' => __('Serious Slider', 'cryout-serious-slider'),
				'text_insert_slider' => __('Insert Slider', 'cryout-serious-slider'),
				'text_cancel' => __('Cancel', 'cryout-serious-slider'),
				'text_select_slider' => __('Select Slider', 'cryout-serious-slider'),
				'text_add_slider' => __('Add Slider', 'cryout-serious-slider'),
			);
			
			// ajax handling for slider parameters in shortcode button generator
			wp_enqueue_script( 'cryout-serious-slider-ajax', plugins_url( 'resources/backend.js', __FILE__ ), NULL, $this->version );
			wp_localize_script( 'cryout-serious-slider-ajax', 'cryout_serious_slider_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
			wp_localize_script( 'cryout-serious-slider-ajax', 'CRYOUT_MCE_LOCALIZED', $localized_mce_strings );
			add_action( 'wp_ajax_cryout_serious_slider_ajax', array( $this, 'get_sliders_json' ) ); // auth users
			add_action( 'wp_ajax_nopriv_cryout_serious_slider_ajax', array( $this, 'get_sliders_json' ) ); // no auth users
			
		} // if (is_admin())
	
		add_action( 'plugins_loaded', array( $this, 'load_textdomain') );
	
	} // register()
	

	/**********************
	* translation domain
	***********************/
	function load_textdomain() {
	  load_plugin_textdomain( 'cryout-serious-slider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
	}

	
	/**********************
	* enqueues
	***********************/
	public function enqueue_scripts() {
		wp_enqueue_script( 'cryout-serious-slider-jquerymobile', plugins_url( 'resources/jquery.mobile.custom.min.js', __FILE__ ), array('jquery'), $this->version );
		wp_enqueue_script( 'cryout-serious-slider-script', plugins_url( 'resources/slider.js', __FILE__ ), NULL, $this->version );
	} // enqueue_scripts()
	
	public function enqueue_styles() {
		wp_register_style( 'cryout-serious-slider-style', plugins_url( 'resources/style.css', __FILE__ ), NULL, $this->version );
		wp_enqueue_style( 'cryout-serious-slider-style' ); 
	} // enqueue_styles()
	
	
	/**********************
	* settings
	***********************/
	/* // register plugin settings
	public function register_settings() {
		register_setting( 'cryout_serious_slider_group', 'cryout_serious_slider' );	
	} // register_settings()*/
	
	// register settings page to dashboard menu
	public function settings_menu() {
		$this->thepage = add_submenu_page( 'edit.php?post_type='.$this->posttype, __('About', 'cryout-serious-slider'), __('About', 'cryout-serious-slider'), 'manage_options', $this->slug . '-about', array( $this, 'settings_page' ) );
	} // settings_menu()
	
	public function settings_page() {
		if (!empty($_GET['add_sample_content']))
			include_once( plugin_dir_path( __FILE__ ) . 'demo/demo-content.php' );
		require_once( plugin_dir_path( __FILE__ ) . 'inc/settings.php' );
	} // settings_page()
	
	// add plugin actions links
	public function actions_links( $links ) {
		array_unshift( $links, '<a href="' . $this->aboutpage . '">' . __( 'About Plugin', 'cryout-serious-slider' ) . '</a>' );
		return $links;
	}

	// add plugin meta links
	public function meta_links( $links, $file ) {
		// Check plugin
		if ( $file === plugin_basename( __FILE__ ) ) {
			unset( $links[2] );
			$links[] = '<a href="http://www.cryoutcreations.eu/cryout-serious-slider/" target="_blank">' . __( 'Plugin homepage', 'cryout-serious-slider' ) . '</a>';
			$links[] = '<a href="http://www.cryoutcreations.eu/forum/" target="_blank">' . __( 'Support forum', 'cryout-serious-slider' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/plugins/cryout-serious-slider/changelog/" target="_blank">' . __( 'Changelog', 'cryout-serious-slider' ) . '</a>';
		}
		return $links;
	}
	
	/* settings handlers */
/*	public function get_settings() {
		$options = get_option('cryout_serious_slider');
		$options = array_merge($this->defaults,(array)$options);
		$this->options = $options;
		return $options;
	} // get_settings()
	
	public function save_settings() {
		if ( isset( $_POST['settings_submit'] ) && check_admin_referer( 'cryout_serious_slider', '_wpnonce' ) ):
			$saved_options = $_POST['cryout_serious_slider'];
			
			foreach ($saved_options as $option => $value):
				$saved_options[$option] = wp_kses_data($value);
			endforeach;

			update_option( 'cryout_serious_slider', $saved_options );
			wp_redirect( 'edit.php?post_type='.$this->posttype.'&page='.$this->slug.'-settings'.'&updated=true' );
		endif;
	} // save_settings() */
	
	
	/**********************
	* helpers
	***********************/
	public function get_slider_meta($sid, $term) {
		// ???????????????????????
	} // get_slider_meta
	
	/* return taxonomy id for slide id */
	public function get_slide_slider( $slide_ID, $taxonomy = '') {
		if (empty($taxonomy)) $taxonomy = $this->taxonomy;
		$tax = wp_get_object_terms( $slide_ID, $taxonomy );
		if (!empty($tax))
			return $tax[0]->term_id;
		else
			return 0;
	} // get_slide_slider()
	
	/* return sliders list for mce insert window */
	public function get_sliders_json() {
		$sliders = $this->get_sliders();
		echo json_encode($sliders);
		wp_die();
	} // get_sliders_json()
	
	public function get_sliders() {
		$data = get_terms( $this->taxonomy, array( 'hide_empty' => false ) );
		
		$sliders = array();
		foreach ($data as $slider) {
			$sliders[] = array('text'=>$slider->name, 'value'=>$slider->term_id);
		}
		
		if (count($sliders)<1) $sliders = array( array('text' => __('No sliders available. Create a slider first...', 'cryout-serious-slider'), 'value' => 0) );
			
		return $sliders;
	} // get_sliders()
	
	// theme compatibility function
	public function get_sliders_list() {
		$data = get_terms( $this->taxonomy, array( 'hide_empty' => false ) );
		
		$sliders = array();
		foreach ($data as $slider) {
			if (!empty($slider->term_id)) $sliders[$slider->term_id] = $slider->name;
		}
		return $sliders;
	} // get_sliders_list()
	
	/* customize taxonomy selection box in add slide window */
	function custom_category_picker( $post, $box ) {
		$defaults = array( 'taxonomy' => 'category' );
		if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
			$args = array();
		} else {
			$args = $box['args'];
		}
		$r = wp_parse_args( $args, $defaults );
		$tax_name = esc_attr( $r['taxonomy'] );
		$taxonomy = get_taxonomy( $r['taxonomy'] );
		?>
		<div id="taxonomy-<?php echo $tax_name; ?>" class="categorydiv">
				<?php
				$name = ( $tax_name == 'category' ) ? 'post_category' : 'tax_input[' . $tax_name . ']';
				?>
				<ul id="<?php echo $tax_name; ?>_selector" data-wp-lists="list:<?php echo $tax_name; ?>" class="form-no-clear">
					<?php 
						$cat_dropdown_args = array(
							'taxonomy'         => $tax_name,
							'hide_empty'       => 0,
							'name'             => 'tax_input[' . $tax_name . ']',
							'orderby'          => 'name',
							'selected'		   => $this->get_slide_slider( $post->ID ),
							'hierarchical'     => 0,
							'show_option_none' => '&mdash; ' . __('Select slider', 'cryout-serious-slider') . ' &mdash;',
						);

						wp_dropdown_categories( $cat_dropdown_args );				
					?>
				</ul>
				<a class="taxonomy-add-new" href="edit-tags.php?taxonomy=<?php echo $this->taxonomy ?>&post_type=<?php echo $this->posttype; ?>" id=""><?php _e(
				'Define Sliders', 'cryout-serious-slider') ?></a>
		</div>
		<?php
	} // slide_custom_category()
	
	
	/**********************
	* custom post types
	***********************/
	public function register_post_types() {

		/* Set up arguments for the custom post type. */
		$args = array(
			'public' 			=> false,
			'show_ui'			=> true,
			'show_admin_column' => true,
			'query_var' 		=> true,
			'description' 		=> __( 'Description.', 'cryout-serious-slider' ),
			'show_in_nav_menus' => false,
			'menu_position' 	=> 21,
			'menu_icon' 		=> plugins_url('/resources/images/serious-slider-icon.png',__FILE__),
			'capability_type' 	=> 'post',
			'supports' 			=> array(
					'title',
					'editor',
					//'excerpt',
					'thumbnail',
					'page-attributes',
			),
			'labels' 			=> array(
					'name'               => _x( 'Slides', 'post type general name', 'cryout-serious-slider' ),
					'singular_name'      => _x( 'Slide', 'post type singular name', 'cryout-serious-slider' ),
					'menu_name'          => _x( 'Serious Slider', 'admin menu', 'cryout-serious-slider' ),
					'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'cryout-serious-slider' ),
					'add_new'            => _x( 'Add New Slide', 'and new in menu', 'cryout-serious-slider' ),
					'add_new_item'       => __( 'Add New Slide', 'cryout-serious-slider' ),
					'new_item'           => __( 'New Slide', 'cryout-serious-slider' ),
					'edit_item'          => __( 'Edit Slide', 'cryout-serious-slider' ),
					'view_item'          => __( 'View Slide', 'cryout-serious-slider' ),
					'all_items'          => __( 'All Slides', 'cryout-serious-slider' ),
					'search_items'       => __( 'Search Slide', 'cryout-serious-slider' ),
					'parent_item_colon'  => __( 'Parent Slides:', 'cryout-serious-slider' ),
					'not_found'          => sprintf( __( 'No slides found. Go ahead and add <a href="%1$s">add some</a> or <a href="%2$s">load sample content</a>.', 'cryout-serious-slider' ), $this->addnewpage, $this->aboutpage ),
					'not_found_in_trash' => __( 'No slides found in Trash.', 'cryout-serious-slider' )
			),
			'taxonomies' 		=> array( 
					$this->taxonomy,
			),
			'register_meta_box_cb' => array( $this, 'metabox_register' ),
		);

		/* Register the post type. */
		register_post_type( $this->posttype, $args );
		
	} // register_post_types()
	
	/* Set up custom taxonomies for the custom post type */
	public function register_taxonomies() {

		$cat_args = array(
			'public'			=> false,
			'hierarchical'      => true,
			'labels'            => array(
					'name'              => _x( 'Sliders', 'taxonomy general name', 'cryout-serious-slider' ),
					'singular_name'     => _x( 'Slider', 'taxonomy singular name', 'cryout-serious-slider' ),
					'search_items'      => __( 'Search Sliders', 'cryout-serious-slider' ),
					'all_items'         => __( 'All Sliders', 'cryout-serious-slider' ),
					'parent_item'       => __( 'Parent Slider', 'cryout-serious-slider' ),
					'parent_item_colon' => __( 'Parent Slider:', 'cryout-serious-slider' ),
					'edit_item'         => __( 'Edit Slider', 'cryout-serious-slider' ),
					'update_item'       => __( 'Update Slider', 'cryout-serious-slider' ),
					'add_new_item'      => __( 'Add New Slider', 'cryout-serious-slider' ),
					'new_item_name'     => __( 'New Slider', 'cryout-serious-slider' ),
					'menu_name'         => __( 'Define Sliders', 'cryout-serious-slider' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			
			'meta_box_cb' => array( $this, 'custom_category_picker' ), // customize taxonomy box selector
		);

		register_taxonomy( $this->taxonomy, array( $this->posttype ), $cat_args );
		add_action( $this->taxonomy . '_add_form_fields', array($this, 'metatax_main_add'), 10, 2 );
		add_action( $this->taxonomy . '_edit_form_fields', array($this, 'metatax_main_edit'), 10, 2 );
		add_action( $this->taxonomy . '_edit_form', array($this, 'right_column'), 10, 2 ); // _pre_edit_form // _edit_form
		
		add_action( 'edited_' . $this->taxonomy, array($this, 'save_taxonomy_custom_meta'), 10, 2 );  
		add_action( 'create_' . $this->taxonomy, array($this, 'save_taxonomy_custom_meta'), 10, 2 );
		add_action( 'delete_' . $this->taxonomy, array($this, 'delete_taxonomy_custom_meta'), 10, 2 );

	} // register_taxonomies()
	
	
	/**********************
	* dashboard layout customization
	***********************/
	public function columns_edit( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'cryout-serious-slider' ),
			$this->taxonomy => __( 'Slider', 'cryout-serious-slider' ),
			'featured_image' => __( 'Featured Image', 'cryout-serious-slider' ),
			'date' => __( 'Date', 'cryout-serious-slider' ),
			'menu_order' => __( 'Order', 'cryout-serious-slider' ),
		);
		return $columns;
	} // columns_edit()
	
	// Show the featured image & taxonomy in posts list
	public function columns_content($column_name, $post_ID) {
	global $post;
	
		switch ($column_name) {
			case 'featured_image': 
			
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_ID ), 'medium' );
				$featured_image = $featured_image[0];
				if ($featured_image) {
					echo '<img style="max-width: 100%;" src="' . $featured_image . '" />';
				} else {
					_e('No featured image set.', 'cryout-serious-slider');
				}
				
			break;
			
			case $this->taxonomy: 
				
				$terms = get_the_terms( $post->ID, $this->taxonomy );
				if ( !empty( $terms ) ) {

					$out = array();
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%1$s">%2$s</a><div class="row-actions"><span class="edit"><a href="%3$s">%4$s</a></span></div>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, $this->taxonomy => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $this->taxonomy, 'display' ) ),
							esc_url( add_query_arg( array(  'action' => 'edit', 'taxonomy' => $this->taxonomy, 'tag_ID' => $term->term_id, 'post_type' => $post->post_type ), 'edit-tags.php' ) ),
							__('Edit slider', 'cryout-serious-slider')
						);
						
					}
					echo join( ', ', $out );
					
				}

				else {
					_e( 'No Slider', 'cryout-serious-slider' );
				}
				
			break;
			
			case 'menu_order':
			
				$order = $post->menu_order;
				echo $order;
				
			break;
		}
	} // columns_content()
	
	/* Add sort by columns support */
	public function order_column_register_sortable($columns){
	  $columns['menu_order'] = 'menu_order';
	  $columns[$this->taxonomy] = $this->taxonomy;
	  return $columns;
	} // order_column_register_sortable()
	
	/* 
	public function custom_list_css() {
		
	} // custom_list_css() */
	
	function add_taxonomy_filters() {
		global $typenow;
	 
		$taxonomies = array( $this->taxonomy );
	 
		// must set this to the post type you want the filter(s) displayed on
		if( $typenow == $this->posttype ){
	 
			foreach ($taxonomies as $tax_slug) {
				$tax_obj = get_taxonomy($tax_slug);
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				if (!empty($_GET[$tax_slug])) $filtered_tax = sanitize_text_field($_GET[$tax_slug]); else $filtered_tax = '';
				if(count($terms) > 0) {
					echo "<select name='$tax_slug' id='filter_$tax_slug' class='postform'>";
					printf( "<option value=''>%s</option>", sprintf( _x('Select %s', 'select terms', 'cryout-serious-slider'), $tax_name ) );
					foreach ($terms as $term) { 
						echo '<option value='. $term->slug, $filtered_tax == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
					}
					echo "</select>";
				}
			}
		}
	} // add_taxonomy_filters()
	
	// add right column content (with shortcode hint) on edit slider page */
	function right_column( $tag, $taxonomy ) {
		$term_ID = $tag->term_id;
		include_once( plugin_dir_path( __FILE__ ) . 'inc/right-column.php' );
	} // right_column()
	
	/*public function custom_js() {
		global $post_type;

		if( $this->posttype == $post_type ) { ?>
			<script type="text/javascript">
				var html = '<div id="<?php echo $this->taxonomy ?>-definesliders">\
							<a class="hide-if-no-js taxonomy-add-new" href="edit-tags.php?taxonomy=<?php echo $this->taxonomy ?>&post_type=<?php echo $this->posttype; ?>" id="">Define Sliders</a>\
							</div>';
				jQuery(document).ready( function() {
						jQuery('#<?php echo $this->taxonomy ?>-adder').after(html);
				});
			</script> <?php 
		}
	} // custom_js()*/
	
	
	/**********************
	* slide meta
	***********************/
	/* Custom post types metaboxes */
	function metabox_register() {
	    add_meta_box('serious_slider_metaboxes', __( 'Slide Link', 'cryout-serious-slider' ), array($this, 'metabox_main'), $this->posttype, 'normal', 'high');
	} // metabox_register()
	
	function metabox_main() {
	
	    global $post;
		$values = get_post_custom( $post->ID );
		$text = isset( $values['cryout_serious_slider_link'] ) ? $values['cryout_serious_slider_link'][0] : '';
		$check = isset( $values['cryout_serious_slider_target'] ) ? esc_attr( $values['cryout_serious_slider_target'][0] ) : '';
	     
		wp_nonce_field( 'cryout_serious_slider_meta_nonce', 'cryout_serious_slider_meta_nonce' ); ?>
    
		<p>
			<label for="cryout_serious_slider_link"><?php _e('Link URL', 'cryout-serious-slider') ?></label>
			<input type="text" size="40" name="cryout_serious_slider_link" id="cryout_serious_slider_link" value="<?php echo $text; ?>" />
			<span>&nbsp;&nbsp;</span>
			<input type="checkbox" id="cryout_serious_slider_target" name="cryout_serious_slider_target" <?php checked( $check ); ?> />
			<label for="cryout_serious_slider_target"><?php _e('Open In New Window', 'cryout-serious-slider') ?></label>
		<br><em><?php _e('Leave empty to disable link.', 'cryout-serious-slider') ?></em></p>
		<?php 
		
	} // metabox_main()
	
	function metabox_save( $post_id ) {

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if( !isset( $_POST['cryout_serious_slider_meta_nonce'] ) || !wp_verify_nonce( $_POST['cryout_serious_slider_meta_nonce'], 'cryout_serious_slider_meta_nonce' ) ) return;
		if( !current_user_can( 'edit_post' ) ) return;
		$allowed = '';
		
		if( isset( $_POST['cryout_serious_slider_link'] ) )
			update_post_meta( $post_id, 'cryout_serious_slider_link', esc_url_raw( $_POST['cryout_serious_slider_link'], $allowed ) );
		$chk = isset( $_POST['cryout_serious_slider_target'] );
		update_post_meta( $post_id, 'cryout_serious_slider_target', $chk );
		
	} // metabox_save()
	
	
	/**********************
	* slider/taxonomy meta
	***********************/
	public function metatax_main_add() {
		
		$the_meta = $this->defaults;
		require_once( plugin_dir_path( __FILE__ ) . 'inc/taxmeta.php' );
		
	} // metabox_main_add()
	
	public function metatax_main_edit($term) {
		
		$tid = $term->term_id;
		$the_meta = get_option( "cryout_serious_slider_${tid}_meta" );
		if ( empty($the_meta) ) $the_meta = $this->defaults; ?>
		<tr class="form-field">
			<td colspan="2">
		<?php require_once( plugin_dir_path( __FILE__ ) . 'inc/taxmeta.php' );?>
		</td>
		</tr><?php 
	
	} // metatax_main_edit()
	
	function save_taxonomy_custom_meta( $tid ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$term_meta = get_option( "cryout_serious_slider_${tid}_meta" );
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = sanitize_text_field($_POST['term_meta'][$key]); 
				}
			}
			// Save the option array.
			update_option( "cryout_serious_slider_${tid}_meta", $term_meta );
		}
	} // save_taxonomy_custom_meta()
	
	function delete_taxonomy_custom_meta( $term_id ) {
		delete_option( "cryout_serious_slider_${term_id}_meta" );
	} // delete_taxonomy_custom_meta()

	
	/**********************
	* mce extension
	***********************/
	function admin_head() {
		global $post_type;
		global $pagenow;

		// don't allow slider shortcode inside slide posts 
		if( $this->posttype != $post_type && in_array( $pagenow, array( 'edit.php', 'post-new.php', 'post.php' ) ) ) {
			// check user permissions
			if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
				return;
			}
			
			// check if WYSIWYG is enabled
			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( $this ,'register_mce_external_plugins' ) );
				add_filter( 'mce_buttons', array( $this, 'regiter_mce_buttons' ) );
			}
		}
	} // admin_head()
	
	function register_mce_external_plugins( $plugin_array ) {
		$plugin_array[$this->mce_tag] = plugins_url( 'resources/mce-button.js' , __FILE__ );
		return $plugin_array;
	} // register_mce_external_plugins()

	function regiter_mce_buttons( $buttons ) {
		array_push( $buttons, $this->mce_tag );
		return $buttons;
	} // regiter_mce_buttons()

	function admin_enqueue_scripts($hook){
		global $post_type;
		global $pagenow; 
		if ( in_array( $pagenow, array( 'edit.php', 'post-new.php', 'post.php' ) ) ) {
			wp_enqueue_style('serious-slider-shortcode', plugins_url( 'resources/mce-button.css' , __FILE__ ) );
		};
		if( ($hook == $this->thepage) || ( $this->posttype == $post_type ) ) {
			wp_enqueue_style('serious-slider-admincss', plugins_url( 'resources/backend.css' , __FILE__ ) );
		};
	} // admin_enqueue_scripts()
	
	
	/**********************
	* form helpers
	***********************/
	function inputfield( $id, $current, $title='', $desc='', $class='', $extra='', $extra2='' ) {
	/* wordpress/wp-admin/js/tags.js empties all text input elements with 
	   $('input[type="text"]:visible, textarea:visible', form).val('');
	   as of 4.4.2; using type="number" as workaround */
	?>
	<tr><th scope="row"><?php echo $title ?></th>
		<td><input id="<?php echo $id ?>" name="<?php echo $id ?>" class="<?php echo $class ?>" type="number" value="<?php echo $current ?>" <?php echo $extra2 ?>> <?php echo $extra ?>
		<p class="description"><?php echo $desc ?></p>
		</td>
	</tr>		
	<?php
	} // inputfield()
	function selectfield( $id, $options=array(), $current, $title='', $desc='', $class='', $extra='' ) {
	?>
	<tr><th scope="row"><?php echo $title ?></th>
		<td><select id="<?php echo $id ?>" name="<?php echo $id ?>" class="<?php echo $class ?>">
			<?php foreach ($options as $value => $label) { ?>
					<option value="<?php echo $value ?>" <?php selected( $current, $value); ?>><?php echo $label ?></option>
			<?php } ?>
			</select>
			<p class="description"><?php echo $desc ?></p>
		</td>
	</tr>
	<?php	
	} // selectfield()
	
} // class Cryout_Serious_Slider

/* * * * get things going * * * */
$cryout_serious_slider = new Cryout_Serious_Slider;

// EOF