<?php 
/**
 * Seoaal Circle Progress
 */
if ( ! function_exists( "seoaal_vc_circle_progress_shortcode" ) ) {
	function seoaal_vc_circle_progress_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_circle_progress", $atts );
		extract( $atts );
		
		//Define Variables
		$title = isset( $title ) && $title != '' ? $title : '';
		$circle_val = isset( $circle_val ) && $circle_val != '' ? $circle_val : '';
		$content = isset( $content ) && $content != '' ? $content : '';
		$progress_size = isset( $progress_size ) && $progress_size != '' ? $progress_size : '';
		$progress_thikness = isset( $progress_thikness ) && $progress_thikness != '' ? $progress_thikness : '';
		$progress_duration = isset( $progress_duration ) && $progress_duration != '' ? $progress_duration : '';
		$empty_color = isset( $circle_empty_color ) && $circle_empty_color != '' ? $circle_empty_color : '';
		$circle_start_color = isset( $circle_start_color ) && $circle_start_color != '' ? $circle_start_color : '';
		$circle_end_color = isset( $circle_end_color ) && $circle_end_color != '' ? $circle_end_color : '';
		
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? $extra_class : '';		
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';	
		$class .= isset( $circle_layout ) && $circle_layout != '' ? ' circle-progress-style-' . $circle_layout : '';	
		
		wp_enqueue_script( 'jquery-circle-progress' );
		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '.' . esc_attr( $rand_class ) . '.circle-progress-wrapper >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		// Get VC Animation
		$class .= seoaalGetCSSAnimation( $animation );
		
		$output = '';
		
		$elemetns = isset( $circle_items ) ? seoaal_drag_and_drop_trim( $circle_items ) : array( 'Enabled' => '' );
	
		if( isset( $elemetns['Enabled'] ) ) :
		
			//Shortcode css ccde here
			$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.circle-progress-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
			if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
			$output .= '<div class="circle-progress-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
		
				foreach( $elemetns['Enabled'] as $element => $value ){
					switch( $element ){
			
						case "circle":
							$output .= '<div class="circle-progress-circle" data-value="'. esc_attr( $circle_val ) .'" data-size="'. esc_attr( $progress_size ) .'" data-thickness="'. esc_attr( $progress_thikness ) .'" data-duration="'. esc_attr( $progress_duration ) .'" data-empty="'. esc_attr( $empty_color ) .'" data-scolor="'. esc_attr( $circle_start_color ) .'" data-ecolor="'. esc_attr( $circle_end_color ) .'">';
								$output .= '<span class="progress-value"></span>';
							$output .= '</div><!-- .circle-progress-circle -->';
						break;
						
						case "title":
							$output .= '<div class="circle-progress-title">';
								$output .= '<h4>'. esc_html( $title ) .'</h4>';
							$output .= '</div><!-- .circle-progress-title -->';
						break;
						
						case "content":
							$output .= '<div class="circle-progress-content">';
								$output .= '<p>'. esc_textarea( $content ) .'</p>';
							$output .= '</div><!-- .circle-progress-read-more -->';
						break;
						
					}
				} // foreach end
				
			$output .= '</div><!-- .circle-progress-wrapper -->';
				
		endif;
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_circle_progress_shortcode_map" ) ) {
	function seoaal_vc_circle_progress_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Circle Progress", "seoaal" ),
				"description"			=> esc_html__( "Circle progress bar.", "seoaal" ),
				"base"					=> "seoaal_vc_circle_progress",
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
						"description"	=> esc_html__( "Here you put the circle progress title.", "seoaal" ),
						"param_name"	=> "title",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Progress Value", "seoaal" ),
						"description"	=> esc_html__( "Here you can place progress value. This value must be in 1 to 100. Example 70", "seoaal" ),
						"param_name"	=> "circle_val",
						"value" 		=> "",
					),
					array(
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Content", "seoaal" ),
						"description"	=> esc_html__( "Here you put the progress content.", "seoaal" ),
						"param_name"	=> "content",
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
						"heading"		=> esc_html__( "Circle Progress Layout", "seoaal" ),
						"param_name"	=> "circle_layout",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/circle-progress/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/circle-progress/2.png",
							"3"	=> SEOAAL_ADMIN_URL . "/assets/images/circle-progress/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Circle Progress Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for Circle Progress custom layout. here you can set your own layout. Drag and drop needed Circle Progress items to Enabled part.", "seoaal" ),
						'param_name'	=> 'circle_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'circle'	=> esc_html__( 'Circle', 'seoaal' ),
								'title'	=> esc_html__( 'Title', 'seoaal' )
								
								
							),
							'disabled' => array(
								'content'	=> esc_html__( 'Content', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Circle Empty Fill Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the circle empty fill color.", "seoaal" ),
						"param_name"	=> "circle_empty_color",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),					
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Circle Start Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the circle fill start color.", "seoaal" ),
						"param_name"	=> "circle_start_color",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Circle End Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the circle fill end color. If you not giving end color, then circle take start color for end color.", "seoaal" ),
						"param_name"	=> "circle_end_color",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Circle Progress Size", "seoaal" ),
						"description"	=> esc_html__( "Here you can set circle progress size. Example 200", "seoaal" ),
						"param_name"	=> "progress_size",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Circle Progress Thickness", "seoaal" ),
						"description"	=> esc_html__( "Here you can set circle progress thickness. Example 10", "seoaal" ),
						"param_name"	=> "progress_thikness",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Circle Progress Duration", "seoaal" ),
						"description"	=> esc_html__( "Here you can set circle progress animation duration. Example 1500", "seoaal" ),
						"param_name"	=> "progress_duration",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for circle progress text align", "seoaal" ),
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
add_action( "vc_before_init", "seoaal_vc_circle_progress_shortcode_map" );