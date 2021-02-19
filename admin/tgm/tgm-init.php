<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Seoaal for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */
/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once SEOAAL_ADMIN . '/tgm/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'seoaal_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function seoaal_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	 
	$path = new SeoaalZozoPath;
	$plugin_url = $path->seoaalGetPath();
	 
	$plugins = array(
		// This is an example of how to include a plugin from an arbitrary external source in your theme.
		array(
			'name'					=> esc_html__( 'Seoaal Core', 'seoaal' ), // The plugin name.
			'slug'					=> 'seoaal-core', // The plugin slug (typically the folder name).
			'source'				=> esc_url( 'http://demo.zozothemes.com/import/sites/seoaal/demo/seoaal-core.zip' ), // The plugin source.
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required.
			'version'				=> '1.0.3',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL.
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/seoaal-core.png' ),
		),
		array(
			'name'					=> esc_html__( 'WPBakery Visual Composer', 'seoaal' ), // The plugin name.
			'slug'					=> 'js_composer', // The plugin slug (typically the folder name).
			'source'				=> esc_url( $plugin_url.'js_composer.zip' ), // The plugin source.
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required.
			'version'				=> '6.2.0',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL.
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/visual-composer.png' ),
		),
		array(
			'name'					=> esc_html__( 'Slider Revolution', 'seoaal' ), // The plugin name.
			'slug'					=> 'revslider', // The plugin slug (typically the folder name).
			'source'				=> esc_url( $plugin_url.'revslider.zip' ), // The plugin source.
			'required'				=> true, // If false, the plugin is only 'recommended' instead of required.
			'version'				=> '6.2.18',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL.
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/revslider.png' ),
		),
		array(
			'name'					=> esc_html__( 'Envato Market', 'seoaal' ), // The plugin name.
			'slug'					=> 'envato-market', // The plugin slug (typically the folder name).
			'source'				=> esc_url( $plugin_url.'envato-market.zip' ), // The plugin source.
			'required'				=> false, // If false, the plugin is only 'recommended' instead of required.
			'version'				=> '2.0.3',
			'force_activation'		=> false,
			'force_deactivation'	=> false,
			'external_url'			=> '', // If set, overrides default API URL and points to an external URL.
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/envato-market.jpg' ),
		),
		array(
			'name'      => esc_html__( 'Contact Form 7', 'seoaal' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/contact-form.png' ),
		),
		array(
			'name'      => esc_html__( 'Product Slider for WooCommerce', 'seoaal' ),
			'slug'      => 'woo-product-slider',
			'required'  => false,
			'image_url' 		 	=> esc_url( get_template_directory_uri() . '/admin/welcome-page/assets/images/plugin/product-slider.png' ),
		),
	);
	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
        'id'           => 'seoaal_tgmpa',           // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
	tgmpa( $plugins, $config );
}
	 
if ( ! class_exists( 'SeoaalZozoPath' ) ) {
	class SeoaalZozoPath{
		private $path;
		
		function seoaalGetPath(){
			return 'http://demo.zozothemes.com/import/plugins/';
		}
	}
}