<?php 
/**
 * Seoaal Timeline Slide
 */
if ( ! function_exists( "seoaal_vc_timeline_slide_shortcode" ) ) {
	function seoaal_vc_timeline_slide_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_timeline_slide", $atts );
		extract( $atts );
		
		//Enqueue Timeline JS
		wp_enqueue_script( 'seoaal-timeline' );
				
		//Define Variables
		$class = isset( $extra_class ) && $extra_class != '' ? $extra_class : ''; 
		$distance = isset( $line_distance ) && $line_distance != '' ? absint( $line_distance ) : '60'; 
		
		$output = '';
		$output .= '<div class="timeline-wrapper'. esc_attr( $class ) .'">';
		
		// All Timeline Items
		$timeline_settings = isset( $timeline_settings ) ? $timeline_settings : '';
		$tl_items =  json_decode( urldecode( $timeline_settings ), true ); // $tl_items is timeline items
		if( $tl_items ):
		
			$tl_header = $tl_slide = '';
			$sel_stat = 0;
			foreach( $tl_items as $tlitem ) {
				
				//timeline_separator, timeline_title, timeline_subtitle, tl_content
				$tl_date = isset( $tlitem['timeline_date'] ) ? $tlitem['timeline_date'] : '';
				$tl_separator = isset( $tlitem['timeline_separator'] ) ? $tlitem['timeline_separator'] : '';
				$tl_title = isset( $tlitem['timeline_title'] ) ? $tlitem['timeline_title'] : '';
				$tl_subtitle = isset( $tlitem['timeline_subtitle'] ) ? $tlitem['timeline_subtitle'] : '';
				$tl_content = isset( $tlitem['tl_content'] ) ? $tlitem['tl_content'] : '';
				$sel_class = '';
				if( !$sel_stat ){
					$sel_class = 'selected';
					$sel_stat = 1;
				}
				
				$tl_header .= '<li><a href="#" data-date="'. esc_attr( $tl_date ) .'" class="'. esc_attr( $sel_class ) .'">'. esc_html( $tl_separator ) .'</a></li>';
				$tl_slide .= '<li class="'. esc_attr( $sel_class ) .'" data-date="'. esc_attr( $tl_date ) .'">
					<h2>'. esc_html( $tl_title ) .'</h2>
					<em>'. esc_html( $tl_subtitle ) .'</em>
					<div class="testimonial-content">'. wp_kses_post( $tl_content ) .'</div>
				</li>';
				
			}
		
			$output .= '<div class="cd-horizontal-timeline" data-distance="'. esc_attr( $distance ) .'">';
				$output .= '<div class="timeline">
					<div class="events-wrapper">
						<div class="events">
							<ul>'. $tl_header .'</ul>

							<span class="filling-line" aria-hidden="true"></span>
						</div> <!-- .events -->
					</div> <!-- .events-wrapper -->
						
					<ul class="cd-timeline-navigation">
						<li><a href="#" class="prev inactive"></a></li>
						<li><a href="#" class="next"></a></li>
					</ul> <!-- .cd-timeline-navigation -->
				</div> <!-- .timeline -->

				<div class="events-content">
					<ul>'. $tl_slide .'</ul>
				</div><!-- .events-content -->';				
			$output .= '</div><!-- .cd-horizontal-timeline -->';
			
		endif;
							
		$output .= '</div><!-- .timeline-wrapper -->';
		
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_timeline_slide_shortcode_map" ) ) {
	function seoaal_vc_timeline_slide_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Timeline Slide", "seoaal" ),
				"description"			=> esc_html__( "Timeline slider.", "seoaal" ),
				"base"					=> "seoaal_vc_timeline_slide",
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
						"heading"		=> esc_html__( "Event Line Distance", "seoaal" ),
						"description"	=> esc_html__( "This is option for timeline event line distance. If you use timeline for years make distance volume low.", "seoaal" ),
						"param_name"	=> "line_distance",
						"value" 		=> "60",
					),
					array(
						'type' => 'param_group',
						"heading"		=> esc_html__( "Timeline Setting", "seoaal" ),
						'value' => '',
						'param_name' => 'timeline_settings',
						'params' => array(
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Timeline Date", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline date. Must follow the date format dd/mm/yyyy. Example 16/01/2014", "seoaal" ),
								"param_name"	=> "timeline_date",
								"group"			=> esc_html__( "Timeline", "seoaal" )
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Timeline Separator Title", "seoaal" ),
								"description"	=> esc_html__( "Here you can put the timeline separator title.", "seoaal" ),
								"param_name"	=> "timeline_separator",
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
								"type"			=> "textarea",
								"heading"		=> esc_html__( "Content", "seoaal" ),
								"description" 	=> esc_html__( "You can give the feature box content here. HTML allowed here.", "seoaal" ),
								"param_name"	=> "tl_content",
								"value" 		=> "",
								"group"			=> esc_html__( "Content", "seoaal" )
							)
						),
						"group"			=> esc_html__( "Timeline", "seoaal" )
					),
					
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_timeline_slide_shortcode_map" );