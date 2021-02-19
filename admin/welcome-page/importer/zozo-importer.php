<?php
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );
/* ================================================
 * Importer
 * ================================================ */
 
// Don't resize images
function seoaal_zozo_import_filter_image_sizes( $sizes ) {
	return array();
}
 
/* ================================================
 * Ajax Hook for Importer
 * ================================================ */
 
/*Custom Code Start*/
 
function seoaal_get_server_files($url){
	$args = array( 'timeout' => 500 );
	$response = wp_remote_get($url, $args);
	$data = wp_remote_retrieve_body($response);
	return $data;
}
 
if( ! function_exists('seoaal_zozo_demo_files_download') ) {
    function seoaal_zozo_demo_files_download() {
        global $zozo_import;
		
		if( ! isset( $_POST['demo_type'] ) || trim( $_POST['demo_type'] ) == '' ) {
			$demo_type = 'demo';
		} else {
			$demo_type = sanitize_text_field($_POST['demo_type']);
		}
		$theme_xml_file = SEOAAL_ADMIN . '/welcome-page/data/theme.xml';				
		$url      = "http://demo.zozothemes.com/import/sites/seoaal/". $demo_type ."/theme.xml";
		$theme_xml_content    = seoaal_get_server_files($url);
		
		$theme_option_file = SEOAAL_ADMIN . '/welcome-page/data/theme-options.json';				
		$url      = "http://demo.zozothemes.com/import/sites/seoaal/". $demo_type ."/theme-options.json";
		$theme_option_content    = seoaal_get_server_files($url);
		
		$sidebar_file = SEOAAL_ADMIN . '/welcome-page/data/custom-sidebars.json';				
		$url      = "http://demo.zozothemes.com/import/sites/seoaal/". $demo_type ."/custom-sidebars.json";
		$sidebar_content    = seoaal_get_server_files($url);
		
		$widget_file = SEOAAL_ADMIN . '/welcome-page/data/widgets.json';				
		$url      = "http://demo.zozothemes.com/import/sites/seoaal/". $demo_type ."/widgets.json";
		$widget_content    = seoaal_get_server_files($url);
		
		$rev_count = '';
		if( isset( $_POST['revslider'] ) || $_POST['revslider'] != '' ){
			if( class_exists( 'RevSlider' ) ) {
				$rev_count = sanitize_text_field($_POST['revslider']);
				echo "".$rev_count ." : ";
			}//class_exists( 'RevSlider' )
		}
		$access_type = get_filesystem_method();
		if($access_type === 'direct')
		{
			/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
			$creds = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());
		
			/* initialize the API */
			if ( ! WP_Filesystem($creds) ) {
				return false;
			}
		
			global $wp_filesystem;
			/* do our file manipulations below */
			$wp_filesystem->put_contents( $theme_xml_file, $theme_xml_content, FS_CHMOD_FILE );
			$wp_filesystem->put_contents( $theme_option_file, $theme_option_content, FS_CHMOD_FILE );
			$wp_filesystem->put_contents( $sidebar_file, $sidebar_content, FS_CHMOD_FILE );
			$wp_filesystem->put_contents( $widget_file, $widget_content, FS_CHMOD_FILE );
			
			if( $rev_count ){
				$sliders_from = $sliders = array();
				for( $i = 1; $i <= absint( $rev_count ); $i++ ){
					$sliders_from[$i] = "http://demo.zozothemes.com/import/sites/seoaal/". $demo_type ."/rev_slider_". $i .".zip";
					$sliders[$i] = SEOAAL_ADMIN . '/welcome-page/data/slider-'. $demo_type .'-'. $i .'.zip';
					copy($sliders_from[$i], $sliders[$i]);
					
				}
			}
			set_theme_mod('seoaal_installed_demo_id', esc_attr( $demo_type ));
			set_theme_mod('seoaal_demo_installed', 1);
			
			echo 'success';
		}	
		else
		{
			/* don't have direct write access. Prompt user with our notice */
			echo esc_html__( 'File access permission problem.', 'seoaal' );
		}
		die();
    }
    add_action('wp_ajax_seoaal_download', 'seoaal_zozo_demo_files_download');
	add_action( 'wp_ajax_nopriv_seoaal_download', 'seoaal_zozo_demo_files_download' );
}
function seoaal_theme_xml_import(){
	
	$filename = SEOAAL_ADMIN . '/welcome-page/data/theme.xml';
	//importer code start here
	if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	require_once ABSPATH . 'wp-admin/includes/import.php';
	$importer_error = false;
	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) ){
			require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		} else {
			$importer_error = true;
		}
	}
	
	if ( !class_exists( 'WP_Import' ) ) {
		$class_wp_import = dirname( __FILE__ ) .'/wordpress-importer.php';
		if ( file_exists( $class_wp_import ) ){
			get_template_part( 'admin/welcome-page/importer/wordpress', 'importer' );
		}else
			$importer_error = true;
	}
	
	if($importer_error){
		
		echo esc_html__( 'Error on import', 'seoaal' );
	} else {
		if ( !class_exists( 'WP_Import' ) ) {
			echo esc_html__("WP_Import Problem", "seoaal");
		}else{
			add_filter('intermediate_image_sizes_advanced', 'seoaal_zozo_import_filter_image_sizes', 10, 1);
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			
			ob_start();
			$wp_import->import( $filename );
			$out = ob_get_clean();
			
			// Reading settings
			$home_page_title = 'Home';
			$post_page_title = 'Blog';
			
			// Set reading options
			$home_page = get_page_by_title( $home_page_title );
			$post_page = get_page_by_title( $post_page_title );
			if( isset( $home_page ) && $home_page->ID ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $home_page->ID ); // Front Page
			}
			if( isset( $post_page ) && $post_page->ID ) {
				update_option( 'page_for_posts', $post_page->ID ); // Posts Page
			}
			
			seoaal_set_demo_menus();
			
			echo 'success';
			
		}
	}
	die();
}
add_action('wp_ajax_seoaal_theme_xml', 'seoaal_theme_xml_import');
function seoaal_theme_option_import(){
	$filename = SEOAAL_ADMIN . '/welcome-page/data/theme-options.json';		
	
	Seoaal_WP_FileSystem_Credentials::check_credentials();
			
	global $wp_filesystem;
    if($wp_filesystem->exists($filename)){
		$theme_option = $wp_filesystem->get_contents( $filename );
		$theme_options = json_decode($theme_option, true);
		$redux = ReduxFrameworkInstances::get_instance('seoaal_options');
		$redux->set_options($theme_options);
		seoaal_save_theme_options();		
		echo 'success';
	}else{
		echo esc_html__( 'Failure to import theme options.', 'seoaal' );
	}
	die();
	
}
add_action('wp_ajax_seoaal_theme_option', 'seoaal_theme_option_import');
function seoaal_custom_sidebars(){
	$filename = SEOAAL_ADMIN . '/welcome-page/data/custom-sidebars.json';
	
	Seoaal_WP_FileSystem_Credentials::check_credentials();
			
	global $wp_filesystem;
    if($wp_filesystem->exists($filename)){
		$sidebar_content = $wp_filesystem->get_contents( $filename );
		update_option( 'seoaal_custom_sidebars', $sidebar_content );
		
		if( class_exists( "seoaal_sidebar_generator" ) ){
			seoaal_sidebar_generator::init();
		}
		echo 'success';
	}else{
		echo esc_html__( 'Failure to import custom sidebars.', 'seoaal' );
	}
	die();
	
}
add_action('wp_ajax_seoaal_custom_sidebars', 'seoaal_custom_sidebars');
function seoaal_widgets_import(){
	$filename = SEOAAL_ADMIN . '/welcome-page/data/widgets.json';		
	
	Seoaal_WP_FileSystem_Credentials::check_credentials();
			
	global $wp_filesystem;
    if($wp_filesystem->exists($filename)){
		$widgets_content = $wp_filesystem->get_contents( $filename );
		$widgets_json = json_decode($widgets_content, true);
		$res = seoaal_widgets_import_process($widgets_json);
		if( $res )
			echo 'success';
		else
			echo ( ''. $res );
	}else{
		echo esc_html__( 'Failure to import theme options.', 'seoaal' );
	}
	
	die();
}
add_action('wp_ajax_seoaal_widgets', 'seoaal_widgets_import');
function seoaal_rev_slider_import(){
	if( isset( $_POST['revslider'] ) || $_POST['revslider'] != '' ){
	
		// Import Revolution Slider
		if( class_exists( 'RevSlider' ) ) {
		
			//deleted wp-load.php file
			require_once ABSPATH . 'wp-includes/functions.php';
			$demo_type = isset( $_POST['demo_type'] ) ? esc_attr( $_POST['demo_type'] ) : '';
			$rev_count = sanitize_text_field($_POST['revslider']);
			$slider = new RevSlider();
			for( $i = 1; $i <= absint( $rev_count ); $i++ ){
				$filepath = SEOAAL_ADMIN . '/welcome-page/data/slider-'. $demo_type .'-'. $i .'.zip';
				if ( file_exists( $filepath ) ){
					$slider->importSliderFromPost(true,true,$filepath);
				}
			}
			//echo 'success';
		} //class_exists( 'RevSlider' )
		
	} // isset post->revslider
	die();
	
}
add_action('wp_ajax_seoaal_rev_slider', 'seoaal_rev_slider_import');
function seoaal_get_available_widgets() {
	global $wp_registered_widget_controls;
	$widget_controls = $wp_registered_widget_controls;
	$available_widgets = array();
	foreach ( $widget_controls as $widget ) {
		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes
			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
			$available_widgets[$widget['id_base']]['name'] = $widget['name'];
		}
	}
	return $available_widgets;
}
function seoaal_widgets_import_process( $data ) {
	global $wp_registered_sidebars;
	// Get all available widgets site supports
	$available_widgets = seoaal_get_available_widgets();
	// Get all existing widget instances
	$widget_instances = array();
	foreach ( $available_widgets as $widget_data ) {
		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	}
	// Begin results
	$results = array();
	// Loop import data's sidebars
	foreach ( $data as $sidebar_id => $widgets ) {
		// Skip inactive widgets
		// (should not be in export file)
		if ( 'wp_inactive_widgets' == $sidebar_id ) {
			continue;
		}
		// Check if sidebar is available on this site
		// Otherwise add widgets to inactive, and say so
		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
			$sidebar_available = true;
			$use_sidebar_id = $sidebar_id;
			$sidebar_message_type = 'success';
			$sidebar_message = '';
		} else {
			$sidebar_available = false;
			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
			$sidebar_message_type = 'error';
			$sidebar_message = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'seoaal' );
		}
		// Result for sidebar
		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
		$results[$sidebar_id]['message'] = $sidebar_message;
		$results[$sidebar_id]['widgets'] = array();
		// Loop widgets
		foreach ( $widgets as $widget_instance_id => $widget ) {
			$fail = false;
			// Get id_base (remove -# from end) and instance ID number
			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );
			// Does site support this widget?
			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
				$fail = true;
				$widget_message_type = 'error';
				$widget_message = esc_html__( 'Site does not support widget', 'seoaal' ); // explain why widget not imported
			}
			// Does widget with identical settings already exist in same sidebar?
			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {
				// Get existing widgets in this sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' );
				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go
				// Loop widgets with ID base
				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				foreach ( $single_widget_instances as $check_id => $check_widget ) {
					// Is widget in same sidebar and has identical settings?
					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
						$fail = true;
						$widget_message_type = 'warning';
						$widget_message = esc_html__( 'Widget already exists', 'seoaal' ); // explain why widget not imported
						break;
					}
				}
			}
			// No failure
			if ( ! $fail ) {
				// Add widget instance
				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				$single_widget_instances[] = (array) $widget; // add it
					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );
					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}
					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}
					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );
				// Assign widget instance to sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data
				// Success message
				if ( $sidebar_available ) {
					$widget_message_type = 'success';
					$widget_message = esc_html__( 'success', 'seoaal' );
				} else {
					$widget_message_type = 'warning';
					$widget_message = esc_html__( 'Imported to Inactive', 'seoaal' );
				}
			}
			// Result for widget instance
			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = ! empty( $widget->title ) ? $widget->title : esc_html__( 'No Title', 'seoaal' ); // show "No Title" if widget instance is untitled
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;
		}
	}
	// Return results
	return $results;
}
function seoaal_set_demo_menus(){
	/* Set imported menus to Registered Menu locations in Theme */
			
	// Registered Menu Locations in Theme
	$locations = get_theme_mod( 'nav_menu_locations' );
	// Get Registered menus
	$menus = wp_get_nav_menus();
	
	// Assign menus to theme locations 
	if( is_array($menus) ) {
		foreach( $menus as $menu ) {
			if( $menu->name == 'Primary Menu' ) {
				$locations['primary-menu'] = $menu->term_id;
			} else if( $menu->name == 'Top Menu' ) {
				$locations['top-menu'] = $menu->term_id;
			} else if( $menu->name == 'Footer Menu' ) {
				$locations['footer-menu'] = $menu->term_id;
			}
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );
}
//Deleting Attachments
function seoaal_uninstall_demo_attachments(){
	$args = array(
		'post_type' => array('attachment'),
		'post_status' => 'inherit',
		'posts_per_page' => '-1',
		'meta_query' => array(
			array(
				'key'     => 'seoaal_demo_attachment_key',
				'value'   => 1,
			),
		)
	);
	$query = new WP_Query( $args );
	if (!empty($query->posts)) {
		foreach ($query->posts as $post) {
			wp_delete_attachment($post->ID, true);
			
		}
	}
	
	$args = array(
		'post_type' => array('page', 'post'),
		'posts_per_page' => '-1',
		'meta_query' => array(
			array(
				'key'     => 'seoaal_demo_content_key',
				'value'   => 1,
			),
		)
	);
	$query = new WP_Query( $args );
	if (!empty($query->posts)) {
		foreach ($query->posts as $post) {
			wp_delete_post($post->ID, true);
			
		}
	}
	
	$args = array(
		'taxonomy'		=> 'category',
		'orderby'		=> 'name',
		'hide_empty'	=> 0,
		'meta_query'	=> array(
			array(
				'key'     => 'seoaal_demo_term_key',
				'value'   => 1,
			),
		)
	);
	$terms = get_terms( $args );
	
	if( !empty( $terms ) ){
		foreach( $terms as $terms ) {
			wp_delete_term( $terms->term_id, 'category' );
		}
	}
	
	$args = array(
		'taxonomy'		=> 'post_tag',
		'orderby'		=> 'name',
		'hide_empty'	=> 0,
		'meta_query'	=> array(
			array(
				'key'     => 'seoaal_demo_term_key',
				'value'   => 1,
			),
		)
	);
	$terms = get_terms( $args );
	
	if( !empty( $terms ) ){
		foreach( $terms as $terms ) {
			wp_delete_term( $terms->term_id, 'post_tag' );
		}
	}
	
	$menu_names = array('primary-menu', 'footer-menu', 'top-menu');
	foreach( $menu_names as $menu )
		wp_delete_nav_menu($menu);
	
	//Empty theme option values
	delete_option( 'seoaal_options' ); 
	seoaal_default_theme_options();
	
	update_option('sidebars_widgets', array());	
	
	set_theme_mod('seoaal_installed_demo_id', '');
	set_theme_mod('seoaal_demo_installed', 0);
	echo 'success';
	die();
	//'post', 'page', 'attachment', 'nav_menu'
}
add_action('wp_ajax_seoaal_uninstall', 'seoaal_uninstall_demo_attachments');
/*Custom Code End*/