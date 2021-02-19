<?php
/**
 * Template part for displaying page content in page.php
 *
 */
?>
<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	echo '<div class="entry-content">';
		the_content();
	echo '</div><!-- .entry-content -->';
	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'seoaal' ),
		'after'  => '</div>',
	) );
?>
</div><!-- #post-## -->