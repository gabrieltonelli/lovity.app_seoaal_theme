<?php 
/**
 * Seoaal Image Grid
 */
if ( ! function_exists( "seoaal_vc_image_grid_shortcode" ) ) {
	function seoaal_vc_image_grid_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_image_grid", $atts );
		extract( $atts );
		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $image_grid_layout ) ? ' image-grid-' . $image_grid_layout : ' image-grid-1';
		$cols = isset( $grid_cols ) ? $grid_cols : 12;
		$slide_opt = isset( $slide_opt ) && $slide_opt == 'on' ? true : false;
		$grids = '';
		
		$gal_atts = $data_atts = '';
		if( isset( $image_grid_images ) ){ 
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
			$grids = isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 2;
			wp_enqueue_script( 'owl-carousel' );
			wp_enqueue_style( 'owl-carousel' );
		}
		
		if( $grids === 1 ){
			$thumb_size = 'large';
		}elseif( $grids == 2 ){
			$thumb_size = 'medium';
		}elseif( $grids == 3 ){
			$thumb_size = 'seoaal-grid-large';
		}else{
			$thumb_size = 'seoaal-grid-medium';
		}
		
		$col_class = "col-lg-". absint( $cols );
		$col_class .= " " . ( $cols == 3 ? "col-md-6" : "col-md-". absint( $cols ) );
			
		if( isset( $image_grid_images ) ){
			
			$output .= '<div class="image-grid-wrapper'. esc_attr( $class_names ) .'">';
				$row_stat = 0;
				
				//Image Grid Slide
				if( $slide_opt ) $output .= '<div class="owl-carousel" '. ( $data_atts ) .'>';
				
					$image_ids = explode( ',', $image_grid_images );
					foreach( $image_ids as $image_id ){
					
						if( $row_stat == 0 && !$slide_opt ) :
							$output .= '<div class="row">';
						endif;
					
						//Image Grid Slide
						if( $slide_opt ) $output .= '<div class="item">';
						
							$output .= '<div class="'. esc_attr( $col_class ) .'">';
								$output .= '<div class="image-grid-inner">';
					
									$img_attr = wp_get_attachment_image_src( $image_id, $thumb_size, true );
									$image_alt = get_post_meta( absint( $image_id ), '_wp_attachment_image_alt', true);
									$image_alt = $image_alt == '' ? esc_html__( 'Image', 'seoaal' ) : $image_alt;
									
									$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
									if( $lazy_opt ){
									
										$thumb_size = 'full';
										$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
									
										$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
										if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
											$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
											$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" class="img-fluid lazy-initiate" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" data-mce-src="'. esc_url( $img_attr[0] ) .'" />';
										}else{
											$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate" alt="'. esc_attr( $image_alt ) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '" data-mce-src="'. esc_url( $img_attr[0] ) .'" />';
										}
									}else{
										$output .= isset( $img_attr[0] ) ? '<img class="img-fluid" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" data-mce-src="'. esc_url( $img_attr[0] ) .'" />' : '';
									}
				
								$output .= '</div><!-- .image-grid-inner -->';
							$output .= '</div><!-- .cols -->';
						
						//Team Slide Item End
						if( $slide_opt ) $output .= '</div><!-- .item -->';		
						
						$row_stat++;
						if( $row_stat == ( 12/ $cols ) && !$slide_opt ) :
							$output .= '</div><!-- .row -->';
							$row_stat = 0;
						endif;
						
					}
					//Unexpected row close
					if( $row_stat != 0 && !$slide_opt ){
						$output .= '</div><!-- .row -->';
					}	
					
				//Image Grid Slide End
				if( $slide_opt ) $output .= '</div><!-- .owl-carousel -->';
				
			$output .= '</div><!-- .image-grid-wrapper -->';
			
		}
		
		return $output;
	}
}
if ( ! function_exists( "seoaal_vc_image_grid_shortcode_map" ) ) {
	function seoaal_vc_image_grid_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Image Grid", "seoaal" ),
				"description"			=> esc_html__( "Image Grid custom post type.", "seoaal" ),
				"base"					=> "seoaal_vc_image_grid",
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
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Image Grid Columns", "seoaal" ),
						"description"	=> esc_html__( "This grid option using to divide columns as per given numbers. This option active only when slide inactive otherwise slide columns only focus to divide.", "seoaal" ),
						"param_name"	=> "grid_cols",
						"value"			=> array(
							esc_html__( "1 Column", "seoaal" )	=> "12",
							esc_html__( "2 Columns", "seoaal" )	=> "6",
							esc_html__( "3 Columns", "seoaal" )	=> "4",
							esc_html__( "4 Columns", "seoaal" )	=> "3",
						)
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Image Grid Layout", "seoaal" ),
						"param_name"	=> "image_grid_layout",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/image-grid/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/image-grid/2.png"
						),
						"default"		=> "1"
					),
					array(
						"type" => "attach_images",
						"heading" => esc_html__( "Attach Images", "seoaal" ),
						"description" => esc_html__( "Choose image grid images.", "seoaal" ),
						"param_name" => "image_grid_images",
						"value" => '',
						"group"			=> esc_html__( "Image", "seoaal" ),
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Enable", "seoaal" ),
						"description"	=> esc_html__( "This is option for enable or disable slide.", "seoaal" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode slide items shown on large devices.", "seoaal" ),
						"param_name"	=> "slide_item",
						"value" 		=> "3",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode slide items shown on tab.", "seoaal" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode slide items shown on mobile.", "seoaal" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode slider auto play.", "seoaal" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode slider loop.", "seoaal" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode center, for this option must active loop and minimum items 2.", "seoaal" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode navigation.", "seoaal" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode pagination.", "seoaal" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode margin space.", "seoaal" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode duration.", "seoaal" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode smart speed.", "seoaal" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "seoaal" ),
						"description"	=> esc_html__( "This is option for image gird shortcode scroll by.", "seoaal" ),
						"param_name"	=> "slide_slideby",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_image_grid_shortcode_map" );