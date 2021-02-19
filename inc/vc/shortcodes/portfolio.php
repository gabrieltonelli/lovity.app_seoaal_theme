<?php 
/**
 * Seoaal Portfolio
 */
if ( ! function_exists( "seoaal_vc_portfolio_shortcode" ) ) {
	function seoaal_vc_portfolio_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_portfolio", $atts );
		extract( $atts );
		$output = '';
		//Variable define
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$class_names .= isset( $article_align ) && $article_align != 'default' ? ' text-' . $article_align : '';
		$cols = isset( $grid_cols ) && $grid_cols != '' ? $grid_cols : 2;
		$gutter = isset( $grid_gutter ) && $grid_gutter != '' ? $grid_gutter : 20;		
		$layout = isset( $portfolio_layout ) && $portfolio_layout != '' ? $portfolio_layout : 2; 
		$infinite = isset( $infinite ) && $infinite == 'on' ? "true" : "false";
		$thumb_size = $image_alt = $cropped_img = '';
		$animate_load = isset( $animate_load ) && $animate_load == 'on' ? true : false;
		$title_head = isset( $title_head ) ? $title_head : 'h4';
		
		$portfolio_items = isset( $portfolio_items ) ? seoaal_drag_and_drop_trim( $portfolio_items ) : array( 'Enabled' => '' ); 
		
		$overlay_items = $overlay_class = '';		
		if( isset( $portfolio_overlay_opt ) && $portfolio_overlay_opt == 'enable' ){
			$overlay_items = isset( $overlay_portfolio_items ) ? seoaal_drag_and_drop_trim( $overlay_portfolio_items ) : array( 'Enabled' => '' );
			$overlay_class .= isset( $overlay_text_align ) && $overlay_text_align != 'default' ? ' text-' . $overlay_text_align : '';
			$overlay_class .= isset( $portfolio_overlay_position ) ? ' overlay-'.$portfolio_overlay_position : ' overlay-center';
		}
		
		$thumb_class = $overlay_items ? ' portfolio-overlay-wrap' : '';
		
		$filter_opt = isset( $filter_opt ) ? $filter_opt : '';
		$zoom_icon_opt = isset( $zoom_icon_opt ) ? $zoom_icon_opt : '';
		$link_icon_opt = isset( $link_icon_opt ) ? $link_icon_opt : '';
		$excerpt_length = isset( $excerpt_length ) ? $excerpt_length : 10;
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . ' .portfolio-wrap { color: '. esc_attr( $font_color ) .'; }' : '';
		$shortcode_css .= isset( $link_color ) && $link_color != '' ? '.' . esc_attr( $rand_class ) . ' .portfolio-wrap a { color: '. esc_attr( $link_color ) .'; }' : '';
		$shortcode_css .= isset( $link_hcolor ) && $link_hcolor != '' ? '.' . esc_attr( $rand_class ) . ' .portfolio-wrap a:hover { color: '. esc_attr( $link_hcolor ) .'!important; }' : '';
			//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '.' . esc_attr( $rand_class ) . '.portfolio-wrapper .portfolio-content-wrap >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
		$thumb_size = isset( $image_size ) ? $image_size : '';
		$cus_thumb_size = '';
		if( $thumb_size == 'custom' ){
			$cus_thumb_size = isset( $custom_image_size ) && $custom_image_size != '' ? $custom_image_size : '';
		}
		
		//Query Start
		global $wp_query;
		$paged = 1;
		if( get_query_var('paged') ){
			$paged = esc_attr( get_query_var('paged') );
		}elseif( get_query_var('page') ){
			$paged = esc_attr( get_query_var('page') );
		}
		
		if( isset( $slide_opt ) && $slide_opt == 'on' ){
			
			$class_names .= isset( $article_style ) ? ' portfolio-' . $article_style : '';
						
			$gal_atts = array(
				'data-loop="'. ( isset( $slide_item_loop ) && $slide_item_loop == 'on' ? 1 : 0 ) .'"',
				'data-margin="'. ( isset( $slide_margin ) && $slide_margin != '' ? absint( $slide_margin ) : 0 ) .'"',
				'data-center="'. ( isset( $slide_center ) && $slide_center == 'on' ? 1 : 0 ) .'"',
				'data-nav="'. ( isset( $slide_nav ) && $slide_nav == 'on' ? 1 : 0 ) .'"',
				'data-dots="'. ( isset( $slide_dots ) && $slide_dots == 'on' ? 1 : 0 ) .'"',
				'data-autoplay="'. ( isset( $slide_item_autoplay ) && $slide_item_autoplay == 'on' ? 1 : 0 ) .'"',
				'data-items="'. ( isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 2 ) .'"',
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
			
			$cols = isset( $slide_item ) && $slide_item != '' ? absint( $slide_item ) : 2;
			$slide_img_layout = isset( $slide_img_layout ) ? $slide_img_layout : 'normal';
			$class_names .= $cols == 1 ? ' owl-single-item' : '';
			
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
					if( term_exists( $cat, 'portfolio-categories' ) ){
						$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );
						//post not in array push
						if( isset( $cat_term->term_id ) )
							array_push( $cats_not_in, absint( $cat_term->term_id ) );	
					}
				}
			}
			$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 2;
			$inc_cat_array = $cats_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_in ) : '';
			$exc_cat_array = $cats_not_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_not_in, 'operator' => 'NOT IN' ) : '';
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
			
			$event = isset( $image_event ) ? $image_event : 'popup';
			$thumb_array = array(
				'layout'		=> $layout,
				'event'			=> $event,
				'thumb_size' => $thumb_size,
				'cus_thumb_size' => $cus_thumb_size
			);
				
			$portfolio_array = array(
				'excerpt_length'=> $excerpt_length,
				'zoom_icon_opt' => $zoom_icon_opt,
				'link_icon_opt' => $link_icon_opt,
				'title_head' => $title_head
			);
			
			if ( $query->have_posts() ) {
				
				wp_enqueue_script( 'jquery-magnific' );
				wp_enqueue_style( 'magnific-popup' );
				
				$output .= '<div class="portfolio-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
					$output .= '<div class="owl-carousel portfolio-slide image-gallery" '. ( $data_atts ) .'>';
						while ( $query->have_posts() ) : $query->the_post();
							
							$post_id = get_the_ID();
							$thumb_array['post_id'] = $post_id;
							$portfolio_array['post_id'] = $post_id;
							
							$portfolio_rand_class = 'single-portfolio-rand-' . $post_id;
							$prim_color = get_post_meta( $post_id, 'seoaal_portfolio_primary_color', true );
							$portfolio_css = '';
							if( $prim_color ){
								$portfolio_css = '.portfolio-default .' . $portfolio_rand_class . ':hover .portfolio-overlay { background-color: '. esc_attr( $prim_color ) .'}';
							}
							if( $portfolio_css ) $portfolio_rand_class .= ' ' . $portfolio_rand_class . ' seoaal-inline-css';
							
							$output .= '<div class="item">';
								$output .= '<div class="portfolio-wrap '. esc_attr( $portfolio_rand_class ) .'" data-css="'. htmlspecialchars( json_encode( $portfolio_css ), ENT_QUOTES, 'UTF-8' ) .'">';
									if( $layout == '4' ) $output .= '<div class="media">';
									
									// Thumb
									$output .= '<div class="portfolio-img'. esc_attr( $thumb_class ) .'">';
										if( $overlay_items ){
											$output .= '<div class="portfolio-overlay'. esc_attr( $overlay_class ) .'">';
												if( isset( $overlay_items['Enabled'] ) ) :
													foreach( $overlay_items['Enabled'] as $element => $value ){
														$output .= seoaal_portfolio_shortcode_elements( $element, $portfolio_array );
													}
												endif;
											$output .= '</div><!-- .portfolio-overlay -->';
										}
										$output .= seoaal_portfolio_shortcode_elements( 'thumb', $thumb_array );
									$output .= '</div>';
									
									if( $layout == '4' ) $output .= '<div class="media-body">';
									
									if( isset( $portfolio_items['Enabled'] ) && !empty( $portfolio_items['Enabled'] ) ) :
										$output .= '<div class="portfolio-content-wrap">';
											foreach( $portfolio_items['Enabled'] as $element => $value ){
												$output .= seoaal_portfolio_shortcode_elements( $element, $portfolio_array );
											}
										$output .= '</div><!-- .portfolio-content-wrap -->';	
									endif;
									
									if( $layout == '4' ) $output .= '</div><!-- .media-body --></div><!-- .media -->';
											
								$output .= '</div><!-- .portfolio-wrap -->';
							$output .= '</div><!-- .item -->';
						endwhile;
					$output .= '</div><!-- .owl-carousel -->';
				$output .= '</div><!-- .portfolio-wrapper -->';
				
			}
			wp_reset_postdata();
			//Query End
			
			
			//if slide end
			
		}else{			
			
			//IF Filter Enable
			$filter_stat = 0;
			$filter_first_cat = '';
			$cats_in = array();
			if( isset( $include_cats ) && $include_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $include_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				if( $filter ):
					$filter_model = isset( $filter_layout ) ? $filter_layout : '1';
					
					$filter_ul_class = isset( $filter_align ) && $filter_align != 'default' ? ' text-' . $filter_align : '';
					
					$filter_all = isset( $filter_all ) && $filter_all != '' ? $filter_all : '';
					if( $filter_all ){
						$filter_stat = 1;
					}
					
					$output .= '<div class="portfolio-filter filter-'. esc_attr( $filter_model ) .'">';
						$output .= '<ul class="nav m-auto d-block'. esc_attr( $filter_ul_class ) .'">';
							
							$output .= $filter_all != '' ? '<li class="active"><a href="#" class="portfolio-filter-item">'. esc_html( $filter_all ) .'</a></li>' : '';
							$c = 1; // Checksum for first category
							foreach( $filter as $cat ){
								if( term_exists( $cat, 'portfolio-categories' ) ){
								
									$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );
									$term_id = isset( $cat_term->term_id ) ? $cat_term->term_id : '';
									$term_name = isset( $cat_term->name ) ? $cat_term->name : '';
									if( $term_id ){
										array_push( $cats_in, absint( $cat_term->term_id ) );
										$output .= '<li><a href="#" class="portfolio-filter-item" data-filter=".portfolio-filter-'. esc_attr( absint( $cat_term->term_id ) ) .'">'. esc_html( $cat_term->name ) .'</a></li>';
										if( $c && $filter_all == '' ){
											$filter_first_cat = $cat;
											$c = 0;
										}
										
									}
								}
							}
						$output .= '</ul>';
					$output .= '</div><!-- .portfolio-filter -->';
				endif;
			}
			
			$output = isset( $filter_opt ) && $filter_opt == 'on' ? '<div class="portfolio-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">' . $output : '<div class="portfolio-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
			
			//Cats Not In
			$cats_not_in = array();
			if( isset( $exclude_cats ) && $exclude_cats != '' ){
				$filter = preg_replace( '/\s+/', '', $exclude_cats );
				$filter = explode( ',', rtrim( $filter, ',' ) );
				foreach( $filter as $cat ){
					if( term_exists( $cat, 'portfolio-categories' ) ){
						$cat_term = get_term_by( 'slug', $cat, 'portfolio-categories' );	
						//post not in array push
						if( isset( $cat_term->term_id ) )
							array_push( $cats_not_in, absint( $cat_term->term_id ) );	
					}
				}
			}
			
			$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 2;
			
			$inc_cat_array = $cats_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_in ) : '';
			$exc_cat_array = $cats_not_in ? array( 'taxonomy' => 'portfolio-categories', 'field' => 'id', 'terms' => $cats_not_in, 'operator' => 'NOT IN' ) : '';
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
				
				$chk = $isotope_stat = 1;
				$post_id = '';
				
				$layout_mode = $layout != 3 && $layout != 4 ? 'fitRows' : 'masonry';
				
				$portfolio_class = '';
				$portfolio_class .= $layout != 4 ? 'grid-layout' : '';
				
				if( $layout == '2' ){
					$portfolio_class .= ' portfolio-fitrow-layout';
				}elseif( $layout == '3' ){
					$portfolio_class .= ' portfolio-masonry-layout';
				}elseif( $layout == '1' ){
					$portfolio_class .= ' portfolio-grid-layout';
				}else{
					$portfolio_class .= ' portfolio-list-layout';
				}
				
				if( $layout != '4' ){
					wp_enqueue_script( 'isotope-pkgd' );
					wp_enqueue_script( 'infinite-scroll' );
					wp_enqueue_script( 'imagesloaded' );
				}
				
				wp_enqueue_script( 'jquery-magnific' );
				wp_enqueue_style( 'magnific-popup' );
				
				$output .= '<div class="image-gallery '. esc_attr( $portfolio_class ) .'" style="margin-bottom: -'. esc_attr( $gutter ) .'px;" data-filter-stat="'. esc_attr( $filter_stat ) .'" data-first-cat="'. esc_attr( $filter_first_cat ) .'">';
					$output .= $layout != '4' ? '<div class="isotope" data-cols="'. esc_attr( $cols ) .'" data-gutter="'. esc_attr( $gutter ) .'" data-layout="'. esc_attr( $layout_mode ) .'" data-infinite="'. esc_attr( $infinite ) .'">' : '';
					
				$event = isset( $image_event ) ? $image_event : 'popup';
				$thumb_array = array(
					'layout'		=> $layout,
					'event'			=> $event,
					'thumb_size' => $thumb_size,
					'cus_thumb_size' => $cus_thumb_size
				);
				$portfolio_array = array(
					'excerpt_length'=> $excerpt_length,
					'zoom_icon_opt' => $zoom_icon_opt,
					'link_icon_opt' => $link_icon_opt,
					'title_head' => $title_head
				);
				
				$row_stat = 0;
	
				// Start the Loop
				while ( $query->have_posts() ) : $query->the_post();
					
					$post_id = get_the_ID();
					$thumb_array['post_id'] = $post_id;
					$portfolio_array['post_id'] = $post_id;
					
					$inner_class = 'vc-portfolio';
					
					$inner_class .= isset( $article_style ) ? ' portfolio-' . $article_style : '';
					
					//Filter Class Arrange
					if( isset( $include_cats ) && $include_cats != '' ){
						$cat_class = '';
						$terms = get_the_terms( $post_id, 'portfolio-categories' );
						if ( $terms && ! is_wp_error( $terms ) ) : 
							foreach ( $terms as $term ) {
								$cat_class .= ' portfolio-filter-' . $term->term_id;
							}
							$inner_class .= $cat_class;
						endif;
					}
					
					$inner_class .= $animate_load ? ' seoaal-animate' : '';
					
					if( $layout == '4' ){
						if( $row_stat == 0 ){
							$output .= '<div class="row">';
						}
						$col_class = $cols != '' ? "col-md-". absint( 12 / absint( $cols ) ) : 'col-md-12';
						$output .= '<div class="'. esc_attr( $col_class ) .'">';
					}
					
					$output .= '<article id="post-'. esc_attr( $post_id ) .'" class="'. esc_attr( $inner_class ) .'">';
					
						$portfolio_rand_id = 'single-portfolio-rand-' . $post_id;
						$prim_color = get_post_meta( $post_id, 'seoaal_portfolio_primary_color', true );
						$portfolio_css = $portfolio_rand_class = '';
						if( $prim_color ){
							$portfolio_css = '.portfolio-default .' . $portfolio_rand_id . ' .portfolio-overlay { background-color: '. esc_attr( $prim_color ) .'}';
						}
						if( $portfolio_css ) $portfolio_rand_class .= ' ' . $portfolio_rand_id . ' seoaal-inline-css';
					
						$output .= '<div class="portfolio-wrap'. esc_attr( $portfolio_rand_class ) .'" data-css="'. htmlspecialchars( json_encode( $portfolio_css ), ENT_QUOTES, 'UTF-8' ) .'">';
						
							if( $layout == '4' ) $output .= '<div class="media">';
							
							// Thumb
							$output .= '<div class="portfolio-img'. esc_attr( $thumb_class ) .'">';
								if( $overlay_items ){
									$output .= '<div class="portfolio-overlay'. esc_attr( $overlay_class ) .'">';
										if( isset( $overlay_items['Enabled'] ) ) :
											foreach( $overlay_items['Enabled'] as $element => $value ){
												$output .= seoaal_portfolio_shortcode_elements( $element, $portfolio_array );
											}
										endif;
									$output .= '</div><!-- .portfolio-overlay -->';
								}
								$output .= seoaal_portfolio_shortcode_elements( 'thumb', $thumb_array );
							$output .= '</div>';
							
							if( $layout == '4' ) $output .= '<div class="media-body">';
							
							if( isset( $portfolio_items['Enabled'] ) && !empty( $portfolio_items['Enabled'] ) ) :
								$output .= '<div class="portfolio-content-wrap">';
									foreach( $portfolio_items['Enabled'] as $element => $value ){
										$output .= seoaal_portfolio_shortcode_elements( $element, $portfolio_array );
									}
								$output .= '</div><!-- .portfolio-content-wrap -->';
							endif;
								
							if( $layout == '4' ) $output .= '</div><!-- .media-body --></div><!-- .media -->';
							
						$output .= '</div><!-- .portfolio-wrap -->';

					$output .= '</article>';
					
					$chk++;
					
					if( $layout == '4' ){
						$output .= '</div><!-- .col -->';
						$row_stat++;
						if( $row_stat == ( 12/ $cols ) ) :
							$output .= '</div><!-- .row -->';
							$row_stat = 0;
						endif;
					}
					
				endwhile;
				
					if( $row_stat != 0 && $layout == '4' ){
						$output .= '</div><!-- .row -->'; // Unexpected row close
					}
	
					$output .= $layout != '4' ? '</div><!-- .isotope -->' : '';
				$output .= '</div><!-- .grid-layout -->';
					 
			} // end of check for query having posts
			
			$output .= '</div><!-- portfolio-wrapper -->';
			
			if( $infinite == "true" ){
				$output .= '<div class="infinite-load">';
					$aps = new SeoaalPostSettings;
					$output .= $aps->seoaalWpBootstrapPagination( $args, $query->max_num_pages, false );
				$output .= '</div><!-- infinite-load -->';
			}elseif( isset( $pagination ) && $pagination == 'on' ){
				$aps = new SeoaalPostSettings;
				$output .= $aps->seoaalWpBootstrapPagination( $args, $query->max_num_pages, false );
			}
			// use reset postdata to restore orginal query
			wp_reset_postdata();
		} // if slide not elable
		return $output;
	}
}
function seoaal_portfolio_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
		case "title":
			$title_head = isset( $opts['title_head'] ) ? $opts['title_head'] : 'h4';
			$custom_url = get_post_meta( get_the_ID(), 'seoaal_portfolio_custom_url', true );
			$target = get_post_meta( get_the_ID(), 'seoaal_portfolio_custom_url_target', true );
			$target = $target == '' ? '_self' : $target;
			$title_url = $custom_url != '' ? $custom_url : get_the_permalink();
			$output .= '<div class="portfolio-title">';
				$output .= '<'. esc_attr( $title_head ) .'>';
				$output .= '<a href="'. esc_url( $title_url ) .'">'. get_the_title() .'</a>';
				$output .= '</'. esc_attr( $title_head ) .'>';
			$output .= '</div><!-- .portfolio-title -->';
		break;
		
		case "thumb":
			if ( has_post_thumbnail() ) {
			
				// Custom Thumb Code
				$thumb_size = $thumb_cond = $opts['thumb_size'];
				$cus_thumb_size = $opts['cus_thumb_size'];
				$custom_opt = $img_prop = '';
				if( $thumb_cond == 'custom' ){
					$custom_opt = $cus_thumb_size != '' ? explode( "x", $cus_thumb_size ) : array();
					$hard_crop = isset( $custom_opt[1] ) && $custom_opt[1] == 9999 ? false : true;
					$img_prop = seoaal_custom_image_size_chk( $thumb_size, $custom_opt, $hard_crop );
					$thumb_size = array( $img_prop[1], $img_prop[2] );
				} 
				// Custom Thumb Code End
			
				$custom_url = get_post_meta( get_the_ID(), 'seoaal_portfolio_custom_url', true );
				$target = get_post_meta( get_the_ID(), 'seoaal_portfolio_custom_url_target', true );
				$target = $target == '' ? '_self' : $target;
				$title_url = $custom_url != '' ? $custom_url : get_the_permalink();
				$output .= $opts['event'] == 'popup' ? '<a href="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) .'" class="image-gallery-link">' : '<a href="'. esc_url( $title_url ) .'" target="'. esc_attr( $target ) .'">';
				
					$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
					if( $lazy_opt ){
						$img_prop = $img_prop ? $img_prop : seoaal_custom_image_size_chk( $thumb_size, $custom_opt );
						$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
						if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
							$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $custom_opt, true, absint( $lazy_img['id'] ) );
							$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid post-thumbnail lazy-initiate cpt-img"  alt="'. the_title_attribute(array('echo' => false)) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_prop[0] ) . '" />';
						}else{
							$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid post-thumbnail lazy-initiate cpt-img"  alt="'. the_title_attribute(array('echo' => false)) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_prop[0] ) . '" />';
						}
					}else{
						if( $thumb_cond == 'custom' ){
							$output .= '<img height="'. esc_attr( $img_prop[2] ) .'" width="'. esc_attr( $img_prop[1] ) .'" class="img-fluid cpt-img"  alt="'. the_title_attribute(array('echo' => false)) .'" src="' . esc_url( $img_prop[0] ) . '"/>';
						}else{
							$output .= get_the_post_thumbnail( $opts['post_id'], $thumb_size, array( 'class' => 'img-fluid cpt-img' ) );
						}
					}
					
				$output .= '</a>';
			}
		break;
		
		case "category":
			$terms = get_the_terms( $opts['post_id'], 'portfolio-categories' );
			if ( $terms && ! is_wp_error( $terms ) ) : 
				$cat_links = array();
				foreach ( $terms as $term ) {
					$cat_links[] = '<span>' . $term->name . '</span>';
				}
				$cats = join( $cat_links );
				$output .= '<div class="portfolio-categories">' . $cats . '</div>';
			endif;
		break;
		
		case "excerpt":
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="portfolio-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .portfolio-excerpt -->';
		break;
		
		case "icons":
			$output .= '<div class="portfolio-icons">';
				$output .= '<p>';
					if( isset( $opts['zoom_icon_opt'] ) && $opts['zoom_icon_opt'] == "on" ){
						$output .= '<a href="'. esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) .'" class="image-gallery-link zoom-icon"><i class="icon-magnifier-add"></i></a>';
					}
					$custom_url = get_post_meta( get_the_ID(), 'seoaal_portfolio_custom_url', true );
					$target = get_post_meta( get_the_ID(), 'seoaal_portfolio_custom_url_target', true );
					$target = $target == '' ? '_self' : $target;
					$title_url = $custom_url != '' ? $custom_url : get_the_permalink();
					if( isset( $opts['link_icon_opt'] ) && $opts['link_icon_opt'] == "on" ){
						$output .= '<a href="'. esc_url( $title_url ) .'" class="link-icon" target="'. esc_attr( $target ) .'"><i class="icon-link"></i></a>';
					}
				$output .= '</p>';
			$output .= '</div><!-- .portfolio-icons -->';		
		break;
	}
	return $output; 
}
if ( ! function_exists( "seoaal_vc_portfolio_shortcode_map" ) ) {
	function seoaal_vc_portfolio_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Portfolio", "seoaal" ),
				"description"			=> esc_html__( "Portfolio custom post type.", "seoaal" ),
				"base"					=> "seoaal_vc_portfolio",
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
						"heading"		=> esc_html__( "Include Categories", "seoaal" ),
						"description"	=> esc_html__( "This is filter categories. If you don't want portfolio filter, then leave this empty. Example slug: travel, web", "seoaal" ),
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
						"description"	=> esc_html__( "This is an option for pagination show or hide.", "seoaal" ),
						"param_name"	=> "pagination",
						"value"			=> "off"
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Infinite Load", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio infinite load.", "seoaal" ),
						"param_name"	=> "infinite",
						"value"			=> "off"
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Animate Load", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio articles animate load.", "seoaal" ),
						"param_name"	=> "animate_load",
						"value"			=> "off"
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
						"std"		=> "h3",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Portfolio Layout", "seoaal" ),
						"description"	=> esc_html__( "Choose portfolio layout normal grid( images or must be equal size ), fit row grid, masonry or list.", "seoaal" ),
						"param_name"	=> "portfolio_layout",
						"value"			=> array(
							esc_html__( "Normal Gird", "seoaal" )=> "1",
							esc_html__( "Fit Row", "seoaal" )=> "2",
							esc_html__( "Masonry", "seoaal" )=> "3",
							esc_html__( "List", "seoaal" )=> "4"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Choose Filter Layout", "seoaal" ),
						"description"	=> esc_html__( "Choose portfolio filter layout. Filter only active when you will categories.", "seoaal" ),
						"param_name"	=> "filter_layout",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "1",
							esc_html__( "Classic", "seoaal" )	=> "2",
							esc_html__( "Modern", "seoaal" )	=> "3"
						),
						"std"		=> "2",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Filter Align", "seoaal" ),
						"param_name"	=> "filter_align",
						"description"	=> esc_html__( "This is an option for filter alignment style.", "seoaal" ),
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Grid Columns", "seoaal" ),
						"description"	=> esc_html__( "How many grid columns to show. Example 3", "seoaal" ),
						"param_name"	=> "grid_cols",
						"value"			=> array(
							esc_html__( "2 Columns", "seoaal" )	=> "2",
							esc_html__( "3 Columns", "seoaal" )	=> "3",
							esc_html__( "4 Columns", "seoaal" )	=> "4"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Gutter Size", "seoaal" ),
						"description"	=> esc_html__( "This is setting for grid column inter spacing. Example 20", "seoaal" ),
						"param_name"	=> "grid_gutter",
						"value" 		=> "20",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Filter All", "seoaal" ),
						"description"	=> esc_html__( "If need filter all tab, just fill the text box needed text to show instead of All text. If you leave this box blank, then all tab will disappear.", "seoaal" ),
						"param_name"	=> "filter_all",
						"value" 		=> "All",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Article Align", "seoaal" ),
						"param_name"	=> "article_align",
						"description"	=> esc_html__( "This is an option for article alignment style.", "seoaal" ),
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Article Style", "seoaal" ),
						"param_name"	=> "article_style",
						"description"	=> esc_html__( "This is an option for article style. Different article template.", "seoaal" ),
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Classic", "seoaal" )	=> "classic",
							esc_html__( "Creative", "seoaal" )	=> "creative",
							esc_html__( "Minimal", "seoaal" )	=> "minimal",
							esc_html__( "Angle", "seoaal" )	=> "angle"						
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Image Click Event", "seoaal" ),
						"param_name"	=> "image_event",
						"description"	=> esc_html__( "This is an option for pop up image or redirect to sigle portfolio.", "seoaal" ),
						"value"			=> array(
							esc_html__( "Pop Up", "seoaal" )	=> "popup",
							esc_html__( "Single Portfolio", "seoaal" )	=> "single"				
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Filter Hide/Show", "seoaal" ),
						"description"	=> esc_html__( "This is an option for show or hide filter.", "seoaal" ),
						"param_name"	=> "filter_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Zoom Icon", "seoaal" ),
						"description"	=> esc_html__( "This is an option for show or hide zoom icon to your choosed layout.", "seoaal" ),
						"param_name"	=> "zoom_icon_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "External Link Icon", "seoaal" ),
						"description"	=> esc_html__( "This is an option for show or hide zoom icon to your choosed layout.", "seoaal" ),
						"param_name"	=> "link_icon_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Portfolio Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for portfolio custom layout. here you can set your own layout. Drag and drop needed portfolio items to Enabled part.", "seoaal" ),
						'param_name'	=> 'portfolio_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'category'	=> esc_html__( 'Category', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' )
							),
							'disabled' => array(
								'icons'	=> esc_html__( 'Icons', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Portfolio Option", "seoaal" ),
						"description"	=> esc_html__( "This is an option for enable overlay portfolio option.", "seoaal" ),
						"param_name"	=> "portfolio_overlay_opt",
						"value"			=> array(
							esc_html__( "Disable", "seoaal" )	=> "disable",
							esc_html__( "Enable", "seoaal" )	=> "enable"
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Items Position", "seoaal" ),
						"description"	=> esc_html__( "This is an option for overlay items position.", "seoaal" ),
						"param_name"	=> "portfolio_overlay_position",
						"value"			=> array(
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Top Left", "seoaal" )	=> "top-left",
							esc_html__( "Top Right", "seoaal" )	=> "top-right",
							esc_html__( "Bottom Left", "seoaal" )	=> "bottom-left",
							esc_html__( "Bottom Right", "seoaal" )	=> "bottom-right",
						),
						'dependency' => array(
							'element' => 'portfolio_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio text align", "seoaal" ),
						"param_name"	=> "overlay_text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						'dependency' => array(
							'element' => 'portfolio_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Overlay Portfolio Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for portfolio custom layout. here you can set your own layout. Drag and drop needed portfolio items to Enabled part.", "seoaal" ),
						'param_name'	=> 'overlay_portfolio_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'category'	=> esc_html__( 'Category', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' )
							),
							'disabled' => array(
								'icons'	=> esc_html__( 'Icons', 'seoaal' )
							)
						),
						'dependency' => array(
							'element' => 'portfolio_overlay_opt',
							'value' => 'enable',
						),
						"group"			=> esc_html__( "Article", "seoaal" )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Image Size", "seoaal" ),
						"param_name"	=> "image_size",
						'description'	=> esc_html__( 'Choose thumbnail size for display different size image.', 'seoaal' ),
						"value"			=> array(
							esc_html__( "Grid Large", "seoaal" )=> "seoaal-grid-large",
							esc_html__( "Grid Medium", "seoaal" )=> "seoaal-grid-medium",
							esc_html__( "Grid Small", "seoaal" )=> "seoaal-grid-small",
							esc_html__( "Medium", "seoaal" )=> "medium",
							esc_html__( "Large", "seoaal" )=> "large",
							esc_html__( "Thumbnail", "seoaal" )=> "thumbnail",
							esc_html__( "Custom", "seoaal" )=> "custom",
						),
						'std'			=> 'newsz_grid_2',
						'group'			=> esc_html__( 'Image', 'seoaal' )
					),
					array(
						'type'			=> 'textfield',
						'heading'		=> esc_html__( 'Custom Image Size', "seoaal" ),
						'param_name'	=> 'custom_image_size',
						'description'	=> esc_html__( 'Enter custom image size. eg: 200x200', 'seoaal' ),
						'value' 		=> '',
						"dependency"	=> array(
								"element"	=> "image_size",
								"value"		=> "custom"
						),
						'group'			=> esc_html__( 'Image', 'seoaal' )
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
					), 
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Slide Option", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider option.", "seoaal" ),
						"param_name"	=> "slide_opt",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slide items shown on large devices.", "seoaal" ),
						"param_name"	=> "slide_item",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Tab", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slide items shown on tab.", "seoaal" ),
						"param_name"	=> "slide_item_tab",
						"value" 		=> "2",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items on Mobile", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slide items shown on mobile.", "seoaal" ),
						"param_name"	=> "slide_item_mobile",
						"value" 		=> "1",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Auto Play", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider auto play.", "seoaal" ),
						"param_name"	=> "slide_item_autoplay",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Loop", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider loop.", "seoaal" ),
						"param_name"	=> "slide_item_loop",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Items Center", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider center, for this option must active loop and minimum items 2.", "seoaal" ),
						"param_name"	=> "slide_center",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Navigation", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider navigation.", "seoaal" ),
						"param_name"	=> "slide_nav",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "switch_bit",
						"heading"		=> esc_html__( "Pagination", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider pagination.", "seoaal" ),
						"param_name"	=> "slide_dots",
						"value"			=> "off",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Margin", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider margin space. Example 10", "seoaal" ),
						"param_name"	=> "slide_margin",
						"value" 		=> "",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Duration", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider duration. Example 5000", "seoaal" ),
						"param_name"	=> "slide_duration",
						"value" 		=> "5000",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Smart Speed", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider smart speed. Example 500", "seoaal" ),
						"param_name"	=> "slide_smart_speed",
						"value" 		=> "250",
						"group"			=> esc_html__( "Slide", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Items Slideby", "seoaal" ),
						"description"	=> esc_html__( "This is an option for portfolio slider scroll by. Example 500", "seoaal" ),
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
add_action( "vc_before_init", "seoaal_vc_portfolio_shortcode_map" );