<?php 
/**
 * Seoaal Events
 */
if ( ! function_exists( "seoaal_vc_events_shortcode" ) ) {
	function seoaal_vc_events_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_events", $atts );
		extract( $atts );
		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$class_names .= isset( $events_layout ) ? ' events-' . $events_layout : '';
		$class_names .= isset( $event_style ) && $event_style != '' ? ' event-style-' . $event_style : '';
		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$class_names .= isset( $variation ) ? ' events-' . $variation : '';
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		$title_head = isset( $title_head ) ? $title_head : 'h4';
		
		$date_opt = isset( $date_opt ) && $date_opt == 'on' ? true : false;
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '.' . esc_attr( $rand_class ) . '.events-wrapper .events-inner >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.events-wrapper.events-dark .events-inner, .' . esc_attr( $rand_class ) . '.events-wrapper .events-inner, .' . esc_attr( $rand_class ) . '.events-dark .media-body, .' . esc_attr( $rand_class ) . ' .media-body { color: '. esc_attr( $font_color ) .'; }' : '';
		$args = array(
			'post_type' => 'seoaal-event',
			'posts_per_page' => absint( $post_per_page ),
			'ignore_sticky_posts' => 1
		);
		
		// Events Grid Layout
		if( isset( $events_layout ) && $events_layout != 'list' ){
			
			$cols = isset( $event_cols ) ? $event_cols : 1;
			$gal_atts = '';
			if( isset( $slide_opt ) && $slide_opt == 'on' ){
				$gal_atts = array(
					'data-loop="'. ( isset( $slide_item_loop ) && $slide_item_loop == 'on' ? 1 : 0 ) .'"',
					'data-margin="'. ( isset( $slide_margin ) && $slide_margin != '' ? absint( $slide_margin ) : 0 ) .'"',
					'data-center="'. ( isset( $slide_center ) && $slide_center == 'on' ? 1 : 0 ) .'"',
					'data-nav="'. ( isset( $slide_nav ) && $slide_nav == 'on' ? 1 : 0 ) .'"',
					'data-dots="'. ( isset( $slide_dots ) && $slide_dots == 'on' ? 1 : 0 ) .'"',
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
				wp_enqueue_script( 'owl-carousel' );
				wp_enqueue_style( 'owl-carousel' );
			}
			
			$thumb_size = 'large';
			if( ( 12 / absint( $cols ) ) > 3 ){
				$thumb_size = 'seoaal-grid-medium';
			}elseif( ( 12 / absint( $cols ) ) > 2 ){
				$thumb_size = 'seoaal-grid-large';
			}elseif( ( 12 / absint( $cols ) ) > 1 ){
				$thumb_size = 'medium';
			}else{
				$thumb_size = 'large';
			}
			
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
				
				$output .= '<div class="events-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
					$row_stat = 0;
					
						$elemetns = isset( $events_items ) ? seoaal_drag_and_drop_trim( $events_items ) : array( 'Enabled' => '' );
						
						$event_array = array(
							'excerpt_length' => $excerpt_length,
							'thumb_size' => $thumb_size,
							'more_text' => $more_text,
							'grid' => 1, 
							'title_head' => $title_head,
							'date_opt' => $date_opt
						);

						//Events Slide
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';	
						
						// Start the Loop
						while ( $query->have_posts() ) : $query->the_post();
						
							if( $row_stat == 0 && $slide_opt != 'on' ) :
								$output .= '<div class="row">';
							endif;
						
							//Events Slide Item
							if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '<div class="item">';	
						
							$col_class = "col-lg-". absint( $cols );
							$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
							$output .= '<div class="'. esc_attr( $col_class ) .'">';
								$output .= '<div class="events-inner">';
								
								$post_id = get_the_ID();
								
								$event_array['post_id'] = $post_id;
								
								//Check Event Exists or Not
								$event_date = get_post_meta( $post_id, 'seoaal_event_start_date', true );
								$end_date = get_post_meta( $post_id, 'seoaal_event_end_date', true );
								$date_exist = !empty( $end_date ) ? $end_date : $event_date;
								if( $date_exist ):
									if( ( time() -( 60*60*24 ) ) > strtotime( $date_exist ) ): 
										$output .= '<span class="event-status">'. apply_filters( 'seoaal_archive_event_close', esc_html( 'Event closed.', 'seoaal' ) ) .'</span>';
									endif;
								endif;

								if( isset( $elemetns['Enabled'] ) ) :
									foreach( $elemetns['Enabled'] as $element => $value ){
										$output .= seoaal_events_shortcode_elements( $element, $event_array );
									}
								endif;
								
								$output .= '</div><!-- .events-inner -->';
							$output .= '</div><!-- .cols -->';
							
							//Events Slide Item End
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
						
						//Events Slide End
						if( isset( $slide_opt ) && $slide_opt == 'on' ) $output .= '</div><!-- .owl-carousel -->';
	
				$output .= '</div><!-- .events-wrapper -->';
				
			}// query exists
			
			// use reset postdata to restore orginal query
			wp_reset_postdata();
		
		}else{ 
		
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
			// Events List Layout
			$thumb_size = 'thumbnail';
			
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				
				$output .= '<div class="events-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				
					// Start the Loop
					while ( $query->have_posts() ) : $query->the_post();
							
						$post_id = get_the_ID();
										
						$event_array = array(
							'post_id' => $post_id,
							'excerpt_length' => $excerpt_length,
							'thumb_size' => $thumb_size,
							'more_text' => $more_text,
							'grid' => 1,
							'title_head' => $title_head,
							'date_opt' => $date_opt
						);
						
							$output .= '<div class="media event-list-item">';
								$output .= seoaal_events_shortcode_elements( 'thumb', $event_array );
								$output .= '<div class="media-body">';
								
									//Check Event Exists or Not
									$event_date = get_post_meta( $post_id, 'seoaal_event_start_date', true );
									$end_date = get_post_meta( $post_id, 'seoaal_event_end_date', true );
									$date_exist = !empty( $end_date ) ? $end_date : $event_date;
									if( $date_exist ):
										if( ( time() -( 60*60*24 ) ) > strtotime( $date_exist ) ): 
											$output .= '<span class="event-status">'. apply_filters( 'seoaal_archive_event_close', esc_html( 'Event closed.', 'seoaal' ) ) .'</span>';
										endif;
									endif;
									
									$event_array['grid'] = 0;
									$elemetns = isset( $events_items ) ? seoaal_drag_and_drop_trim( $events_items ) : array( 'Enabled' => '' );
									if( isset( $elemetns['Enabled'] ) ) :
										foreach( $elemetns['Enabled'] as $element => $value ){
											$output .= seoaal_events_shortcode_elements( $element, $event_array );
										}
									endif;
									
								$output .= '</div><!-- .media-body -->';
							$output .= '</div><!-- .media -->';
	
					endwhile;
				
				$output .= '</div><!-- .events-wrapper -->';
				
			} // Wp Query have posts
			// use reset postdata to restore orginal query
			wp_reset_postdata();
		}
		
		return $output;
	}
}
function seoaal_events_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "title":
			$title_head = isset( $opts['title_head'] ) ? $opts['title_head'] : 'h4';
			$output .= '<div class="events-title">';
				$output .= '<'. esc_attr( $title_head ) .'><a href="'. esc_url( get_the_permalink() ) .'" class="entry-title">'. get_the_title() .'</a></'. esc_attr( $title_head ) .'>';
			$output .= '</div><!-- .events-title -->';		
		break;
		case "thumb":
			if( $opts['grid'] ){
				if ( has_post_thumbnail() ) {
					$output .= '<div class="events-thumb">';
						
						$thumb_size = $opts['thumb_size'];
					
						$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
						$img_prop = seoaal_custom_image_size_chk( $thumb_size, '' );
						
						if( $lazy_opt ){
							$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
							if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
								$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, '', true, absint( $lazy_img['id'] ) );
								$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid post-thumbnail lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_prop[0] ) . '" />';
							}else{
								$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid post-thumbnail lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_prop[0] ) . '" />';
							}
						}else{
							if( $thumb_cond == 'custom' ){
								$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid"  alt="'. the_title_attribute(array('echo' => false)) .'" src="' . esc_url( $img_prop[0] ) . '"/>';
							}else{
								$output .= get_the_post_thumbnail( $opts['post_id'], $thumb_size, array( 'class' => 'img-fluid' ) );
							}
						}
					
					
						
						if( isset( $opts['date_opt'] ) && $opts['date_opt'] == true ) {
							$output .= seoaal_events_shortcode_elements( "date", $opts );
						}
					$output .= '</div><!-- .events-thumb -->';
				}
			}
		break;
		
		case "excerpt":
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="events-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .events-excerpt -->';	
		break;
		
		case "date":
		
			$event_date = get_post_meta( $opts['post_id'], 'seoaal_event_start_date', true );
			if( $event_date ):
				$output .= '<div class="events-date">';
					$date_format = get_post_meta( $opts['post_id'], 'seoaal_event_date_format', true );
					$output .= !empty( $date_format ) ? date( $date_format, strtotime( $event_date ) ) : esc_html( $event_date );
					$event_time = get_post_meta( $opts['post_id'], 'seoaal_event_time', true );
					if( $event_time ) : 
						$output .= '<span class="event-time">'. esc_html( $event_time ) .'</span>';
					endif;
				$output .= '</div><!-- .events-date -->';
			endif;
			
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'seoaal' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
	}
	return $output; 
}
if ( ! function_exists( "seoaal_vc_events_shortcode_map" ) ) {
	function seoaal_vc_events_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Events", "seoaal" ),
				"description"			=> esc_html__( "Events custom post type.", "seoaal" ),
				"base"					=> "seoaal_vc_events",
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
						"group"			=> esc_html__( "Layouts", "seoaal" )
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
						"heading"		=> esc_html__( "Events Style", "seoaal" ),
						"param_name"	=> "event_style",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/event/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/event/2.png",
							"3"	=> SEOAAL_ADMIN_URL . "/assets/images/event/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Events Layout", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events layout either grid or list.", "seoaal" ),
						"param_name"	=> "events_layout",
						"value"			=> array(
							esc_html__( "Grid", "seoaal" )	=> "grid",
							esc_html__( "List", "seoaal" )		=> "list",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Events Variation", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events variation either dark or light.", "seoaal" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "seoaal" )	=> "light",
							esc_html__( "Dark", "seoaal" )		=> "dark",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Events Columns", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events columns.", "seoaal" ),
						"param_name"	=> "event_cols",
						"value"			=> array(
							esc_html__( "1 Column", "seoaal" )	=> "12",
							esc_html__( "2 Columns", "seoaal" )	=> "6",
							esc_html__( "3 Columns", "seoaal" )	=> "4",
							esc_html__( "4 Columns", "seoaal" )	=> "3",
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Overlay Date Option", "seoaal" ),
						"description"	=> esc_html__( "This is an option to enable overlay date and time of the event in image.", "seoaal" ),
						"param_name"	=> "date_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Event Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for events custom layout. here you can set your own layout. Drag and drop needed events items to Enabled part.", "seoaal" ),
						'param_name'	=> 'events_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'thumb'	=> esc_html__( 'Image', 'seoaal' ),
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'date'	=> esc_html__( 'Date and Time', 'seoaal' )
							),
							'disabled' => array(
								'more'	=> esc_html__( 'Read More', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events text align", "seoaal" ),
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
						"description"	=> esc_html__( "This is an option for events slider option only for events grid not for events list.", "seoaal" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slide items shown on large devices.", "seoaal" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slide items shown on tab.", "seoaal" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slide items shown on mobile.", "seoaal" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider auto play.", "seoaal" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider loop.", "seoaal" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider center, for this option must active loop and minimum items 2.", "seoaal" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider navigation.", "seoaal" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider pagination.", "seoaal" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider margin space.", "seoaal" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider duration.", "seoaal" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider smart speed.", "seoaal" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "seoaal" ),
						"description"	=> esc_html__( "This is an option for events slider scroll by.", "seoaal" ),
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
add_action( "vc_before_init", "seoaal_vc_events_shortcode_map" );