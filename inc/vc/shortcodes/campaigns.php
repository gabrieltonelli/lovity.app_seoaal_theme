<?php 
/**
 * Campaigns Grid shortcode
 */
if ( ! function_exists( 'seoaal_vc_seoaal_campaigns_grid_shortcode' ) ) {
	function seoaal_vc_seoaal_campaigns_grid_shortcode( $atts, $content = NULL ) {
	
		$atts = vc_map_get_attributes( 'seoaal_vc_seoaal_campaigns_grid', $atts );
		extract( $atts );
		
		$output = $seoaal_attr = '';
		
		
				// Classes

		$main_classes = '';
		if( isset( $classes ) && $classes != '' ) {
			$main_classes .= ' ' . $classes;
		}

				
		//posts Count
		$seoaal_attr .= isset( $num_posts ) && $num_posts != '' ? 'number=' . absint($num_posts) . ' ' : '';
		
		//column 
		if( isset( $layout_style ) && $layout_style != 'list' ) {
			add_filter( 'charitable_campaign_loop_thumbnail_size', 'charitable_campaign_loop_thumbnail_size_thumbnail', 10 );
			$seoaal_attr .= isset( $columns ) && $columns != '' ? 'columns=' . absint($columns) . ' ' : '';
		}else{
			add_filter( 'charitable_campaign_loop_thumbnail_size', 'charitable_campaign_loop_thumbnail_size_revert', 10 );
			$seoaal_attr .= isset( $columns ) && $columns != '' ? 'columns=1 ' : '';
		}	
		
		//category
		$seoaal_attr .= isset( $include_categories ) && $include_categories != '' ? 'category=' . esc_attr($include_categories) . ' ' : '';

		//order
		$seoaal_attr .= isset( $orderby ) && $orderby != '' ? 'orderby=' . esc_attr($orderby) . ' ' : '';
		
		//Include id
		$seoaal_attr .= isset( $camp_id ) && $camp_id != '' ? 'id=' . absint($camp_id) . ' ' : '';
		
			$output .= '<div class="seoaal-campaigns' .$main_classes.'">'; 
				$output .=	do_shortcode('[campaigns '. $seoaal_attr .']');		   
			$output .= '</div>';
			return $output;


		
	}
}

if ( ! function_exists( 'seoaal_vc_seoaal_campaigns_grid_shortcode_map' ) ) {
	function seoaal_vc_seoaal_campaigns_grid_shortcode_map() {
		
		vc_map( 
			array(
				"name"					=> esc_html__( "Campaigns", "seoaal" ),
				"description"			=> esc_html__( "Show your seoaal campaigns by different styles.", 'seoaal' ),
				"base"					=> "seoaal_vc_seoaal_campaigns_grid",
				"category"				=> esc_html__( "Shortcodes", "seoaal" ),
				"icon"					=> "zozo-vc-icon",
				"params"				=> array(					
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Extra Class', "seoaal" ),
						'param_name'	=> 'classes',
						'value' 		=> '',
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Campaigns per Page", "seoaal" ),
						"admin_label" 	=> true,
						"param_name"	=> "num_posts",	
						"value"			=> ""					
					),		
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Layouts", "seoaal" ),
						"param_name"	=> "layout_style",
						"value"			=> array(
							esc_html__( "Grid", "seoaal" )=> "grid",
							esc_html__( "List", "seoaal" )=> "list"),

					),
					
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Columns", "seoaal" ),
						"param_name"	=> "columns",
						"value"			=> array(
							esc_html__( "Two Columns", "seoaal" )		=> "2",
							esc_html__( "Three Columns", "seoaal" )	=> "3",
							esc_html__( "Four Columns", "seoaal" )		=> "4" ),
							
							'dependency'	=> array(
							'element'	=> 'layout_style',
							'value'		=>  'grid' ,
						),
					),
					
					array(

						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Include Category', 'seoaal' ),
						'param_name'	=> 'include_categories',
						'admin_label'	=> true,
						'description'	=> esc_html__( "Enter the slug of a category", 'seoaal' ),

					),
					
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Campaigns ID's", "seoaal" ),
						"admin_label" 	=> true,
						"param_name"	=> "camp_id",	
						"value"			=> "",
						'description'	=> esc_html__( "Enter the ID of a categories (comma seperated) to pull campaigns from campaigns. Example: 15, 12", 'seoaal' ),			
					),
					
					array(

						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Order By", "seoaal" ),
						"param_name"	=> "orderby",
						"value"			=> array(
							esc_html__( "Post Date", "seoaal" )		=> "post_date",
							esc_html__( "popular Campaigns", "seoaal" )		=> "post_date",
							esc_html__( "Ending Campaigns", "seoaal" )		=> "ending",							
						),
					),
			
			  )
			
			)
			
		);
	}
}
add_action( 'vc_before_init', 'seoaal_vc_seoaal_campaigns_grid_shortcode_map' );