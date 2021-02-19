<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 */
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'seoaal' ); ?></h1>
	</header>
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<?php
				$allowed_html = array(
					'a' => array(
						'href' => array(),
						'title' => array()
					)
				);
			?>
			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'seoaal' ), $allowed_html ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can not find what you are looking for. Perhaps searching can help.', 'seoaal' ); ?></p>
			<?php
				get_search_form();
		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->