<?php
/**
 * Template part for displaying related post as slider
 *
 */
$aps = new SeoaalPostSettings;
$slide_template = 'featured';
$cols = '';
$gal_atts = array(
	'data-loop="'. $aps->seoaalThemeOpt( $slide_template.'-slide-infinite' ) .'"',
	'data-margin="'. $aps->seoaalThemeOpt( $slide_template.'-slide-margin' ) .'"',
	'data-center="'. $aps->seoaalThemeOpt( $slide_template.'-slide-center' ) .'"',
	'data-nav="'. $aps->seoaalThemeOpt( $slide_template.'-slide-navigation' ) .'"',
	'data-dots="'. $aps->seoaalThemeOpt( $slide_template.'-slide-pagination' ) .'"',
	'data-autoplay="'. $aps->seoaalThemeOpt( $slide_template.'-slide-autoplay' ) .'"',
	'data-items="'. $aps->seoaalThemeOpt( $slide_template.'-slide-items' ) .'"',
	'data-items-tab="'. $aps->seoaalThemeOpt( $slide_template.'-slide-tab' ) .'"',
	'data-items-mob="'. $aps->seoaalThemeOpt( $slide_template.'-slide-mobile' ) .'"',
	'data-duration="'. $aps->seoaalThemeOpt( $slide_template.'-slide-duration' ) .'"',
	'data-smartspeed="'. $aps->seoaalThemeOpt( $slide_template.'-slide-smartspeed' ) .'"',
	'data-scrollby="'. $aps->seoaalThemeOpt( $slide_template.'-slide-scrollby' ) .'"',
	'data-autoheight="'. $aps->seoaalThemeOpt( $slide_template.'-slide-autoheight' ) .'"',
);
$data_atts = implode( " ", $gal_atts );
$cols = absint( $aps->seoaalThemeOpt( $slide_template.'-slide-items' ) );
if( $cols == 1 ){
	$thumb_size = 'large';
}elseif( $cols == 2 ){
	$thumb_size = 'medium';
}elseif( $cols == 3 ){
	$thumb_size = 'seoaal-grid-large';
}else{
	$thumb_size = 'seoaal-grid-medium';
}
$args = array(
	'ignore_sticky_posts' => 1,
	'posts_per_page'=> -1,
	'meta_query' => array(
		array(
			'key' => 'seoaal_post_featured_stat',
			'value' => 1
		)
	),
);
$slide_class = $cols == 1 ? ' owl-single-item' : '';
$related_query = new WP_Query( $args );
if( $related_query->have_posts() ) { 

	wp_enqueue_script( 'owl-carousel' );
	wp_enqueue_style( 'owl-carousel' );

?>
	<div class="featured-slider-wrapper clearfix">
		<div class="owl-carousel featured-slider<?php echo esc_attr( $slide_class ); ?>" <?php echo ( ''. $data_atts ); ?>><?php
		while( $related_query->have_posts() ) : $related_query->the_post(); ?>
		
			<div class="item">
				<div class="featured-item">
					<?php 
						if ( has_post_thumbnail( get_the_ID() ) ) :
					?>
						<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute();  ?>">
							<?php echo get_the_post_thumbnail( get_the_ID(), $thumb_size, array( 'class' => 'img-fluid' ) ); ?>
						</a>
					<?php else: ?>
						<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
							<div class="empty-post-image text-center"><i class="fa fa-picture-o"></i></div>
						</a>
					<?php endif; ?>
					<div class="featured-item-inner">
					
						<?php echo ( ''. $aps->seoaalMetaCategory() ); ?>
						
						<h3 class="featured-title">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" title="<?php the_title_attribute();  ?>">
								<?php echo get_the_title(); ?>
							</a>
						</h3>
						<?php
							//Author 
							echo ( ''. $aps->seoaalMetaAuthor() );
						?>
						<div class="featured-meta">
							<?php	
								//Date 
								echo ( ''. $aps->seoaalMetaDate() );
								
								//Comments Count 
								echo ( ''. $aps->seoaalMetaComment() );
							?>
						</div>
					</div><!-- .featured-item-inner -->
				</div><!-- .featured-item -->
			</div><!-- .item -->
		<?php
		endwhile;?>
		
		</div><!-- .related-slider -->
	</div><!-- .related-slider-wrapper --><?php
}
wp_reset_postdata();