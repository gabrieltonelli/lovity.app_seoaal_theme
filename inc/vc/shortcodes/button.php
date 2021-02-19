<?php 
/**
 * Seoaal Buttom
 */
if ( ! function_exists( "seoaal_vc_button_shortcode" ) ) {
	function seoaal_vc_button_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_button", $atts );
		extract( $atts );
		
		//Define Variables
		$class = isset( $extra_class ) && $extra_class != '' ? $extra_class : '';
		
		if( !empty( $extra_class ) && strpos( ' '.$extra_class, "popup-video-post" ) ){
			wp_enqueue_script( 'jquery-magnific' );
			wp_enqueue_style( 'magnific-popup' );
		}
		
		$class .= ' seoaal-btn';
		$class .= isset( $btn_type ) && $btn_type != '' ? ' btn-'. $btn_type : ' btn-default';
		$class .= isset( $btn_size ) && $btn_size != '' ? ' btn-'. $btn_size : '';
		$class .= isset( $btn_style ) && $btn_style != '' ? ' btn-'. $btn_style : '';
		$class .= isset( $btn_style ) && $btn_style != '' ? ' '. $btn_style : '';
		
		
		$btn_txt = isset( $btn_txt ) ? $btn_txt : esc_html_( 'Button', 'seoaal' );
		$btn_icon = isset( $btn_icon ) && $btn_icon == 'enable' ? true : false;
		$btn_icon_pos = isset( $btn_icon_pos ) ? $btn_icon_pos : 'left';	
		$border_trans = isset( $border_trans ) && $border_trans ? $border_trans : '';
		$btn_url = isset( $btn_url ) && $btn_url != '' ? $btn_url : "#";
		$btn_wrap_class = isset( $btn_alignment ) && $btn_alignment != '' ? ' d-flex justify-content-'. $btn_alignment : "";
		
		$btn_border = isset( $btn_border ) && $btn_border == 'enable' ? true : false;	
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		// VC Design Options
		$btn_wrap_class .= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), "seoaal_vc_button", $atts );
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.btn.' . esc_attr( $rand_class ) . ' { color: '. esc_attr( $font_color ) .'; }' : '';
		$shortcode_css .= isset( $font_hcolor ) && $font_hcolor != '' ? '.btn.' . esc_attr( $rand_class ) . ':hover { color: '. esc_attr( $font_hcolor ) .'; }' : '';
		
		if( $btn_icon ){
			$icon_type = isset( $icon_type ) ? 'icon_' . $icon_type : '';
			$icon = isset( $$icon_type ) ? $$icon_type : '';
			$icon_class = isset( $icon_style ) ? ' ' . $icon_style : '';
		}
	
		//Background Color
		if( isset( $btn_bg_trans ) ){
			if( $btn_bg_trans == 't' ){
				$shortcode_css .= '.btn.' . esc_attr( $rand_class ) . ' { background: transparent; }';
			}elseif( $btn_bg_trans == 'c' ){
				$shortcode_css .= isset( $btn_bg_color ) && $btn_bg_color != '' ? '.btn.' . esc_attr( $rand_class ) . ' { background-color: '. esc_attr( $btn_bg_color ) .'; }' : '';
			}else{
				$class .= ' ' . esc_attr( $btn_bg_trans );
			}
		}
		
		//Background Hover Color
		if( isset( $btn_hbg_trans ) && $btn_hbg_trans ){
			if( $btn_hbg_trans == 't' ){
				$shortcode_css .= '.btn.' . esc_attr( $rand_class ) . ':hover { background: transparent; }';
			}elseif( $btn_hbg_trans == 'c' ){
				$shortcode_css .= isset( $btn_hbg_color ) && $btn_hbg_color != '' ? '.btn.' . esc_attr( $rand_class ) . ':hover { background-color: '. esc_attr( $btn_hbg_color ) .'; }' : '';
			}
		}
		
		if( $btn_border ){
			$shortcode_css .= isset( $border_size ) && $border_size != '' ? '.btn.' . esc_attr( $rand_class ) . ' { border-style: solid; border-width: '. esc_attr( $border_size ) .'px; }' : '';
			//Border Color
			if( isset( $border_trans ) && $border_trans ){
				if( $border_trans == 't' ){
					$shortcode_css .= '.btn.' . esc_attr( $rand_class ) . ' { border-color: transparent; }';
				}elseif( $border_trans == 'c' ){
					$shortcode_css .= isset( $border_color ) && $border_color != '' ? '.btn.' . esc_attr( $rand_class ) . ' { border-color: '. esc_attr( $border_color ) .'; }' : '';
				}
			}
			
			//Border Hover Color
			if( isset( $border_htrans ) && $border_htrans ){
				if( $border_htrans == 't' ){
					$shortcode_css .= '.btn.' . esc_attr( $rand_class ) . ':hover { border-color: transparent; }';
				}elseif( $border_htrans == 'c' ){
					$shortcode_css .= isset( $border_hcolor ) && $border_hcolor != '' ? '.btn.' . esc_attr( $rand_class ) . ':hover { border-color: '. esc_attr( $border_hcolor ) .'; }' : '';
				}
			}
			
		}
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
		$output = '<div class="btn-wrap'. esc_attr( $btn_wrap_class ) .'">';
			$output .= '<a href="'. esc_url( $btn_url ) .'" class="btn '. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				$output .= $btn_icon && $btn_icon_pos == 'left' ? '<span class="btn-icon btn-icon-left '. esc_attr( $icon ) .'"></span>' : '';
				$output .= esc_html( $btn_txt );
				$output .= $btn_icon && $btn_icon_pos == 'right'  ? '<span class="btn-icon btn-icon-right '. esc_attr( $icon ) .'"></span>' : '';
			$output .= '</a>';
		$output .= '</div>';
		
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_button_shortcode_map" ) ) {
	function seoaal_vc_button_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Button", "seoaal" ),
				"description"			=> esc_html__( "Variation of buttons.", "seoaal" ),
				"base"					=> "seoaal_vc_button",
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
						"heading"		=> esc_html__( "Button Text", "seoaal" ),
						"param_name"	=> "btn_txt",
						"value" 		=> esc_html__( "Button", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Button URL", "seoaal" ),
						"param_name"	=> "btn_url",
						"value" 		=> "#"
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the font color.", "seoaal" ),
						"param_name"	=> "font_color"
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Hover Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the hover font color.", "seoaal" ),
						"param_name"	=> "font_hcolor"
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Type", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Light", "seoaal" )	=> "light",
							esc_html__( "Dark", "seoaal" )		=> "dark",
							esc_html__( "Link", "seoaal" )		=> "link",
						),
						"param_name" 	=> "btn_type"
					),	
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Button Size", "seoaal" ),
						"description" 	=> esc_html__( "This is an option for choose button size.", "seoaal" ),
						"param_name"	=> "btn_size",
						"value" 		=> array(
							esc_html__( "Default", "seoaal" )		=> "",
							esc_html__( "Small", "seoaal" )	=> "sm",
							esc_html__( "Large", "seoaal" )	=> "lg"
						)
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Style", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Default", "seoaal" ) => "",
							esc_html__( "Rounded", "seoaal" ) => "rounded",
							esc_html__( "Circled", "seoaal" ) => "rounded-circle",
						),
						"param_name" 	=> "btn_style"
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Alignment", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Default", "seoaal" ) => "",
							esc_html__( "Left", "seoaal" ) => "start",
							esc_html__( "Center", "seoaal" ) => "center",
							esc_html__( "Right", "seoaal" ) => "end",
						),
						"param_name" 	=> "btn_alignment"
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Icon", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" )		=> "",
							esc_html__( "Enable", "seoaal" )	=> "enable"
						),
						"admin_label" 	=> true,
						"param_name" 	=> "btn_icon",
						"description" 	=> esc_html__( "Select enable, If need icon.", "seoaal" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Choose from Button library", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) 				=> "",
							esc_html__( "Font Awesome", "seoaal" ) 		=> "fontawesome",
							esc_html__( "Simple Line Icons", "seoaal" ) => "simplelineicons",
						),
						"admin_label" 	=> true,
						"param_name" 	=> "icon_type",
						"description" 	=> esc_html__( "Select icon library.", "seoaal" ),
						'dependency' => array(
							'element' => 'btn_icon',
							'value' => 'enable',
						)
					),		
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'seoaal' ),
						'param_name' => 'icon_fontawesome',
						"value" 		=> "fa fa-heart-o",
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'fontawesome',
							'iconsPerPage' => 675,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'fontawesome',
						),
						'description' => esc_html__( 'Select icon from library.', 'seoaal' )
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'seoaal' ),
						'param_name' => 'icon_simplelineicons',
						"value" 	=> "vc_li vc_li-star",
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'simplelineicons',
							'iconsPerPage' => 500,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'simplelineicons',
						),
						'description' => esc_html__( 'Select icon from library.', 'seoaal' )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Icon Position", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Right", "seoaal" )	=> "right"
						),
						"param_name" 	=> "btn_icon_pos",
						"description" 	=> esc_html__( "Select icon position.", "seoaal" ),
						'dependency' => array(
							'element' => 'btn_icon',
							'value' => 'enable',
						)
					),	
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Background", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Default", "seoaal" ) => "",
							esc_html__( "Transparent", "seoaal" ) => "t",
							esc_html__( "Theme Color", "seoaal" ) => "theme-color-bg",
							esc_html__( "Set Color", "seoaal" )=> "c"
						),
						"std"			=> "",
						"param_name" 	=> "btn_bg_trans"
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Button Background Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the icon background color.", "seoaal" ),
						"param_name"	=> "btn_bg_color",
						'dependency' => array(
							'element' => 'btn_bg_trans',
							'value' => 'c',
						)
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Background Hover", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Default", "seoaal" ) => "",
							esc_html__( "Transparent", "seoaal" ) => "t",
							esc_html__( "Set Color", "seoaal" )=> "c"
						),
						"param_name" 	=> "btn_hbg_trans"
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Button Background Hover Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the icon background hover color.", "seoaal" ),
						"param_name"	=> "btn_hbg_color",
						'dependency' => array(
							'element' => 'btn_hbg_trans',
							'value' => 'c',
						)
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Border", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" )		=> "",
							esc_html__( "Enable", "seoaal" )	=> "enable"
						),
						"admin_label" 	=> true,
						"param_name" 	=> "btn_border",
						"description" 	=> esc_html__( "Select enable, If need icon.", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Border Size", "seoaal" ),
						"description"	=> esc_html__( "Here you can set border size. Example 3.", "seoaal" ),
						"param_name"	=> "border_size",
						"value" 		=> "",
						'dependency' => array(
							'element' => 'btn_border',
							'value' => 'enable',
						)
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Border Color Option", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) => "",
							esc_html__( "Transparent", "seoaal" ) => "t",
							esc_html__( "Set Color", "seoaal" )=> "c"
						),
						"param_name" 	=> "border_trans",
						'dependency' => array(
							'element' => 'btn_border',
							'value' => 'enable',
						)
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Border Custom Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the border color.", "seoaal" ),
						"param_name"	=> "border_color",
						'dependency' => array(
							'element' => 'border_trans',
							'value' => 'c',
						)
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Border Hover Color Option", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) => "",
							esc_html__( "Transparent", "seoaal" ) => "t",
							esc_html__( "Set Color", "seoaal" )=> "c"
						),
						"param_name" 	=> "border_htrans",
						'dependency' => array(
							'element' => 'btn_border',
							'value' => 'enable',
						)
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Border Hover Custom Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the border hover color.", "seoaal" ),
						"param_name"	=> "border_hcolor",
						'dependency' => array(
							'element' => 'border_htrans',
							'value' => 'c',
						)
					),
					array(
						'type'		=> "css_editor",
						'heading'	=> esc_html__( "Css", 'seoaal' ),
						'param_name'=> "css",
						'group'		=> esc_html__( "Design options", "seoaal" ),
					)
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_button_shortcode_map" );