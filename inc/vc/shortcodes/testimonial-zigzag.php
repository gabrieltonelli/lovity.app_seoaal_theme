<?php 
/**
 * Seoaal Testimonial Zigzag
 */
if ( ! function_exists( "seoaal_vc_testimonialzz_zigzag_shortcode" ) ) {
	function seoaal_vc_testimonialzz_zigzag_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_testimonialzz_zigzag", $atts );
		extract( $atts );
		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		$alter_align = isset( $alter_align ) && $alter_align == 'on' ? true : false;
		$alter_zigzag = isset( $alter_zigzag ) && $alter_zigzag == 'on' ? 1 : 0;
		
		$testimonialzz_overlay_opt = isset( $testimonialzz_overlay_opt ) && $testimonialzz_overlay_opt == 'enable' ? true : false;

		$overlay_class = '';
		$overlay_class .= isset( $testimonialzz_overlay_position ) ? ' overlay-'.$testimonialzz_overlay_position : ' overlay-center';
		
		$thumb_size = isset( $image_size ) ? $image_size : '';
		$cus_thumb_size = '';
		$thumb_hard_crop = '';
		if( $thumb_size == 'custom' ){
			$cus_thumb_size = isset( $custom_image_size ) && $custom_image_size != '' ? $custom_image_size : '';
			$thumb_hard_crop = isset( $hard_crop ) && $hard_crop == 'on' ? true : false;
		}
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.testimonial-wrapper, .' . esc_attr( $rand_class ) . '.testimonial-wrapper.testimonial-dark .testimonial-inner { color: '. esc_attr( $font_color ) .'; }' : '';
		
		//Overlay Styles
		$overlay_class .= isset( $overlay_text_align ) && $overlay_text_align != 'default' ? ' text-' . $overlay_text_align : '';
		
		
		$shortcode_css .= isset( $testimonialzz_overlay_font_color ) && $testimonialzz_overlay_font_color != '' ? '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-overlay { color : '. esc_attr( $testimonialzz_overlay_font_color ) .' ; }' : '';
		$rgba_from = isset( $testimonialzz_overlay_custom_color_1 ) && $testimonialzz_overlay_custom_color_1 != '' ? $testimonialzz_overlay_custom_color_1 : '';
		$rgba_to = isset( $testimonialzz_overlay_custom_color_2 ) && $testimonialzz_overlay_custom_color_2 != '' ? $testimonialzz_overlay_custom_color_2 : '';
		$shortcode_css .= $rgba_from != '' && $rgba_to != '' ? '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-thumb .overlay-custom { background : linear-gradient(to bottom, '. esc_attr( $rgba_from ) .' 0%, '. esc_attr( $rgba_to ) .' 75%); background : -webkit-linear-gradient(to bottom, '. esc_attr( $rgba_from ) .' 0%, '. esc_attr( $rgba_to ) .' 75%); background : -moz-linear-gradient(to bottom, '. esc_attr( $rgba_from ) .' 0%, '. esc_attr( $rgba_to ) .' 75%); }' : '';
		
		$overlay_link = isset( $testimonialzz_overlay_link_colors ) ? $testimonialzz_overlay_link_colors : '';
		if( $overlay_link ){
			$overlay_link = preg_replace('/\s+/', '', $overlay_link);
			$overlay_link_arr = explode(",",$overlay_link);
			if( isset( $overlay_link_arr[0] ) && $overlay_link_arr[0] != '' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-overlay a { color: '. esc_attr( $overlay_link_arr[0] ) .'; }';
			}
			if( isset( $overlay_link_arr[1] ) && $overlay_link_arr[1] != '' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-overlay a:hover { color: '. esc_attr( $overlay_link_arr[1] ) .'; }';
			}
		}
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '';
			$space_class_name = '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-right-wrap >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		$args = array(
			'post_type' => 'seoaal-testimonial',
			'posts_per_page' => absint( $post_per_page ),
			'ignore_sticky_posts' => 1
		);
		
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
		
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
			
			$output .= '<div class="testimonial-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				$inner_class = $testimonialzz_overlay_opt ? ' testimonial-overlay-actived' : '';
				$output .= '<div class="testimonial-inner'. esc_attr( $inner_class ) .'">';
					
					$testimonialzz_array = array(
						'thumb_size' => $thumb_size,
						'cus_thumb_size' => $cus_thumb_size,
						'thumb_hard_crop' => $thumb_hard_crop,
						'excerpt_length' => $excerpt_length,
						'more_text' => $more_text,
					);
					
					$zz = 1;
					
					// Start the Loop
					while ( $query->have_posts() ) : $query->the_post();
						
						// Parameters Defined
						$post_id = get_the_ID();
						$testimonialzz_array['post_id'] = $post_id;
						
						//Overlay Output Formation
						$overlay_out = '';
						if( $testimonialzz_overlay_opt ) {
							if( isset( $testimonialzz_overlay_type ) && $testimonialzz_overlay_type != 'none' ){
								$overlay_out .= '<span class="overlay-bg overlay-'. esc_attr( $testimonialzz_overlay_type ) .'"></span>';
							}
							$overlay_out .= '<div class="testimonial-overlay'. esc_attr( $overlay_class ) .'">';
								
								$overlay_elemetns = isset( $overlay_testimonialzz_items ) ? seoaal_drag_and_drop_trim( $overlay_testimonialzz_items ) : array( 'Enabled' => array() );
								if( isset( $overlay_elemetns['Enabled'] ) ) :
									foreach( $overlay_elemetns['Enabled'] as $element => $value ){
										$overlay_out .= seoaal_testimonialzz_shortcode_elements( $element, $testimonialzz_array );
									}
								endif;
								
							$overlay_out .= '</div><!-- .testimonial-overlay -->';
						}
						$output .= '<div class="testimonial-zig-zag row">';
							
							$left_col_zz = $right_col_zz = '';
							if( $zz%2 == $alter_zigzag ){
								$left_col_zz = ' push-md-6';
								$right_col_zz = ' pull-md-6';
								$right_col_zz .= $alter_align ? ' text-right' : '';
							}else{
								$left_col_zz .= $alter_align ? ' text-right' : '';
							}
							
							$output .= '<div class="testimonial-left-wrap align-self-center col-md-6'. esc_attr( $left_col_zz ) .'">';
								$testimonialzz_array['overlay'] = $overlay_out;
								$output .= seoaal_testimonialzz_shortcode_elements( 'thumb', $testimonialzz_array );
							$output .= '</div><!-- .testimonial-left-wrap -->';
							
							$output .= '<div class="testimonial-right-wrap align-self-center col-md-6'. esc_attr( $right_col_zz ) .'">';
								$elemetns = isset( $testimonialzz_items ) ? seoaal_drag_and_drop_trim( $testimonialzz_items ) : array( 'Enabled' => '' );
								if( isset( $elemetns['Enabled'] ) ) :
									foreach( $elemetns['Enabled'] as $element => $value ){
										$output .= seoaal_testimonialzz_shortcode_elements( $element, $testimonialzz_array );
									}
									
								endif;
							$output .= '</div><!-- .testimonial-right-wrap -->';
							
							$zz++;
							
						$output .= '</div><!-- .testimonial-zig-zag -->';
						
					endwhile;					
				$output .= '</div><!-- .testimonial-inner -->';
			$output .= '</div><!-- .testimonial-wrapper -->';
			
		}// query exists
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();
		
		return $output;
	}
}
function seoaal_testimonialzz_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "title":
			$output .= '<div class="testimonial-name">';
				$output .= '<h6>'. get_the_title() .'</h6>';
			$output .= '</div><!-- .testimonial-name -->';
		break;
		
		case "author":
			$author = get_post_meta( $opts['post_id'], 'seoaal_testimonial_name', true );
			$output .= $author ? '<div class="testimonial-author">'. esc_html( $author ) .'</div><!-- .testimonial-name -->' : '';
		break;
		
		case "designation":
			$designation = get_post_meta( $opts['post_id'], 'seoaal_testimonial_designation', true );
			$output .= $designation ? '<div class="testimonial-designation">'. esc_html( $designation ) .'</div><!-- .testimonial-designation -->' : '';
		break;
		
		case "company":
			$company_name = get_post_meta( $opts['post_id'], 'seoaal_testimonial_company_name', true );
			$company_url = get_post_meta( $opts['post_id'], 'seoaal_testimonial_company_url', true );
			$output .= $company_name ? '<div class="testimonial-company"><a href="'. esc_url( $company_url ) .'">'. esc_html( $company_name ) .'</a></div><!-- .testimonial-company -->' : '';
		break;
		
		case "rating":
			$rating = get_post_meta( $opts['post_id'], 'seoaal_testimonial_rating', true );
			$output .= $rating ? '<div class="testimonial-rating">'. seoaal_star_rating( $rating ) .'</div><!-- .testimonial-rating -->' : '';
		break;

		case "thumb":
			// Custom Thumb Code
			$thumb_size = $thumb_cond = $opts['thumb_size'];
			$cus_thumb_size = $opts['cus_thumb_size'];
			$hard_crop = $opts['thumb_hard_crop'];
			$custom_opt = $img_prop = '';
			if( $thumb_cond == 'custom' ){
				$custom_opt = $cus_thumb_size != '' ? explode( "x", $cus_thumb_size ) : array();
				$img_prop = seoaal_custom_image_size_chk( $thumb_size, $custom_opt, $hard_crop );
				$thumb_size = array( $img_prop[1], $img_prop[2] );
			} 
			// Custom Thumb Code End
			
			$output .= '<div class="testimonial-thumb">';
				$output .= isset( $opts['overlay'] ) ? $opts['overlay'] : '';
				
				$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
				if( $lazy_opt ){
					$img_prop = $img_prop ? $img_prop : seoaal_custom_image_size_chk( $thumb_size, $custom_opt );
					$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
					if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
						$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $custom_opt, true, absint( $lazy_img['id'] ) );
						$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_prop[0] ) . '" />';
					}else{
						$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_prop[0] ) . '" />';
					}
				}else{
					if( $thumb_cond == 'custom' ){
						$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid"  alt="'. the_title_attribute(array('echo' => false)) .'" src="' . esc_url( $img_prop[0] ) . '"/>';
					}else{
						$output .= get_the_post_thumbnail( $opts['post_id'], $thumb_size, array( 'class' => 'img-fluid' ) );
					}
				}
				
			$output .= '</div><!-- .testimonial-thumb -->';
		break;
		
		case "excerpt":
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="testimonial-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .testimonial-excerpt -->';	
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'seoaal' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
	}
	return $output; 
}
if ( ! function_exists( "seoaal_vc_testimonialzz_zigzag_shortcode_map" ) ) {
	function seoaal_vc_testimonialzz_zigzag_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Testimonial Zig Zag", "seoaal" ),
				"description"			=> esc_html__( "Testimonial custom post type.", "seoaal" ),
				"base"					=> "seoaal_vc_testimonialzz_zigzag",
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
						"heading"		=> esc_html__( "Post Per Page", "seoaal" ),
						"description"	=> esc_html__( "Here you can define post limits per page. Example 10", "seoaal" ),
						"param_name"	=> "post_per_page",
						"value" 		=> "2",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Excerpt Length", "seoaal" ),
						"param_name"	=> "excerpt_length",
						"value" 		=> "15"
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Read More Text", "seoaal" ),
						"description"	=> esc_html__( "Here you can enter read more text instead of default text.", "seoaal" ),
						"param_name"	=> "more_text",
						"value" 		=> esc_html__( "Read More", "seoaal" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the font color.", "seoaal" ),
						"param_name"	=> "font_color",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Testimonial Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for testimonial custom layout. here you can set your own layout. Drag and drop needed testimonial items to Enabled part.", "seoaal" ),
						'param_name'	=> 'testimonialzz_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'author'	=> esc_html__( 'Author', 'seoaal' ),
								'designation'	=> esc_html__( 'Designation', 'seoaal' )
							),
							'disabled' => array(
								'more'	=> esc_html__( 'Read More', 'seoaal' ),
								'company'	=> esc_html__( 'Company', 'seoaal' ),
								'rating'	=> esc_html__( 'Rating', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Alternate Text Align", "seoaal" ),
						"description"	=> esc_html__( "Switch on/off for alternate text align.", "seoaal" ),
						"param_name"	=> "alter_align",
						"value"			=> "on",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Alternate Zig Zag", "seoaal" ),
						"description"	=> esc_html__( "Switch on/off for alternate zig zag layout. If enable this zig zag layout starts from right.", "seoaal" ),
						"param_name"	=> "alter_zigzag",
						"value"			=> "off",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Testimonial Option", "seoaal" ),
						"description"	=> esc_html__( "This is an option for enable overlay testimonial option.", "seoaal" ),
						"param_name"	=> "testimonialzz_overlay_opt",
						"value"			=> array(
							esc_html__( "Disable", "seoaal" )	=> "disable",
							esc_html__( "Enable", "seoaal" )	=> "enable"
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put testimonial overlay font color.", "seoaal" ),
						"param_name"	=> "testimonialzz_overlay_font_color",
						'dependency' => array(
							'element' => 'testimonialzz_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Overlay Link Colors", "seoaal" ),
						"description"	=> esc_html__( "Here you can put testimonial overlay link normal, hover colors. Example #ffffff, #cccccc", "seoaal" ),
						"param_name"	=> "testimonialzz_overlay_link_colors",
						'dependency' => array(
							'element' => 'testimonialzz_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Overlay Testimonial Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for testimonial items(name, excerpt etc..) overlay on thumbnail. Drag and drop needed testimonial items to Enabled part.", "seoaal" ),
						'param_name'	=> 'overlay_testimonialzz_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'seoaal' )
							),
							'disabled' => array(
								'author'	=> esc_html__( 'Author', 'seoaal' ),
								'designation'	=> esc_html__( 'Designation', 'seoaal' ),
								'more'	=> esc_html__( 'Read More', 'seoaal' ),
								'company'	=> esc_html__( 'Company', 'seoaal' ),
								'rating'	=> esc_html__( 'Rating', 'seoaal' )
							)
						),
						'dependency' => array(
							'element' => 'testimonialzz_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Items Position", "seoaal" ),
						"description"	=> esc_html__( "This is an option for overlay items position.", "seoaal" ),
						"param_name"	=> "testimonialzz_overlay_position",
						"value"			=> array(
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Top Left", "seoaal" )	=> "top-left",
							esc_html__( "Top Right", "seoaal" )	=> "top-right",
							esc_html__( "Bottom Left", "seoaal" )	=> "bottom-left",
							esc_html__( "Bottom Right", "seoaal" )	=> "bottom-right",
							
							esc_html__( "Bottom Center", "seoaal" )	=> "bottom-center",
						),
						'dependency' => array(
							'element' => 'testimonialzz_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for testimonial text align", "seoaal" ),
						"param_name"	=> "overlay_text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						'dependency' => array(
							'element' => 'testimonialzz_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Type", "seoaal" ),
						"description"	=> esc_html__( "This is an option for testimonial overlay type.", "seoaal" ),
						"param_name"	=> "testimonialzz_overlay_type",
						"value"			=> array(
							esc_html__( "None", "seoaal" ) => "none",
							esc_html__( "Overlay Dark", "seoaal" ) => "dark",
							esc_html__( "Overlay White", "seoaal" ) => "light",
							esc_html__( "Custom Color", "seoaal" ) => "custom"
						),
						'dependency' => array(
							'element' => 'testimonialzz_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Custom Gradient From", "seoaal" ),
						"description"	=> esc_html__( "Here you can put testimonial overlay custom gradient from color.", "seoaal" ),
						"param_name"	=> "testimonialzz_overlay_custom_color_1",
						'dependency' => array(
							'element' => 'testimonialzz_overlay_type',
							'value' => 'custom',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Custom Gradient To", "seoaal" ),
						"description"	=> esc_html__( "Here you can put testimonial overlay custom gradient to color.", "seoaal" ),
						"param_name"	=> "testimonialzz_overlay_custom_color_2",
						'dependency' => array(
							'element' => 'testimonialzz_overlay_type',
							'value' => 'custom',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Image Size", "seoaal" ),
						"param_name"	=> "image_size",
						'description'	=> esc_html__( 'Choose thumbnail size for display different size image.', 'seoaal' ),
						"value"			=> array(
							esc_html__( "Grid Large", "seoaal" )=> "seoaal-grid-large",
							esc_html__( "Grid Medium", "seoaal" )=> "seoaal-grid-medium",
							esc_html__( "Grid Small", "seoaal" )=> "seoaal-grid-small",
							esc_html__( "Medium", "seoaal" )=> "medium",
							esc_html__( "Large", "seoaal" )=> "large",
							esc_html__( "Thumbnail", "seoaal" )=> "thumbnail",
							esc_html__( "Custom", "seoaal" )=> "custom",
						),
						'std'			=> 'newsz_grid_2',
						'group'			=> esc_html__( 'Image', 'seoaal' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Custom Image Size', "seoaal" ),
						'param_name'	=> 'custom_image_size',
						'description'	=> esc_html__( 'Enter custom image size. eg: 200x200', 'seoaal' ),
						'value' 		=> '',
						"dependency"	=> array(
								"element"	=> "image_size",
								"value"		=> "custom"
						),
						'group'			=> esc_html__( 'Image', 'seoaal' )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Image Hard Crop", "seoaal" ),
						"description"	=> esc_html__( "This option only applicable only when image size choose custom.", "seoaal" ),
						"param_name"	=> "hard_crop",
						"value"			=> "off",
						"dependency" => array(
							"element" => "image_size",
							"value"	=> "custom"
						),
						"group"			=> esc_html__( "Image", "seoaal" )
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
add_action( "vc_before_init", "seoaal_vc_testimonialzz_zigzag_shortcode_map" );