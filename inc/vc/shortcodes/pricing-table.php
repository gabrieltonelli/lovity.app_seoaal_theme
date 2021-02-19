<?php 
/**
 * Seoaal Pricing Table
 */
if ( ! function_exists( "seoaal_vc_pricing_table_shortcode" ) ) {
	function seoaal_vc_pricing_table_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_pricing_table", $atts ); 
		extract( $atts );
		
		$output = '';
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';	
		$class .= isset( $pricing_layout ) ? ' pricing-style-' . $pricing_layout : '';	
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$ribbon_opt = isset( $ribbon_opt ) && $ribbon_opt == 'on' ? true : false;
		
		// Custom Style
		$shortcode_css = $title_class = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		$class .= ' ' . $shortcode_rand_id;
		
		$icon_type = isset( $icon_type ) ? 'icon_' . $icon_type : '';
		if( $icon_type == 'icon_fontawesome' && function_exists( 'vc_icon_element_fonts_enqueue' ) ) vc_icon_element_fonts_enqueue( 'fontawesome' );
		$icon = isset( $$icon_type ) ? $$icon_type : '';
		
		//Shortcode css code here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.pricing-table-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $title_color ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .pricing-table-head > .pricing-title { color: '. esc_attr( $title_color ) .'; }';
		}
		
		if( $ribbon_opt && isset( $ribbon_color ) && $ribbon_color != '' ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .corner-ribbon { background-color: '. esc_attr( $ribbon_color ) .'; }';
		}
		
		$icon_class = '';
		if( isset( $icon_variation ) ){
			if( $icon_variation == 'c' ){
				$shortcode_css .= isset( $icon_color ) && $icon_color != '' ? '.' . esc_attr( $rand_class ) . ' .pricing-inner-wrapper .pricing-icon { color: '. esc_attr( $icon_color ) .'; }' : '';
			}else{
				$icon_class .= ' ' . esc_attr( $icon_variation );
			}
		}
		
		if( $shortcode_css ) $class .= ' seoaal-inline-css';
		
		// Get VC Animation
		$class .= seoaalGetCSSAnimation( $animation );
		
		$elemetns = isset( $pricing_items ) ? seoaal_drag_and_drop_trim( $pricing_items ) : array( 'Enabled' => '' );
	
		if( isset( $elemetns['Enabled'] ) ) :
		
			$output .= '<div class="pricing-table-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">'; 
				
				if( $ribbon_opt ) :
					$ribbon_class = isset( $ribbon_position ) ? ' ' . $ribbon_position : '';
					$ribbon_text = isset( $ribbon_text ) && $ribbon_text != '' ? $ribbon_text : '';
					$output .= '<div class="corner-ribbon'. esc_attr( $ribbon_class ) .'">'. esc_html( $ribbon_text ) .'</div>';
				endif;
				
				$output .= '<div class="pricing-inner-wrapper">';
				
					foreach( $elemetns['Enabled'] as $element => $value ){
						switch( $element ){
							
							case "title":
								if( isset( $title ) && $title != '' ) : 
									$output .= '<div class="pricing-table-head">';
										$output .= '<h3 class="pricing-title'. esc_attr( $title_class ) .'">' . esc_html( $title ) . '</h3>';
									$output .= '</div><!-- .pricing-table-head -->';
								endif;						
							break;
							
							case "icon":
								$output .= '<div class="pricing-icon'. esc_attr( $icon_class ) .'">';
									$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
								$output .= '</div><!-- .pricing-icon -->';
							break;
							
							case "price":
								$output .= '<div class="pricing-table-info">';
									if( isset( $price_before ) && $price_before != '' ):
										$output .= '<div class="price-before">';
											$output .= '<p>' . esc_html( $price_before ) . '</p>';
										$output .= '</div><!-- .price-before -->';
									endif;
									
									if( isset( $price ) && $price != '' ):
										$output .= '<div class="price-text">';
											$output .= '<p>' . esc_html( $price ) . '</p>';
										$output .= '</div><!-- .price-text -->';
									endif;
									
									if( isset( $price_after ) && $price_after != '' ):
										$output .= '<div class="price-after">';
											$output .= '<p>' . esc_html( $price_after ) . '</p>';
										$output .= '</div><!-- .price-after -->';
									endif;
								$output .= '</div><!-- .pricing-table-info -->';
							break;
							
							case "features":
								$prc_fetrs =  json_decode( urldecode( $pricing_titles ), true ); // $prc_fetrs is pricing features
								if( $prc_fetrs ):
									$output .= '<div class="pricing-table-body">';
										$output .= '<ul class="pricing-features-list list-group">';
										foreach( $prc_fetrs as $feature ) {
											$status = isset( $feature['title_stat'] ) && $feature['title_stat'] == 'off' ? ' feature-inactive' : '';
											$p_title = isset( $feature['title'] ) ? $feature['title'] : '';
											$output .= '<li class="list-group-item'. esc_attr( $status ) .'">'. esc_html( $p_title ) . '</li>';
										}
										$output .= '</ul>';
									$output .= '</div><!-- .pricing-table-body -->';
								endif;
							break;
							
							case "image":
								if( isset( $pricing_image ) && !empty( $pricing_image ) ) :
									$img_attr = wp_get_attachment_image_src( absint( $pricing_image ), 'full', true );
									$image_alt = get_post_meta( absint( $pricing_image ), '_wp_attachment_image_alt', true);
									if( $img_attr ) :
										$output .= '<div class="pricing-image">';
										
											$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
											if( $lazy_opt ){
											
												$thumb_size = 'full';
												$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
											
												$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
												if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
													$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
													$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid m-auto d-block lazy-initiate" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" alt="'. esc_attr( $image_alt ) .'" />';
												}else{
													$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid m-auto d-block lazy-initiate" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '" alt="'. esc_attr( $image_alt ) .'" />';
												}
											}else{
												$output .= '<img class="img-fluid m-auto d-block" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />';
											}	
											
										$output .= '</div><!-- .pricing-image -->';
									endif;
								endif;
							break;
							
							case "video":
								if( isset( $pricing_video ) && !empty( $pricing_video ) ) :
										$output .= '<div class="pricing-image">';
											$output .= do_shortcode( '[videoframe url="'. esc_url( $pricing_video ).'" width="100%" height="100%" params="byline=0&portrait=0&badge=0" /]' );
										$output .= '</div><!-- .pricing-image -->';
								endif;
							break;
							
							case "btn":
								if( isset( $btn_text ) && $btn_text != '' ) :
									$btn_url = isset( $btn_url ) && $btn_url != '' ? $btn_url : '#';
									$output .= '<div class="pricing-table-foot">';
										$output .= '<a href="'. esc_url( $btn_url ) .'" class="btn btn-default mt-2">'. esc_html( $btn_text ) .'</a>';
									$output .= '</div><!-- .pricing-table-foot -->';
								endif;
							break;
							
							case "content":
								if( isset( $pricing_content ) && $pricing_content != '' ):
									$output .= '<div class="pricing-content">';
										$output .= '<p>' . esc_textarea( $pricing_content ) . '</p>'; 
									$output .= '</div><!-- .pricing-content -->';
								endif;
							break;
	
						}
					} // foreach end
					
				$output .= '</div><!-- .pricing-inner-wrapper -->';
			
			$output .= '</div><!-- .pricing-table-wrapper -->';
			
		endif;
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_pricing_table_shortcode_map" ) ) {
	function seoaal_vc_pricing_table_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Pricing Table", "seoaal" ),
				"description"			=> esc_html__( "Pricing table variations.", "seoaal" ),
				"base"					=> "seoaal_vc_pricing_table",
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
						"heading"		=> esc_html__( "Title", "seoaal" ),
						"description"	=> esc_html__( "Here you put the day social shortcode title.", "seoaal" ),
						"param_name"	=> "title",
						"value" 		=> "",
					),
					array(
						"type"			=> "animation_style",
						"heading"		=> esc_html__( "Animation Style", "seoaal" ),
						"description"	=> esc_html__( "Choose your animation style.", "seoaal" ),
						"param_name"	=> "animation",
						'admin_label'	=> false,
                		'weight'		=> 0,
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the font color.", "seoaal" ),
						"param_name"	=> "font_color",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Pricing Table Layout", "seoaal" ),
						"param_name"	=> "pricing_layout",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/pricing-table/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/pricing-table/2.png",
							"3"	=> SEOAAL_ADMIN_URL . "/assets/images/pricing-table/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Pricing Table Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for pricing table custom layout. here you can set your own layout. Drag and drop needed pricing items to Enabled part.", "seoaal" ),
						'param_name'	=> 'pricing_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'price'	=> esc_html__( 'Price Info', 'seoaal' ),
								'features'	=> esc_html__( 'Features List', 'seoaal' ),
								'btn'	=> esc_html__( 'Button', 'seoaal' )
								
							),
							'disabled' => array(
								'image'	=> esc_html__( 'Image', 'seoaal' ),
								'video'	=> esc_html__( 'Video', 'seoaal' ),
								'icon'	=> esc_html__( 'Icon', 'seoaal' ),
								'content'	=> esc_html__( 'Content', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Color", "seoaal" ),
						"description"	=> esc_html__( "Here you put the title color.", "seoaal" ),
						"param_name"	=> "title_color",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Price Before Text", "seoaal" ),
						"description"	=> esc_html__( "This is before text field for price.", "seoaal" ),
						"param_name"	=> "price_before",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Price", "seoaal" ),
						"description"	=> esc_html__( "This is field for price.", "seoaal" ),
						"param_name"	=> "price",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Price After", "seoaal" ),
						"description"	=> esc_html__( "This is after text field for price.", "seoaal" ),
						"param_name"	=> "price_after",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type' => 'param_group',
						"heading"		=> esc_html__( "Price Features List", "seoaal" ),
						'value' => '',
						'param_name' => 'pricing_titles',
						'params' => array(
							array(
								'type' => 'textfield',
								'value' => esc_html__( "Pricing Feature", "seoaal" ),
								'heading' => esc_html__( "Pricing Features Name", "seoaal" ),
								'param_name' => 'title',
							),
							array(
								"type"			=> "switch_bit",
								"heading"		=> esc_html__( "Active/Inactive", "seoaal" ),
								"param_name"	=> "title_stat",
								"value"			=> "on",
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__( "Pricing Image", "seoaal" ),
						"param_name" => "pricing_image",
						"value" => '',
						"description" => esc_html__( "Choose pricing image.", "seoaal" ),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Pricing Video", "seoaal" ),
						"param_name" => "pricing_video",
						"value" => '',
						"description" => esc_html__( "Choose pricing video. This url maybe youtube or vimeo video. Example https://www.youtube.com/embed/qAHRvrrfGC4", "seoaal" ),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__( "Pricing Content", "seoaal" ),
						"param_name" => "pricing_content",
						"value" => '',
						"description" => esc_html__( "This is option for pricing content.", "seoaal" ),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Button Text", "seoaal" ),
						"param_name" => "btn_text",
						"value" => esc_html__( "Plan", "seoaal" ),
						"description" => esc_html__( "This is option for pricing button text.", "seoaal" ),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Button URL", "seoaal" ),
						"param_name" => "btn_url",
						"value" => "",
						"description" => esc_html__( "This is option for pricing button url.", "seoaal" ),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is option for day social icons shortcode text align", "seoaal" ),
						"param_name"	=> "text_align",
						"value"			=> array(
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Right", "seoaal" )		=> "right",
							esc_html__( "Default", "seoaal" )	=> "default"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Ribbon Option", "seoaal" ),
						"description"	=> esc_html__( "This is option for pricing table ribbon. If you enable this option, then it's showing ribbon settings i.e color, text, etc..", "seoaal" ),
						"param_name"	=> "ribbon_opt",
						"value"			=> array(
							esc_html__( "Disable", "seoaal" )	=> "off",
							esc_html__( "Enable", "seoaal" )	=> "on"
						),
						"group"			=> esc_html__( "Ribbon", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Ribbon Background Color", "seoaal" ),
						"description"	=> esc_html__( "This is option for ribbon background color.", "seoaal" ),
						"param_name"	=> "ribbon_color",
						"value" 		=> "",
						"group"			=> esc_html__( "Ribbon", "seoaal" ),
						'dependency' => array(
							'element' => 'ribbon_opt',
							'value' => 'on',
						)
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Ribbon Text", "seoaal" ),
						"description"	=> esc_html__( "This is option for ribbon text field for price.", "seoaal" ),
						"param_name"	=> "ribbon_text",
						"value" 		=> "",
						"group"			=> esc_html__( "Ribbon", "seoaal" ),
						'dependency' => array(
							'element' => 'ribbon_opt',
							'value' => 'on',
						)
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Choose Ribbon Position", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Top Left", "seoaal" ) 		=> "top-left",
							esc_html__( "Top Right", "seoaal" )		=> "top-right",
							esc_html__( "Bottom Left", "seoaal" )	=> "bottom-left",
							esc_html__( "Bottom Right", "seoaal" )	=> "bottom-right",
						),
						"admin_label" 	=> true,
						"param_name" 	=> "ribbon_position",
						"group"			=> esc_html__( "Ribbon", "seoaal" ),
						'dependency' => array(
							'element' => 'ribbon_opt',
							'value' => 'on',
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
						"group"			=> esc_html__( "Icon", "seoaal" ),
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
						'description' => esc_html__( 'Select icon from library.', 'seoaal' ),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'seoaal' ),
						'param_name' => 'icon_simplelineicons',
						"value" 	=> "icon-star",
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'simplelineicons',
							'iconsPerPage' => 500,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'simplelineicons',
						),
						'description' => esc_html__( 'Select icon from library.', 'seoaal' ),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),	
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Icon Style", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box icon style.", "seoaal" ),
						"param_name"	=> "icon_variation",
						"value"			=> array(
							esc_html__( "Dark", "seoaal" )		=> "icon-dark",
							esc_html__( "Light", "seoaal" )		=> "icon-light",
							esc_html__( "Theme", "seoaal" )		=> "theme-color",
							esc_html__( "Custom", "seoaal" )	=> "c"
						),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the icons icon color.", "seoaal" ),
						"param_name"	=> "icon_color",
						'dependency' => array(
							'element' => 'icon_variation',
							'value' => 'c',
						),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_pricing_table_shortcode_map" );