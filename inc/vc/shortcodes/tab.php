<?php 
/**
 * Seoaal Tab
 */
if ( ! function_exists( "seoaal_vc_tab_shortcode" ) ) {
	function seoaal_vc_tab_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_tab", $atts );
		extract( $atts );
		
		//Define Variables
		$class = isset( $extra_class ) && $extra_class != '' ? ' '. $extra_class : '';
		
		$tab_name = isset( $tab_name ) && $tab_name != '' ? $tab_name : '';
		$tab_id = isset( $tab_id ) && $tab_id != '' ? $tab_id : '';
		
		$icon_list_dec = isset( $icon_list_dec ) && $icon_list_dec != 'none' ? $icon_list_dec : '';
		
		$icon_out = $img_out = '';
		if( $icon_list_dec == 'icon' ){
			$icon = 'icon_' . esc_attr( $icon_type );
			$icon = isset( $$icon ) ? $$icon : '';
			$icon_out = '<div class="tab-list-icon"><span class="'. esc_attr( $icon ) .'"></span></div>';
		}elseif( $icon_list_dec == 'image' ){
			$tab_image = isset( $tab_image ) ? $tab_image : '';
			$img_attr = wp_get_attachment_image_src( absint( $tab_image ), 'full', true );
			$image_alt = get_post_meta( absint( $tab_image ), '_wp_attachment_image_alt', true);
			$image_alt = $image_alt != '' ? $image_alt : $tab_name;
			
			$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
			if( $lazy_opt ){
			
				$thumb_size = 'full';
				$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
			
				$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
				if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
					$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
					$output .= '<div class="tab-list-img"><img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" alt="'. esc_attr( $image_alt ) .'" /></div>';
				}else{
					$output .= '<div class="tab-list-img"><img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '" alt="'. esc_attr( $image_alt ) .'" /></div>';
				}
			}else{
				$img_out = isset( $img_attr[0] ) ? '<div class="tab-list-img"><img class="img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" /></div>' : '';
			}
			
		}
			
		
		$list_out = '<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#'. esc_attr( $tab_id ) .'" role="tab" aria-controls="'. esc_attr( $tab_id ) .'" aria-selected="true">';
		$list_out .= $icon_out;
		$list_out .= $img_out;
		$list_out .= esc_html( $tab_name );
		$list_out .= '<span class="box-down-arrow"></span></li>';
		$list_out .= '</a>';		
		
		$tab_cont = '<div class="tab-pane fade" id="'. esc_attr( $tab_id ) .'" role="tabpanel" aria-labelledby="'. esc_attr( $tab_id ) .'-tab">'. do_shortcode( $content ) .'</div>';
		
		$t = seoaal_tabs_shortcode_list_collect( $list_out );
		$t = seoaal_tabs_shortcode_content_collect( $tab_cont );
		
		return '';
	}
}
if ( ! function_exists( "seoaal_vc_tab_shortcode_map" ) ) {
	function seoaal_vc_tab_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Tab", "seoaal" ),
				"description"			=> esc_html__( "Default tab.", "seoaal" ),
				"base"					=> "seoaal_vc_tab",
				'allowed_container_element' => 'vc_row',
				'as_child'        => array('only' => 'seoaal_vc_tabs'),
				//'allowed_container_element' => false,
				"is_container"			=> true,
				'content_element' => true,
				"js_view" 				=> 'VcColumnView',
				"icon"					=> "zozo-vc-icon",
				"category"				=> esc_html__( "Shortcodes", "seoaal" ),
				"params"				=> array(
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Extra Class", "seoaal" ),
						"param_name"	=> "extra_class",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Tab Name", "seoaal" ),
						"param_name"	=> "tab_name",
						"value" 		=> esc_html__( "Tab 1", "seoaal" ),
					),
					array(
						'type' => 'tab_id',
						'heading' => esc_html__( 'Tab ID', 'seoaal' ),
						'param_name' => 'tab_id',
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Icon List Icon/Image", "seoaal" ),
						"description"	=> esc_html__( "This is option for put list icon/image.", "seoaal" ),
						"param_name"	=> "icon_list_dec",
						"value"			=> array(
							esc_html__( "None", "seoaal" )		=> "none",
							esc_html__( "Icon", "seoaal" )		=> "icon",
							esc_html__( "Image", "seoaal" )		=> "image"
						)
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Choose from Icon library", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) 				=> "",
							esc_html__( "Font Awesome", "seoaal" ) 		=> "fontawesome",
							esc_html__( "Simple Line Icons", "seoaal" ) => "simplelineicons",
						),
						"admin_label" 	=> true,
						"param_name" 	=> "icon_type",
						"description" 	=> esc_html__( "Select icon library.", "seoaal" ),
						'dependency' => array(
							'element' => 'icon_list_dec',
							'value' => 'icon',
						),
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
						"type" => "attach_image",
						"heading" => esc_html__( "Select Image", "seoaal" ),
						"description" => esc_html__( "Choose tab list image instead of tab icon.", "seoaal" ),
						"param_name" => "tab_image",
						"value" => '',
						'dependency' => array(
							'element' => 'icon_list_dec',
							'value' => 'image',
						),
					)
				)
			) 
		);
		
	}
}
add_action( "vc_before_init", "seoaal_vc_tab_shortcode_map" );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Seoaal_Vc_Tab extends WPBakeryShortCodesContainer {
    }
}