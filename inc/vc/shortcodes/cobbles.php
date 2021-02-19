<?php 
/**
 * Seoaal Cobbles
 */
if ( ! function_exists( "seoaal_vc_cobbles_shortcode" ) ) {
	function seoaal_vc_cobbles_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_cobbles", $atts );
		extract( $atts );
		$output = '';
		//Variable define
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$layout = isset( $cobbles_layout ) && $cobbles_layout != '' ? $cobbles_layout : 'classic';
		$excerpt_len = isset( $excerpt_len ) && $excerpt_len != '' ? $excerpt_len : 10;
		add_filter( 'excerpt_length', __return_value( $excerpt_len ) );
		
		$overlay_items = $overlay_class = '';		
		if( isset( $cobbles_overlay_opt ) && $cobbles_overlay_opt == 'enable' ){
			$overlay_items = isset( $overlay_cobbles_items ) ? seoaal_drag_and_drop_trim( $overlay_cobbles_items ) : array( 'Enabled' => '' );
			$overlay_class .= isset( $overlay_text_align ) && $overlay_text_align != 'default' ? ' text-' . $overlay_text_align : '';
			$overlay_class .= isset( $cobbles_overlay_position ) ? ' overlay-'.$cobbles_overlay_position : ' overlay-center';
		}
		
		$thumb_class = $overlay_items ? ' cobbles-overlay-wrap' : '';

		$zoom_icon_opt = isset( $zoom_icon_opt ) ? $zoom_icon_opt : '';
		$link_icon_opt = isset( $link_icon_opt ) ? $link_icon_opt : '';
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . ' .cobbles-wrap { color: '. esc_attr( $font_color ) .'; }' : '';
		$shortcode_css .= isset( $link_color ) && $link_color != '' ? '.' . esc_attr( $rand_class ) . ' .cobbles-wrap a { color: '. esc_attr( $link_color ) .'; }' : '';
		$shortcode_css .= isset( $link_hcolor ) && $link_hcolor != '' ? '.' . esc_attr( $rand_class ) . ' .cobbles-wrap a:hover { color: '. esc_attr( $link_hcolor ) .'; }' : '';
		if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
		//Query Start
		global $wp_query;
		$paged = 1;
		if( get_query_var('paged') ){
			$paged = esc_attr( get_query_var('paged') );
		}elseif( get_query_var('page') ){
			$paged = esc_attr( get_query_var('page') );
		}
		
		if( $layout == 'classic' ){
			$ppp = 5;
			$thumb_array = array( 
				array( 600, 600 ),
				array( 300, 300 ),
				array( 300, 300 ),
				array( 300, 300 ),
				array( 300, 300 )
			);
			$class_names .= ' cobbles-classis';
		}else{
			$ppp = 8;
			$thumb_array = array( 
				array( 600, 600 ),
				array( 600, 300 ),
				array( 300, 300 ),
				array( 300, 300 ),
				array( 600, 300 ),
				array( 600, 600 ),
				array( 300, 300 ),
				array( 300, 300 )				
			);
			$class_names .= ' cobbles-modern';
		}
		
		$cobbles_array = array(
			'zoom_icon_opt' => $zoom_icon_opt,
			'link_icon_opt' => $link_icon_opt
		);
		
		wp_enqueue_script( 'jquery-magnific' );
		wp_enqueue_style( 'magnific-popup' );
		
		$output = '<div class="cobbles-wrapper image-gallery '. esc_attr( $class_names ) .' clearfix" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
			//Cats In
			$cats_in = array();
			if( isset( $include_cats ) && $include_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $include_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				foreach( $filter as $cat ){
					if( term_exists( $cat, 'portfolio-categories' ) ){
						$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );	
						//post in array push
						if( isset( $cat_term->term_id ) )
							array_push( $cats_in, absint( $cat_term->term_id ) );	
					}
				}
			}
			
			//Cats Not In
			$cats_not_in = array();
			if( isset( $exclude_cats ) && $exclude_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $exclude_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				foreach( $filter as $cat ){
					if( term_exists( $cat, 'cobbles-categories' ) ){
						$cat_term = get_term_by( 'slug', $cat, 'cobbles-categories' );	
						//post not in array push
						if( isset( $cat_term->term_id ) )
							array_push( $cats_not_in, absint( $cat_term->term_id ) );	
					}
				}
			}
			
			$inc_cat_array = $cats_in ? array( 'taxonomy' => 'cobbles-categories', 'field' => 'id', 'terms' => $cats_in ) : '';
			$exc_cat_array = $cats_not_in ? array( 'taxonomy' => 'cobbles-categories', 'field' => 'id', 'terms' => $cats_not_in, 'operator' => 'NOT IN' ) : '';
			$args = array(
				'post_type' => 'seoaal-portfolio',
				'posts_per_page' => absint( $ppp ),
				'paged' => $paged,
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					$inc_cat_array,
					$exc_cat_array
				)
				
			);
			$query = new WP_Query( $args );
	
			if ( $query->have_posts() ) {
				
				$post_id = '';
				$i = 0;
				// Start the Loop
				while ( $query->have_posts() ) : $query->the_post();
					
					$post_id = get_the_ID();
					$cobbles_array['post_id'] = $post_id;
					
					$output .= '<div class="cobbles-wrap">';
						
						// Thumb
						$output .= '<div class="cobbles-img'. esc_attr( $thumb_class ) .'">';
							if( $overlay_items ){
								$output .= '<div class="cobbles-overlay'. esc_attr( $overlay_class ) .'">';
									if( isset( $overlay_items['Enabled'] ) ) :
										foreach( $overlay_items['Enabled'] as $element => $value ){
											$output .= seoaal_cobbles_shortcode_elements( $element, $cobbles_array );
										}
									endif;
								$output .= '</div><!-- .cobbles-overlay -->';
							}
							$cur_thumb = array( 'thumb_size' => $thumb_array[$i++], 'post_id' => $post_id );
							$output .= seoaal_cobbles_shortcode_elements( 'thumb', $cur_thumb );
						$output .= '</div>';
						
					$output .= '</div><!-- .cobbles-wrap -->';
					
				endwhile;
					 
			} // end of check for query having posts
			
		$output .= '</div><!-- cobbles-wrapper -->';
		
		if( isset( $pagination ) && $pagination == 'on' ){
			$aps = new SeoaalPostSettings;
			$output .= $aps->seoaalWpBootstrapPagination( $args, $query->max_num_pages, false );
		}
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();

		return $output;
	}
}
function seoaal_cobbles_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
		case "title":
			$custom_url = get_post_meta( get_the_ID(), 'seoaal_cobbles_custom_url', true );
			$target = get_post_meta( get_the_ID(), 'seoaal_cobbles_custom_url_target', true );
			$target = $target == '' ? '_self' : $target;
			$title_url = $custom_url != '' ? $custom_url : get_the_permalink();
			$output .= '<div class="cobbles-title">';
				$output .= '<h3><a href="'. esc_url( $title_url ) .'" target="'. esc_attr( $target ) .'">'. esc_html( get_the_title() ) .'</a></h3>';
			$output .= '</div><!-- .cobbles-title -->';
		break;
		
		case "thumb":
			if ( has_post_thumbnail() ) {
				$custom_url = get_post_meta( get_the_ID(), 'seoaal_cobbles_custom_url', true );
				$target = get_post_meta( get_the_ID(), 'seoaal_cobbles_custom_url_target', true );
				$target = $target == '' ? '_self' : $target;
				$title_url = $custom_url != '' ? $custom_url : get_the_permalink();
				
				$thumb_size = $opts['thumb_size'];
				$cus_thumb_size = '';
				
				if( isset( $opts['thumb_size'] ) && is_array( $opts['thumb_size'] ) ){
					$hard_crop = $opts['thumb_size'][1] == 9999 ? false : true;
					$thumb_size = 'custom';
					$cus_thumb_size = $opts['thumb_size'];
				}
							
				$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
				if( $lazy_opt ){
					$img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size );
					$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
					if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
						$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, $hard_crop, absint( $lazy_img['id'] ) );
						$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid post-thumbnail lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_prop[0] ) . '" />';
					}else{
						$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid post-thumbnail lazy-initiate"  alt="'. the_title_attribute(array('echo' => false)) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_prop[0] ) . '" />';
					}
				}else{
					if( isset( $opts['thumb_size'] ) && is_array( $opts['thumb_size'] ) ){
						$hard_crop = $opts['thumb_size'][1] == 9999 ? false : true;
						$cropped_img = aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $opts['thumb_size'][0], $opts['thumb_size'][1], $hard_crop, false );
						if( $cropped_img ){
							$image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
							$image_alt = $image_alt != '' ? $image_alt : get_the_title();
							$output .= '<img class="img-fluid cpt-img" src="'. esc_url( $cropped_img[0] ) .'" width="'. esc_attr( $cropped_img[1] ) .'" height="'. esc_attr( $cropped_img[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />';
						}else{
							$output .= get_the_post_thumbnail( $opts['post_id'], $opts['thumb_size'], array( 'class' => 'img-fluid' ) );
						}
					}else{	
						$output .= get_the_post_thumbnail( $opts['post_id'], $opts['thumb_size'], array( 'class' => 'img-fluid' ) );
					}
				}
				
				

			}
		break;
		
		case "category":
			$terms = get_the_terms( $opts['post_id'], 'portfolio-categories' );
			if ( $terms && ! is_wp_error( $terms ) ) : 
				$cat_links = array();
				foreach ( $terms as $term ) {
					$cat_links[] = '<span>' . $term->name . '</span>';
				}
				$cats = join( ",", $cat_links );
				$output .= '<div class="cobbles-categories">' . $cats . '</div>';
			endif;
		break;
		
		case "excerpt":
			ob_start();
			the_excerpt();	
			$output .= ob_get_clean();		
		break;
		
		case "icons":
			$output .= '<div class="cobbles-icons">';
				$output .= '<p>';
					if( isset( $opts['zoom_icon_opt'] ) && $opts['zoom_icon_opt'] == "on" ){
						$output .= '<a href="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) .'" class="image-gallery-link zoom-icon"><i class="icon-magnifier-add"></i></a>';
					}
					$custom_url = get_post_meta( get_the_ID(), 'seoaal_cobbles_custom_url', true );
					$target = get_post_meta( get_the_ID(), 'seoaal_cobbles_custom_url_target', true );
					$target = $target == '' ? '_self' : $target;
					$title_url = $custom_url != '' ? $custom_url : get_the_permalink();
					if( isset( $opts['link_icon_opt'] ) && $opts['link_icon_opt'] == "on" ){
						$output .= '<a href="'. esc_url( $title_url ) .'" class="link-icon" target="'. esc_attr( $target ) .'"><i class="icon-link"></i></a>';
					}
				$output .= '</p>';
			$output .= '</div><!-- .cobbles-icons -->';		
		break;
	}
	return $output; 
}

if ( ! function_exists( "seoaal_vc_cobbles_shortcode_map" ) ) {
	function seoaal_vc_cobbles_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Cobbles", "seoaal" ),
				"description"			=> esc_html__( "Portfolio unequal grids.", "seoaal" ),
				"base"					=> "seoaal_vc_cobbles",
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
						"heading"		=> esc_html__( "Excerpt Length", "seoaal" ),
						"description"	=> esc_html__( "Here you can set length of excerpt text", "seoaal" ),
						"param_name"	=> "excerpt_len",
						"value" 		=> "10",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Include Categories", "seoaal" ),
						"description"	=> esc_html__( "This is filter categories. If you don't want cobbles filter, then leave this empty. Example slug: travel, web", "seoaal" ),
						"param_name"	=> "include_cats",
						"value" 		=> "",
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Exclude Categories", "seoaal" ),
						"description"	=> esc_html__( "Here you can mention unwanted categories. Example slug: travel, web", "seoaal" ),
						"param_name"	=> "exclude_cats",
						"value" 		=> "",
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "seoaal" ),
						"description"	=> esc_html__( "This is option for pagination show or hide.", "seoaal" ),
						"param_name"	=> "pagination",
						"value"			=> "off"
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Cobbles Layout", "seoaal" ),
						"description"	=> esc_html__( "Choose cobbles layout normal grid( images or must be equal size ), fit row grid, masonry or list.", "seoaal" ),
						"param_name"	=> "cobbles_layout",
						"value"			=> array(
							esc_html__( "Classic", "seoaal" )	=> "classic",
							esc_html__( "Modern", "seoaal" )	=> "modern",
						),
						"default"		=> "classic",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Zoom Icon", "seoaal" ),
						"description"	=> esc_html__( "This is option for show or hide zoom icon to your choosed layout.", "seoaal" ),
						"param_name"	=> "zoom_icon_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "External Link Icon", "seoaal" ),
						"description"	=> esc_html__( "This is option for show or hide zoom icon to your choosed layout.", "seoaal" ),
						"param_name"	=> "link_icon_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Cobbles Option", "seoaal" ),
						"description"	=> esc_html__( "This is option for enable overlay cobbles option.", "seoaal" ),
						"param_name"	=> "cobbles_overlay_opt",
						"value"			=> array(
							esc_html__( "Disable", "seoaal" )	=> "disable",
							esc_html__( "Enable", "seoaal" )	=> "enable"
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Items Position", "seoaal" ),
						"description"	=> esc_html__( "This is option for overlay items position.", "seoaal" ),
						"param_name"	=> "cobbles_overlay_position",
						"value"			=> array(
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Top Left", "seoaal" )	=> "top-left",
							esc_html__( "Top Right", "seoaal" )	=> "top-right",
							esc_html__( "Bottom Left", "seoaal" )	=> "bottom-left",
							esc_html__( "Bottom Right", "seoaal" )	=> "bottom-right",
						),
						'dependency' => array(
							'element' => 'cobbles_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is option for cobbles text align", "seoaal" ),
						"param_name"	=> "overlay_text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						'dependency' => array(
							'element' => 'cobbles_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Overlay Cobbles Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for cobbles custom layout. here you can set your own layout. Drag and drop needed cobbles items to Enabled part.", "seoaal" ),
						'param_name'	=> 'overlay_cobbles_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'category'	=> esc_html__( 'Category', 'seoaal' )
							),
							'disabled' => array(
								'icons'	=> esc_html__( 'Icons', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' )
							)
						),
						'dependency' => array(
							'element' => 'cobbles_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Font Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can choose font color.", "seoaal" ),
						"param_name"	=> "font_color",
						"group"			=> esc_html__( "Color Settings", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Link Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can choose link color.", "seoaal" ),
						"param_name"	=> "link_color",
						"group"			=> esc_html__( "Color Settings", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Link Hover Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can choose link hover color.", "seoaal" ),
						"param_name"	=> "link_hcolor",
						"group"			=> esc_html__( "Color Settings", "seoaal" )
					)
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_cobbles_shortcode_map" );