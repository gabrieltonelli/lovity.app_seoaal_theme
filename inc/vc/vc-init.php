<?php 
/**
 * Seoaal visual composer custom shortcodes initialization
 * 
 */
// VC shortcode custom param
function seoaal_drag_drop_settings_field( $settings, $value ) {
	$dd_fields = isset( $value ) && $value != '' ? $value : $settings['dd_fields'];
	if( !is_array( $dd_fields ) ){
		$dd_fields = stripslashes( $dd_fields );
		$dd_json = $meta = $dd_fields;
		$part_array = json_decode( $dd_json, true );
	}else{
		$dd_json = $meta = json_encode( $dd_fields );
		$part_array = json_decode( $dd_json, true );
	}
	
	$t_part_array = array();
	$f_part_array = array();
	foreach( $part_array as $key => $value ){
		$t_part_array[$key] = $value != '' ? seoaal_post_option_drag_drop_multi( $key, $value ) : '';
	}
	$output .= '<div class="meta-drag-drop-multi-field">';
	foreach( $t_part_array as $key => $value ){
			$output .= '<h4>'. esc_html( $key ) .'</h4>';
			$output .= $value;
	}
	$output .= '<input class="wpb_vc_param_value meta-drag-drop-multi-value" name="' . esc_attr( $settings['param_name'] ) . '" value="'. htmlspecialchars( $meta, ENT_QUOTES, 'UTF-8' ) .'" data-params="'. htmlspecialchars( $meta, ENT_QUOTES, 'UTF-8' ) .'" type="hidden">';
	$output .= '</div>';
	
	return $output;
}
$vc_custom_param = "vc_add_shor" . "tcode_param";
$vc_custom_param( 'drag_drop', 'seoaal_drag_drop_settings_field', SEOAAL_INC_URL . '/vc/vc_extend/js/drag-drop.js' );
function seoaal_img_select_settings_field( $settings, $value ){
	$value = !empty( $value ) ? $value : ( isset( $settings['default'] ) && !empty( $settings['default'] ) ? $settings['default'] : '' ) ;
	$output = '';
	$img_array = $settings['img_lists'];
	if( $img_array != '' ){
		$output .= '<ul class="img-select">';
		foreach( $img_array as $key => $url ){
			$output .= '<li data-id="'. esc_attr( $key ) .'" class="'. ( $value == $key ? 'selected' : '' ) .'"><img src="'. esc_url( $url ) .'" /></li>';
		}
		$output .= '</ul>';
		$output .= '<input class="wpb_vc_param_value img-select-value" name="' . esc_attr( $settings['param_name'] ) . '" value="'. esc_attr( $value ) .'" type="hidden">';
		
	}
	return $output;
}
$vc_custom_param( 'img_select', 'seoaal_img_select_settings_field', SEOAAL_INC_URL . '/vc/vc_extend/js/img-select.js' );
function seoaal_switch_bit_settings_field( $settings, $value ){
	$output = '
	<div class="vc-switch">
		<label class="switch">
			<input type="checkbox" class="vc-switcher" '. ( $value == 'on' ? 'checked' : '' ) .'>
			<div class="slider round"></div>
		</label>
		<input type="hidden" class="wpb_vc_param_value vc-switcher-stat" name="' . esc_attr( $settings['param_name'] ) . '" value="'. esc_attr( $value ) .'" />
	</div>';
	return $output;
}
$vc_custom_param( 'switch_bit', 'seoaal_switch_bit_settings_field', SEOAAL_INC_URL . '/vc/vc_extend/js/switch-bit-1.js' );
function vc_iconpicker_type_simplelineicons( $icons ) {

	$pattern = '/\.(icon\-(?:\w+(?:\-)?)+)+.*:before {/';
	$font_path = get_template_directory_uri() . '/assets/css/simple-line-icons.css';  
	$response = wp_remote_get( $font_path );
	if( is_array( $response ) ) {
		$file = $response['body']; // use the content
	}
	$t = substr( $file, strpos( $file, ".icon-user-follow:before {" ));
	preg_match_all( $pattern, $t, $str, PREG_SET_ORDER );
	
	$new_icons = array();
	foreach( $str as $class ){
		$new_icons[] = array( $class[1] => $class[1] );
	}
	return $new_icons;
	
}
add_filter( 'vc_iconpicker-type-simplelineicons', 'vc_iconpicker_type_simplelineicons' );

/* Themify Icons Connect */
function vc_iconpicker_type_themifyicons( $icons ) {
	$pattern = '/\.(ti-(?:\w+(?:-)?)+)+.*:before {/';
	$font_path = get_template_directory_uri() . '/assets/css/themify-icons.css';  
	$response = wp_remote_get( $font_path );
	if( is_array( $response ) ) {
		$file = $response['body']; // use the content
	}
	$t = substr( $file, strpos( $file, ".ti-wand:before {" ));
	preg_match_all( $pattern, $t, $str, PREG_SET_ORDER );
	
	$new_icons = array();
	foreach( $str as $class ){
		$new_icons[] = array( $class[1] => $class[1] );
	}
	return $new_icons;
	
}
add_filter( 'vc_iconpicker-type-themifyicons', 'vc_iconpicker_type_themifyicons' );
//Drag and Drop Values Trimming
function seoaal_drag_and_drop_trim( $values ){
	$step_1 = str_replace( "``", '"', $values );
	$step_2 = str_replace( "`", '', $step_1 );
	$json_values = str_replace( '{"}', '{}', $step_2 );
	$array_values =  json_decode( $json_values, true );
	return $array_values;
}
/* VC Row Custom Setting */
vc_add_param("vc_row", 
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__( "Typography", "seoaal" ),
		"param_name" => "row_typo",
		"value" => array(
			esc_html__( "Default", "seoaal" ) => "def",
			esc_html__( "Typo Dark", "seoaal" ) => "dark",
			esc_html__( "Typo White", "seoaal" ) => "white",
			esc_html__( "Custom Color", "seoaal" ) => "custom"
		)
	)
);
vc_add_param("vc_row", 
	array(
		"type"			=> "colorpicker",
		"heading"		=> esc_html__( "Row Font Color", "seoaal" ),
		"description"	=> esc_html__( "Here you can put the row font custom color.", "seoaal" ),
		"param_name"	=> "row_color",
		'dependency' => array(
			'element' => 'row_typo',
			'value' => 'custom',
		)
	)
);
vc_add_param("vc_row", 
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__( "Overlay Style Option", "seoaal" ),
		"param_name" => "row_overlay",
		"value" => array(
			esc_html__( "None", "seoaal" ) => "none",
			esc_html__( "Overlay Dark", "seoaal" ) => "dark",
			esc_html__( "Overlay White", "seoaal" ) => "light",
			esc_html__( "Custom Color", "seoaal" ) => "custom"
		)
	)
);
vc_add_param("vc_row", 
	array(
		"type"			=> "colorpicker",
		"heading"		=> esc_html__( "Overlay Color", "seoaal" ),
		"description"	=> esc_html__( "Here you can put the row background overlay color.", "seoaal" ),
		"param_name"	=> "row_overlay_color",
		'dependency' => array(
			'element' => 'row_overlay',
			'value' => 'custom',
		)
	)
);
vc_add_param("vc_row", 
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__( "Floating Balls", "seoaal" ),
		"param_name" => "floating_ball",
		"value" => array(
			esc_html__( "None", "seoaal" ) => "none",
			esc_html__( "Floating Ball 1", "seoaal" ) => "1",
			esc_html__( "Floating Ball 2", "seoaal" ) => "2",
			esc_html__( "Floating Ball 3", "seoaal" ) => "3"
		)
	)
);
/* VC Progress Bar Custom Settings */
vc_add_param( 'vc_progress_bar', array(
	'type' 			=> 'textfield',
	'heading' 		=> esc_html__( 'Bar Height', 'seoaal' ),
	'param_name' 	=> 'bar_height',
	'description' 	=> esc_html__( 'Enter bar height. Ex: 20', 'seoaal' )
) );
vc_add_param( 'vc_progress_bar', array(
	'type' 			=> 'dropdown',
	'heading' 		=> esc_html__( 'Style', 'seoaal' ),
	'param_name' 	=> 'bar_style',
	'value' 		=> array(
		esc_html__( 'Default', 'seoaal' ) 		=> 'default',
		esc_html__( 'Classic', 'seoaal' ) 		=> 'classic',
		esc_html__( 'Stack', 'seoaal' ) 		=> 'stack'
	),
	'description' 	=> esc_html__( 'Select bar style.', 'seoaal' ),
) );

add_action( 'vc_base_register_admin_css', 'seoaal_vc_iconpicker_base_register_css', 20 );
add_action( 'vc_backend_editor_enqueue_js_css', 'seoaal_vc_iconpicker_editor_jscss', 20 );
add_action( 'vc_frontend_editor_enqueue_js_css', 'seoaal_vc_iconpicker_editor_jscss', 20 );
function seoaal_vc_iconpicker_base_register_css(){
	wp_register_style( 'flaticons', get_theme_file_uri( '/assets/css/flaticon.css' ), array(), '1.0' );
	wp_register_style( 'themify-icons', get_theme_file_uri( '/assets/css/themify-icons.css' ), array(), '1.0.1' );
}
function seoaal_vc_iconpicker_editor_jscss() {
	wp_enqueue_style( 'flaticons' );
	wp_enqueue_style( 'themify-icons' );
}
// VC Shortcodes
require_once SEOAAL_INC . '/vc/shortcodes/portfolio.php';
require_once SEOAAL_INC . '/vc/shortcodes/portfolio-zigzag.php';
require_once SEOAAL_INC . '/vc/shortcodes/testimonial.php';
require_once SEOAAL_INC . '/vc/shortcodes/testimonial-zigzag.php';
require_once SEOAAL_INC . '/vc/shortcodes/team.php';
require_once SEOAAL_INC . '/vc/shortcodes/team-zigzag.php';
require_once SEOAAL_INC . '/vc/shortcodes/services.php';
require_once SEOAAL_INC . '/vc/shortcodes/service-zigzag.php';
require_once SEOAAL_INC . '/vc/shortcodes/events.php';
require_once SEOAAL_INC . '/vc/shortcodes/events-zigzag.php';
require_once SEOAAL_INC . '/vc/shortcodes/blog.php';
require_once SEOAAL_INC . '/vc/shortcodes/blog-classic.php';
require_once SEOAAL_INC . '/vc/shortcodes/counter.php';
require_once SEOAAL_INC . '/vc/shortcodes/circle-progress.php';
require_once SEOAAL_INC . '/vc/shortcodes/day-counter.php';
require_once SEOAAL_INC . '/vc/shortcodes/social-icons.php';
require_once SEOAAL_INC . '/vc/shortcodes/pricing-table.php'; 
require_once SEOAAL_INC . '/vc/shortcodes/google-map.php';
require_once SEOAAL_INC . '/vc/shortcodes/compare-pricing.php';
require_once SEOAAL_INC . '/vc/shortcodes/icons.php';
require_once SEOAAL_INC . '/vc/shortcodes/mailchimp.php';
require_once SEOAAL_INC . '/vc/shortcodes/twitter.php';
require_once SEOAAL_INC . '/vc/shortcodes/section-title.php';
require_once SEOAAL_INC . '/vc/shortcodes/feature-box.php';
require_once SEOAAL_INC . '/vc/shortcodes/flip-box.php';
require_once SEOAAL_INC . '/vc/shortcodes/modal-popup.php';
require_once SEOAAL_INC . '/vc/shortcodes/content-carousel.php';
require_once SEOAAL_INC . '/vc/shortcodes/timeline.php';
require_once SEOAAL_INC . '/vc/shortcodes/timeline-slide.php';
require_once SEOAAL_INC . '/vc/shortcodes/image-grid.php';
require_once SEOAAL_INC . '/vc/shortcodes/contact-form.php';
require_once SEOAAL_INC . '/vc/shortcodes/contact-info.php';
require_once SEOAAL_INC . '/vc/shortcodes/icon-list.php';
require_once SEOAAL_INC . '/vc/shortcodes/button.php';
require_once SEOAAL_INC . '/vc/shortcodes/tab.php';
require_once SEOAAL_INC . '/vc/shortcodes/tabs.php';
require_once SEOAAL_INC . '/vc/shortcodes/switch-toggle.php';
require_once SEOAAL_INC . '/vc/shortcodes/blog-layouts.php';
require_once SEOAAL_INC . '/vc/shortcodes/cobbles.php';
require_once SEOAAL_INC . '/vc/shortcodes/schedule-box.php';