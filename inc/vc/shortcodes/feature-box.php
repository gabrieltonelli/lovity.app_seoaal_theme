<?php 
/**
 * Seoaal Feature Box
 */
if ( ! function_exists( "seoaal_vc_feature_box_shortcode" ) ) {
	function seoaal_vc_feature_box_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_feature_box", $atts );
		extract( $atts );
		$output = '';
	
		//Defined Variable
		$animation = isset( $animation ) ? $animation : '';
		$class = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';		
		$class .= isset( $feature_layout ) ? ' feature-box-style-' . $feature_layout : '';	
		$class .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';	
		
		
		// Get VC Animation
		$class .= seoaalGetCSSAnimation( $animation );
		
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		// VC Design Options
		$class .= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), "seoaal_vc_feature_box", $atts );
		
		//Shortcode css ccde here
		$shortcode_css .= isset( $title_color ) && $title_color != '' ? '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .section-title { color: '. esc_attr( $title_color ) .'; }' : '';
		$shortcode_css .= isset( $title_color ) && $title_color != '' ? '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .section-title > a { color: '. esc_attr( $title_color ) .'; }' : '';
		$shortcode_css .= isset( $title_text_trans ) && $title_text_trans != 'default' ? '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .section-title { text-transform: '. esc_attr( $title_text_trans ) .'; }' : '';
		$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.feature-box-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
		
		//Spacing
		if( isset( $sc_spacing ) && !empty( $sc_spacing ) ){
			$sc_spacing = preg_replace( '!\s+!', ' ', $sc_spacing );
			$space_arr = explode( " ", $sc_spacing );
			$i = 1;
			$space_class_name = '';
			if( $layout == 'list' ){
				$list_layout = isset( $list_layout ) ? $list_layout : 'list-1';
				if( $list_layout == 'list-2' ){
					$space_class_name = '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .fbox-list >';
				}else{
					$space_class_name = '.' . esc_attr( $rand_class ) . '.feature-box-wrapper .fbox-list .media-body >';
				}	
			}else{
				$space_class_name = '.' . esc_attr( $rand_class ) . '.feature-box-wrapper >';
			}
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		if( isset( $gradient_opt ) && $gradient_opt != '' ){
			$clr_1 = isset( $gradient_color_1 ) ? $gradient_color_1 : '';
			$clr_2 = isset( $gradient_color_2 ) ? $gradient_color_2 : '';
			$clr_3 = isset( $gradient_color_3 ) ? $gradient_color_3 : '';
			$shortcode_css .= '.' . esc_attr( $rand_class ) . '.feature-box-wrapper {';
				$shortcode_css .= 'background: -moz-linear-gradient(141deg, '. esc_attr( $clr_1 ) .' 0%, '. esc_attr( $clr_2 ) .' 51%, '. esc_attr( $clr_3 ) .' 75%);
				background: -webkit-linear-gradient(141deg, '. esc_attr( $clr_1 ) .' 0%, '. esc_attr( $clr_2 ) .' 51%, '. esc_attr( $clr_3 ) .' 75%);
				background: linear-gradient(141deg, '. esc_attr( $clr_1 ) .' 0%, '. esc_attr( $clr_2 ) .' 51%, '. esc_attr( $clr_3 ) .' 75%);';
			$shortcode_css .= '}';
		}
		
		
		if( isset( $icon_size ) && $icon_size ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { font-size: '. esc_attr( $icon_size ) .'px; }';
			$dimension = absint( $icon_size ) * 2;
			if( isset( $icon_inner_space ) && !$icon_inner_space )
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { height: '. esc_attr( $dimension ) .'px; width: '. esc_attr( $dimension ) .'px; }';
		}
		if( isset( $icon_midd ) && $icon_midd ){
			if( isset( $icon_inner_space ) && !$icon_inner_space )
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon > span { line-height: 2; }';
		}
		
		// Icon Variation/Styles
		$icon_type = isset( $icon_type ) ? 'icon_' . $icon_type : '';
		if( $icon_type == 'icon_fontawesome' && function_exists( 'vc_icon_element_fonts_enqueue' ) ) vc_icon_element_fonts_enqueue( 'fontawesome' );
		$icon = isset( $$icon_type ) ? $$icon_type : '';
		$icon_class = isset( $icon_style ) ? ' ' . $icon_style : '';
		
		//Number
		$number_opt = isset( $number_opt ) ? $number_opt : '';
		
		if( isset( $icon_variation ) ){
			if( $icon_variation == 'c' ){
				$shortcode_css .= isset( $icon_color ) && $icon_color != '' ? '.' . esc_attr( $rand_class ) . ' .feature-box-icon { color: '. esc_attr( $icon_color ) .'; }' : '';
			}else{
				$icon_class .= ' ' . esc_attr( $icon_variation );
			}
		}
		$shortcode_css .= isset( $icon_hcolor ) && $icon_hcolor != '' ? '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { color: '. esc_attr( $icon_hcolor ) .'; }' : '';
		if( isset( $icon_bg_trans ) ){
			if( $icon_bg_trans == 'c' ){
				$shortcode_css .= isset( $icon_bg_color ) && $icon_bg_color != '' ? '.' . esc_attr( $rand_class ) . ' .feature-box-icon { background-color: '. esc_attr( $icon_bg_color ) .'; }' : '';
			}elseif( $icon_bg_trans == 't' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { background: transparent; }';
			}else{
				$icon_class .= ' ' . esc_attr( $icon_bg_trans );
			}
			
		}
		if( isset( $icon_hbg_trans ) ){
		
			if( $icon_hbg_trans == 'c' ){
				$shortcode_css .= isset( $icon_hbg_color ) && $icon_hbg_color != '' ? '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { background-color: '. esc_attr( $icon_hbg_color ) .'; }' : '';
			}elseif( $icon_hbg_trans == 't' ){
				$shortcode_css .= '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { background: '. esc_attr( $icon_hbg_trans ) .'; }';
			}elseif( $icon_hbg_trans != 'none' ){
				$icon_class .= ' ' . esc_attr( $icon_hbg_trans );
			}
		}
		
		if( isset( $border_color ) && $border_color != '' ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { border-style: solid; border-color: '. esc_attr( $border_color ) .'; }';
		}
		
		if( isset( $border_hcolor ) && $border_hcolor != '' ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ':hover .feature-box-icon { border-color: '. esc_attr( $border_hcolor ) .'; }';
		}
		
		if( isset( $border_size ) && $border_size != '' ){
			$shortcode_css .= '.' . esc_attr( $rand_class ) . ' .feature-box-icon { border-width: '. esc_attr( $border_size ) .'px; }';
		}
		
		if( $shortcode_css ) $class .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
		
		$title = isset( $title ) ? $title : '';
		$title_head = isset( $title_head ) ? $title_head : 'h2';
		$img_class = isset( $img_style ) ? ' ' . $img_style : ''; 
		$class .= isset( $img_effects ) && $img_effects != 'none' ? ' fbox-img-' . $img_effects : '';
		$fbox_image = isset( $fbox_image ) ? ' ' . $fbox_image : '';
		$video_url = isset( $fbox_video ) ? $fbox_video : '';
		
		$content = isset( $content ) && $content != '' ? $content : '';
		
		//Button Properties
		$btnn_txt = $btnn_type = $btnn_url = '';
		if( isset( $btn_text ) && $btn_text != '' ){
			$btnn_txt = $btn_text;
			$btnn_url = isset( $btn_url ) ? $btn_url : '';
			$btnn_type = isset( $btn_type ) ? $btn_type : '';
		}
		
		$layout = isset( $layout ) ? $layout : 'normal';
		
		if( $layout == 'list' ){
			$class .= isset( $list_layout ) ? ' feature-' . $list_layout : '';
		}		
		
		$fbox_attr = '';
		if( isset( $fbox_url_opt ) && $fbox_url_opt == 'yes' ){
			$fbox_attr .= isset( $fbox_url ) ? ' data-redirect="'. esc_url( $fbox_url ) .'"' : '';
			$fbox_attr .= isset( $fbox_target ) ? ' data-target="'. esc_attr( $fbox_target ) .'"' : '';
		}
			
		$output .= '<div class="feature-box-wrapper'. esc_attr( $class ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'" '. ( $fbox_attr ) .'>';
		
			$output .= isset( $ribbon_value ) && $ribbon_value != '' && $layout != 'list' && $feature_layout == '4' ? '<span class="feature-box-ribbon">'. esc_html( $ribbon_value ) .'</span>' : '';
			
			// Normal/Grid Layout
			if( $layout == 'normal' ):
			
				$opt_array = array(
					'icon_class' => $icon_class,
					'icon' => $icon,
					'img_id' => $fbox_image,
					'img_class' => $img_class,
					'img_effects' => $img_effects,
					'title' => $title,
					'title_head' => $title_head,
					'content' => $content,
					'btn_text' => $btnn_txt,
					'btn_url' => $btnn_url,
					'btn_type' => $btnn_type,
					'video'	=> $video_url,
					'number_opt' => $number_opt
				);
	
				$elemetns = isset( $fbox_items ) ? seoaal_drag_and_drop_trim( $fbox_items ) : array( 'Enabled' => '' );
	
				if( isset( $elemetns['Enabled'] ) ) :
					foreach( $elemetns['Enabled'] as $element => $value ){
						$output .= seoaal_feature_box_shortcode_elements( $element, $opt_array );
					}
				endif;
				
			elseif( $layout == 'list' ):
				
				$list_layout = isset( $list_layout ) ? $list_layout : 'list-1';
				$list_head = isset( $list_head ) ? $list_head : 'icon';
				
				$title_url_opt = isset( $title_url_opt ) ? $title_url_opt : '';
				$tit_url = isset( $title_url ) ? $title_url : '';
				
				if( $list_layout == 'list-1' ):
				
					$output .= '<div class="fbox-list">';
						$output .= '<div class="media">';
							if( $list_head == 'icon' ){
								$output .= '<div class="feature-box-icon mr-4 text-center'. esc_attr( $icon_class ) .'">';
									$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
								$output .= '</div><!-- .feature-box-icon -->';
							}else{
								if( $list_head == 'invis_num' ){
									$output .= $number_opt ? '<h6 class="invisible-number">'. esc_html( $number_opt ) .'</h6>' : '';
								}else{
									if( $fbox_image ){
										$img_attr = wp_get_attachment_image_src( absint( $fbox_image ), 'full', true );
										$output .= '<div class="feature-box-thumb mr-4">';
											$image_alt = get_post_meta( absint( $fbox_image ), '_wp_attachment_image_alt', true);
											$image_alt = $image_alt != '' ? $image_alt : $title;
											
											$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
											if( $lazy_opt ){
											
												$thumb_size = 'full';
												$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
											
												$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
												if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
													$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
													$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" />';
												}else{
													$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" alt="'. esc_attr( $image_alt ) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '"  />';
												}
											}else{
												$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />' : '';
											}											
											
										$output .= '</div><!-- .feature-box-thumb -->';
									}
								}	
							}
							
							$output .= '<div class="media-body">';
							
								$output .= '<div class="feature-box-title">';
									$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
										$output .= esc_html( $title );
									$output .= '</' . esc_attr( $title_head ) . '>';
								$output .= '</div><!-- .feature-box-title -->';
								
								if( $content != '' ):
									$output .= '<div class="feature-box-content">';
										$output .= wp_kses_post( $content );
									$output .= '</div><!-- .feature-box-content -->';
								endif;
								
								if( $btnn_txt != '' ):
									$output .= '<div class="feature-box-btn">';
										$output .= '<a class="btn '. esc_attr( $btnn_type ) .'" href="'. esc_url( $btnn_url ) .'" title="'. esc_attr( $btnn_txt ) .'">'. esc_html( $btnn_txt ) .'</a>';
									$output .= '</div><!-- .feature-box-btn -->';
								endif;
								
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				
				elseif( $list_layout == 'list-2' ):
				
					$output .= '<div class="fbox-list">';
					
						$output .= '<div class="media fbox-list-head clearfix">';
							if( $list_head == 'icon' ){
								$output .= '<div class="feature-box-icon text-center'. esc_attr( $icon_class ) .'">';
									$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
								$output .= '</div><!-- .feature-box-icon -->';
							}else{
								if( $fbox_image ){
									$img_attr = wp_get_attachment_image_src( absint( $fbox_image ), 'full', true );
									$output .= '<div class="feature-box-thumb">';
										$image_alt = get_post_meta( absint( $fbox_image ), '_wp_attachment_image_alt', true);
										$image_alt = $image_alt != '' ? $image_alt : $title;
										
										$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
										if( $lazy_opt ){
										
											$thumb_size = 'full';
											$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
										
											$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
											if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
												$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
												$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" />';
											}else{
												$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" alt="'. esc_attr( $image_alt ) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '"  />';
											}
										}else{
											$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'"  alt="'. esc_attr( $image_alt ) .'" />' : '';
										}										
										
									$output .= '</div><!-- .feature-box-thumb -->';
								}
							}
							
							$output .= '<div class="media-body align-self-center feature-box-title">';
								$output .= $number_opt ? '<h6 class="invisible-number">'. esc_html( $number_opt ) .'</h6>' : '';
								$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
									$output .= esc_html( $title );
								$output .= '</' . esc_attr( $title_head ) . '>';
							$output .= '</div><!-- .feature-box-title -->';
						$output .= '</div><!-- .fbox-list-head -->';
						if( $content != '' ):
							$output .= '<div class="fbox-list-body">';
								$output .= '<div class="feature-box-content">';
									$output .= wp_kses_post( $content );
								$output .= '</div><!-- .feature-box-content -->';
							$output .= '</div>';
						endif;
						if( $btnn_txt != '' ):
							$output .= '<div class="feature-box-btn">';
								$output .= '<a class="btn '. esc_attr( $btnn_type ) .'" href="'. esc_url( $btnn_url ) .'" title="'. esc_attr( $btnn_txt ) .'">'. esc_html( $btnn_txt ) .'</a>';
							$output .= '</div><!-- .feature-box-btn -->';
						endif;
					$output .= '</div><!-- .fbox-list -->';
				elseif( $list_layout == 'list-3' ):
				
					$output .= '<div class="fbox-list">';
						$output .= '<div class="media">';
							
							$output .= '<div class="media-body">';
							
								$output .= '<div class="feature-box-title">';
									$output .= $number_opt ? '<h6 class="invisible-number">'. esc_html( $number_opt ) .'</h6>' : '';
									$output .= '<' . esc_attr( $title_head ) . ' class="section-title">';
										$output .= esc_html( $title );
									$output .= '</' . esc_attr( $title_head ) . '>';
								$output .= '</div><!-- .feature-box-title -->';
								
								if( $content != '' ):
									$output .= '<div class="feature-box-content">';
										$output .= wp_kses_post( $content );
									$output .= '</div><!-- .feature-box-content -->';
								endif;
								if( $btnn_txt != '' ):
									$output .= '<div class="feature-box-btn">';
										$output .= '<a class="btn '. esc_attr( $btnn_type ) .'" href="'. esc_url( $btnn_url ) .'" title="'. esc_attr( $btnn_txt ) .'">'. esc_html( $btnn_txt ) .'</a>';
									$output .= '</div><!-- .feature-box-btn -->';
								endif;
								
							$output .= '</div>';
							
							if( $list_head == 'icon' ){
								$output .= '<div class="feature-box-icon ml-3 text-center'. esc_attr( $icon_class ) .'">';
									$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
								$output .= '</div><!-- .feature-box-icon -->';
							}else{
								if( $fbox_image ){
									$img_attr = wp_get_attachment_image_src( absint( $fbox_image ), 'full', true );
									$output .= '<div class="feature-box-thumb ml-3">';
										$image_alt = get_post_meta( absint( $fbox_image ), '_wp_attachment_image_alt', true);
										$image_alt = $image_alt != '' ? $image_alt : $title;
										
										$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
										if( $lazy_opt ){
										
											$thumb_size = 'full';
											$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
										
											$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
											if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
												$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
												$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" />';
											}else{
												$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" alt="'. esc_attr( $image_alt ) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '"  />';
											}
										}else{
											$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'"  alt="'. esc_attr( $image_alt ) .'" />' : '';
										}
										
									$output .= '</div><!-- .feature-box-thumb -->';
								}
							}
							
						$output .= '</div>';
					$output .= '</div>';
				endif;
				
			endif;
			
		$output .= '</div><!-- .feature-box-wrapper -->';
		
		return $output;
	}
}

function seoaal_feature_box_shortcode_elements( $element, $opts ){
	$output = '';
	switch( $element ){
	
		case "title":
			$output .= '<div class="feature-box-title">';
				$output .= isset( $opts['number_opt'] ) && $opts['number_opt'] != '' ? '<h6 class="invisible-number">'. esc_html( $opts['number_opt'] ) .'</h6>' : '';
				$output .= '<' . esc_attr( $opts['title_head'] ) . ' class="section-title">';
					$output .= esc_html( $opts['title'] );
				$output .= '</' . esc_attr( $opts['title_head'] ) . '>';
			$output .= '</div><!-- .feature-box-title -->';		
		break;
		
		case "icon":
			$icon_class = $opts['icon_class'];
			$icon = $opts['icon'];
			if( $icon ):
				$output .= '<div class="feature-box-icon text-center'. esc_attr( $icon_class ) .'">';
					$output .= '<span class="'. esc_attr( $icon ) .'"></span>';
				$output .= '</div><!-- .feature-box-icon -->';
			endif;
		break;
		
		case "image":
			$img_id = $opts['img_id'];
			$img_class = $opts['img_class'];
			$img_attr = wp_get_attachment_image_src( absint( $img_id ), 'full', true );
			if( isset( $img_attr ) ):
				$output .= '<div class="feature-box-thumb">';
					$image_alt = get_post_meta( absint( $img_id ), '_wp_attachment_image_alt', true);
					$image_alt = $image_alt != '' ? $image_alt : esc_html( $opts['title'] );
					
					$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
					if( $lazy_opt ){
					
						$thumb_size = 'full';
						$cus_thumb_size = array( $img_attr[1], $img_attr[2] );
					
						$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
						if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
							$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $cus_thumb_size, true, absint( $lazy_img['id'] ) );
							$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" src="'. esc_url( $pre_img_prop[0] ) .'" data-src="' . esc_url( $img_attr[0] ) . '" />';
						}else{
							$output .= '<img width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" class="img-fluid lazy-initiate'. esc_attr( $img_class ) .'" alt="'. esc_attr( $image_alt ) .'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . esc_url( $img_attr[0] ) . '"  />';
						}
					}else{
						$output .= isset( $img_attr[0] ) ? '<img class="img-fluid'. esc_attr( $img_class ) .'" src="'. esc_url( $img_attr[0] ) .'" width="'. esc_attr( $img_attr[1] ) .'" height="'. esc_attr( $img_attr[2] ) .'" alt="'. esc_attr( $image_alt ) .'" />' : '';
					}					
					
				$output .= '</div><!-- .feature-box-thumb -->';
			endif;
		break;
		
		case "content":
			if( $opts['content'] != '' ):
				$output .= '<div class="feature-box-content">';
					$output .= wp_kses_post( $opts['content'] );
				$output .= '</div><!-- .feature-box-content -->';
			endif;
		break;
		
		case "btn":
			if( $opts['btn_text'] != '' ):
				$output .= '<div class="feature-box-btn">';
					$output .= '<a class="btn '. esc_attr( $opts['btn_type'] ) .'" href="'. esc_url( $opts['btn_url'] ) .'" title="'. esc_attr( $opts['btn_text'] ) .'">'. esc_html( $opts['btn_text'] ) .'</a>';
				$output .= '</div><!-- .feature-box-btn -->';
			endif;
		break;
		
		case "video":
			if( isset( $opts['video'] ) ) :
				$output .= '<div class="feature-box-video">';
					$output .= do_shortcode( '[videoframe url="'. esc_url( $opts['video'] ) .'" width="100%" height="100%" params="byline=0&portrait=0&badge=0" /]' );
				$output .= '</div><!-- .feature-box-video -->';
			endif;
		break;
		
	}
	return $output; 
}
if ( ! function_exists( "seoaal_vc_feature_box_shortcode_map" ) ) {
	function seoaal_vc_feature_box_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Feature Box", "seoaal" ),
				"description"			=> esc_html__( "Ultimate feature box.", "seoaal" ),
				"base"					=> "seoaal_vc_feature_box",
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
						"heading"		=> esc_html__( "Navigate Feature Box", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box title as link. Enable yes to set title url.", "seoaal" ),
						"param_name"	=> "fbox_url_opt",
						"value"			=> array(
							esc_html__( "No", "seoaal" )	=> "no",
							esc_html__( "Yes", "seoaal" )	=> "yes"
						)
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Feature Box External Link", "seoaal" ),
						"param_name"	=> "fbox_url",
						"value" 		=> "",
						'dependency' => array(
							'element' => 'fbox_url_opt',
							'value' => 'yes',
						)
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Target Window", "seoaal" ),
						"param_name"	=> "fbox_target",
						"value"			=> array(
							esc_html__( "Self", "seoaal" )	=> "_self",
							esc_html__( "Blank", "seoaal" )	=> "_blank",
							esc_html__( "Parent", "seoaal" )	=> "_parent"
						),
						'dependency' => array(
							'element' => 'fbox_url_opt',
							'value' => 'yes',
						)
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
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Title", "seoaal" ),
						"param_name"	=> "title",
						"value" 		=> "",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Title Heading Tag", "seoaal" ),
						"description"	=> esc_html__( "This is option for title heading tag", "seoaal" ),
						"param_name"	=> "title_head",
						"value"			=> array(
							esc_html__( "H2", "seoaal" )=> "h2",
							esc_html__( "H3", "seoaal" )=> "h3",
							esc_html__( "H4", "seoaal" )=> "h4",
							esc_html__( "H5", "seoaal" )=> "h5",
							esc_html__( "H6", "seoaal" )=> "h6"
						),
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Title Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the font color.", "seoaal" ),
						"param_name"	=> "title_color",
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Title Heading Tag", "seoaal" ),
						"description"	=> esc_html__( "This is option for title heading tag", "seoaal" ),
						"param_name"	=> "title_text_trans",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )=> "default",
							esc_html__( "Capitalized", "seoaal" )=> "capitalize",
							esc_html__( "Upper Case", "seoaal" )=> "uppercase",
							esc_html__( "Lower Case", "seoaal" )=> "lowercase"
						),
						"group"			=> esc_html__( "Title", "seoaal" )
					),
					array(
						"type"			=> "img_select",
						"heading"		=> esc_html__( "Feature Box Layout", "seoaal" ),
						"param_name"	=> "feature_layout",
						"img_lists" => array ( 
							"1"	=> SEOAAL_ADMIN_URL . "/assets/images/feature-box/1.png",
							"2"	=> SEOAAL_ADMIN_URL . "/assets/images/feature-box/2.png",
							"3"	=> SEOAAL_ADMIN_URL . "/assets/images/feature-box/3.png",
							"4"	=> SEOAAL_ADMIN_URL . "/assets/images/feature-box/4.png"
						),
						"default"		=> "1",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box text align", "seoaal" ),
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
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Feature Box Layout", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box layout.", "seoaal" ),
						"param_name"	=> "layout",
						"value"			=> array(
							esc_html__( "Normal", "seoaal" )	=> "normal",
							esc_html__( "List Style", "seoaal" )	=> "list"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Ribbon Values", "seoaal" ),
						"description"	=> esc_html__( "This is option for corner rounded number like ribbon. This option working only when active feature box layout 4.", "seoaal" ),
						"param_name"	=> "ribbon_value",
						"value" 		=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Feature Box Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for feature box custom layout. here you can set your own layout. Drag and drop needed feature items to Enabled part.", "seoaal" ),
						'param_name'	=> 'fbox_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'icon'	=> esc_html__( 'Icon', 'seoaal' ),
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'content'	=> esc_html__( 'Content', 'seoaal' )					
							),
							'disabled' => array(
								'image'	=> esc_html__( 'Image', 'seoaal' ),
								'btn'	=> esc_html__( 'Button', 'seoaal' ),
								'video'	=> esc_html__( 'Video', 'seoaal' )
							)
						),
						'dependency' => array(
							'element' => 'layout',
							'value' => 'normal',
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
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Gradient Background", "seoaal" ),
						"description"	=> esc_html__( "This is option for enable gradient background. You must give three colors.", "seoaal" ),
						"param_name"	=> "gradient_opt",
						"value"			=> array(
							esc_html__( "Disable", "seoaal" )	=> "0",
							esc_html__( "Enable", "seoaal" )	=> "1"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Gradient Color 1", "seoaal" ),
						"description"	=> esc_html__( "Here you can choose gradient start color.", "seoaal" ),
						"param_name"	=> "gradient_color_1",
						'dependency' => array(
							'element' => 'gradient_opt',
							'value' => '1',
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Gradient Color 2", "seoaal" ),
						"description"	=> esc_html__( "Here you can choose gradient middle color.", "seoaal" ),
						"param_name"	=> "gradient_color_2",
						'dependency' => array(
							'element' => 'gradient_opt',
							'value' => '1',
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Gradient Color 3", "seoaal" ),
						"description"	=> esc_html__( "Here you can choose gradient end color.", "seoaal" ),
						"param_name"	=> "gradient_color_3",
						'dependency' => array(
							'element' => 'gradient_opt',
							'value' => '1',
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Feature Box List Head", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box list head item.", "seoaal" ),
						"param_name"	=> "list_head",
						"value"			=> array(
							esc_html__( "Icon", "seoaal" )	=> "icon",
							esc_html__( "Image", "seoaal" )	=> "img",
							esc_html__( "Number", "seoaal" )	=> "invis_num"
						),
						'dependency' => array(
							'element' => 'layout',
							'value' => 'list',
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Feature Box List Layout", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box list layout.", "seoaal" ),
						"param_name"	=> "list_layout",
						"value"			=> array(
							esc_html__( "List Style 1", "seoaal" )	=> "list-1",
							esc_html__( "List Style 2", "seoaal" )	=> "list-2",
							esc_html__( "List Style 3", "seoaal" )	=> "list-3"
						),
						'dependency' => array(
							'element' => 'layout',
							'value' => 'list',
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Icon Size", "seoaal" ),
						"description" 	=> esc_html__( "This is option for set icon size. Example 30", "seoaal" ),
						"param_name"	=> "icon_size",
						"value" 		=> "24",
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Icon Vertical Middle", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box icon set vertically middle.", "seoaal" ),
						"param_name"	=> "icon_midd",
						"value"			=> array(
							esc_html__( "Yes", "seoaal" )	=> "1",
							esc_html__( "No", "seoaal" )	=> "0"
						),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Numbered Option", "seoaal" ),
						"description"	=> esc_html__( "Enter text for feature box number option. Example 01.", "seoaal" ),
						"param_name"	=> "number_opt",
						"value"			=> "",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"        => "checkbox",
						"heading"     => esc_html__( "Icon Inner Space Empty", "seoaal" ),
						"description" => esc_html__( "check this to empty icon inner space.", "seoaal" ),
						"param_name"  => "icon_inner_space",
						"value"       => array(
							'Check to 0 space' => '1'
						), //value
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Choose from Icon library", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) 				=> "",
							esc_html__( "Font Awesome", "seoaal" ) 		=> "fontawesome",
							esc_html__( "Simple Line Icons", "seoaal" ) => "simplelineicons",
							esc_html__( "Themify Icons", "seoaal" ) => "themifyicons"
							
						),
						"admin_label" 	=> true,
						"param_name" 	=> "icon_type",
						"description" 	=> esc_html__( "Select icon library.", "seoaal" ),
						"group"			=> esc_html__( "Icon", "seoaal" ),
					),		
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'seoaal' ),
						'param_name' => 'icon_fontawesome',
						"value" 		=> "fa fa-heart-o",
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'fontawesome',
							'iconsPerPage' => 675,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'fontawesome',
						),
						'description' => esc_html__( 'Select icon from library.', 'seoaal' ),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'seoaal' ),
						'param_name' => 'icon_simplelineicons',
						"value" 	=> "vc_li vc_li-star",
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'simplelineicons',
							'iconsPerPage' => 500,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'simplelineicons',
						),
						'description' => esc_html__( 'Select icon from library.', 'seoaal' ),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'seoaal' ),
						'param_name' => 'icon_themifyicons',
						"value" 		=> "ti-star",
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'themifyicons',
							'iconsPerPage' => 100,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'themifyicons',
						),
						'description' => esc_html__( 'Select icon from library.', 'seoaal' ),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Icon Style", "seoaal" ),
						"description"	=> esc_html__( "This is option for feature box icon style.", "seoaal" ),
						"param_name"	=> "icon_variation",
						"value"			=> array(
							esc_html__( "Dark", "seoaal" )		=> "icon-dark",
							esc_html__( "Light", "seoaal" )		=> "icon-light",
							esc_html__( "Theme", "seoaal" )		=> "theme-color",
							esc_html__( "Custom", "seoaal" )	=> "c"
						),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the icons icon color.", "seoaal" ),
						"param_name"	=> "icon_color",
						'dependency' => array(
							'element' => 'icon_variation',
							'value' => 'c',
						),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Hover Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the icon hover color.", "seoaal" ),
						"param_name"	=> "icon_hcolor",
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Icon Background", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) => "none",
							esc_html__( "Theme Color", "seoaal" ) => "theme-color-bg",
							esc_html__( "Transparent", "seoaal" ) => "t",
							esc_html__( "Custom Color", "seoaal" )=> "c"
						),
						"param_name" 	=> "icon_bg_trans",
						"group"			=> esc_html__( "Icon", "seoaal" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Background Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the icon background color.", "seoaal" ),
						"param_name"	=> "icon_bg_color",
						'dependency' => array(
							'element' => 'icon_bg_trans',
							'value' => 'c',
						),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Icon Background Hover", "seoaal" ),
						"value" 		=> array(
							esc_html__( "None", "seoaal" ) => "none",
							esc_html__( "Theme Color", "seoaal" ) => "theme-hcolor-bg",
							esc_html__( "Transparent", "seoaal" ) => "t",
							esc_html__( "Set Color", "seoaal" )=> "c"
						),
						"param_name" 	=> "icon_hbg_trans",
						"group"			=> esc_html__( "Icon", "seoaal" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Icon Background Hover Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the icon background hover color.", "seoaal" ),
						"param_name"	=> "icon_hbg_color",
						'dependency' => array(
							'element' => 'icon_hbg_trans',
							'value' => 'c',
						),
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Icon Style", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Squared", "seoaal" ) => "squared",
							esc_html__( "Rounded", "seoaal" ) => "rounded",
							esc_html__( "Circled", "seoaal" ) => "rounded-circle",
						),
						"param_name" 	=> "icon_style",
						"group"			=> esc_html__( "Icon", "seoaal" ),
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Border Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the border color.", "seoaal" ),
						"param_name"	=> "border_color",
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "colorpicker",
						"heading"		=> esc_html__( "Hover Border Color", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the hover border color.", "seoaal" ),
						"param_name"	=> "border_hcolor",
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Border Size", "seoaal" ),
						"description"	=> esc_html__( "Here you can put the border size in value. Example 2", "seoaal" ),
						"param_name"	=> "border_size",
						"value" 		=> "",
						"group"			=> esc_html__( "Icon", "seoaal" )
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__( "Feature Box Image", "seoaal" ),
						"description" => esc_html__( "Choose feature box image.", "seoaal" ),
						"param_name" => "fbox_image",
						"value" => '',
						"group"			=> esc_html__( "Image", "seoaal" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Image Style", "seoaal" ),
						"value" 		=> array(
							esc_html__( "Squared", "seoaal" ) => "squared",
							esc_html__( "Rounded", "seoaal" ) => "rounded",
							esc_html__( "Circled", "seoaal" ) => "rounded-circle",
						),
						"param_name" 	=> "img_style",
						"group"			=> esc_html__( "Image", "seoaal" ),
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Image Hover Effects", "seoaal" ),
						"description"	=> esc_html__( "This is effects option for image hover.", "seoaal" ),
						"param_name"	=> "img_effects",
						"value"			=> array(
							esc_html__( "None", "seoaal" )=> "none",
							esc_html__( "Overlay", "seoaal" )=> 'overlay',
							esc_html__( "Zoom In", "seoaal" )=> 'zoomin',
							esc_html__( "Grayscale", "seoaal" )=> 'grayscale',
							esc_html__( "Blur", "seoaal" )=> 'blur'
						),
						"group"			=> esc_html__( "Image", "seoaal" )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Feature Box Video", "seoaal" ),
						"param_name" => "fbox_video",
						"value" => '',
						"description" => esc_html__( "Choose feature box video. This url maybe youtube or vimeo video. Example https://www.youtube.com/embed/qAHRvrrfGC4", "seoaal" ),
						"group"			=> esc_html__( "Video", "seoaal" )
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Button Text", "seoaal" ),
						"description"	=> esc_html__( "Enter section button text here. If no need button, then leave this box blank.", "seoaal" ),
						"param_name"	=> "btn_text",
						"value" 		=> "",
						"group"			=> esc_html__( "Button", "seoaal" ),
					),
					array(
						"type"			=> "textfield",
						"heading"		=> esc_html__( "Button URL", "seoaal" ),
						"description"	=> esc_html__( "Enter section button url here. If no need button url, then leave this box blank.", "seoaal" ),
						"param_name"	=> "btn_url",
						"value" 		=> "",
						"group"			=> esc_html__( "Button", "seoaal" ),
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Button Type", "seoaal" ),
						"param_name" 	=> "btn_type",
						"value" 		=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Link", "seoaal" )		=> "link",
							esc_html__( "Classic", "seoaal" )	=> "classic",
							esc_html__( "Bordered", "seoaal" )	=> "bordered",
							esc_html__( "Inverse", "seoaal" )	=> "inverse"
						),
						"group"			=> esc_html__( "Button", "seoaal" ),
					),
					array(
						"type"			=> "textarea_html",
						"heading"		=> esc_html__( "Content", "seoaal" ),
						"description" 	=> esc_html__( "You can give the feature box content here. HTML allowed here.", "seoaal" ),
						"param_name"	=> "content",
						"value" 		=> "",
						"group"			=> esc_html__( "Content", "seoaal" )
					),
					array(
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Items Spacing", "seoaal" ),
						"description"	=> esc_html__( "Enter custom bottom space for each item on main wrapper. Your space values will apply like nth child method. If you leave this empty, default theme space apply for each child. If you want default value for any child, just type \"default\". It will take default value for that child. Example 10px 12px 8px", "seoaal" ),
						"param_name"	=> "sc_spacing",
						"value" 		=> "",
						"group"			=> esc_html__( "Spacing", "seoaal" ),
					),
					array(
						'type'		=> "css_editor",
						'heading'	=> esc_html__( "Css", 'seoaal' ),
						'param_name'=> "css",
						'group'		=> esc_html__( "Design options", "seoaal" ),
					),
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_feature_box_shortcode_map" );