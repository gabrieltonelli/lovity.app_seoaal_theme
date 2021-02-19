<?php
/**
 * The template for displaying archive pages
 */
//Check CPT
if( class_exists( "SeoaalCPT" ) ){
	if( is_tax( array( 'portfolio-categories', 'portfolio-tags', 'team-categories' ) ) ){
		get_template_part( 'taxonomy', 'cpt' );
		return;
	}
}
get_header(); 
$ahe = new SeoaalHeaderElements;
$template = 'blog'; // template id
$aps = new SeoaalPostSettings;
if( $aps->seoaalCheckTemplateExists( 'archive' ) ){
	$template = 'archive';
}
$aps->seoaalSetPostTemplate( $template );
add_filter( 'excerpt_length', array( &$aps, 'seoaalSetExcerptLength' ), 999 );
$template_class = $aps->seoaalTemplateContentClass();
$extra_class = $layout = $aps->seoaalGetCurrentLayout();
$top_standard = $aps->seoaalGetThemeOpt( $template.'-top-standard-post' );
$gutter = $cols = $infinite = $isotope = '';
if( $layout == 'grid-layout' ){
	$cols = $aps->seoaalGetThemeOpt( $template.'-grid-cols' );
	$gutter = $aps->seoaalGetThemeOpt( $template.'-grid-gutter' );
	$infinite = $aps->seoaalGetThemeOpt( $template.'-infinite-scroll' ) ? 'true' : 'false';
	$isotope = $aps->seoaalGetThemeOpt( $template.'-grid-type' );
	$extra_class .= $aps->seoaalGetThemeOpt( $template.'-grid-type' ) == 'normal' ? ' grid-normal' : '';
	
	if( $isotope == 'isotope' ){
		wp_enqueue_script( 'isotope-pkgd' );
		wp_enqueue_script( 'imagesloaded' );
	}
	if( $infinite == 'true' ){
		wp_enqueue_script( 'infinite-scroll' );
	}
}
?>
<div class="seoaal-content <?php echo esc_attr( 'seoaal-' . $template ); ?>">
	<?php $ahe->seoaalPageTitle( $template ); ?>
	
	<?php 
		if( $aps->seoaalThemeOpt( $template.'-featured-slider' ) ){
			$ahe->seoaalFeaturedSlider( $template );
		}
	?>
	
	<div class="seoaal-content-inner">
		<div class="container">
			
			<div class="row">
		
				<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
					<div id="primary" class="content-area">
						<main id="main" class="site-main <?php echo esc_attr( $template ); ?>-template <?php echo esc_attr( $extra_class ); ?>" data-cols="<?php echo esc_attr( $cols ); ?>" data-gutter="<?php echo esc_attr( $gutter ); ?>">
							
							<?php
							
							if ( have_posts() ) :
		
								$chk = $isotope_stat = 1;
								/* Start the Loop */
								while ( have_posts() ) : the_post();
								
									if( $top_standard && $layout != 'standard-layout' ) : ?>
										
										<div class="top-standard-post clearfix">
											<?php
											$aps::$top_standard = true;
											get_template_part( 'template-parts/post/content' );
											$aps::$top_standard = false;
											$top_standard = false;
											?>
										</div><?php
										
									else :
									
										if( $layout == 'grid-layout' && $isotope == 'isotope' && $isotope_stat == 1 ) : $isotope_stat = 0; ?>
											<div class="isotope" data-cols="<?php echo esc_attr( $cols ); ?>" data-gutter="<?php echo esc_attr( $gutter ); ?>" data-infinite="<?php echo esc_attr( $infinite ); ?>"><?php
										endif;
		
										if( $chk == 1 && $layout == 'grid-layout' && $isotope == 'normal' ) : echo '<div class="grid-parent clearfix">';  endif;
										
										get_template_part( 'template-parts/post/content' );
										
										if( $chk == $cols && $layout == 'grid-layout' && $isotope == 'normal' ) : echo '</div><!-- .grid-parent -->'; $chk = 0; endif;
										
										$chk++;
									
									endif;
				
								endwhile;
								
									if( $layout == 'grid-layout' && $isotope == 'isotope' && $isotope_stat == 0 ) : $isotope_stat = 0; ?>
										</div><!-- .isotope --><?php
									endif;
		
									if( $chk != 1 && $layout == 'grid-layout' && $isotope == 'normal' ) : echo '</div><!-- .grid-parent -->'; endif; // Unexpected if odd grid
					
							else :
				
								get_template_part( 'template-parts/post/content', 'none' );
				
							endif;
							?>
				
						</main><!-- #main -->
							<?php $aps->seoaalWpBootstrapPagination(); ?>
					</div><!-- #primary -->
				</div><!-- main col -->
				
				<?php if( $template_class['lsidebar_class'] != '' ) : ?>
				<div class="<?php echo esc_attr( $template_class['lsidebar_class'] ); ?>">
					<aside class="widget-area left-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
						<?php dynamic_sidebar( $template_class['left_sidebar'] ); ?>
					</aside>
				</div><!-- sidebar col -->
				<?php endif; ?>
				
				<?php if( $template_class['rsidebar_class'] != '' ) : ?>
				<div class="<?php echo esc_attr( $template_class['rsidebar_class'] ); ?>">
					<aside class="widget-area right-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
						<?php dynamic_sidebar( $template_class['right_sidebar'] ); ?>
					</aside>
				</div><!-- sidebar col -->
				<?php endif; ?>
				
			</div><!-- .row -->
			
		</div><!-- .container -->
	</div><!-- .seoaal-content-inner -->
</div><!-- .seoaal-content -->
<?php get_footer();