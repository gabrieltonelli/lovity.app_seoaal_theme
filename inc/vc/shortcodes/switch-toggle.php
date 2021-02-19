<?php 
/**
 * Seoaal Switch Toggle
 */
if ( ! function_exists( "seoaal_vc_switch_toggle_shortcode" ) ) {
	function seoaal_vc_switch_toggle_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_switch_toggle", $atts );
		extract( $atts );
		
		//Define Variables
		$class = isset( $extra_class ) && $extra_class != '' ? ' '. $extra_class : '';
		$primary_title = isset( $primary_title ) && $primary_title != '' ? $primary_title : esc_html__( "Primary", "seoaal" );
		$secondary_title = isset( $secondary_title ) && $secondary_title != '' ? $secondary_title : esc_html__( "Secondary", "seoaal" );
		$switch_pos = isset( $switch_pos ) && $switch_pos != '' ? $switch_pos : 'bottom';
		$switch_align = isset( $switch_align ) && $switch_align != '' ? ' text-'. $switch_align : ' text-center';
		
		
		$output = '';	
		
		$switch_output = '<div class="switch-toggle-tab-trigger'. esc_attr( $switch_align ) .'">
			<ul class="nav">
				<li><span class="swtich-first-title">'. esc_html( $primary_title ) .'</span></li>
				<li>
					<label class="switch">
						<input class="switch-checkbox" type="checkbox">
						<span class="slider round"></span>
					</label>
				</li>
				<li><span class="swtich-last-title">'. esc_html( $secondary_title ) .'</span></li>
			</ul>
		</div>';
		
		$output .= '<div class="switch-toggle-tab-wrap'. esc_attr( $class ) .'">';
			$output .= $switch_pos == 'top' ? $switch_output : '';
			$output .= '<div class="switch-toggle-tab-inner">';
				$output .= do_shortcode( $content );
			$output .= '</div>';
			$output .= $switch_pos == 'bottom' ? $switch_output : '';
		$output .= '</div>';
		
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_switch_toggle_shortcode_map" ) ) {
	function seoaal_vc_switch_toggle_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Switch Toggle", "seoaal" ),
				"description"			=> esc_html__( "Switch tab anything.", "seoaal" ),
				"base"					=> "seoaal_vc_switch_toggle",
				"is_container"			=> true,
				"content_element"		=> true,
				"js_view" 				=> 'VcColumnView',
				"category"				=> esc_html__( "Shortcodes", "seoaal" ),
				"icon"					=> "zozo-vc-icon",
				"params"				=> array(
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Extra Class", "seoaal" ),
						"param_name"	=> "extra_class",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "First Title", "seoaal" ),
						"description"	=> esc_html__( "Enter switch first title.", "seoaal" ),
						"param_name"	=> "primary_title",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Second Title", "seoaal" ),
						"description"	=> esc_html__( "Enter switch last title.", "seoaal" ),
						"param_name"	=> "secondary_title",
						"value" 		=> "",
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Switch Position", "seoaal" ),
						"description"	=> esc_html__( "Choose switch position top or bottom", "seoaal" ),
						"param_name"	=> "switch_pos",
						"value"			=> array(
							esc_html__( "Bottom", "seoaal" )	=> "bottom",
							esc_html__( "Top", "seoaal" )		=> "top"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Switch Alignment", "seoaal" ),
						"description"	=> esc_html__( "Choose switch alignment.", "seoaal" ),
						"param_name"	=> "switch_align",
						"value"			=> array(
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_switch_toggle_shortcode_map" );
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Seoaal_Vc_Switch_Toggle extends WPBakeryShortCodesContainer {
    }
}