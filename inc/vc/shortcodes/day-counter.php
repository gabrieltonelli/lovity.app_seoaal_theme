<?php 
/**
 * Seoaal Day Counter
 */
if ( ! function_exists( "seoaal_vc_day_counter_shortcode" ) ) {
	function seoaal_vc_day_counter_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_day_counter", $atts ); 
		extract( $atts );
		
		$output = '';
		
		//Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';		
		$class .= isset( $variation ) ? ' day-counter-' . $variation : '';	
		$shape_class = isset( $counter_shape ) ? ' ' . $counter_shape : '';				
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$date = isset( $date ) ? $date : '';
		
		// Get VC Animation
		$class .= seoaalGetCSSAnimation( $animation );
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		$elemetns = isset( $counter_items ) ? seoaal_drag_and_drop_trim( $counter_items ) : array( 'Enabled' => '' );
		$class .= count( $elemetns['Enabled'] ) ? ' counter-field-' . count( $elemetns['Enabled'] ) : '';
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.day-counter-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
		wp_enqueue_script( 'jquery-countdown' );
		
		$output .= '<div class="day-counter-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			$output .= '<div class="day-counter" data-date="'. esc_attr( $date ) .'">';
			
				if( isset( $elemetns['Enabled'] ) ) :
					foreach( $elemetns['Enabled'] as $element => $value ){
						
						switch( $element ){
							
							case "day":
								$day_label = isset( $day_label ) ? $day_label : '';
								$output .= '<div class="counter-day'. esc_attr( $shape_class ) .'">';
									$output .= '<div class="counter-item">';
										$output .= '<h3></h3>';
										$output .= '<span>'. esc_html( $day_label ) .'</span>';
									$output .= '</div>';
								$output .= '</div><!-- .counter-day -->';		
							break;
						
							case "hour":
								$hour_label = isset( $hour_label ) ? $hour_label : '';
								$output .= '<div class="counter-hour'. esc_attr( $shape_class ) .'">';
									$output .= '<div class="counter-item">';
										$output .= '<h3></h3>';
										$output .= '<span>'. esc_html( $hour_label ) .'</span>';
									$output .= '</div>';
								$output .= '</div><!-- .counter-hour -->';
							break;
							
							case "min":
								$min_label = isset( $min_label ) ? $min_label : '';
								$output .= '<div class="counter-min'. esc_attr( $shape_class ) .'">';
									$output .= '<div class="counter-item">';
										$output .= '<h3></h3>';
										$output .= '<span>'. esc_html( $min_label ) .'</span>';
									$output .= '</div>';
								$output .= '</div><!-- .counter-min -->';	
							break;
							
							case "sec":
								$sec_label = isset( $sec_label ) ? $sec_label : '';
								$output .= '<div class="counter-sec'. esc_attr( $shape_class ) .'">';
									$output .= '<div class="counter-item">';
										$output .= '<h3></h3>';
										$output .= '<span>'. esc_html( $sec_label ) .'</span>';
									$output .= '</div>';
								$output .= '</div><!-- .counter-sec -->';		
							break;
							
							case "week":
								$week_label = isset( $week_label ) ? $week_label : '';
								$output .= '<div class="counter-week'. esc_attr( $shape_class ) .'">';
									$output .= '<div class="counter-item">';
										$output .= '<h3></h3>';
										$output .= '<span>'. esc_html( $week_label ) .'</span>';
									$output .= '</div>';
								$output .= '</div><!-- .counter-week -->';		
							break;
							
						}
						
					}
				endif;
			
			$output .= '</div><!-- .day-counter -->';
		$output .= '</div><!-- .day-counter-wrapper -->';
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_day_counter_shortcode_map" ) ) {
	function seoaal_vc_day_counter_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Day Counter", "seoaal" ),
				"description"			=> esc_html__( "Day/Time counter.", "seoaal" ),
				"base"					=> "seoaal_vc_day_counter",
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
						"heading"		=> esc_html__( "Date", "seoaal" ),
						"description"	=> esc_html__( "Here you put the day counter date. Date format should be yyyy/mm/dd", "seoaal" ),
						"param_name"	=> "date",
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
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Counter Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for day counter custom layout. here you can set your own layout. Drag and drop needed services items to Enabled part.", "seoaal" ),
						'param_name'	=> 'counter_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'day'	=> esc_html__( 'Days', 'seoaal' ),
								'hour'	=> esc_html__( 'Hours', 'seoaal' ),
								'min'	=> esc_html__( 'Minutes', 'seoaal' ),
								'sec'	=> esc_html__( 'Seconds', 'seoaal' )
							),
							'disabled' => array(
								'week'	=> esc_html__( 'Weeks', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Counter Variation", "seoaal" ),
						"description"	=> esc_html__( "This is option for counter variatoin either dark or light.", "seoaal" ),
						"param_name"	=> "variation",
						"value"			=> array(
							esc_html__( "Light", "seoaal" )	=> "light",
							esc_html__( "Dark", "seoaal" )	=> "dark",
							esc_html__( "Transparent", "seoaal" )	=> "transparent"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Counter Shape", "seoaal" ),
						"description"	=> esc_html__( "This is option for counter shape.", "seoaal" ),
						"param_name"	=> "counter_shape",
						"value"			=> array(
							esc_html__( "Square", "seoaal" )	=> "rounded-0",
							esc_html__( "Round", "seoaal" )	=> "rounded",
							esc_html__( "Circle", "seoaal" )	=> "rounded-circle"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is option for day counter text align", "seoaal" ),
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
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Days Label", "seoaal" ),
						"description"	=> esc_html__( "Here you set the days label for counter date.", "seoaal" ),
						"param_name"	=> "day_label",
						"value" 		=> esc_html__( "Days", "seoaal" ),
						"group"			=> esc_html__( "Labels", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Hours Label", "seoaal" ),
						"description"	=> esc_html__( "Here you set the hours label for counter date.", "seoaal" ),
						"param_name"	=> "hour_label",
						"value" 		=> esc_html__( "Hours", "seoaal" ),
						"group"			=> esc_html__( "Labels", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Minutes Label", "seoaal" ),
						"description"	=> esc_html__( "Here you set the minutes label for counter date.", "seoaal" ),
						"param_name"	=> "min_label",
						"value" 		=> esc_html__( "Minutes", "seoaal" ),
						"group"			=> esc_html__( "Labels", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Seconds Label", "seoaal" ),
						"description"	=> esc_html__( "Here you set the seconds label for counter date.", "seoaal" ),
						"param_name"	=> "sec_label",
						"value" 		=> esc_html__( "Seconds", "seoaal" ),
						"group"			=> esc_html__( "Labels", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Weeks Label", "seoaal" ),
						"description"	=> esc_html__( "Here you set the weeks label for counter date.", "seoaal" ),
						"param_name"	=> "week_label",
						"value" 		=> esc_html__( "Weeks", "seoaal" ),
						"group"			=> esc_html__( "Labels", "seoaal" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_day_counter_shortcode_map" );