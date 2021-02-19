<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
$aps = new SeoaalPostSettings;
$layout = $aps->seoaalGetCurrentLayout();
$article_style = $aps->seoaalArticleStyle();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( esc_attr( $article_style ) ); ?>>
	<?php if ( is_sticky() && is_home() ) : ?>
		<span class="sticky-post-icon"><i class="icon-pin icons"></i></span>
	<?php endif; ?>
	<?php $aps->seoaalPostItems(); ?>
</article><!-- #post-## -->