<?php 
/**
 * Seoaal Section Title
 */
if ( ! function_exists( "seoaal_vc_section_title_shortcode" ) ) {
	function seoaal_vc_section_title_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_section_title", $atts );
		extract( $atts );
		
		$output = '';
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';		
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';	
		
		$title = isset( $title ) ? $title : '';
		$title_head = isset( $title_head ) ? $title_head : 'h1';
		$google_fonts = isset( $google_fonts ) ? $google_fonts : array();
		$background_title = isset( $background_title ) ? $background_title : '';
		$background_title_color = isset( $background_title_color ) ? $background_title_color : '';
				
		// Get VC Animation
		$class .= seoaalGetCSSAnimation( $animation );
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		if( !empty( $google_fonts ) ){
			$google_font_rand = str_replace( "-", "_", $shortcode_rand_id );
			$google_font_style = seoaal_get_custom_google_font_con( $google_fonts, $google_font_rand );
			$shortcode_css .= isset( $google_font_style ) && $google_font_style != '' ? '.' . esc_attr( $rand_class ) . ' .background-title { '. ( $google_font_style ) .' }' : '';
		}
		
		$bg_title_class = '';
		if( !empty( $background_title_color ) ){ 
			$bg_title_class = ' bg-title-enabled';
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .background-title { color: '. esc_attr( $background_title_color ) .'; }';
		}
		
		// Title Color/ Title Prefix / Title Suffix Coloe CSS / Title Typo Settings
		$shortcode_css .= isset( $title_prefix_color ) && $title_prefix_color != '' ? '.' . esc_attr( $rand_class ) . ' .section-title .title-prefix { color: '. esc_attr( $title_prefix_color ) .'; }' : '';
		$shortcode_css .= isset( $title_suffix_color ) && $title_suffix_color != '' ? '.' . esc_attr( $rand_class ) . ' .section-title .title-suffix { color: '. esc_attr( $title_suffix_color ) .'; }' : '';
		$shortcode_css .= isset( $title_margin ) && $title_margin != '' ? '.' . esc_attr( $rand_class ) . ' .title-wrap { margin: '. esc_attr( $title_margin ) .'; }' : '';
		
		
		$sep_border_color = isset( $sep_border_color ) ? $sep_border_color : '';
		$shortcode_css .= isset( $sep_type ) && $sep_type == 'border' ? '.' . esc_attr( $rand_class ) . ' .title-separator.separator-border, .' . esc_attr( $rand_class ) . ' .title-separator.separator-border:after, .' . esc_attr( $rand_class ) . ' .title-separator.separator-border:before { background-color: '. esc_attr( $sep_border_color ) .'; }' : '';
		
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.section-title-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		$shortcode_css .= isset( $sub_title_color ) && $sub_title_color != '' ? '.' . esc_attr( $rand_class ) . '.section-title-wrapper .sub-title { color: '. esc_attr( $sub_title_color ) .'; }' : '';
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '.' . esc_attr( $rand_class ) . '.section-title-wrapper >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}		
		
		$title_css = isset( $title_color ) && $title_color != '' ? ' color: '. esc_attr( $title_color ) .';' : '';
		$title_css .= isset( $font_size ) && $font_size != '' ? ' font-size: '. esc_attr( $font_size ) .'px;' : '';
		$title_css .= isset( $line_height ) && $line_height != '' ? ' line-height: '. esc_attr( $line_height ) .'px;' : '';
		$title_css .= isset( $title_trans ) && $title_trans != '' ? ' text-transform: '. esc_attr( $title_trans ) .';' : '';
		
		$shortcode_css .= $title_css != '' ? '.' . esc_attr( $rand_class ) . ' .section-title {' . $title_css . ' }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' seoaal-inline-css'; 
		
		$sub_title = isset( $sub_title ) && $sub_title != '' ? '<span class="sub-title">'. esc_html( $sub_title ) .'</span>' : ''; 
		$sub_title_pos = isset( $sub_title_pos ) ? $sub_title_pos : 'bottom';
		
		$output .= '<div class="section-title-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
			$output .= '<div class="title-wrap'. esc_attr( $bg_title_class ) .'">';
			
				if( $background_title ){
					$output .= '<span class="background-title">'. esc_html( $background_title ) .'</span>'; 
				}
			
				// Section title 
				$output .= $sub_title != '' && $sub_title_pos == 'top' ? $sub_title : '';
				$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
					$output .= isset( $title_prefix ) && $title_prefix != '' ? '<span class="title-prefix theme-color">' . esc_html( $title_prefix ) . '</span> ' : '';
					$output .= esc_html( $title );
					$output .= isset( $title_suffix ) && $title_suffix != '' ? ' <span class="title-suffix theme-color">' . esc_html( $title_suffix ) . '</span>' : '';
				$output .= '</' . esc_attr( $title_head ) . '>';
				$output .= $sub_title != '' && $sub_title_pos == 'bottom' ? $sub_title : '';
				// Section title separator 
				$sep_type = isset( $sep_type ) ? $sep_type : 'border';
				if( $sep_type == 'border' ){
					$output .= '<span class="title-separator separator-border theme-color-bg"></span>';
				}elseif( $sep_type == 'image' ){
					$img_attr = wp_get_attachment_image_src( absint( $sep_image ), 'full', true );
					$image_alt = get_post_meta( absint( $sep_image ), '_wp_attachment_image_alt', true);
					
					$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
					if( $lazy_opt ){
					
						$thumb_size = 'full';
						$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
					
						$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
						if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
							$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
							$output .= '<span class="title-separator separator-img"><img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" alt="'. esc_attr( $image_alt ) .'" /></span>';
						}else{
							$output .= '<span class="title-separator separator-img"><img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '" alt="'. esc_attr( $image_alt ) .'" /></span>';
						}
					}else{
						$output .= isset( $img_attr[0] ) ? '<span class="title-separator separator-img"><img class="img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" /></span>' : '';
					}
					
				}
			$output .= '</div><!-- .title-wrap -->';
			
			$output .= '<div class="section-description">';
				$output .= isset( $content ) && $content != '' ? wp_kses_post( $content ) : '';
			$output .= '</div><!-- .section-description -->';
			
			$output .= '<div class="button-section">';
				$btn_url = isset( $btn_url ) ? $btn_url : '';
				$btn_type = isset( $btn_type ) ? $btn_type : '';
				$output .= isset( $btn_text ) && $btn_text != '' ? '<p><a class="btn '. esc_attr( $btn_type ) .'" href="'. esc_url( $btn_url ) .'" title="'. esc_attr( $btn_text ) .'">'. esc_html( $btn_text ) .'</a></p>' : '';			
			$output .= '</div><!-- .button-section -->';
			
		$output .= '</div><!-- .section-title-wrapper -->';
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_section_title_shortcode_map" ) ) {
	function seoaal_vc_section_title_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Section Title", "seoaal" ),
				"description"			=> esc_html__( "Variant section title.", "seoaal" ),
				"base"					=> "seoaal_vc_section_title",
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
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Title Heading Tag", "seoaal" ),
						"description"	=> esc_html__( "This is an option for title heading tag", "seoaal" ),
						"param_name"	=> "title_head",
						"value"			=> array(
							esc_html__( "H1", "seoaal" )=> "h1",
							esc_html__( "H2", "seoaal" )=> "h2",
							esc_html__( "H3", "seoaal" )=> "h3",
							esc_html__( "H4", "seoaal" )=> "h4",
							esc_html__( "H5", "seoaal" )=> "h5",
							esc_html__( "H6", "seoaal" )=> "h6"
						),
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title", "seoaal" ),
						"description"	=> esc_html__( "Enter section title here.", "seoaal" ),
						"param_name"	=> "title",
						"value" 		=> "",
						'admin_label'	=> true,
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title Prefix", "seoaal" ),
						"description"	=> esc_html__( "Enter section title prefix. If no need title prefix, then leave this box blank.", "seoaal" ),
						"param_name"	=> "title_prefix",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title Suffix", "seoaal" ),
						"description"	=> esc_html__( "Enter section title suffix. If no need title suffix, then leave this box blank.", "seoaal" ),
						"param_name"	=> "title_suffix",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Background Title", "seoaal" ),
						"description"	=> esc_html__( "Enter section title background title.", "seoaal" ),
						"param_name"	=> "background_title",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "google_fonts",
						"heading"		=> esc_html__( "Choose Background Title Font Name and Style", "seoaal" ),
						"description"	=> esc_html__( "Choose background title section title font from google.", "seoaal" ),
						"param_name"	=> "google_fonts",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Background Title Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can set the section background title color.", "seoaal" ),
						"param_name"	=> "background_title_color",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for section title text align.", "seoaal" ),
						"param_name"	=> "text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can set the section title color.", "seoaal" ),
						"param_name"	=> "title_color",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Prefix Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can set the section prefix title color.", "seoaal" ),
						"param_name"	=> "title_prefix_color",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Suffix Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can set the section title suffix color.", "seoaal" ),
						"param_name"	=> "title_suffix_color",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Font Size", "seoaal" ),
						"description"	=> esc_html__( "Enter title font size. Example 30.", "seoaal" ),
						"param_name"	=> "font_size",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Line Height", "seoaal" ),
						"description"	=> esc_html__( "Enter title line height. Example 30.", "seoaal" ),
						"param_name"	=> "line_height",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Title Text Transform", "seoaal" ),
						"param_name" 	=> "title_trans",
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) => "none",
							esc_html__( "Capitalize", "seoaal" ) => "capitalize",
							esc_html__( "Upper Case", "seoaal" )=> "uppercase",
							esc_html__( "Lower Case", "seoaal" )=> "lowercase"
						),
						"group"			=> esc_html__( "Title", "seoaal" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title Margin", "seoaal" ),
						"description"	=> esc_html__( "Enter title margin here. Example 30px 20px 30px 20px.", "seoaal" ),
						"param_name"	=> "title_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Sub Title", "seoaal" ),
						"description"	=> esc_html__( "Enter section title here. If no need sub title, then leave this box blank.", "seoaal" ),
						"param_name"	=> "sub_title",
						"value" 		=> "",
						"group"			=> esc_html__( "Sub Title", "seoaal" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Sub Title Position", "seoaal" ),
						"param_name" 	=> "sub_title_pos",
						"value" 		=> array(
							esc_html__( "Bottom", "seoaal" ) => "bottom",
							esc_html__( "Top", "seoaal" )=> "top"
						),
						"group"			=> esc_html__( "Sub Title", "seoaal" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Sub Title Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can set the section sub title color.", "seoaal" ),
						"param_name"	=> "sub_title_color",
						"group"			=> esc_html__( "Sub Title", "seoaal" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Separator Type", "seoaal" ),
						"param_name" 	=> "sep_type",
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) => "none",
							esc_html__( "Border", "seoaal" ) => "border",
							esc_html__( "Image", "seoaal" )=> "image"
						),
						"group"			=> esc_html__( "Separator", "seoaal" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Separator Border", "seoaal" ),
						"description"	=> esc_html__( "Here you can set the section title separator border color.", "seoaal" ),
						"param_name"	=> "sep_border_color",
						'dependency' => array(
							'element' => 'sep_type',
							'value' => 'border',
						),
						"group"			=> esc_html__( "Separator", "seoaal" )
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__( "Separator Image", "seoaal" ),
						"description" => esc_html__( "Choose section title separator image.", "seoaal" ),
						"param_name" => "sep_image",
						"value" => '',
						'dependency' => array(
							'element' => 'sep_type',
							'value' => 'image',
						),
						"group"			=> esc_html__( "Separator", "seoaal" ),
					),
					array(
						"type"			=> "textarea_html",
						"heading"		=> esc_html__( "Content", "seoaal" ),
						"description"	=> esc_html__( "Enter section title below content.", "seoaal" ),
						"param_name"	=> "content",
						"value" 		=> "",
						"group"			=> esc_html__( "Content", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Button Text", "seoaal" ),
						"description"	=> esc_html__( "Enter section button text here. If no need button, then leave this box blank.", "seoaal" ),
						"param_name"	=> "btn_text",
						"value" 		=> "",
						"group"			=> esc_html__( "Button", "seoaal" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Button URL", "seoaal" ),
						"description"	=> esc_html__( "Enter section button url here. If no need button url, then leave this box blank.", "seoaal" ),
						"param_name"	=> "btn_url",
						"value" 		=> "",
						"group"			=> esc_html__( "Button", "seoaal" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Type", "seoaal" ),
						"param_name" 	=> "btn_type",
						"value" 		=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Link", "seoaal" )		=> "link",
							esc_html__( "Classic", "seoaal" )	=> "classic",
							esc_html__( "Bordered", "seoaal" )	=> "bordered",
							esc_html__( "Inverse", "seoaal" )	=> "inverse"
						),
						"group"			=> esc_html__( "Button", "seoaal" ),
					),
					array(
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Items Spacing", "seoaal" ),
						"description"	=> esc_html__( "Enter custom bottom space for each item on main wrapper. Your space values will apply like nth child method. If you leave this empty, default theme space apply for each child. If you want default value for any child, just type \"default\". It will take default value for that child. Example 10px 12px 8px", "seoaal" ),
						"param_name"	=> "sc_spacing",
						"value" 		=> "",
						"group"			=> esc_html__( "Spacing", "seoaal" ),
					)
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_section_title_shortcode_map" );