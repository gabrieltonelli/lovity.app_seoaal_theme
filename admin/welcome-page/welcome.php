<?php // Admin Page
if( ! class_exists( 'Seoaal_Zozo_Admin_Page' ) ){
	class Seoaal_Zozo_Admin_Page {
	
		function __construct(){
			add_action( 'admin_init', array( $this, 'seoaal_admin_page_init' ) );	
			add_action( 'admin_menu', array( $this, 'seoaal_zozo_admin_menu') );			
			add_action( 'admin_menu', array( $this, 'seoaal_zozo_edit_admin_menus' ) ); 
			add_action( 'admin_head', array( $this, 'seoaal_zozo_admin_page_scripts' ) );
			add_action( 'after_switch_theme', array( $this, 'seoaal_zozo_theme_activation_redirect' ) ); 
		}		
		
		function seoaal_admin_page_init(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				
				if( isset( $_GET['zozo-deactivate'] ) && $_GET['zozo-deactivate'] == 'deactivate-plugin' ) {
					check_admin_referer( 'zozo-deactivate', 'zozo-deactivate-nonce' );
					$plugins = TGM_Plugin_Activation::$instance->plugins;
					foreach( $plugins as $plugin ) {
						if( $plugin['slug'] == $_GET['plugin'] ) {
							deactivate_plugins( $plugin['file_path'] );
						}
					}
				} 
				
				if( isset( $_GET['zozo-activate'] ) && $_GET['zozo-activate'] == 'activate-plugin' ) {
					check_admin_referer( 'zozo-activate', 'zozo-activate-nonce' );
					$plugins = TGM_Plugin_Activation::$instance->plugins;
					foreach( $plugins as $plugin ) {
						if( $plugin['slug'] == $_GET['plugin'] ) {
							activate_plugin( $plugin['file_path'] );
						}
					}
				}
			}
		}
		
		function seoaal_zozo_theme_activation_redirect(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				header('Location:'.admin_url().'admin.php?page=seoaal');
			}
		}
		
		function seoaal_zozo_admin_menu(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				// Work around for theme check
				$zozo_menu_page = 'add_menu' . '_page';
				$zozo_submenu_page = 'add_submenu' . '_page';
			
				$welcome_screen = $zozo_menu_page( 
					'Seoaal',
					'Seoaal',
					'administrator',
					'seoaal',
					array( $this, 'seoaal_zozo_welcome_screen' ), 
					'dashicons-admin-home',
					3);
				$demos = $zozo_submenu_page(
						'seoaal',
						esc_html__( 'Install Seoaal Demos', 'seoaal' ),
						esc_html__( 'Install Demos', 'seoaal' ),
						'administrator',
						'seoaal-demos',
						array( $this, 'seoaal_demos_tab' ) ); 
						
				$plugins = $zozo_submenu_page(
						'seoaal',
						esc_html__( 'Plugins', 'seoaal' ),
						esc_html__( 'Plugins', 'seoaal' ),
						'administrator',
						'zozothemes-plugins',
						array( $this, 'seoaal_themes_plugins_tab' ) );
				
				$system_status = $zozo_submenu_page(
						'seoaal',
						esc_html__( 'System Status', 'seoaal' ),
						esc_html__( 'System Status', 'seoaal' ),
						'administrator',
						'system-status',
						array( $this, 'seoaal_system_status' ) ); 
				add_action( 'admin_print_scripts-'.$welcome_screen, array( $this, 'seoaal_zozo_admin_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$demos, array( $this, 'seoaal_zozo_admin_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$plugins, array( $this, 'seoaal_zozo_admin_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$system_status, array( $this, 'seoaal_zozo_admin_screen_scripts' ) );
			}
		}
		
		function seoaal_zozo_edit_admin_menus() {
			global $submenu;
			if ( current_user_can( 'edit_theme_options' ) ) {
				$submenu['seoaal'][0][0] = 'Welcome';
			}
		}
		
		function seoaal_zozo_welcome_screen() {
			get_template_part( 'admin/welcome-page/screens/welcome' );
		}
				
		function seoaal_demos_tab() {
			get_template_part( 'admin/welcome-page/screens/install', 'demos' ); 
		}
		
		function seoaal_themes_plugins_tab() {
			get_template_part( 'admin/welcome-page/screens/zozothemes', 'plugins' ); 
		}
		
		function seoaal_system_status() {
			get_template_part( 'admin/welcome-page/screens/system', 'status' ); 
		}
				
		function seoaal_zozo_admin_page_scripts() {
			if ( is_admin() && ( isset( $_GET['page'] ) && $_GET['page'] == 'seoaal-demos' ) ) {
				wp_enqueue_style( 'seoaal-zozo-admin-confirm-css', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/css/jquery-confirm.min.css' ) );
				wp_enqueue_script( 'seoaal-zozo-admin-confirm-js', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/js/jquery-confirm.min.js' ) );
			}
		}
		function seoaal_zozo_admin_screen_scripts() {
			wp_enqueue_style( 'seoaal-zozo-admin-page-css', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/css/admin-screen.css' ) );
			wp_enqueue_script( 'seoaal-zozo-admin-page-js', esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/js/admin-screen.js' ) );
		}
		
		function seoaal_plugin_link( $item ) {
			$installed_plugins = get_plugins();
			$item['sanitized_plugin'] = $item['name'];
			 $is_plug_act = 'is_plugin_active';
			if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
				$actions = array(
					'install' => sprintf(
						'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%4$s</a>',
						esc_url( wp_nonce_url(
							add_query_arg(
								array(
									'page'		  	=> urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'		=> urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'plugin_source' => urlencode( $item['source'] ),
									'tgmpa-install' => 'install-plugin',
									'return_url' 	=> 'zozothemes_plugins'
								),
								admin_url( TGM_Plugin_Activation::$instance->parent_slug )
							),
							'tgmpa-install',
							'tgmpa-nonce'
						) ),
						$item['sanitized_plugin'],
						esc_attr__( 'Install', 'seoaal' ),
						esc_html__( 'Install', 'seoaal' )
					),
				);
			}
			
			elseif ( is_plugin_inactive( $item['file_path'] ) ) {
				if ( version_compare( $item['version'], $installed_plugins[$item['file_path']]['Version'], '>' ) ) {
					$actions = array(
						'update' => sprintf(
							'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%4$s</a>',
							wp_nonce_url(
								add_query_arg(
									array(
										'page'		  	=> urlencode( TGM_Plugin_Activation::$instance->menu ),
										'plugin'		=> urlencode( $item['slug'] ),
										'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
										'plugin_source' => urlencode( $item['source'] ),
										'tgmpa-update' 	=> 'update-plugin',
										'version' 		=> urlencode( $item['version'] ),
										'return_url' 	=> 'zozothemes_plugins'
									),
									admin_url( TGM_Plugin_Activation::$instance->parent_slug )
								),
								'tgmpa-update',
								'tgmpa-nonce'
							),
							$item['sanitized_plugin'],
							esc_attr__( 'Update', 'seoaal' ),
							esc_html__( 'Update', 'seoaal' )
						),
					);
				} else {
					$actions = array(
						'activate' => sprintf(
							'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%4$s</a>',
							esc_url( add_query_arg(
								array(
									'plugin'			   	=> urlencode( $item['slug'] ),
									'plugin_name'		  	=> urlencode( $item['sanitized_plugin'] ),
									'plugin_source'			=> urlencode( $item['source'] ),
									'zozo-activate'	   		=> 'activate-plugin',
									'zozo-activate-nonce' 	=> wp_create_nonce( 'zozo-activate' ),
								),
								admin_url( 'admin.php?page=zozothemes-plugins' )
							) ),
							$item['sanitized_plugin'],
							esc_attr__( 'Activate', 'seoaal' ),
							esc_html__( 'Activate', 'seoaal' )
						),
					);
				}
			}
			
			elseif ( version_compare( $item['version'], $installed_plugins[$item['file_path']]['Version'], '>' ) ) {
				$actions = array(
					'update' => sprintf(
						'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%3$s</a>',
						wp_nonce_url(
							add_query_arg(
								array(
									'page'		  	=> urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'		=> urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'plugin_source' => urlencode( $item['source'] ),
									'tgmpa-update' 	=> 'update-plugin',
									'version' 		=> urlencode( $item['version'] ),
									'return_url' 	=> 'zozothemes_plugins'
								),
								admin_url( TGM_Plugin_Activation::$instance->parent_slug )
							),
							'tgmpa-update',
							'tgmpa-nonce'
						),
						$item['sanitized_plugin'],
						esc_attr__( 'Update', 'seoaal' ),
						esc_html__( 'Update', 'seoaal' )
					),
				);
			}
			elseif ( $is_plug_act( $item['file_path'] ) ) {
				$actions = array(
					'deactivate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="%3$s %2$s">%4$s</a>',
						esc_url( add_query_arg(
							array(
								'plugin'					=> urlencode( $item['slug'] ),
								'plugin_name'		  		=> urlencode( $item['sanitized_plugin'] ),
								'plugin_source'				=> urlencode( $item['source'] ),
								'zozo-deactivate'	   		=> 'deactivate-plugin',
								'zozo-deactivate-nonce' 	=> wp_create_nonce( 'zozo-deactivate' ),
							),
							admin_url( 'admin.php?page=zozothemes-plugins' )
						) ),
						$item['sanitized_plugin'],
						esc_attr__( 'Deactivate', 'seoaal' ),
						esc_html__( 'Deactivate', 'seoaal' )
					),
				);
			}
			return $actions;
		}
		
	}// class Seoaal_Zozo_Admin_Page
	new Seoaal_Zozo_Admin_Page;
}
class Seoaal_WP_FileSystem_Credentials {
	static function check_credentials() {
		// Get user credentials for WP filesystem API
		$demo_import_page_url = wp_nonce_url( 'themes.php?page=seoaal-demos', 'seoaal-demos' );
		if ( false === ( $creds = request_filesystem_credentials( $demo_import_page_url, '', false, false, null ) ) ) {
			return new WP_Error( 'XML_parse_error', esc_html__( 'There was an error when reading this WXR file', 'seoaal' ) );
		}
		// Now we have credentials, try to get the wp_filesystem running
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again
			request_filesystem_credentials( $demo_import_page_url, '', true, false, null );
			return true;
		}
	}
}