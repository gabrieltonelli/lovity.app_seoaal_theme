<?php
if( !class_exists( "seoaalThemeStyles" ) ){
	require_once SEOAAL_INC . '/theme-class/theme-style-class.php';
}
$ats = new seoaalThemeStyles;
$theme_color = $ats->seoaalThemeColor();

echo '.editor-styles-wrapper .wp-block, .editor-styles-wrapper .editor-block-list__block.wp-block[data-align=wide], .wp-block[data-align="wide"] {
	max-width: '. $ats->seoaal_container_width() .';
}';

echo '.editor-styles-wrapper .wp-block:not([data-align="full"]) {
	max-width: '. $ats->seoaal_container_width() .';
}';

echo '.editor-block-list__layout .editor-block-list__block,
.editor-styles-wrapper .editor-block-list__layout .editor-block-list__block p,
.block-editor__container .editor-styles-wrapper .mce-content-body {';
	$ats->seoaal_typo_generate( 'body-typography' );
echo '
}';

echo '.post-type-post .editor-block-list__layout .editor-block-list__block {
	color: '. $ats->seoaal_theme_opt( 'single-post-article-color' ) .'; }';

$ats->seoaal_custom_font_check( 'h1-typography' );
echo '.editor-block-list__layout .editor-block-list__block h1,
.editor-styles-wrapper .editor-post-title__block .editor-post-title__input {';
	$ats->seoaal_typo_generate( 'h1-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h2-typography' );
echo '.editor-block-list__layout .editor-block-list__block h2{';
	$ats->seoaal_typo_generate( 'h2-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h3-typography' );
echo '.editor-block-list__layout .editor-block-list__block h3{';
	$ats->seoaal_typo_generate( 'h3-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h4-typography' );
echo '.editor-block-list__layout .editor-block-list__block h4{';
	$ats->seoaal_typo_generate( 'h4-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h5-typography' );
echo '.editor-block-list__layout .editor-block-list__block h5{';
	$ats->seoaal_typo_generate( 'h5-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h6-typography' );
echo '.editor-block-list__layout .editor-block-list__block h6{';
	$ats->seoaal_typo_generate( 'h6-typography' );
echo '
}';

$gen_link = $ats->seoaal_theme_opt('single-post-article-link-color');
if( $gen_link ):
echo '.post-type-post .editor-block-list__layout .editor-block-list__block a{';
	$ats->seoaal_link_color( 'single-post-article-link-color', 'regular' );
echo '
}';
echo '.post-type-post .editor-block-list__layout .editor-block-list__block a:hover{';
	$ats->seoaal_link_color( 'single-post-article-link-color', 'hover' );
echo '
}';
echo '.post-type-post .editor-block-list__layout .editor-block-list__block a:active{';
	$ats->seoaal_link_color( 'single-post-article-link-color', 'active' );
echo '
}';
endif;

$gen_link = $ats->seoaal_theme_opt('theme-link-color');
if( $gen_link ):
echo '.editor-block-list__layout .editor-block-list__block a{';
	$ats->seoaal_link_color( 'theme-link-color', 'regular' );
echo '
}';
echo '.editor-block-list__layout .editor-block-list__block a:hover{';
	$ats->seoaal_link_color( 'theme-link-color', 'hover' );
echo '
}';
echo '.editor-block-list__layout .editor-block-list__block a:active{';
	$ats->seoaal_link_color( 'theme-link-color', 'active' );
echo '
}';
endif;


echo '.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color),
.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline:hover .wp-block-button__link:not(.has-text-color),
.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline:focus .wp-block-button__link:not(.has-text-color),
.editor-block-list__layout .editor-block-list__block .wp-block-button.is-style-outline:active .wp-block-button__link:not(.has-text-color) {
	color: '. esc_attr( $theme_color ) .'; /* base: #0073a8; */
}


/* Button colors */
.entry-content .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color), 
.entry-content .wp-block-button.is-style-outline:hover .wp-block-button__link:not(.has-text-color) {
	color: '. esc_attr( $theme_color ) .'; /* base: #005177; */
}

.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button,
.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link,
.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:active,
.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:focus,
.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:hover {
	background-color: '. esc_attr( $theme_color ) .'; /* base: #0073a8; */
}

.wp-block-quote::before, .wp-block-freeform.block-library-rich-text__tinymce blockquote::before,
.wp-block-pullquote blockquote.has-light-gray-color::before, .editor-block-list__layout .editor-block-list__block .has-cyan-bluish-gray-background-color.has-cyan-bluish-gray-background-color:not(.has-background-color) blockquote::before, .wp-block-pullquote blockquote::before {
	color: '. esc_attr( $theme_color ) .'; /* base: #0073a8; */
}

.wp-block-quote::after, .wp-block-freeform.block-library-rich-text__tinymce blockquote::after,
.wp-block-pullquote blockquote.has-light-gray-color::after, .wp-block-pullquote blockquote::after {
	background-color: '. esc_attr( $theme_color ) .'; /* base: #0073a8; */
}

.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__button:hover,
.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:active,
.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:focus,
.editor-block-list__layout .editor-block-list__block .wp-block-button:not(.is-style-outline) .wp-block-button__link:hover {
	background-color: #333; /* base: #0073a8; */
}

/* Hover colors */
.editor-block-list__layout .editor-block-list__block .wp-block-file .wp-block-file__textlink:hover {
color: '. esc_attr( $theme_color ) .'; /* base: #005177; */
}
.editor-block-list__layout figure.wp-block-pullquote {
    border-bottom: none;
    border-top: none;
}
.wp-block-quote, .wp-block-freeform.block-library-rich-text__tinymce blockquote,
.wp-block-pullquote blockquote.has-light-gray-color,
.wp-block-pullquote blockquote, blockquote.wp-block-quote.is-style-large {
	border-left: 5px solid '. esc_attr( $theme_color ) .'; /* base: #005177; */
}
.wp-block-quote[style*="text-align:right"], .wp-block-quote[style*="text-align: right"] {
	border-right: 5px solid '. esc_attr( $theme_color ) .'; /* base: #005177; */
}
/* Do not overwrite solid color pullquote or cover links */
.editor-block-list__layout .editor-block-list__block .wp-block-pullquote.is-style-solid-color a,
.editor-block-list__layout .editor-block-list__block .wp-block-cover a {
color: inherit;
}';

