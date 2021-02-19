<?php 
/**
 * Seoaal Compare Pricing
 */
if ( ! function_exists( "seoaal_vc_compare_pricing_shortcode" ) ) {
	function seoaal_vc_compare_pricing_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_compare_pricing", $atts ); 
		extract( $atts );
		
		$output = '';
		
		// Define Variables
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';	
		$class .= isset( $pricing_layout ) ? ' compare-pricing-style-' . $pricing_layout : '';	
		
		// Shortcode Css
		$pshortcode_css = '';
		$pshortcode_rand_id = $prand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		$class .= ' ' . $pshortcode_rand_id;
		
		//Shortcode css code here
		$pshortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $prand_class ) . '.compare-pricing-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		if( isset( $title_height ) && $title_height != '' ){
			$pshortcode_css .= ' .' . $prand_class . ' .compare-title-wrap { height: '. esc_attr( $title_height ) .'px; }';
		}
		
		if( $pshortcode_css ) $class .= ' seoaal-inline-css';
		
		$output .= '<div class="compare-pricing-wrapper clearfix'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $pshortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">'; 
			// Compare Lists
			$output .= '<div class="compare-pricing-lists text-center">';
				
				// Compare Title
				if( isset( $compare_title ) && $compare_title != '' ) : 
					$output .= '<div class="compare-title-wrap">';
						$output .= '<h3 class="compare-title">' . esc_html( $compare_title ) . '</h3>';
					$output .= '</div><!-- .compare-title-wrap -->';
					$output .= '<div class="compare-features-wrap">';
						// Pricing Features
						$pricing_titles = isset( $compare_list ) ? $compare_list : '';
						$prc_fetrs =  json_decode( urldecode( $pricing_titles ), true ); // $prc_fetrs is pricing features
						if( $prc_fetrs ):
							$output .= '<div class="pricing-table-body">';
								$output .= '<ul class="pricing-features-list list-group">';
									foreach( $prc_fetrs as $feature ) {
										$p_title = isset( $feature['pricing_compare_title'] ) ? $feature['pricing_compare_title'] : '';
										$output .= '<li class="list-group-item">'. esc_html( $p_title ) . '</li>';
									}
								$output .= '</ul>';
							$output .= '</div><!-- .pricing-table-body -->';
						endif;
					$output .= '</div><!-- .compare-features-wrap -->';
				endif;	
					
			$output .= '</div><!-- .compare-pricing-lists -->';
			
			$output .= '<div class="compare-pricing-tables">';
				$output .= '<div class="compare-pricing-inner clearfix">';
		
				if( isset( $compare_pricings ) ):
				
					$pricing_tables = json_decode( urldecode( $compare_pricings ), true );
					$pricing_width = count( $pricing_tables ) > 0 ? 100 / count( $pricing_tables ) : '100';
					foreach( $pricing_tables as $pricing_table ){
						
						$shortcode_class = $shortcode_css = '';
						$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
						$shortcode_class .= ' ' . $shortcode_rand_id;
						if( isset( $pricing_table['title_color'] ) && $pricing_table['title_color'] ){
							$shortcode_css .= ' .' . $shortcode_rand_id . ' .pricing-title { color: '. esc_attr( $pricing_table['title_color'] ) .'; }';
						}
						$shortcode_css .= ' .compare-pricing-wrapper .' . $shortcode_rand_id . '.pricing-inner-wrapper { width: '. esc_attr( $pricing_width ) .'%; }';
						
						if( $shortcode_css ) $shortcode_class .= ' seoaal-inline-css';
						
						if( $pricing_table ):
							$output .= '<div class="pricing-inner-wrapper text-center'. esc_attr( $shortcode_class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
								
								// Pricing Title
								$title = $pricing_table['pricing_title'];
								if( isset( $title ) && $title != '' ) : 
									$output .= '<div class="pricing-table-head">';
										$output .= '<h3 class="pricing-title">' . esc_html( $title ) . '</h3>';
									$output .= '</div><!-- .pricing-table-head -->';
								endif;		
								
								// Pricing Rate Info
								$price_before = isset( $pricing_table['price_before'] ) ? $pricing_table['price_before'] : '';
								$price = isset( $pricing_table['price'] ) ? $pricing_table['price'] : '';
								$price_after = isset( $pricing_table['price_after'] ) ? $pricing_table['price_after'] : '';
								if( $price_before || $price || $price_after ):
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
								endif;
								
								// Pricing Features
								$pricing_titles = $pricing_table['pricing_features'];
								$prc_fetrs =  json_decode( urldecode( $pricing_titles ), true ); // $prc_fetrs is pricing features
								if( $prc_fetrs ):
									$output .= '<div class="pricing-table-body">';
										$output .= '<ul class="pricing-features-list list-group">';
											foreach( $prc_fetrs as $feature ) {
												$p_title = isset( $feature['pricing_feature'] ) ? $feature['pricing_feature'] : '';
												$p_stat = $feature['pricing_status'];
												if( !empty( $p_title ) ){
													$output .= '<li class="list-group-item">'. esc_html( $p_title ) . '</li>';
												}elseif( $p_stat == 'dash' ){
													$output .= '<li class="list-group-item"><span class="dashed">---</span></li>';
												}elseif( $p_stat == 'tick' ){
													$output .= '<li class="list-group-item"><span class="fa fa-check"></span></li>';
												}elseif( $p_stat == 'cross' ){
													$output .= '<li class="list-group-item"><span class="fa fa-times"></span></li>';
												}else{
													$output .= '<li class="list-group-item"><span class="stat-empty"></span></li>';
												}
												
											}
										$output .= '</ul>';
									$output .= '</div><!-- .pricing-table-body -->';
								endif;
								
								// Button
								$btn_text = $pricing_table['btn_text'];
								$btn_url = $pricing_table['btn_url'];
								if( isset( $btn_text ) && $btn_text != '' ) :
									$btn_url = isset( $btn_url ) && $btn_url != '' ? $btn_url : '#';
									$output .= '<div class="pricing-table-foot">';
										$output .= '<a href="'. esc_url( $btn_url ) .'" class="btn btn-default mt-2">'. esc_html( $btn_text ) .'</a>';
									$output .= '</div><!-- .pricing-table-foot -->';
								endif;
							
							$output .= '</div><!-- .pricing-inner-wrapper -->';
						endif;
						
					}//single pricing table
					
				endif; // compare_pricings items endif
				
				$output .= '</div><!-- .compare-pricing-inner -->';
			$output .= '</div><!-- .compare-pricing-tables -->';
				
		$output .= '</div><!-- .compare-pricing-wrapper -->';
		
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_compare_pricing_shortcode_map" ) ) {
	function seoaal_vc_compare_pricing_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Compare Pricing", "seoaal" ),
				"description"			=> esc_html__( "Compare pricing table.", "seoaal" ),
				"base"					=> "seoaal_vc_compare_pricing",
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
						"heading"		=> esc_html__( "Compare Pricing Table Layout", "seoaal" ),
						"param_name"	=> "pricing_layout",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/compare-pricing/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/compare-pricing/2.png",
							"3"	=> SEOAAL_ADMIN_URL . "/assets/images/compare-pricing/3.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( "Compare Main Title", "seoaal" ),
						'param_name' => 'compare_title',
						'value' => esc_html__( "Title", "seoaal" ),
						"group"			=> esc_html__( "Pricing Compare", "seoaal" )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( "Compare Title Height", "seoaal" ),
						'param_name' => 'title_height',
						'value' => 50,
						"group"	=> esc_html__( "Pricing Compare", "seoaal" )
					),
					array(
						'type' => 'param_group',
						"heading"		=> esc_html__( "Price Tables", "seoaal" ),
						'value' => '',
						'param_name' => 'compare_list',
						'params' => array(
							array(
								'type' => 'textfield',
								'value' => esc_html__( "Pricing Compare Title", "seoaal" ),
								'heading' => esc_html__( "Pricing Compare Title", "seoaal" ),
								'param_name' => 'pricing_compare_title',
								'admin_label' => true,
							),
						),
						"group"			=> esc_html__( "Pricing Compare", "seoaal" )
					),
					array(
						'type' => 'param_group',
						"heading"		=> esc_html__( "Price Tables", "seoaal" ),
						'value' => '',
						'param_name' => 'compare_pricings',
						'params' => array(
							array(
								'type' => 'textfield',
								'value' => esc_html__( "Pricing Title", "seoaal" ),
								'heading' => esc_html__( "Pricing Title", "seoaal" ),
								'param_name' => 'pricing_title',
								'admin_label' => true,
							),
							array(
								"type"			=> "colorpicker",
								"heading"		=> esc_html__( "Title Color", "seoaal" ),
								"description"	=> esc_html__( "Here you put the title color.", "seoaal" ),
								"param_name"	=> "title_color",
								"value" 		=> ""
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Price Before Text", "seoaal" ),
								"description"	=> esc_html__( "This is before text field for price.", "seoaal" ),
								"param_name"	=> "price_before",
								"value" 		=> ""
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Price", "seoaal" ),
								"description"	=> esc_html__( "This is field for price.", "seoaal" ),
								"param_name"	=> "price",
								"value" 		=> ""
							),
							array(
								"type"			=> "textfield",
								"heading"		=> esc_html__( "Price After", "seoaal" ),
								"description"	=> esc_html__( "This is after text field for price.", "seoaal" ),
								"param_name"	=> "price_after",
								"value" 		=> ""
							),
							array(
								'type' => 'param_group',
								"heading"	=> esc_html__( "Price Features", "seoaal" ),
								'value' => '',
								'param_name' => 'pricing_features',
								'params' => array(
									array(
										'type' => 'textfield',
										'value' => '',
										'heading' => esc_html__( "Pricing Feature Name", "seoaal" ),
										'param_name' => 'pricing_feature',
										'admin_label' => true,
									),
									array(
										"type"			=> "dropdown",
										"heading"		=> esc_html__( "Pricing Status", "seoaal" ),
										"description"	=> esc_html__( "This is option for showing pricing status to tick, cross, dash or none.", "seoaal" ),
										"param_name"	=> "pricing_status",
										"value"			=> array(
											esc_html__( "None", "seoaal" )	=> "none",
											esc_html__( "Dashed", "seoaal" )=> "dash",
											esc_html__( "Tick", "seoaal" )	=> "tick",
											esc_html__( "Cross", "seoaal" )	=> "cross"
										)
									)
								)
							),
							array(
								"type" => "textfield",
								"heading" => esc_html__( "Button Text", "seoaal" ),
								"param_name" => "btn_text",
								"value" => esc_html__( "Plan", "seoaal" ),
								"description" => esc_html__( "This is option for pricing button text.", "seoaal" )
							),
							array(
								"type" => "textfield",
								"heading" => esc_html__( "Button URL", "seoaal" ),
								"param_name" => "btn_url",
								"value" => "",
								"description" => esc_html__( "This is option for pricing button url.", "seoaal" )
							)
						),
						"group"			=> esc_html__( "Pricing Tables", "seoaal" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_compare_pricing_shortcode_map" );