<?php 
/**
 * Seoaal Testimonial
 */
if ( ! function_exists( "seoaal_vc_testimonial_shortcode" ) ) {
	function seoaal_vc_testimonial_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_testimonial", $atts );
		extract( $atts );
		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$tsti_lay = '1';
		if( isset( $testimonial_layout ) ){
			$class_names .= ' testimonial-' . $testimonial_layout;
			$tsti_lay = $testimonial_layout;
		}else{
			$class_names .= ' testimonial-1';
		}
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$class_names .= isset( $variation ) ? ' testimonial-' . $variation : '';
		$cols = isset( $testi_cols ) ? $testi_cols : 1;
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		
		$testi_pagi_items = isset( $testi_pagi_items ) ? seoaal_drag_and_drop_trim( $testi_pagi_items ) : array( 'Enabled' => array() );
		$pagi_position = isset( $testi_pagi_position ) ? $testi_pagi_position : 'bottom';
		$pagi_class_names = isset( $pagi_text_align ) && $pagi_text_align != 'default' ? ' text-' . $pagi_text_align : '';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.testimonial-wrapper, .' . esc_attr( $rand_class ) . '.testimonial-wrapper.testimonial-dark .testimonial-inner { color: '. esc_attr( $font_color ) .'; }' : '';
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			if( $tsti_lay == '4' ){
				$space_class_name = '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-inner .media-body >';
			}else{
				$space_class_name = '.' . esc_attr( $rand_class ) . '.testimonial-wrapper .testimonial-inner >';
			}
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		$gal_atts = '';
		if( isset( $slide_opt ) && $slide_opt == 'on' ){
			$gal_atts = array(
				'data-loop="'. ( isset( $slide_item_loop ) && $slide_item_loop == 'on' && isset( $slide_dots_type ) && $slide_dots_type != 'content' ? 1 : 0 ) .'"',
				'data-margin="'. ( isset( $slide_margin ) && $slide_margin != '' && isset( $slide_dots_type ) && $slide_dots_type != 'content' ? absint( $slide_margin ) : 0 ) .'"',
				'data-center="'. ( isset( $slide_center ) && $slide_center == 'on' && isset( $slide_dots_type ) && $slide_dots_type != 'content' ? 1 : 0 ) .'"',
				'data-nav="'. ( isset( $slide_nav ) && $slide_nav == 'on' ? 1 : 0 ) .'"',
				'data-dots="'. ( isset( $slide_dots ) && $slide_dots == 'on' && isset( $slide_dots_type ) && $slide_dots_type != 'content' ? 1 : 0 ) .'"',
				'data-autoplay="'. ( isset( $slide_item_autoplay ) && $slide_item_autoplay == 'on' ? 1 : 0 ) .'"',
				'data-items="'. ( isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 1 ) .'"',
				'data-items-tab="'. ( isset( $slide_item_tab ) && $slide_item_tab != '' ? absint( $slide_item_tab ) : 1 ) .'"',
				'data-items-mob="'. ( isset( $slide_item_mobile ) && $slide_item_mobile != '' ? absint( $slide_item_mobile ) : 1 ) .'"',
				'data-duration="'. ( isset( $slide_duration ) && $slide_duration != '' ? absint( $slide_duration ) : 5000 ) .'"',
				'data-smartspeed="'. ( isset( $slide_smart_speed ) && $slide_smart_speed != '' ? absint( $slide_smart_speed ) : 250 ) .'"',
				'data-scrollby="'. ( isset( $slide_slideby ) && $slide_slideby != '' ? absint( $slide_slideby ) : 1 ) .'"',
				'data-autoheight="false"',
			);
			$data_atts = implode( " ", $gal_atts );
		}
		
		$pagination_atts = $thumb_data_atts = '';
		if( isset( $slide_opt ) && $slide_opt == 'on' ){
			$pagination_atts = array(
				'data-loop="false"',
				'data-margin="10"',
				'data-center="false"',
				'data-nav="false"',
				'data-dots="false"',
				'data-autoplay="false"',
				'data-items="'. ( isset( $slide_pagi_item ) && $slide_pagi_item != '' ? absint( $slide_pagi_item ) : 3 ) .'"',
				'data-items-tab="2"',
				'data-items-mob="1"',
				'data-duration=""',
				'data-smartspeed="'. ( isset( $slide_smart_speed ) && $slide_smart_speed != '' ? absint( $slide_smart_speed ) : 250 ) .'"',
				'data-scrollby=""',
				'data-autoheight="false"',
			);
			$thumb_data_atts = implode( " ", $pagination_atts );
			wp_enqueue_script( 'owl-carousel' );
			wp_enqueue_style( 'owl-carousel' );
		}
		
		$args = array(
			'post_type' => 'seoaal-testimonial',
			'posts_per_page' => absint( $post_per_page ),
			'ignore_sticky_posts' => 1
		);
		
		$page_slide_out = '';
		$pagi_opt = isset( $slide_opt ) && $slide_opt == 'on' && isset( $slide_dots_type ) && $slide_dots_type == 'content' ? true : false;
		
		$elemetns = isset( $testimonial_items ) ? seoaal_drag_and_drop_trim( $testimonial_items ) : array( 'Enabled' => '' );
		
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
		
			$testimoanil_array = array(
				'excerpt_length' => $excerpt_length,
				'more_text' => $more_text
			);
		
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
			
			$class_names .= $pagi_opt ? ' seoaal-pagination-slide-actived seoaal-pagi-slide-'. $pagi_position : '';
			
			$output .= '<div class="testimonial-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				$output .= '<div class="row">';
				
					$main_out = '';
				
					//Testimonial Slide
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $main_out .= '<div class="seoaal-page-carousel owl-carousel" '. ( $data_atts ) .'>';	
					
					// Start the Loop
					while ( $query->have_posts() ) : $query->the_post();
					
						//Testimonial Slide Item
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $main_out .= '<div class="item">';	
					
					
						$col_class = "col-lg-". absint( $cols );
						$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
						$main_out .= '<div class="'. esc_attr( $col_class ) .'">';
							$main_out .= '<div class="testimonial-inner rounded">';
							
							$post_id = get_the_ID();
							$testimoanil_array['post_id'] = $post_id;
							
							if ( $tsti_lay == '4' ){
								$main_out .= '<div class="media">';
									$main_out .= '<div class="testimonial-thumb">';
										$main_out .= get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'img-fluid' ) );
									$main_out .= '</div><!-- .testimonial-thumb -->';
									$main_out .= '<div class="media-body">';
										if( isset( $elemetns['Enabled'] ) ) :
											foreach( $elemetns['Enabled'] as $element => $value ){
												$main_out .= seoaal_testimonial_shortcode_elements( $element, $testimoanil_array );
											}
										endif;
									$main_out .= '</div><!-- .media-body -->';
								$main_out .= '</div><!-- .media -->';
							}elseif ( $tsti_lay != '1' ){
								$list_stat = false;
								$testimoanil_array['list_stat'] = $list_stat;
								$elemetns = isset( $testimonial_items ) ? seoaal_drag_and_drop_trim( $testimonial_items ) : array( 'Enabled' => '' );
								if( isset( $elemetns['Enabled'] ) ) :
									foreach( $elemetns['Enabled'] as $element => $value ){
										$main_out .= seoaal_testimonial_shortcode_elements( $element, $testimoanil_array );
									}
								endif;
								
							}else{ //Layout != 1
								$main_out .= '<div class="testimonial-abs-part">';
								
									$name = get_post_meta( $post_id, 'seoaal_testimonial_name', true );
									$designation = get_post_meta( $post_id, 'seoaal_testimonial_designation', true );
								
									$main_out .= '<div class="testimonial-thumb">';
										$main_out .= get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'img-fluid rounded-circle' ) );
									$main_out .= '</div><!-- .testimonial-thumb -->';
									
								$main_out .= '</div><!-- .testimonial-abs-part -->';
								$main_out .= '<div class="testimonial-info-wrap">';
								
									$excerpt = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 20;
									$main_out .= '<div class="testimonial-excerpt">';
										add_filter( 'excerpt_length', __return_value( $excerpt ) );
										ob_start();
										the_excerpt();
										$excerpt_cont = ob_get_clean();
										$main_out .= $excerpt_cont;
									$main_out .= '</div><!-- .testimonial-excerpt -->';	
									
									$main_out .= '<div class="testimonial-title">';
										$main_out .= '<h5><a href="'. esc_url( get_the_permalink() ) .'" class="client-say">'. esc_html( get_the_title() ) .'</a></h5>';
									$main_out .= '</div><!-- .testimonial-title -->';	
													
									$main_out .= '<div class="testimonial-designation">';
										$main_out .= '<p>'. esc_html( $designation ) .'</p>';
									$main_out .= '</div><!-- .testimonial-designation -->';	
									
								$main_out .= '</div><!-- .testimonial-info-wrap -->';
							}
							
							$main_out .= '</div><!-- .testimonial-inner -->';
						$main_out .= '</div><!-- .cols -->';
						
						//Testimonial Slide Item End
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $main_out .= '</div><!-- .item -->';	
						
						if( $pagi_opt ){
							$page_slide_out .= '<div class="seoaal-pagi-item'. esc_attr( $pagi_class_names ) .'">';
								if( isset( $testi_pagi_items['Enabled'] ) ) :
									foreach( $testi_pagi_items['Enabled'] as $element => $value ){
										$testimoanil_array['list_stat'] = false;
										$page_slide_out .= seoaal_testimonial_shortcode_elements( $element, $testimoanil_array );
										$testimoanil_array['list_stat'] = true;
									}
								endif;
							$page_slide_out .= '</div><!-- .seoaal-pagi-item -->';
						}
						
					endwhile;
					
					//Testimonial Slide End
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $main_out .= '</div><!-- .owl-carousel -->';
					
					//Testimonial Pagination Slide
					if( $pagi_opt && $pagi_position == 'top' ){
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="seoaal-pagination-carousel seoaal-pagination-'. esc_attr( $pagi_position ) .' owl-carousel" '. ( $thumb_data_atts ) .'>';	
							$output .= $page_slide_out;	
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .seoaal-pagination-carousel -->';
					}
					
					$output .= $main_out;	
					
					//Testimonial Pagination Slide
					if( $pagi_opt && $pagi_position == 'bottom' ){
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="seoaal-pagination-carousel seoaal-pagination-'. esc_attr( $pagi_position ) .' owl-carousel" '. ( $thumb_data_atts ) .'>';	
							$output .= $page_slide_out;	
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .seoaal-pagination-carousel -->';
					}
					
				$output .= '</div><!-- .row -->';

			$output .= '</div><!-- .testimonial-wrapper -->';
			
		}// query exists
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();
		
		return $output;
	}
}
function seoaal_testimonial_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "title":
			$output .= '<div class="testimonial-title">';
				$output .= '<h5><a href="'. esc_url( get_the_permalink() ) .'" class="client-say">'. esc_html( get_the_title() ) .'</a></h5>';
			$output .= '</div><!-- .testimonial-title -->';		
		break;
		
		case "name":
			$output .= '<div class="testimonial-name">';
				$name = get_post_meta( $opts['post_id'], 'seoaal_testimonial_name', true );
				$output .= '<h6>'. esc_html( $name ) .'</h6>';
			$output .= '</div><!-- .testimonial-name -->';		
		break;
		
		case "designation":
			$designation = get_post_meta( $opts['post_id'], 'seoaal_testimonial_designation', true );
			if( $designation ) :
				
				$output .= '<div class="testimonial-designation">';
					$output .= '<p>'. esc_html( $designation ) .'</p>';
				$output .= '</div><!-- .testimonial-designation -->';		
			endif;
		break;
		
		case "info":
			$output .= '<div class="testimonial-info">';
				$output .= '<p>';
					$output .= '<a href="'. esc_url( get_the_permalink() ) .'" class="client-name">'. esc_html( get_the_title() ) .'</a>';
					
					$designation = get_post_meta( $opts['post_id'], 'seoaal_testimonial_designation', true );
					if( $designation ) :
						$output .= '<span class="client-designation">'. esc_html( $designation ) .'</span>';
					endif;
					
					$company_url = get_post_meta( $opts['post_id'], 'seoaal_testimonial_company_url', true );
					if( $company_url ) :
						$output .= '<a href="'. esc_url( $company_url ) .'" class="company-url">'. esc_url( $company_url ) .'</a>';
					endif;
				$output .= '</p>';
			$output .= '</div><!-- .testimonial-info -->';		
		break;
		
		case "thumb":
			if( isset( $opts['list_stat'] ) && !$opts['list_stat'] ){
				if ( has_post_thumbnail() ) {
					$output .= '<div class="testimonial-thumb">';
						
						$thumb_size = 'thumbnail';
						
						$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
						if( $lazy_opt ){
							$img_prop = seoaal_custom_image_size_chk( $thumb_size, '' );
							$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
							if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
								$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, '', true, absint( $lazy_img['id'] ) );
								$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid rounded-circle lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_prop[0] ) . '" />';
							}else{
								$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid rounded-circle lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_prop[0] ) . '" />';
							}
						}else{
							$output .= get_the_post_thumbnail( $opts['post_id'], 'thumbnail', array( 'class' => 'img-fluid rounded-circle' ) );
						}
					
						
					$output .= '</div><!-- .testimonial-thumb -->';
				}
			}
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
		
		case "rate":
			$rate = get_post_meta( $opts['post_id'], 'seoaal_testimonial_rating', true );
			if( $rate ) :
				$output .= '<div class="testimonial-rating">';
					$output .= '<p>'. seoaal_star_rating( $rate ) .'</p>';
				$output .= '</div><!-- .testimonial-rating -->';	
			endif;	
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'seoaal' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
	}
	return $output; 
}
if ( ! function_exists( "seoaal_vc_testimonial_shortcode_map" ) ) {
	function seoaal_vc_testimonial_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Testimonial", "seoaal" ),
				"description"			=> esc_html__( "Testimonial custom post type.", "seoaal" ),
				"base"					=> "seoaal_vc_testimonial",
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
						"value" 		=> "",
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
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Testimonial Layout", "seoaal" ),
						"description"	=> esc_html__( "If you want dynamic layout, choose 2nd or 3rd layout option.", "seoaal" ),
						"param_name"	=> "testimonial_layout",
						"value"			=> array(
							esc_html__( "1 Layout", "seoaal" )		=> "1",
							esc_html__( "2nd Layout", "seoaal" )	=> "2",
							esc_html__( "3rd Layout", "seoaal" )	=> "3",
							esc_html__( "List Layout", "seoaal" )	=> "4"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Testimonial Variation", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial variatoin either dark or light.", "seoaal" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "seoaal" )	=> "light",
							esc_html__( "Dark", "seoaal" )		=> "dark",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Testimonial Columns", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial columns.", "seoaal" ),
						"param_name"	=> "testi_cols",
						"value"			=> array(
							esc_html__( "1 Column", "seoaal" )	=> "12",
							esc_html__( "2 Columns", "seoaal" )	=> "6",
							esc_html__( "3 Columns", "seoaal" )	=> "4",
							esc_html__( "4 Columns", "seoaal" )	=> "3",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Drag and Drop', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for testimonial custom layout. here you can set your own layout. Drag and drop needed testimonial items to Enabled part.", "seoaal" ),
						'param_name'	=> 'testimonial_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'name'	=> esc_html__( 'Name', 'seoaal' ),
								'designation'	=> esc_html__( 'Designation', 'seoaal' ),
								'thumb'	=> esc_html__( 'Image', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'rate'	=> esc_html__( 'Star Rating', 'seoaal' ),
								'info'	=> esc_html__( 'Client Info', 'seoaal' ),
							),
							'disabled' => array(
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'more'	=> esc_html__( 'Read More', 'seoaal' )
							)
						),
						"dependency" => array(
							"element" => "testimonial_layout",
							"value"	=> array( "2", "3", "4" )
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial text align", "seoaal" ),
						"param_name"	=> "text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Option", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider option.", "seoaal" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slide items shown on large devices.", "seoaal" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slide items shown on tab.", "seoaal" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slide items shown on mobile.", "seoaal" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider auto play.", "seoaal" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider loop.", "seoaal" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider center, for this option must active loop and minimum items 2.", "seoaal" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider navigation.", "seoaal" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Pagination", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider pagination.", "seoaal" ),
						"param_name"	=> "slide_dots",
						"value"			=> array(
							esc_html__( "Off", "seoaal" )	=> "off",
							esc_html__( "On", "seoaal" )	=> "on"
						),
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Pagination Type", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slide pagination dots or content", "seoaal" ),
						"param_name"	=> "slide_dots_type",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Content", "seoaal" )	=> "content"
						),
						"group"			=> esc_html__( "Slide", "seoaal" ),
						"dependency" => array(
							"element" => "slide_dots",
							"value"	=> array( "on" )
						),
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Testimonial Pagination Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for testimonial pagenation slide item custom layout. here you can set your own layout. Drag and drop needed testimonial items to Enabled part.", "seoaal" ),
						'param_name'	=> 'testi_pagi_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'thumb'	=> esc_html__( 'Image', 'seoaal' ),
								'name'	=> esc_html__( 'Name', 'seoaal' )
							),
							'disabled' => array(
								'designation'	=> esc_html__( 'Designation', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'rate'	=> esc_html__( 'Star Rating', 'seoaal' ),
								'info'	=> esc_html__( 'Client Info', 'seoaal' ),
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'more'	=> esc_html__( 'Read More', 'seoaal' )
							)
						),
						"dependency" => array(
							"element" => "slide_dots_type",
							"value"	=> array( "content" )
						),
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Testimonial Pagination Slide Position", "seoaal" ),
						"description"	=> esc_html__( "This is an option for set testimonial pagination slide position.", "seoaal" ),
						"param_name"	=> "testi_pagi_position",
						"value"			=> array(
							esc_html__( "Top", "seoaal" )		=> "top",
							esc_html__( "Bottom", "seoaal" )	=> "bottom"
						),
						"dependency" => array(
							"element" => "slide_dots_type",
							"value"	=> array( "content" )
						),
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Pagination Slide Items", "seoaal" ),
						"description"	=> esc_html__( "This is an option for testimonial pagination slide items shown on devices.", "seoaal" ),
						"param_name"	=> "slide_pagi_item",
						"value" 		=> "3",
						"dependency" => array(
							"element" => "slide_dots_type",
							"value"	=> array( "content" )
						),
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Pagination Slide Items Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial pagination slide items text align.", "seoaal" ),
						"param_name"	=> "pagi_text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider margin space.", "seoaal" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider duration.", "seoaal" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider smart speed.", "seoaal" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "seoaal" ),
						"description"	=> esc_html__( "This is option for testimonial slider scroll by.", "seoaal" ),
						"param_name"	=> "slide_slideby",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "seoaal" )
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
add_action( "vc_before_init", "seoaal_vc_testimonial_shortcode_map" );