<?php
/**
 * The template for displaying all custom post types
 */
 
get_header(); 
$ahe = new SeoaalHeaderElements;
$aps = new SeoaalPostSettings;
$template = 'blog'; // template id
if( $aps->seoaalCheckTemplateExists( 'archive' ) ){
	$template = 'archive';
}
$aps->seoaalSetPostTemplate( $template );
$template_class = $aps->seoaalTemplateContentClass();
$full_width_class = '';
$acpt = new SeoaalCPT;
?>
<div class="seoaal-content <?php echo esc_attr( 'seoaal-' . $template ); ?>">
		
		<?php $ahe->seoaalHeaderSlider('bottom'); ?>
		
		<?php $ahe->seoaalPageTitle( $template ); ?>
		<div class="seoaal-content-inner">
			<div class="container">
	
				<div class="row">
					
					<div class="<?php echo esc_attr( $template_class['content_class'] ); ?>">
						<div id="primary" class="content-area">
							<?php
								$q_object = get_queried_object();
								$taxonomy = '';
								if( isset($q_object->taxonomy) )
									$taxonomy = $q_object->taxonomy;
								
								$acpt->seoaalCPTCallTaxTemplate( $taxonomy );
							?>				
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
					
				</div><!-- row -->
			
		</div><!-- .container -->
	</div><!-- .seoaal-content-inner -->
</div><!-- .seoaal-content -->
<?php get_footer();