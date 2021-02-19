<?php 
/**
 * Seoaal Blog Layouts
 */
if ( ! function_exists( "seoaal_vc_blog_multi_layout_shortcode" ) ) {
	function seoaal_vc_blog_multi_layout_shortcode( $atts, $content = NULL ) {
		
		$atts = vc_map_get_attributes( "seoaal_vc_blog_multi_layout", $atts );
		extract( $atts );
		$output = '';
	
		//Defined Variable
		$class_names = isset( $extra_class ) && $extra_class != '' ? ' ' . $extra_class : '';
		$post_per_page = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : '';
		$excerpt_length = isset( $excerpt_length ) && $excerpt_length != '' ? $excerpt_length : 0;
		$more_text = isset( $more_text ) && $more_text != '' ? $more_text : '';
		$blog_pagination = isset( $blog_pagination ) && $blog_pagination == 'on' ? 'true' : 'false';
		$primary_title_head = isset( $primary_title_head ) ? $primary_title_head : 'h4';
		$secondary_title_head = isset( $secondary_title_head ) ? $secondary_title_head : 'h4';
		$blog_overlay_opt = isset( $blog_overlay_opt ) && $blog_overlay_opt == 'yes' ? true : false;
		$blog_overlay_items = isset( $blog_overlay_items ) ? seoaal_drag_and_drop_trim( $blog_overlay_items ) : array( 'Enabled' => array() );
		$overlay_class = '';
		$overlay_class .= isset( $blog_overlay_position ) ? ' overlay-'.$blog_overlay_position : ' overlay-center';
		$blog_layout = isset( $blog_layout ) && $blog_layout != '' ? 'seoaal_blog_multi_layout_'. esc_attr( $blog_layout ) .'_generate' : 'seoaal_blog_multi_layout_1_generate';
		
		$thumb_size = isset( $primary_image_size ) ? $primary_image_size : 'large';
		$cus_thumb_size = '';
		if( $thumb_size == 'custom' ){
			$cus_thumb_size = isset( $custom_primary_image_size ) && $custom_primary_image_size != '' ? $custom_primary_image_size : '';
		}
		$secondary_thumb_size = isset( $secondary_image_size ) ? $secondary_image_size : '';
		$cus_secondary_thumb_size = '';
		if( $secondary_thumb_size == 'custom' ){
			$cus_secondary_thumb_size = isset( $custom_secondary_image_size ) && $custom_secondary_image_size != '' ? $custom_secondary_image_size : '';
		}
		
		$top_meta = isset( $top_meta ) && $top_meta != '' ? $top_meta : array( 'Enabled' => '' );
		$bottom_meta = isset( $bottom_meta ) && $bottom_meta != '' ? $bottom_meta : array( 'Enabled' => '' );

		$class_names .= isset( $text_align ) && $text_align != 'default' ? ' text-' . $text_align : '';
		$class_names .= isset( $variation ) ? ' blog-' . $variation : '';
		$sec_text_align = isset( $sec_text_align ) && $sec_text_align != 'default' ? $sec_text_align : '';

		
		// This is custom css options for main shortcode warpper
		$shortcode_css = '';
		$shortcode_rand_id = $rand_class = 'shortcode-rand-'. seoaal_shortcode_rand_id();
		
		//Grid Spacing
		if( isset( $sc_grid_spacing ) && !empty( $sc_grid_spacing ) ){
			$sc_grid_spacing = preg_replace( '!\s+!', ' ', $sc_grid_spacing );
			$space_arr = explode( " ", $sc_grid_spacing );
			$i = 1;
			$space_class_name = '.' . esc_attr( $rand_class ) . '.blog-multi-layout-wrapper .blog-grid >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		//List Spacing
		if( isset( $sc_list_spacing ) && !empty( $sc_list_spacing ) ){
			$sc_list_spacing = preg_replace( '!\s+!', ' ', $sc_list_spacing );
			$space_arr = explode( " ", $sc_list_spacing );
			$i = 1;
			$space_class_name = '.' . esc_attr( $rand_class ) . '.blog-multi-layout-wrapper .blog-list > .media > .media-body >';
			foreach( $space_arr as $space ){
				$shortcode_css .= $space != 'default' ? $space_class_name .' *:nth-child('. esc_attr( $i ) .') { margin-bottom: '. esc_attr( $space ) .'; }' : '';
				$i++;
			}
		}
		
		//Cats In
		$cats_in = array();
		if( isset( $include_cats ) && $include_cats != '' ){
			$filter = preg_replace( '/\s+/', '', $include_cats );
			$filter = explode( ',', rtrim( $filter, ',' ) );
			foreach( $filter as $cat ){
				if( term_exists( $cat, 'category' ) ){
					$cat_term = get_term_by( 'slug', $cat, 'category' );	
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
				if( term_exists( $cat, 'category' ) ){
					$cat_term = get_term_by( 'slug', $cat, 'category' );	
					//post not in array push
					if( isset( $cat_term->term_id ) )
						array_push( $cats_not_in, absint( $cat_term->term_id ) );	
				}
			}
		}
		
		//Query Start
		global $wp_query;
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		
		$ppp = isset( $post_per_page ) && $post_per_page != '' ? $post_per_page : 2;
		$inc_cat_array = $cats_in ? array( 'taxonomy' => 'category', 'field' => 'id', 'terms' => $cats_in ) : '';
		$exc_cat_array = $cats_not_in ? array( 'taxonomy' => 'category', 'field' => 'id', 'terms' => $cats_not_in, 'operator' => 'NOT IN' ) : '';
		$args = array(
			'post_type' => 'post',
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
			
			$primary_elemetns = isset( $primary_items ) ? seoaal_drag_and_drop_trim( $primary_items ) : array( 'Enabled' => '' );
			$secondary_elemetns = isset( $secondary_items ) ? seoaal_drag_and_drop_trim( $secondary_items ) : array( 'Enabled' => '' );
			
			$blog_array = array(
				'excerpt_length' => $excerpt_length,
				'thumb_size' => $thumb_size,
				'cus_thumb_size' => $cus_thumb_size,
				'secondary_thumb_size' => $secondary_thumb_size,
				'cus_secondary_thumb_size' => $cus_secondary_thumb_size,
				'more_text' => $more_text,
				'elemetns' => $primary_elemetns,
				'secondary_elemetns' => $secondary_elemetns,
				'top_meta' => $top_meta,
				'bottom_meta' => $bottom_meta,
				'title_head' => $primary_title_head,
				'secondary_title_head' => $secondary_title_head,
				'overlay_opt' => $blog_overlay_opt,
				'overlay_items' => $blog_overlay_items,
				'overlay_class' => $overlay_class
			);
			
			//Shortcode css ccde here
			$shortcode_css .= isset( $font_color ) && $font_color != '' ? '.' . esc_attr( $rand_class ) . '.blog-multi-layout-wrapper { color: '. esc_attr( $font_color ) .'; }' : '';
			
			$shortcode_css .= isset( $sec_text_align ) && $sec_text_align != '' ? '.' . esc_attr( $rand_class ) . '.blog-multi-layout-wrapper .independent-block-secondary { text-align: '. esc_attr( $sec_text_align ) .'; }' : '';
			
			if( $shortcode_css ) $class_names .= ' ' . $shortcode_rand_id . ' seoaal-inline-css';
			$output .= '<div class="blog-multi-layout-wrapper'. esc_attr( $class_names ) .'" data-css="'. htmlspecialchars( json_encode( $shortcode_css ), ENT_QUOTES, 'UTF-8' ) .'">';
				$output .= function_exists( $blog_layout ) ? $blog_layout( $query, $blog_array ) : '';	
					
			$output .= '</div><!-- .blog-multi-layout-wrapper -->';
			
		}// query exists
		
		// use reset postdata to restore orginal query
		wp_reset_postdata();
		
		return $output;
	}
}

function seoaal_blog_multi_layout_1_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-1">';
		$output = '<div class="row">';
		$single = 0;
		
		while ($query->have_posts()){
			$query->the_post();
			if($single == 0){
				$blog_array['grid_stat'] = 1;
				$output .= '<div class="col-md-6"><!--top col start-->';
					$output .= seoaal_blog_multi_layout_generate($blog_array);
				$output .= '</div><!--top col end-->';
				$output .= '<div class="col-md-6">';
					$output .= '<div class="independent-block-secondary">';
				$single = 1;
				
				$blog_array['elemetns'] = $blog_array['secondary_elemetns'];
				$blog_array['thumb_size'] = $blog_array['secondary_thumb_size'];
				$blog_array['cus_thumb_size'] = $blog_array['cus_secondary_thumb_size'];
				$blog_array['title_head'] = $blog_array['secondary_title_head'];
			}else{	
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$output .= '<div class="media mb-3">';
						$output .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$output .= '<div class="media-body ml-3">';
							$output .= seoaal_blog_multi_layout_generate($t_blog_array);
						$output .= '</div><!-- .media-body -->';
					$output .= '</div><!-- .media -->';
				}else{
					$output .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}
		}
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-sm-6 -->';
		$output .= '</div><!-- .row -->';
	$output .= '</div><!-- .blog-multi-layout-1 -->';
	return $output;
}

function seoaal_blog_multi_layout_2_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-2">';
		$output .= '<div class="row">';
			$output .= '<div class="col-md-6">';
		$single = 0;
		
		while ($query->have_posts()){
			$query->the_post();
			if($single <= 1){
				$blog_array['grid_stat'] = 1;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$output .= '<div class="media mb-3">';
						$output .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$output .= '<div class="media-body ml-3">';
							$output .= seoaal_blog_multi_layout_generate($t_blog_array);
						$output .= '</div><!-- .media-body -->';
					$output .= '</div><!-- .media -->';
				}else{
					$output .= seoaal_blog_multi_layout_generate($blog_array);
				}
				
				if($single == 1){
					$blog_array['elemetns'] = $blog_array['secondary_elemetns'];
					$blog_array['thumb_size'] = $blog_array['secondary_thumb_size'];
					$blog_array['cus_thumb_size'] = $blog_array['cus_secondary_thumb_size'];
					$blog_array['title_head'] = $blog_array['secondary_title_head'];
				}
			}else{	
				if($single == 2){
					$output .= '</div><!-- .col-md-6 -->';
					$output .= '<div class="col-md-6">';
				}
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$output .= '<div class="media mb-3">';
						$output .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$output .= '<div class="media-body ml-3">';
							$output .= seoaal_blog_multi_layout_generate($t_blog_array);
						$output .= '</div><!-- .media-body -->';
					$output .= '</div><!-- .media -->';
				}else{
					$output .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}
			$single++;
		}
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-md-6 -->';
		$output .= '</div><!-- .row -->';
	$output .= '</div><!-- .blog-multi-layout-1 -->';
	return $output;
}

function seoaal_blog_multi_layout_3_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-3">';
		$single = 1;
		
		$copy_blog_array = $blog_array;
		$copy_blog_array['elemetns'] = $copy_blog_array['secondary_elemetns'];
		$copy_blog_array['thumb_size'] = $copy_blog_array['secondary_thumb_size'];
		$copy_blog_array['cus_thumb_size'] = $copy_blog_array['cus_secondary_thumb_size'];
		$copy_blog_array['title_head'] = $copy_blog_array['secondary_title_head'];
	
		$first_out = $sec_out = $last_out = '';
		$blog_array['grid_stat'] = 1;

		while ($query->have_posts()){
			$query->the_post();
			if($single == 1){
				$first_out = seoaal_blog_multi_layout_generate($blog_array);
			}elseif($single == 2){
				$sec_out = seoaal_blog_multi_layout_generate($blog_array);
			}else{	
				$blog_array['grid_stat'] = 0;
				if( isset( $copy_blog_array['elemetns']['Enabled']['thumb'] ) ){
					$last_out .= '<div class="media mb-3">';
						$last_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $copy_blog_array );
						$t_blog_array = $copy_blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$last_out .= '<div class="media-body ml-3">';
							$last_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$last_out .= '</div><!-- .media-body -->';
					$last_out .= '</div><!-- .media -->';
				}else{
					$last_out .= seoaal_blog_multi_layout_generate($copy_blog_array);
				}
			}
			$single++;
		}
		
		$output .= '<div class="row">';	
			$output .= '<div class="col-md-4">';
				$output .= $first_out;
			$output .= '</div><!-- .col-md-4 -->';
			$output .= '<div class="col-md-4">';
				$output .= $sec_out;
			$output .= '</div><!-- .col-md-4 -->';
			$output .= '<div class="col-md-4">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $last_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-md-4 -->';
		$output .= '</div><!-- .row -->';
	$output .= '</div><!-- .blog-multi-layout-3 -->';
	return $output;
}

function seoaal_blog_multi_layout_4_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-4">';
		$single = 1;
		$copy_blog_array = $blog_array;
		$first_out = $sec_out = $last_out = '';
		$total = $query->post_count;

		while ($query->have_posts()){
			$query->the_post();
			if($single == 1){
				$blog_array['grid_stat'] = 1;
				$first_out = seoaal_blog_multi_layout_generate($blog_array);
				$blog_array['elemetns'] = $blog_array['secondary_elemetns'];
				$blog_array['thumb_size'] = $blog_array['secondary_thumb_size'];
				$blog_array['cus_thumb_size'] = $blog_array['cus_secondary_thumb_size'];
				$blog_array['title_head'] = $blog_array['secondary_title_head'];
			}elseif($single == $total){
				$copy_blog_array['grid_stat'] = 1;
				$last_out .= seoaal_blog_multi_layout_generate($copy_blog_array);
			}else{
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$sec_out .= '<div class="media mb-3">';
						$sec_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$sec_out .= '<div class="media-body ml-3">';
							$sec_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$sec_out .= '</div><!-- .media-body -->';
					$sec_out .= '</div><!-- .media -->';
				}else{
					$sec_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}
			$single++;
		}
				
		$output .= '<div class="row">';
			$output .= '<div class="col-md-4">';
				$output .= $first_out;
			$output .= '</div><!-- .col-md-4 -->';
			$output .= '<div class="col-md-4">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $sec_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-sm-4 -->';
			$output .= '<div class="col-md-4">';
				$output .= $last_out;
			$output .= '</div><!-- .col-md-4 -->';
		$output .= '</div><!-- .row -->';
		
	$output .= '</div><!-- .blog-multi-layout-4 -->';
	return $output;
}

function seoaal_blog_multi_layout_5_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-5">';
		$single = 1;
		$copy_blog_array = $blog_array;
		$total = $query->post_count;
		
		$first_out = $sec_out = $third_out = '';
		
		while ($query->have_posts()){
			$query->the_post();
			if($single == 1){
				$blog_array['grid_stat'] = 1;
				$first_out .= seoaal_blog_multi_layout_generate($blog_array);
				$blog_array['elemetns'] = $blog_array['secondary_elemetns'];
				$blog_array['thumb_size'] = $blog_array['secondary_thumb_size'];
				$blog_array['cus_thumb_size'] = $blog_array['cus_secondary_thumb_size'];
				$blog_array['title_head'] = $blog_array['secondary_title_head'];
			}elseif($single >= 5){
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$third_out .= '<div class="media mb-3">';
						$third_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$third_out .= '<div class="media-body ml-3">';
							$third_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$third_out .= '</div><!-- .media-body -->';
					$third_out .= '</div><!-- .media -->';
				}else{
					$third_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}else{
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$sec_out .= '<div class="media mb-3">';
						$sec_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$sec_out .= '<div class="media-body ml-3">';
							$sec_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$sec_out .= '</div><!-- .media-body -->';
					$sec_out .= '</div><!-- .media -->';
				}else{
					$sec_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}
			$single++;
		}
		$output .= '<div class="row">';
			$output .= '<div class="col-md-4">';
				$output .= $first_out;
			$output .= '</div><!-- .col -->';
			$output .= '<div class="col-md-4">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $sec_out;
				$output .= '</div><!-- .independent-block-secondary -->';	
			$output .= '</div><!-- .col -->';
			$output .= '<div class="col-md-4">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $third_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col -->';
		$output .= '</div><!-- .row -->';
	$output .= '</div><!-- .blog-multi-layout-5 -->';
	return $output;
}

function seoaal_blog_multi_layout_6_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-6">';
		$single = 0;
		
		$first_out = $sec_out = '';
		
		while ($query->have_posts()){
			$query->the_post();
			if($single == 0){
				$blog_array['grid_stat'] = 1;
				$first_out = seoaal_blog_multi_layout_generate($blog_array);
				
				$single = 1;
				$blog_array['elemetns'] = $blog_array['secondary_elemetns'];
				$blog_array['thumb_size'] = $blog_array['secondary_thumb_size'];
				$blog_array['cus_thumb_size'] = $blog_array['cus_secondary_thumb_size'];
				$blog_array['title_head'] = $blog_array['secondary_title_head'];
			}else{	
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$sec_out .= '<div class="media mb-3">';
						$sec_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$sec_out .= '<div class="media-body ml-3">';
							$sec_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$sec_out .= '</div><!-- .media-body -->';
					$sec_out .= '</div><!-- .media -->';
				}else{
					$sec_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}
		}
		$output .= '<div class="row">';
			$output .= '<div class="col-md-12"><!--top col start-->';
				$output .= $first_out;
			$output .= '</div><!--col end-->';
			$output .= '<div class="col-md-12">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $sec_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-md-12 -->';
		$output .= '</div><!-- .row -->';
	$output .= '</div><!-- .blog-multi-layout-6 -->';
	return $output;
}

function seoaal_blog_multi_layout_7_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-7">';
		$single = 1;
		$total = $query->post_count;
		
		$first_out = $sec_out = $third_out = $last_out = '';
		
		while ($query->have_posts()){
			$query->the_post();
			if($single == 1){
				$blog_array['grid_stat'] = 1;
				$first_out = seoaal_blog_multi_layout_generate($blog_array);
			}elseif($single == 2){
				$blog_array['grid_stat'] = 1;
				$sec_out = seoaal_blog_multi_layout_generate($blog_array);
				$blog_array['elemetns'] = $blog_array['secondary_elemetns'];
				$blog_array['thumb_size'] = $blog_array['secondary_thumb_size'];
				$blog_array['cus_thumb_size'] = $blog_array['cus_secondary_thumb_size'];
				$blog_array['title_head'] = $blog_array['secondary_title_head'];
			}elseif( $single > 2 && ( $single % 2 == 1 ) ){
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$third_out .= '<div class="media mb-3">';
						$third_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$third_out .= '<div class="media-body ml-3">';
							$third_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$third_out .= '</div><!-- .media-body -->';
					$third_out .= '</div><!-- .media -->';
				}else{
					$third_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}else{	
				$blog_array['grid_stat'] = 0;
				if( isset( $blog_array['elemetns']['Enabled']['thumb'] ) ){
					$last_out .= '<div class="media mb-3">';
						$last_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $blog_array );
						$t_blog_array = $blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$last_out .= '<div class="media-body ml-3">';
							$last_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$last_out .= '</div><!-- .media-body -->';
					$last_out .= '</div><!-- .media -->';
				}else{
					$last_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}
			$single++;
		}
				
		$output .= '<div class="row">';
			$output .= '<div class="col-md-6">';
				$output .= $first_out;
			$output .= '</div><!-- .col-md-6 -->';
			$output .= '<div class="col-md-6">';
				$output .= $sec_out;
			$output .= '</div><!-- .col-md-6 -->';
		$output .= '</div><!-- .row -->';
		$output .= '<div class="row">';
			$output .= '<div class="col-md-6">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $third_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-md-6 -->';
			$output .= '<div class="col-md-6">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $last_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-md-6 -->';
		$output .= '</div><!-- .row -->';
	$output .= '</div><!-- .blog-multi-layout-7 -->';
	return $output;
}

function seoaal_blog_multi_layout_8_generate( $query, $blog_array ){
	$output = '<div class="blog-multi-layout-8">';
		$single = 1;
		$total = $query->post_count;
		$copy_blog_array = $blog_array;
		$first_out = $sec_out = $third_out = $last_out = '';
		
		$copy_blog_array['elemetns'] = $copy_blog_array['secondary_elemetns'];
		$copy_blog_array['thumb_size'] = $copy_blog_array['secondary_thumb_size'];
		$copy_blog_array['cus_thumb_size'] = $copy_blog_array['cus_secondary_thumb_size'];
		$copy_blog_array['title_head'] = $copy_blog_array['secondary_title_head'];
		
		while ($query->have_posts()){
			$query->the_post();
			if($single == 1){
				$blog_array['grid_stat'] = 1;
				$first_out = seoaal_blog_multi_layout_generate($blog_array);
			}elseif( $single > 1 && $single < 5 ){
				$blog_array['grid_stat'] = 0;
				if( isset( $copy_blog_array['elemetns']['Enabled']['thumb'] ) ){
					$sec_out .= '<div class="media mb-3">';
						$sec_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $copy_blog_array );
						$t_blog_array = $copy_blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$sec_out .= '<div class="media-body ml-3">';
							$sec_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$sec_out .= '</div><!-- .media-body -->';
					$sec_out .= '</div><!-- .media -->';
				}else{
					$sec_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}elseif($single == $total){
				$blog_array['grid_stat'] = 1;
				$last_out = seoaal_blog_multi_layout_generate($blog_array);
			}else{	
				$blog_array['grid_stat'] = 0;
				if( isset( $copy_blog_array['elemetns']['Enabled']['thumb'] ) ){
					$third_out .= '<div class="media mb-3">';
						$t_blog_array = $copy_blog_array;
						unset( $t_blog_array['elemetns']['Enabled']['thumb'] );
						$third_out .= '<div class="media-body mr-3">';
							$third_out .= seoaal_blog_multi_layout_generate($t_blog_array);
						$third_out .= '</div><!-- .media-body -->';
						$third_out .= seoaal_blog_classic_shortcode_elements( 'thumb', $copy_blog_array );
					$third_out .= '</div><!-- .media -->';
				}else{
					$third_out .= seoaal_blog_multi_layout_generate($blog_array);
				}
			}
			$single++;
		}
				
		$output .= '<div class="row">';
			$output .= '<div class="col-md-6">';
				$output .= $first_out;
			$output .= '</div><!-- .col-md-6 -->';
			$output .= '<div class="col-md-6">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $sec_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-md-6 -->';
		$output .= '</div><!-- .row -->';
		$output .= '<div class="row">';
			$output .= '<div class="col-md-6">';
				$output .= '<div class="independent-block-secondary">';
					$output .= $third_out;
				$output .= '</div><!-- .independent-block-secondary -->';
			$output .= '</div><!-- .col-md-6 -->';
			$output .= '<div class="col-md-6">';
				$output .= $last_out;
			$output .= '</div><!-- .col-md-6 -->';
		$output .= '</div><!-- .row -->';
	$output .= '</div><!-- .blog-multi-layout-8 -->';
	return $output;
}

function seoaal_blog_multi_layout_generate( $blog_array ){
	$output = '';
	$elemetns = $blog_array['elemetns'];
	if( isset( $elemetns['Enabled'] ) ) :
		foreach( $elemetns['Enabled'] as $element => $value ){
			$output .= seoaal_blog_classic_shortcode_elements( $element, $blog_array );
		}
	endif;
	return $output;
}

function seoaal_blog_multi_layout_shortcode_elements( $element, $opts = array() ){
	$output = '';
	switch( $element ){
	
		case "title":
			$title_head = isset( $opts['title_head'] ) ? $opts['title_head'] : 'h4';
			$output .= '<div class="entry-title">';
				$output .= '<'. esc_attr( $title_head ) .'><a href="'. esc_url( get_the_permalink() ) .'" class="post-title">'. get_the_title() .'</a></'. esc_attr( $title_head ) .'>';
			$output .= '</div><!-- .entry-title -->';		
		break;
		
		case "thumb":
			if ( has_post_thumbnail() ) {
				// Custom Thumb Code
				$thumb_size = $thumb_cond = $opts['thumb_size'];
				$cus_thumb_size = $opts['cus_thumb_size'];
				$custom_opt = $img_prop = '';
				if( $thumb_cond == 'custom' ){
					$custom_opt = $cus_thumb_size != '' ? explode( "x", $cus_thumb_size ) : array();
					$img_prop = seoaal_custom_image_size_chk( $thumb_size, $custom_opt );
					$thumb_size = array( $img_prop[1], $img_prop[2] );
				} 
				// Custom Thumb Code End
									
				$output .= '<div class="post-thumb">';
					
					$lazy_opt = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load');
					if( $lazy_opt ){
						$img_prop = $img_prop ? $img_prop : seoaal_custom_image_size_chk( $thumb_size, $custom_opt );
						$lazy_img = SeoaalThemeOpt::seoaalStaticThemeOpt('lazy-load-img');
						if( isset( $lazy_img['id'] ) && $lazy_img['id'] != '' ){
							$pre_img_prop = seoaal_custom_image_size_chk( $thumb_size, $custom_opt, true, absint( $lazy_img['id'] ) );
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
										
					if( isset( $opts['overlay_opt'] ) && $opts['overlay_opt'] && isset( $opts['grid_stat'] ) && $opts['grid_stat'] == 1 ){
						$elemetns = isset( $opts['overlay_items'] ) && !empty( $opts['overlay_items'] ) ? $opts['overlay_items'] : array( 'Enabled' => '' );
						$overlay_class = isset( $opts['overlay_class'] ) ? $opts['overlay_class'] : '';
						if( isset( $elemetns['Enabled'] ) ) :
							$output .= '<div class="post-overlay-wrap seoaal-overlay-wrap'. esc_attr( $overlay_class ) .'">';
								foreach( $elemetns['Enabled'] as $element => $value ){
									$output .= seoaal_blog_multi_layout_shortcode_elements( $element, $opts );
								}
							$output .= '</div><!-- .seoaal-overlay-wrap -->';
						endif;
					}
					
				$output .= '</div><!-- .post-thumb -->';
			}
		break;
		
		case "category":
			$categories = get_the_category(); 
			if ( ! empty( $categories ) ){
				$coutput = '<div class="post-category">';
					foreach ( $categories as $category ) {
						$coutput .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>,';
					}
					$output .= rtrim( $coutput, ',' );
				$output .= '</div>';
			}
		break;
		
		case "author":
			$output .= '<div class="post-author">';
				$output .= '<a href="'. get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) .'">';
					$output .= '<span class="author-name"><i class="fa fa-user mr-2"></i>'. get_the_author() .'</span>';
				$output .= '</a>';
			$output .= '</div>';
		break;
		
		case "date":
			$archive_year  = get_the_time('Y');
			$archive_month = get_the_time('m'); 
			$archive_day   = get_the_time('d');
			$output = '<div class="post-date"><a href="'. esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) .'" >'. get_the_time( get_option( 'date_format' ) ) .'</a></div>';
		break;
		
		case "more":
			$read_more_text = isset( $opts['more_text'] ) ? $opts['more_text'] : esc_html__( 'Read more', 'seoaal' );
			$output = '<div class="post-more"><a class="read-more" href="'. esc_url( get_permalink( get_the_ID() ) ) . '">'. esc_html( $read_more_text ) .'</a></div>';
		break;
		
		case "comment":
			$comments_count = wp_count_comments(get_the_ID());
			$cmt_txt = esc_html__( 'Comments', 'seoaal' );
			if( $comments_count->total_comments == 1 ){
				$cmt_txt = esc_html__( 'Comment', 'seoaal' );
			}
			$output = '<div class="post-comment"><a href="'. esc_url( get_comments_link( get_the_ID() ) ) .'" rel="bookmark" class="comments-count"><i class="fa fa-comments mr-1"></i> '. esc_html( $comments_count->total_comments .' '. $cmt_txt ).'</a></div>';
		break;
		
		case "excerpt":
			$output = '';
			$excerpt = isset( $opts['excerpt_length'] ) && $opts['excerpt_length'] != '' ? $opts['excerpt_length'] : 20;
			$output .= '<div class="post-excerpt">';
				add_filter( 'excerpt_length', __return_value( $excerpt ) );
				ob_start();
				the_excerpt();
				$excerpt_cont = ob_get_clean();
				$output .= $excerpt_cont;
			$output .= '</div><!-- .post-excerpt -->';	
		break;		
		
		case "top-meta":
			$output = '';
			$top_meta = $opts['top_meta'];
			$elemetns = isset( $top_meta ) ? seoaal_drag_and_drop_trim( $top_meta ) : array( 'Enabled' => '' );
			if( isset( $elemetns['Enabled'] ) ) :
				$output .= '<div class="top-meta clearfix"><ul class="top-meta-list">';
					foreach( $elemetns['Enabled'] as $element => $value ){
						$blog_array = array( 'more_text' => $opts['more_text'] );
						$output .= '<li>'. seoaal_blog_multi_layout_shortcode_elements( $element, $blog_array ) .'</li>';
					}
				$output .= '</ul></div>';
			endif;
		break;
		
		case "bottom-meta":
			$output = '';
			$bottom_meta = $opts['bottom_meta'];
			$elemetns = isset( $bottom_meta ) ? seoaal_drag_and_drop_trim( $bottom_meta ) : array( 'Enabled' => '' );
			if( isset( $elemetns['Enabled'] ) ) :
				$output .= '<div class="bottom-meta clearfix"><ul class="bottom-meta-list">';
					foreach( $elemetns['Enabled'] as $element => $value ){
						$blog_array = array( 'more_text' => $opts['more_text'] );
						$output .= '<li>'. seoaal_blog_multi_layout_shortcode_elements( $element, $blog_array ) .'</li>';
					}
				$output .= '</ul></div>';
			endif;
		break;
	}
	return $output; 
}
if ( ! function_exists( "seoaal_vc_blog_multi_layout_shortcode_map" ) ) {
	function seoaal_vc_blog_multi_layout_shortcode_map() {
				
		vc_map( 
			array(
				"name"					=> esc_html__( "Blog Layouts", "seoaal" ),
				"description"			=> esc_html__( "Blog custom post type.", "seoaal" ),
				"base"					=> "seoaal_vc_blog_multi_layout",
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
						"heading"		=> esc_html__( "Blog Layout", "seoaal" ),
						"description"	=> esc_html__( "This is an option for change blog layout", "seoaal" ),
						"param_name"	=> "blog_layout",
						"value"			=> array(
							esc_html__( "Layout 1", "seoaal" )=> "1",
							esc_html__( "Layout 2", "seoaal" )=> "2",
							esc_html__( "Layout 3", "seoaal" )=> "3",
							esc_html__( "Layout 4", "seoaal" )=> "4",
							esc_html__( "Layout 5", "seoaal" )=> "5",
							esc_html__( "Layout 6", "seoaal" )=> "6",
							esc_html__( "Layout 7", "seoaal" )=> "7",
							esc_html__( "Layout 8", "seoaal" )=> "8"
						),
						"std"	=> "1"
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
						"description"	=> esc_html__( "Here you can define post excerpt length. Example 10", "seoaal" ),
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
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Read More Text", "seoaal" ),
						"description"	=> esc_html__( "Here you can enter read more text instead of default text.", "seoaal" ),
						"param_name"	=> "more_text",
						"value" 		=> esc_html__( "Read More", "seoaal" ),
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
						"heading"		=> esc_html__( "Primary Title Heading Tag", "seoaal" ),
						"description"	=> esc_html__( "This is an option for title heading tag", "seoaal" ),
						"param_name"	=> "primary_title_head",
						"value"			=> array(
							esc_html__( "H1", "seoaal" )=> "h1",
							esc_html__( "H2", "seoaal" )=> "h2",
							esc_html__( "H3", "seoaal" )=> "h3",
							esc_html__( "H4", "seoaal" )=> "h4",
							esc_html__( "H5", "seoaal" )=> "h5",
							esc_html__( "H6", "seoaal" )=> "h6"
						),
						"std"	=> "h3",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Title Heading Tag", "seoaal" ),
						"description"	=> esc_html__( "This is an option for title heading tag", "seoaal" ),
						"param_name"	=> "secondary_title_head",
						"value"			=> array(
							esc_html__( "H1", "seoaal" )=> "h1",
							esc_html__( "H2", "seoaal" )=> "h2",
							esc_html__( "H3", "seoaal" )=> "h3",
							esc_html__( "H4", "seoaal" )=> "h4",
							esc_html__( "H5", "seoaal" )=> "h5",
							esc_html__( "H6", "seoaal" )=> "h6"
						),
						"std"	=> "h6",
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Primary Post Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for blog custom layout. here you can set your own layout. Drag and drop needed blog items to Enabled part.", "seoaal" ),
						'param_name'	=> 'primary_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'thumb'	=> esc_html__( 'Feature Image', 'seoaal' ),
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'category'	=> esc_html__( 'Category', 'seoaal' ),
								'author'	=> esc_html__( 'Author', 'seoaal' ),
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' )
							),
							'disabled' => array(
								'top-meta'	=> esc_html__( 'Top Meta', 'seoaal' ),
								'bottom-meta'	=> esc_html__( 'Bottom Meta', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Secondary Post Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for blog custom secondary layout. here you can set your own secondary layout. Drag and drop needed blog secondary items to Enabled part.", "seoaal" ),
						'param_name'	=> 'secondary_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'thumb'	=> esc_html__( 'Feature Image', 'seoaal' ),
								'title'	=> esc_html__( 'Title', 'seoaal' ),
								'category'	=> esc_html__( 'Category', 'seoaal' ),
								'author'	=> esc_html__( 'Author', 'seoaal' )								
							),
							'disabled' => array(
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'top-meta'	=> esc_html__( 'Top Meta', 'seoaal' ),
								'bottom-meta'	=> esc_html__( 'Bottom Meta', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Blog Overlay Option", "seoaal" ),
						"description"	=> esc_html__( "This is an option for enable blog image overlay items show.", "seoaal" ),
						"param_name"	=> "blog_overlay_opt",
						"value"			=> array(
							esc_html__( "No", "seoaal" )	=> "no",
							esc_html__( "Yes", "seoaal" )	=> "yes"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Blog Overlay Items', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for blog overlay custom layout. here you can set your own layout. Drag and drop needed blog overlay items to Enabled part.", "seoaal" ),
						'param_name'	=> 'blog_overlay_items',
						'dd_fields' => array ( 
							'Enabled' => array( 
								'title'	=> esc_html__( 'Title', 'seoaal' )													
							),
							'disabled' => array(
								'excerpt'	=> esc_html__( 'Excerpt', 'seoaal' ),
								'top-meta'	=> esc_html__( 'Top Meta', 'seoaal' ),
								'bottom-meta'	=> esc_html__( 'Bottom Meta', 'seoaal' ),
								'category'	=> esc_html__( 'Category', 'seoaal' ),
								'author'	=> esc_html__( 'Author', 'seoaal' )
							)
						),
						"dependency" => array(
							"element" => "blog_overlay_opt",
							"value"	=> array( "yes" )
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Overlay Items Position", "seoaal" ),
						"description"	=> esc_html__( "This is an option for blog overlay items position.", "seoaal" ),
						"param_name"	=> "blog_overlay_position",
						"value"			=> array(
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Top Left", "seoaal" )	=> "top-left",
							esc_html__( "Top Right", "seoaal" )	=> "top-right",
							esc_html__( "Bottom Left", "seoaal" )	=> "bottom-left",
							esc_html__( "Bottom Right", "seoaal" )	=> "bottom-right",
							esc_html__( "Bottom Center", "seoaal" )	=> "bottom-center"
						),
						'dependency' => array(
							'element' => 'blog_overlay_opt',
							'value' => 'yes',
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Post Top Meta', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for blog shortcode post top meta.", "seoaal" ),
						'param_name'	=> 'top_meta',
						'dd_fields' => array ( 
							'Enabled' => array(),
							'disabled' => array(
								'category'	=> esc_html__( 'Category', 'seoaal' ),
								'author'	=> esc_html__( 'Author', 'seoaal' ),
								'more'	=> esc_html__( 'Read More', 'seoaal' ),
								'date'	=> esc_html__( 'Date', 'seoaal' ),
								'comment'	=> esc_html__( 'Comment', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						'type'			=> 'drag_drop',
						'heading'		=> esc_html__( 'Post Bottom Meta', 'seoaal' ),
						"description"	=> esc_html__( "This is settings for blog shortcode post bottom meta.", "seoaal" ),
						'param_name'	=> 'bottom_meta',
						'dd_fields' => array ( 
							'Enabled' => array(),
							'disabled' => array(
								'category'	=> esc_html__( 'Category', 'seoaal' ),
								'author'	=> esc_html__( 'Author', 'seoaal' ),
								'more'	=> esc_html__( 'Read More', 'seoaal' ),
								'date'	=> esc_html__( 'Date', 'seoaal' ),
								'comment'	=> esc_html__( 'Comment', 'seoaal' )
							)
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> "dropdown",
						"heading"		=> esc_html__( "Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for blog text align", "seoaal" ),
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
						"heading"		=> esc_html__( "Secondary Posts Text Align", "seoaal" ),
						"description"	=> esc_html__( "This is an option for secondary layout posts text align", "seoaal" ),
						"param_name"	=> "sec_text_align",
						"value"			=> array(
							esc_html__( "Default", "seoaal" )	=> "default",
							esc_html__( "Left", "seoaal" )		=> "left",
							esc_html__( "Center", "seoaal" )	=> "center",
							esc_html__( "Right", "seoaal" )		=> "right"
						),
						"group"			=> esc_html__( "Layouts", "seoaal" )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Primary Image Size", "seoaal" ),
						"param_name"	=> "primary_image_size",
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
						'heading'		=> esc_html__( 'Primary Custom Image Size', "seoaal" ),
						'param_name'	=> 'custom_primary_image_size',
						'description'	=> esc_html__( 'Enter custom image size. eg: 200x200', 'seoaal' ),
						'value' 		=> '',
						"dependency"	=> array(
								"element"	=> "primary_image_size",
								"value"		=> "custom"
						),
						'group'			=> esc_html__( 'Image', 'seoaal' )
					),
					array(
						"type"			=> 'dropdown',
						"heading"		=> esc_html__( "Secondary Image Size", "seoaal" ),
						"param_name"	=> "secondary_image_size",
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
						'heading'		=> esc_html__( 'Secondary Custom Image Size', "seoaal" ),
						'param_name'	=> 'custom_secondary_image_size',
						'description'	=> esc_html__( 'Enter custom image size. eg: 200x200', 'seoaal' ),
						'value' 		=> '',
						"dependency"	=> array(
								"element"	=> "secondary_image_size",
								"value"		=> "custom"
						),
						'group'			=> esc_html__( 'Image', 'seoaal' )
					),
					array(
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Primary Items Spacing", "seoaal" ),
						"description"	=> esc_html__( "This is options for grid layout spacing, Enter custom bottom space for each item on main wrapper. Your space values will apply like nth child method. If you leave this empty, default theme space apply for each child. If you want default value for any child, just type \"default\". It will take default value for that child. Example 10px 12px 8px", "seoaal" ),
						"param_name"	=> "sc_grid_spacing",
						"value" 		=> "",
						"group"			=> esc_html__( "Spacing", "seoaal" ),
					),
					array(
						"type"			=> "textarea",
						"heading"		=> esc_html__( "Secondary Items Spacing", "seoaal" ),
						"description"	=> esc_html__( "This is options for list layout spacing, Enter custom bottom space for each item on main wrapper. Your space values will apply like nth child method. If you leave this empty, default theme space apply for each child. If you want default value for any child, just type \"default\". It will take default value for that child. Example 10px 12px 8px", "seoaal" ),
						"param_name"	=> "sc_list_spacing",
						"value" 		=> "",
						"group"			=> esc_html__( "Spacing", "seoaal" ),
					)
				)
			) 
		);
	}
}
add_action( "vc_before_init", "seoaal_vc_blog_multi_layout_shortcode_map" );