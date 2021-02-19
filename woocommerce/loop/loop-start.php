<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$product_class = $data_atts = '';

if( is_shop() ){

	$ato = new SeoaalThemeOpt;

	$product_col = $ato->seoaalThemeOpt('woo-shop-columns');

	$product_col = $product_col ? $product_col : 4;

	$product_class = ' shop-col-'. esc_attr( $product_col );

}elseif( is_product_category() || is_product_tag() ){

	$ato = new SeoaalThemeOpt;

	$product_col = $ato->seoaalThemeOpt('woo-shop-archive-columns');

	$product_col = $product_col ? $product_col : 4;

	$product_class = ' shop-col-'. esc_attr( $product_col );

}elseif( is_product () ){

	$ato = new SeoaalThemeOpt;

	$slide_template = 'woo-related';

	$gal_atts = array(

		'data-loop="'. $ato->seoaalThemeOpt( $slide_template.'-slide-infinite' ) .'"',

		'data-margin="'. $ato->seoaalThemeOpt( $slide_template.'-slide-margin' ) .'"',

		'data-center="'. $ato->seoaalThemeOpt( $slide_template.'-slide-center' ) .'"',

		'data-nav="'. $ato->seoaalThemeOpt( $slide_template.'-slide-navigation' ) .'"',

		'data-dots="'. $ato->seoaalThemeOpt( $slide_template.'-slide-pagination' ) .'"',

		'data-autoplay="'. $ato->seoaalThemeOpt( $slide_template.'-slide-autoplay' ) .'"',

		'data-items="'. $ato->seoaalThemeOpt( $slide_template.'-slide-items' ) .'"',

		'data-items-tab="'. $ato->seoaalThemeOpt( $slide_template.'-slide-tab' ) .'"',

		'data-items-mob="'. $ato->seoaalThemeOpt( $slide_template.'-slide-mobile' ) .'"',

		'data-duration="'. $ato->seoaalThemeOpt( $slide_template.'-slide-duration' ) .'"',

		'data-smartspeed="'. $ato->seoaalThemeOpt( $slide_template.'-slide-smartspeed' ) .'"',

		'data-scrollby="'. $ato->seoaalThemeOpt( $slide_template.'-slide-scrollby' ) .'"',

		'data-autoheight="'. $ato->seoaalThemeOpt( $slide_template.'-slide-autoheight' ) .'"',

	);
	
	wp_enqueue_script( 'owl-carousel' );
	wp_enqueue_style( 'owl-carousel' );

	$data_atts = implode( " ", $gal_atts );

	$product_class .= ' owl-carousel related-slider';

	

	$cols = $ato->seoaalThemeOpt( $slide_template.'-slide-items' );

	

}

?>

<ul class="products<?php echo esc_attr( $product_class ); ?>" <?php echo ( ''. $data_atts ); ?>>