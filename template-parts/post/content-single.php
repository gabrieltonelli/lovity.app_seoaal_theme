<?php
/**
 * Template part for displaying posts
 *
 */
$template = 'single-post';
$layout = 'standard';
$aps = new SeoaalPostSettings;
$post_elements = $aps->seoaalThemeOpt( $template.'-items' );
$post_items = array();
$post_items_opt = get_post_meta( get_the_ID(), 'seoaal_post_items_opt', true );
if( $post_items_opt == '' || $post_items_opt == 'theme-default' ){
	$post_items = isset( $post_elements['Enabled'] ) && !empty( $post_elements['Enabled'] ) ? $post_elements['Enabled'] : '';
	
}else{
	$meta_post_items = get_post_meta( get_the_ID(), 'seoaal_post_items', true );
	$t_post_items = explode( ',', $meta_post_items );
	foreach ( $t_post_items as $element ) 
		$post_items[$element] = $element;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="article-inner post-items">
	<?php
		if( $post_items ):
		
			if( array_key_exists( "placebo", $post_items ) ) unset( $post_items['placebo'] );
			foreach ( $post_items as $element => $value ) {
				
				switch($element) {
				
					case 'title':
						$layout = $aps->seoaalThemeOpt($template.'-post-template');
					?>
						<header class="entry-header">
							<?php echo ( ''. $aps->seoaalPostTitle( $layout ) ); ?>
						</header>
					<?php									
					break;
					
					case 'top-meta':
					?>
						<div class="entry-meta top-meta clearfix">
							<?php $aps->seoaalPostMeta( 'topmeta' ); ?>
						</div>
					<?php
					break;
					
					case 'thumb':
						if( $layout != 'list-layout' ):
							$post_format = $aps->seoaalPostFormat();
							if( !empty( $post_format  ) ){
							?>
								<div class="post-format-wrap">
									<?php echo ( ''. $post_format ); ?>
								</div>
							<?php
							}
						endif;
						if ( is_attachment() ) {
							echo '<div class="entry-content">';
								the_content();
							echo '</div>';
						}
					break;
					
					case 'content':
						if( '' !== get_the_content() ) {
					?>
						<div class="entry-content">
							<?php 
							
								the_content();
								
								wp_link_pages( array(
									'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'seoaal' ),
									'after'       => '</div>',
									'link_before' => '<span class="page-number">',
									'link_after'  => '</span>',
								) );
								
							?>
						</div>
					<?php
						}
					break;
					
					case 'bottom-meta':
					?>
						<footer class="entry-footer">
							<div class="entry-meta bottom-meta clearfix">
								<?php $aps->seoaalPostMeta( 'bottommeta' ); ?>
							</div>
						</footer>
					<?php
					break;
					
					
				} // switch					
			} //foreach		
		endif;
	?>
	</div><!-- .article-inner -->
</article><!-- #post-## -->