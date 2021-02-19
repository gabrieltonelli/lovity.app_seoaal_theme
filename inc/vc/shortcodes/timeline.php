<?php 
/**
 * Seoaal Timeline
 */
if ( ! function_exists( "seoaal_vc_timeline_shortcode" ) ) {
	function seoaal_vc_timeline_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_timeline", $atts );
		extract( $atts );
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? $extra_class : ''; 
		$class .= isset( $timeline_style ) && $timeline_style != '' ? ' timeline-style-'.$timeline_style : ''; 
		// Get VC Animation
		$class .= seoaalGetCSSAnimation( $animation );
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.timeline-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
		$output = '';
		$output .= '<div class="timeline-wrapper '. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
		
		// All Timeline Items
		$timeline_settings = isset( $timeline_settings ) ? $timeline_settings : '';
		$tl_items =  json_decode( urldecode( $timeline_settings ), true ); // $tl_items is timeline items
		if( $tl_items ):
			
			$tl_layout = isset( $timeline_layout ) ? $timeline_layout : '';
			$layout_class = $timeline_layout != 'default' ? ' tl-' . $timeline_layout . '-layout' : '';
			$layout_class .= isset( $timeline_line ) && $timeline_line != 'default' ? ' tl-border-' . $timeline_line : '';
			$output .= '<ul class="timeline'. esc_attr( $layout_class ) .'">';
			foreach( $tl_items as $tlitem ) {
				
				$tl_rand_class = 'timeline-rand-'. seoaal_shortcode_rand_id();
				$tl_pos = isset( $tlitem['timeline_pos'] ) ? $tlitem['timeline_pos'] : '';
				$li_class = '';
				if( $tl_layout == 'default' ){
					$li_class .= $tl_pos == 'opp' ? ' timeline-inverted' : '';
				}elseif( $tl_layout == 'left' ){
					$li_class .= ' timeline-inverted';
				}
				$tl_title = isset( $tlitem['timeline_title'] ) ? $tlitem['timeline_title'] : '';
				$tl_stitle = isset( $tlitem['timeline_subtitle'] ) ? $tlitem['timeline_subtitle'] : '';
				$tl_content = isset( $tlitem['tl_content'] ) ? $tlitem['tl_content'] : '';
				$auto_p = isset( $tlitem['tl_content_p'] ) ? $tlitem['tl_content_p'] : '';
				
				$separator_type = isset( $tlitem['separator_type'] ) ? $tlitem['separator_type'] : 'none';
				$sep_out = '';
				switch( $separator_type ){
					case "icon":
						$icon_type = isset( $tlitem['icon_type'] ) ? 'icon_' . $tlitem['icon_type'] : '';
						if( $icon_type == 'icon_fontawesome' && function_exists( 'vc_icon_element_fonts_enqueue' ) ) vc_icon_element_fonts_enqueue( 'fontawesome' );
						$icon = isset( $tlitem[$icon_type] ) ? $tlitem[$icon_type] : '';
						$sep_out = '<i class="'. esc_attr( $icon ) .'"></i>';
					break;
					case "img":
						$sep_image = isset( $tlitem['separator_image'] ) ? $tlitem['separator_image'] : '';
						if( $sep_image ){
							$img_attr = wp_get_attachment_image_src( absint( $sep_image ), 'full', true );
							$image_alt = get_post_meta( absint( $sep_image ), '_wp_attachment_image_alt', true);
							
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
								$sep_out = isset( $img_attr[0] ) ? '<img class="img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />' : '';
							}
														
						}
					break;
					case "txt":
						$sep_text = isset( $tlitem['separator_text'] ) ? $tlitem['separator_text'] : '';
						$sep_out = '<span class="separator-text">'. esc_html( $sep_text ) .'</span>';
					break;
					default:
						$sep_out = '<span class="separator-empty"></span>';
					break;
				}
				
				$sep_title = isset( $tlitem['separator_title'] ) && $tlitem['separator_title'] != '' ? $tlitem['separator_title'] : '';
				$sep_stitle = isset( $tlitem['separator_subtitle'] ) && $tlitem['separator_subtitle'] != '' ? $tlitem['separator_subtitle'] : '';
				$sep_tit_out = '';
				if( $sep_title != '' || $sep_stitle != '' ){
					$sep_tit_out .= $sep_title != '' ? esc_html( $sep_title ) : '';
					$sep_tit_out .= $sep_stitle != '' ? '<span>'. esc_html( $sep_stitle ) .'</span>' : '';
				}
				
				$sep_class = '';
				$sep_bg_stat = 1;
				if( $sep_out ){
					if( isset( $tlitem['separator_shape'] ) ){
						if( is_numeric( $tlitem['separator_shape'] ) ){
							$sep_class = ' separator-shape-custom';
							$sep_bg = isset( $tlitem['separator_bgcolor'] ) ? $tlitem['separator_bgcolor'] : '#333';
							$sep_out .= '<canvas id="canvas_agon" class="canvas_agon" width=50 height=50 data-size="25" data-side="'. esc_attr( $tlitem['separator_shape'] ) .'" data-color="'. esc_attr( $sep_bg ) .'"></canvas>';
							$sep_bg_stat = 0;
						}else{
							$sep_class = ' '.$tlitem['separator_shape'];
						}
					}else{
						$sep_class = ' '. $tlitem['separator_shape'];
					}
				}
				
				//Timeline css ccde here
				$tl_css = isset( $tlitem['title_color'] ) && $tlitem['title_color'] != '' ? '.' . esc_attr( $tl_rand_class ) . ' .timeline-title { color: '. esc_attr( $tlitem['title_color'] ) .'; }' : '';
				
				if( $sep_bg_stat ){
					$tl_css .= isset( $tlitem['separator_bgcolor'] ) && $tlitem['separator_bgcolor'] != '' ? '.timeline > .' . esc_attr( $tl_rand_class ) . ' .timeline-badge { background-color: '. esc_attr( $tlitem['separator_bgcolor'] ) .'; }' : '';
				}
				$tl_css .= isset( $tlitem['separator_color'] ) && $tlitem['separator_color'] != '' ? '.timeline > .' . esc_attr( $tl_rand_class ) . ' .timeline-badge { color: '. esc_attr( $tlitem['separator_color'] ) .'; }' : '';
				if( $tl_css ) $li_class .= ' ' . $tl_rand_class . ' seoaal-inline-css';
				$output .= '<li class="'. esc_attr( $li_class ) .'" data-css="'. htmlspecialchars( json_encode( $tl_css ), ENT_QUOTES, 'UTF-8' ) .'">';
					
					$output .= $sep_out != '' ? '<div class="timeline-badge'. esc_attr( $sep_class ) .'">'. ( $sep_out ) .'</div>' : '';
					$output .= $sep_tit_out != '' ? '<div class="timeline-sep-title">'. wp_kses_post( $sep_tit_out ) .'</div>' : '';
				
					$output .= '<div class="timeline-panel">';
						if( $tl_title || $tl_stitle ):
							$output .= '<div class="timeline-heading">';
								$output .= $tl_title != '' ? '<h4 class="timeline-title">'. esc_html( $tl_title ) .'</h4>' : '';
								$output .= $tl_stitle != '' ? '<p><small class="text-muted">'. wp_kses_post( $tl_stitle ) .'</small></p>' : '';
							$output .= '</div>';
						endif;
						
						if( $tl_content ):
							$output .= '<div class="timeline-body">';
								$output .= $auto_p ? '<p>' : '';
								$output .= do_shortcode( $tl_content );
								$output .= $auto_p ? '</p>' : '';
							$output .= '</div>';
						endif;
						
					$output .= '</div>';
				$output .= '</li><!-- .timeline item li -->';
				
			}
			$output .= '</ul>';
		endif;
							
		$output .= '</div><!-- .timeline-wrapper -->';
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_timeline_shortcode_map" ) ) {
	function seoaal_vc_timeline_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Timeline", "seoaal" ),
				"description"			=> esc_html__( "Numeric timeline.", "seoaal" ),
				"base"					=> "seoaal_vc_timeline",
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
						"heading"		=> esc_html__( "Timeline Style", "seoaal" ),
						"param_name"	=> "timeline_style",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/timeline/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/timeline/2.png",
							"3"	=> SEOAAL_ADMIN_URL . "/assets/images/timeline/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Timeline", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Timeline Layout", "seoaal" ),
						"description"	=> esc_html__( "This is option for timeline layout. If you choose left/right layout, then this option set the timeline position same side.", "seoaal" ),
						"param_name"	=> "timeline_layout",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )		=> "default",
							esc_html__( "Left Layout", "seoaal" )	=> "left",
							esc_html__( "Right Layout", "seoaal" )	=> "right"
						),
						"group"			=> esc_html__( "Timeline", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "History Line Style", "seoaal" ),
						"description"	=> esc_html__( "This is option for timeline history line style.", "seoaal" ),
						"param_name"	=> "timeline_line",
						"value"			=> array(
							esc_html__( "Dotted", "seoaal" )	=> "default",
							esc_html__( "Solid", "seoaal" )		=> "solid"
						),
						"group"			=> esc_html__( "Timeline", "seoaal" )
					),
					array(
						'type' => 'param_group',
						"heading"		=> esc_html__( "Timeline Setting", "seoaal" ),
						'value' => '',
						'param_name' => 'timeline_settings',
						'params' => array(
							array(
								"type"			=> "dropdown",
								"heading"		=> esc_html__( "Timeline Position", "seoaal" ),
								"description"	=> esc_html__( "This is option for timeline position. Either same side or opposite side.", "seoaal" ),
								"param_name"	=> "timeline_pos",
								"value"			=> array(
									esc_html__( "Same Side", "seoaal" )=> "same",
									esc_html__( "Opposite Side", "seoaal" )=> "opp"
								),
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Timeline Title", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline title.", "seoaal" ),
								"param_name"	=> "timeline_title",
								"admin_label" 	=> true,
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Timeline Sub Title", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline sub title.", "seoaal" ),
								"param_name"	=> "timeline_subtitle",
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "colorpicker",
								"heading"		=> esc_html__( "Timeline Title Color", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline title and subtitle color.", "seoaal" ),
								"param_name"	=> "title_color",
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type" 			=> "dropdown",
								"param_name" 	=> "separator_shape",
								"heading" 		=> esc_html__( "Separator Shape", "seoaal" ),
								"description" 	=> esc_html__( "This is options for separator shape.", "seoaal" ),
								"value" 		=> array(
									esc_html__( "Square", "seoaal" ) => "sq",
									esc_html__( "Rounded", "seoaal" )=> "rounded",
									esc_html__( "Circle", "seoaal" ) => "rounded-circle",
									esc_html__( "Triangle", "seoaal" ) => "3",
									esc_html__( "Pentagon", "seoaal" ) => "5",
									esc_html__( "Hexagon", "seoaal" ) => "6",
									esc_html__( "Heptagon", "seoaal" ) => "7",
									esc_html__( "Octagon", "seoaal" ) => "8",
									esc_html__( "Nonagon", "seoaal" ) => "9",
									esc_html__( "Decagon", "seoaal" ) => "10",
								),
								"group"			=> esc_html__( "Timeline", "seoaal" ),
							),
							array(
								"type"			=> "dropdown",
								"heading"		=> esc_html__( "Separator Type", "seoaal" ),
								"description"	=> esc_html__( "This is option for timeline separator type either icon/image/text. If no need separator, then choose none.", "seoaal" ),
								"param_name"	=> "separator_type",
								"value"			=> array(
									esc_html__( "None", "seoaal" )=> "none",
									esc_html__( "Icon", "seoaal" )=> "icon",
									esc_html__( "Image", "seoaal" )=> "img",
									esc_html__( "Text", "seoaal" )=> "txt"
								),
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type" 			=> "dropdown",
								"heading" 		=> esc_html__( "Separator Icon", "seoaal" ),
								"value" 		=> array(
									esc_html__( "None", "seoaal" ) 				=> "",
									esc_html__( "Font Awesome", "seoaal" ) 		=> "fontawesome",
									esc_html__( "Simple Line Icons", "seoaal" ) => "simplelineicons",
								),
								"param_name" 	=> "icon_type",
								"description" 	=> esc_html__( "Choose from Icon library.", "seoaal" ),
								'dependency' => array(
									'element' => 'separator_type',
									'value' => 'icon',
								),
								"group"			=> esc_html__( "Timeline", "seoaal" ),
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
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								'type' => 'iconpicker',
								'heading' => esc_html__( 'Icon', 'seoaal' ),
								'param_name' => 'icon_simplelineicons',
								"value" 	=> "icon-trophy",
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
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),		
							array(
								"type" => "attach_image",
								"heading" => esc_html__( "Separator Image", "seoaal" ),
								"description" => esc_html__( "Choose separator image.", "seoaal" ),
								"param_name" => "separator_image",
								"value" => '',
								'dependency' => array(
									'element' => 'separator_type',
									'value' => 'img',
								),
								"group"			=> esc_html__( "Timeline", "seoaal" ),
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Separator Text", "seoaal" ),
								"description" => esc_html__( "This is option for showing text on separator.", "seoaal" ),
								"param_name"	=> "separator_text",
								"value" 		=> "",
								'dependency' => array(
									'element' => 'separator_type',
									'value' => 'txt',
								),
								"group"			=> esc_html__( "Timeline", "seoaal" ),
							),
							array(
								"type"			=> "colorpicker",
								"heading"		=> esc_html__( "Separator Color", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline separator color.", "seoaal" ),
								"param_name"	=> "separator_color",
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "colorpicker",
								"heading"		=> esc_html__( "Separator Background Color", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline separator color.", "seoaal" ),
								"param_name"	=> "separator_bgcolor",
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Separator Title", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline separator title.", "seoaal" ),
								"param_name"	=> "separator_title",
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Separator Sub Title", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline separator sub title.", "seoaal" ),
								"param_name"	=> "separator_subtitle",
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "textarea",
								"heading"		=> esc_html__( "Content", "seoaal" ),
								"description" 	=> esc_html__( "You can give the feature box content here. HTML allowed here.", "seoaal" ),
								"param_name"	=> "tl_content",
								"value" 		=> "",
								"group"			=> esc_html__( "Content", "seoaal" )
							),
							array(
								"type"			=> "switch_bit",
								"heading"		=> esc_html__( "Auto Paragrap", "seoaal" ),
								"description" 	=> esc_html__( "This is option for content covered by paragrap.", "seoaal" ),
								"param_name"	=> "tl_content_p",
								"value"			=> "off",
							)
						),
						"group"			=> esc_html__( "Timeline", "seoaal" )
					),
					
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_timeline_shortcode_map" );