<?php 
/**
 * Seoaal Team
 */
if ( ! function_exists( "seoaal_vc_team_shortcode" ) ) {
	function seoaal_vc_team_shortcode( $atts, $content = NULL ) {
		 
		$atts = vc_map_get_attributes( "seoaal_vc_team", $atts );
		extract( $atts );
		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$class_names .= isset( $team_layout ) ? ' team-' . $team_layout : ' team-1';
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$class_names .= isset( $variation ) ? ' team-' . $variation : '';
		$cols = isset( $team_cols ) ? $team_cols : 12;
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		
		$team_model = isset( $team_model ) && $team_model != '' ? 'team-'.$team_model : 'team-grid'; 
		
		$sclass_name = isset( $social_style ) && !empty( $social_style ) ? ' social-' . $social_style : '';
		$sclass_name .= isset( $social_color ) && !empty( $social_color ) ? ' social-' . $social_color : '';
		$sclass_name .= isset( $social_hcolor ) && !empty( $social_hcolor ) ? ' social-' . $social_hcolor : '';
		$sclass_name .= isset( $social_bg ) && !empty( $social_bg ) ? ' social-' . $social_bg : '';
		$sclass_name .= isset( $social_hbg ) && !empty( $social_hbg ) ? ' social-' . $social_hbg : '';
		
		$overlay_class = '';
		$overlay_class .= isset( $team_overlay_position ) ? ' overlay-'.$team_overlay_position : ' overlay-center';
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.team-wrapper, .' . esc_attr( $rand_class ) . '.team-wrapper.team-dark .team-inner { color: '. esc_attr( $font_color ) .'; }' : '';
		
		//Overlay Styles
		$overlay_class .= isset( $overlay_text_align ) && $overlay_text_align != 'default' ? ' text-' . $overlay_text_align : '';
		
		
		$shortcode_css .= isset( $team_overlay_font_color ) && $team_overlay_font_color != '' ? '.' . esc_attr( $rand_class ) . '.team-wrapper .team-overlay { color : '. esc_attr( $team_overlay_font_color ) .' ; }' : '';
		$rgba_from = isset( $team_overlay_custom_color_1 ) && $team_overlay_custom_color_1 != '' ? $team_overlay_custom_color_1 : '';
		$rgba_to = isset( $team_overlay_custom_color_2 ) && $team_overlay_custom_color_2 != '' ? $team_overlay_custom_color_2 : '';
		$shortcode_css .= $rgba_from != '' && $rgba_to != '' ? '.' . esc_attr( $rand_class ) . '.team-wrapper .team-thumb .overlay-custom,.team-1 .team-inner > .team-name-designation { background : linear-gradient(to bottom, '. esc_attr( $rgba_from ) .' 0%, '. esc_attr( $rgba_to ) .' 75%); background : -webkit-linear-gradient(to bottom, '. esc_attr( $rgba_from ) .' 0%, '. esc_attr( $rgba_to ) .' 75%); background : -moz-linear-gradient(to bottom, '. esc_attr( $rgba_from ) .' 0%, '. esc_attr( $rgba_to ) .' 75%); }' : '';
		
		$overlay_link = isset( $team_overlay_link_colors ) ? $team_overlay_link_colors : '';
		if( $overlay_link ){
			$overlay_link = preg_replace('/\s+/', '', $overlay_link);
			$overlay_link_arr = explode(",",$overlay_link);
			if( isset( $overlay_link_arr[0] ) && $overlay_link_arr[0] != '' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . '.team-wrapper .team-overlay a { color: '. esc_attr( $overlay_link_arr[0] ) .'; }';
			}
			if( isset( $overlay_link_arr[1] ) && $overlay_link_arr[1] != '' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . '.team-wrapper .team-overlay a:hover { color: '. esc_attr( $overlay_link_arr[1] ) .'; }';
			}
		}
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '';
			if( $team_model == 'team-list' ){
				$space_class_name = '.' . esc_attr( $rand_class ) . '.team-wrapper .team-inner .media-body >';
			}else{
				$space_class_name = '.' . esc_attr( $rand_class ) . '.team-wrapper .team-inner >';
			}
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		$gal_atts = '';
		if( isset( $slide_opt ) && $slide_opt == 'on' ){
			$slide_item = isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 1;
			$gal_atts = array(
				'data-loop="'. ( isset( $slide_item_loop ) && $slide_item_loop == 'on' ? 1 : 0 ) .'"',
				'data-margin="'. ( isset( $slide_margin ) && $slide_margin != '' ? absint( $slide_margin ) : 0 ) .'"',
				'data-center="'. ( isset( $slide_center ) && $slide_center == 'on' ? 1 : 0 ) .'"',
				'data-nav="'. ( isset( $slide_nav ) && $slide_nav == 'on' ? 1 : 0 ) .'"',
				'data-dots="'. ( isset( $slide_dots ) && $slide_dots == 'on' ? 1 : 0 ) .'"',
				'data-autoplay="'. ( isset( $slide_item_autoplay ) && $slide_item_autoplay == 'on' ? 1 : 0 ) .'"',
				'data-items="'. ( $slide_item ) .'"',
				'data-items-tab="'. ( isset( $slide_item_tab ) && $slide_item_tab != '' ? absint( $slide_item_tab ) : 1 ) .'"',
				'data-items-mob="'. ( isset( $slide_item_mobile ) && $slide_item_mobile != '' ? absint( $slide_item_mobile ) : 1 ) .'"',
				'data-duration="'. ( isset( $slide_duration ) && $slide_duration != '' ? absint( $slide_duration ) : 5000 ) .'"',
				'data-smartspeed="'. ( isset( $slide_smart_speed ) && $slide_smart_speed != '' ? absint( $slide_smart_speed ) : 250 ) .'"',
				'data-scrollby="'. ( isset( $slide_slideby ) && $slide_slideby != '' ? absint( $slide_slideby ) : 1 ) .'"',
				'data-autoheight="false"',
			);
			$data_atts = implode( " ", $gal_atts );
			wp_enqueue_script( 'owl-carousel' );
			wp_enqueue_style( 'owl-carousel' );
		}
		
		$args = array(
			'post_type' => 'seoaal-team',
			'posts_per_page' => absint( $post_per_page ),
			'ignore_sticky_posts' => 1
		);
		
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
		
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
			
			$output .= '<div class="team-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				$row_stat = 0;
				
					//Team Slide
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';	
					// Start the Loop
					while ( $query->have_posts() ) : $query->the_post();
						
						// Parameters Defined
						$post_id = get_the_ID();
						$team_array = array(
							'post_id' => $post_id,
							'excerpt_length' => $excerpt_length,
							'cols' => $cols,
							'more_text' => $more_text,
							'social_class' => $sclass_name,
							'list_stat' => true
						);
					
						//Overlay Output Formation
						$overlay_out = '';
						if( isset( $team_overlay_opt ) && $team_overlay_opt == 'enable' ) {
							if( isset( $team_overlay_type ) && $team_overlay_type != 'none' ){
								$overlay_out .= '<span class="overlay-bg overlay-'. esc_attr( $team_overlay_type ) .'"></span>';
							}
							$overlay_out .= '<div class="team-overlay'. esc_attr( $overlay_class ) .'">';
								
								$overlay_elemetns = isset( $overlay_team_items ) ? seoaal_drag_and_drop_trim( $overlay_team_items ) : array( 'Enabled' => '' );
								if( isset( $overlay_elemetns['Enabled'] ) ) :
									foreach( $overlay_elemetns['Enabled'] as $element => $value ){
										$overlay_out .= seoaal_team_shortcode_elements( $element, $team_array );
									}
								endif;
								
							$overlay_out .= '</div><!-- .team-overlay -->';
						}
					
						if( $row_stat == 0 && $slide_opt != 'on' ) :
							$output .= '<div class="row">';
						endif;
					
						//Team Slide Item
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="item">';	
						$col_class = "col-lg-". absint( $cols );
						
						if( $team_model == 'team-list' )
							$col_class .= " col-md-12";
						else
							$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
							
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $team_array['cols'] = 12 / $slide_item;
							
						$output .= '<div class="'. esc_attr( $col_class ) .'">';
							$inner_class = $overlay_out ? ' team-overlay-actived' : '';
							$output .= '<div class="team-inner'. esc_attr( $inner_class ) .'">';
							$elemetns = isset( $team_items ) ? seoaal_drag_and_drop_trim( $team_items ) : array( 'Enabled' => '' );
							if( isset( $elemetns['Enabled'] ) ) :
							
							
								if( $team_model == 'team-list' && array_key_exists( "thumb", $elemetns['Enabled'] ) ) {
									$output .= '<div class="media">';
										$output .= '<div class="team-left-wrap">';
										$team_array['list_stat'] = true;
										$output .= seoaal_team_shortcode_elements( 'thumb', $team_array );
										$team_array['list_stat'] = false;
										$output .= '</div><!-- .team-left-wrap -->';
										$output .= '<div class="media-body team-right-wrap">';
								}
								foreach( $elemetns['Enabled'] as $element => $value ){
									if( $element == 'thumb' ){
										$team_array['overlay'] = $overlay_out;
									}
									$output .= seoaal_team_shortcode_elements( $element, $team_array );
								}
								
								if( $team_model == 'team-list' && array_key_exists( "thumb", $elemetns['Enabled'] ) ) {
										$output .= '</div><!-- .media-body -->';
									$output .= '</div><!-- .media -->';							
								}
								
							endif;
							
							$output .= '</div><!-- .team-inner -->';
						$output .= '</div><!-- .cols -->';
						
						//Team Slide Item End
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .item -->';	
									
						$row_stat++;
						if( $row_stat == ( 12/ $cols ) && $slide_opt != 'on' ) :
							$output .= '</div><!-- .row -->';
							$row_stat = 0;
						endif;
						
					endwhile;
					
					if( $row_stat != 0 && $slide_opt != 'on' ){
						$output .= '</div><!-- .row -->'; // Unexpected row close
					}
					
					//Team Slide End
					if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .owl-carousel -->';
			$output .= '</div><!-- .team-wrapper -->';
			
		}// query exists
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();
		
		return $output;
	}
}
function seoaal_team_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "name":
			$output .= '<div class="team-name">';
				$output .= '<h6><a href="'. esc_url( get_the_permalink() ) .'" class="client-name">'. get_the_title() .'</a></h6>';
			$output .= '</div><!-- .team-name -->';		
		break;
		
		case "designation":
			$designation = get_post_meta( $opts['post_id'], 'seoaal_team_designation', true );
			if( $designation ) :
				
				$output .= '<div class="team-designation">';
					$output .= '<p>'. esc_html( $designation ) .'</p>';
				$output .= '</div><!-- .team-designation -->';		
			endif;
		break;
		
		case "email":
			$email = get_post_meta( $opts['post_id'], 'seoaal_team_email', true );
			if( $email ) :
				$output .= '<div class="team-email">';
					$output .= '<span>'. esc_html( "Email: ", "seoaal" ) .'</span><a href="mailto:'. esc_url( $email ) .'">'. esc_html( $email ) .'</a>';
				$output .= '</div><!-- .team-email -->';		
			endif;
		break;
		
		case "phone":
			$phone = get_post_meta( $opts['post_id'], 'seoaal_team_phone', true );
			if( $phone ) :
				$output .= '<div class="team-phone">';
					$output .= '<span>'. esc_html( "Phone: ", "seoaal" ) .'</span><a href="tel://'. esc_attr( trim( $phone ) ) .'">'. esc_html( $phone ) .'</a>';
				$output .= '</div><!-- .team-phone -->';		
			endif;
		break;
		
		case "namedes":
			$output .= '<div class="team-name-designation">';
				$output .= '<p><a href="'. esc_url( get_the_permalink() ) .'" class="client-name">'. get_the_title() .'</a></p>';
				$designation = get_post_meta( $opts['post_id'], 'seoaal_team_designation', true );
				if( $designation ) :
					$output .= '<p>'. esc_html( $designation ) .'</p>';
				endif;
			$output .= '</div><!-- .team-name-designation -->';		
		break;
		
		case "thumb":
			if ( has_post_thumbnail() && isset( $opts['list_stat'] ) && $opts['list_stat'] == true ) {
			
				$thumb_size = 'large';
				if( ( 12 / absint( $opts['cols'] ) ) >= 3 ){
					$thumb_size = 'seoaal-team-medium';
				}else{
					$thumb_size = 'large';
				}
				
				$output .= '<div class="team-thumb">';
					$output .= isset( $opts['overlay'] ) ? $opts['overlay'] : '';
					
					$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
					if( $lazy_opt ){
						$img_prop = seoaal_custom_image_size_chk( $thumb_size, '' );
						$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
						if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
							$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, '', true, absint( $lazy_img['id'] ) );
							$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid lazy-initiate" alt="'. the_title_attribute(array('echo' => false)) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_prop[0] ) . '" />';
						}else{
							$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid lazy-initiate" alt="'. the_title_attribute(array('echo' => false)) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_prop[0] ) . '" />';
						}
					}else{
						$output .= get_the_post_thumbnail( $opts['post_id'], $thumb_size, array( 'class' => 'img-fluid' ) );
					}
					
				$output .= '</div><!-- .team-thumb -->';
			}
		break;
		
		case "excerpt":
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="team-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .team-excerpt -->';	
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'seoaal' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
		case "social":
			$output .= '<div class="team-social-wrap clearfix">';
				$output .= '<ul class="nav social-icons team-social'. esc_attr( $opts['social_class'] ) .'">';
					$taget = get_post_meta( get_the_ID(), 'seoaal_team_link_target', true );
					$social_media = array( 
						'social-fb' => 'fa fa-facebook', 
						'social-twitter' => 'fa fa-twitter', 
						'social-instagram' => 'fa fa-instagram',
						'social-linkedin' => 'fa fa-linkedin', 
						'social-pinterest' => 'fa fa-pinterest-p', 						
						'social-youtube' => 'fa fa-youtube-play', 
						'social-vimeo' => 'fa fa-vimeo',
						'social-flickr' => 'fa fa-flickr', 
						'social-dribbble' => 'fa fa-dribbble'
					);
					$social_opt = array(
						'social-fb' => 'seoaal_team_facebook', 
						'social-twitter' => 'seoaal_team_twitter',
						'social-instagram' => 'seoaal_team_instagram',
						'social-linkedin' => 'seoaal_team_linkedin',
						'social-pinterest' => 'seoaal_team_pinterest',
						'social-youtube' => 'seoaal_team_youtube',
						'social-vimeo' => 'seoaal_team_vimeo',
						'social-flickr' => 'seoaal_team_flickr',
						'social-dribbble' => 'seoaal_team_dribbble',
					);
					// Actived social icons from theme option output generate via loop
					foreach( $social_media as $key => $class ){
						$social_url = get_post_meta( get_the_ID(), $social_opt[$key], true );
						if( $social_url ):
							$output .= '<li>';
								$output .= '<a class="'. esc_attr( $key ) .'" href="'. esc_url( $social_url ) .'" target="'. esc_attr( $taget ) .'">';
									$output .= '<i class="'. esc_attr( $class ) .'"></i>';
								$output .= '</a>';
							$output .= '</li>';
						endif;
					}
				$output .= '</ul>';
			$output .= '</div> <!-- .team-social-wrap -->';
		break;
		
	}
	return $output; 
}
if ( ! function_exists( "seoaal_vc_team_shortcode_map" ) ) {
	function seoaal_vc_team_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Team", "seoaal" ),
				"description"			=> esc_html__( "Team custom post type.", "seoaal" ),
				"base"					=> "seoaal_vc_team",
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
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Team Layout", "seoaal" ),
						"param_name"	=> "team_layout",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/team/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/team/2.png",
							"3"	=> SEOAAL_ADMIN_URL . "/assets/images/team/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Team Variation", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team variation either dark or light.", "seoaal" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "seoaal" )	=> "light",
							esc_html__( "Dark", "seoaal" )		=> "dark",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Team Model", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team model either grid or list.", "seoaal" ),
						"param_name"	=> "team_model",
						"value"			=> array(
							esc_html__( "Grid", "seoaal" )	=> "grid",
							esc_html__( "List", "seoaal" )	=> "list",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Team Columns", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team columns.", "seoaal" ),
						"param_name"	=> "team_cols",
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
						'heading'		=> esc_html__( 'Team Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for team custom layout. here you can set your own layout. Drag and drop needed team items to Enabled part.", "seoaal" ),
						'param_name'	=> 'team_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'thumb'	=> esc_html__( 'Image', 'seoaal' ),
								'name'	=> esc_html__( 'Name', 'seoaal' ),
								'designation'	=> esc_html__( 'Designation', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'social'	=> esc_html__( 'Social Links', 'seoaal' ),
							),
							'disabled' => array(
								'more'	=> esc_html__( 'Read More', 'seoaal' ),
								'email'	=> esc_html__( 'Email', 'seoaal' ),
								'phone'	=> esc_html__( 'Phone Number', 'seoaal' ),
								'namedes'	=> esc_html__( 'Name and Designation', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team text align", "seoaal" ),
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
						"description"	=> esc_html__( "This is an option for team slider option.", "seoaal" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Image", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team image layout either normal, rounded, or circled", "seoaal" ),
						"param_name"	=> "img_layout",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "",
							esc_html__( "Rounded", "seoaal" )	=> "rounded",
							esc_html__( "Circle", "seoaal" )	=> "circle",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Team Option", "seoaal" ),
						"description"	=> esc_html__( "This is an option for enable overlay team option.", "seoaal" ),
						"param_name"	=> "team_overlay_opt",
						"value"			=> array(
							esc_html__( "Disable", "seoaal" )	=> "disable",
							esc_html__( "Enable", "seoaal" )	=> "enable"
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put team overlay font color.", "seoaal" ),
						"param_name"	=> "team_overlay_font_color",
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Overlay Link Colors", "seoaal" ),
						"description"	=> esc_html__( "Here you can put team overlay link normal, hover colors. Example #ffffff, #cccccc", "seoaal" ),
						"param_name"	=> "team_overlay_link_colors",
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Overlay Team Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for team items(name, excerpt etc..) overlay on thumbnail. Drag and drop needed team items to Enabled part.", "seoaal" ),
						'param_name'	=> 'overlay_team_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'name'	=> esc_html__( 'Name', 'seoaal' )
							),
							'disabled' => array(
								'designation'	=> esc_html__( 'Designation', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'social'	=> esc_html__( 'Social Links', 'seoaal' ),
								'email'	=> esc_html__( 'Email', 'seoaal' ),
								'phone'	=> esc_html__( 'Phone Number', 'seoaal' ),
								'namedes'	=> esc_html__( 'Name and Designation', 'seoaal' )
							)
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Items Position", "seoaal" ),
						"description"	=> esc_html__( "This is an option for overlay items position.", "seoaal" ),
						"param_name"	=> "team_overlay_position",
						"value"			=> array(
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Top Left", "seoaal" )	=> "top-left",
							esc_html__( "Top Right", "seoaal" )	=> "top-right",
							esc_html__( "Bottom Left", "seoaal" )	=> "bottom-left",
							esc_html__( "Bottom Right", "seoaal" )	=> "bottom-right",
							
							esc_html__( "Bottom Center", "seoaal" )	=> "bottom-center",
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team text align", "seoaal" ),
						"param_name"	=> "overlay_text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Type", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team overlay type.", "seoaal" ),
						"param_name"	=> "team_overlay_type",
						"value"			=> array(
							esc_html__( "None", "seoaal" ) => "none",
							esc_html__( "Overlay Dark", "seoaal" ) => "dark",
							esc_html__( "Overlay White", "seoaal" ) => "light",
							esc_html__( "Custom Color", "seoaal" ) => "custom"
						),
						'dependency' => array(
							'element' => 'team_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Custom Gradient From", "seoaal" ),
						"description"	=> esc_html__( "Here you can put team overlay custom gradient from color.", "seoaal" ),
						"param_name"	=> "team_overlay_custom_color_1",
						'dependency' => array(
							'element' => 'team_overlay_type',
							'value' => 'custom',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Overlay Custom Gradient To", "seoaal" ),
						"description"	=> esc_html__( "Here you can put team overlay custom gradient to color.", "seoaal" ),
						"param_name"	=> "team_overlay_custom_color_2",
						'dependency' => array(
							'element' => 'team_overlay_type',
							'value' => 'custom',
						),
						"group"			=> esc_html__( "Overlay", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Style", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team social icons style.", "seoaal" ),
						"param_name"	=> "social_style",
						"value"			=> array(
							esc_html__( "Circled", "seoaal" )	=> "circled",
							esc_html__( "Square", "seoaal" )	=> "squared",
							esc_html__( "Rounded", "seoaal" )	=> "rounded",
							esc_html__( "Transparent", "seoaal" )		=> "transparent"
						),
						"group"			=> esc_html__( "Social", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Color", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team social icons color.", "seoaal" ),
						"param_name"	=> "social_color",
						"value"			=> array(
							esc_html__( "Black", "seoaal" )		=> "black",
							esc_html__( "White", "seoaal" )		=> "white",
							esc_html__( "Own Color", "seoaal" )	=> "own"
						),
						"group"			=> esc_html__( "Social", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Hover Color", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team social icons hover color.", "seoaal" ),
						"param_name"	=> "social_hcolor",
						"value"			=> array(
							esc_html__( "White", "seoaal" )		=> "h-white",
							esc_html__( "Black", "seoaal" )		=> "h-black",
							esc_html__( "Own Color", "seoaal" )	=> "h-own"
						),
						"group"			=> esc_html__( "Social", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Background", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team social icons background.", "seoaal" ),
						"param_name"	=> "social_bg",
						"value"			=> array(
							esc_html__( "White", "seoaal" )		=> "bg-white",
							esc_html__( "Black", "seoaal" )		=> "bg-black",
							esc_html__( "RGBA Light", "seoaal" )=> "bg-light",
							esc_html__( "RGBA Dark", "seoaal" )	=> "bg-dark",
							esc_html__( "Own Color", "seoaal" )	=> "bg-own",
							
							esc_html__( "Transparent", "seoaal" )	=> "bg-trans"
						),
						"group"			=> esc_html__( "Social", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Social Icons Hover Background Color", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team social icons hover background.", "seoaal" ),
						"param_name"	=> "social_hbg",
						"value"			=> array(
							esc_html__( "Own Color", "seoaal" )	=> "hbg-own",
							esc_html__( "Black", "seoaal" )		=> "hbg-black",
							esc_html__( "White", "seoaal" )		=> "hbg-white",
							esc_html__( "RGBA Light", "seoaal" )=> "hbg-light",
							esc_html__( "RGBA Dark", "seoaal" )	=> "hbg-dark",
							esc_html__( "Transparent", "seoaal" )	=> "hbg-trans"						
						),
						"group"			=> esc_html__( "Social", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slide items shown on large devices.", "seoaal" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slide items shown on tab.", "seoaal" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slide items shown on mobile.", "seoaal" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider auto play.", "seoaal" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider loop.", "seoaal" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider center, for this option must active loop and minimum items 2.", "seoaal" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider navigation.", "seoaal" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider pagination.", "seoaal" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider margin space.", "seoaal" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider duration.", "seoaal" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider smart speed.", "seoaal" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "seoaal" ),
						"description"	=> esc_html__( "This is an option for team slider scroll by.", "seoaal" ),
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
add_action( "vc_before_init", "seoaal_vc_team_shortcode_map" );