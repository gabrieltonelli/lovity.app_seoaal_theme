<?php
/* =========================================
 * Enqueues parent theme stylesheet
 * ========================================= */

add_action( 'wp_enqueue_scripts', 'seoaal_enqueue_child_theme_styles', 30 );
function seoaal_enqueue_child_theme_styles() {
	wp_enqueue_style( 'seoaal-child-theme-style', get_stylesheet_uri(), array(), null );
}
