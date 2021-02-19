<?php
/*
 * The header for seoaal theme
 */
$ahe = new SeoaalHeaderElements;
$protocal = is_ssl() ? 'https' : 'http';
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="<?php echo esc_attr( $protocal ); ?>://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<?php
	$smooth_scroll = $ahe->seoaalThemeOpt('smooth-opt');
	$scroll_time = $scroll_dist = '';
	if( $smooth_scroll ){
		$scroll_time = $ahe->seoaalThemeOpt('scroll-time');
		$scroll_dist = $ahe->seoaalThemeOpt('scroll-distance');
		wp_enqueue_script( 'smoothscroll' );
	}
	$scroll_offset = $ahe->seoaalThemeOpt('sticky-part-offset');
	$scroll_moffset = $ahe->seoaalThemeOpt('sticky-part-moffset');
?>
<body <?php body_class(); ?> data-scroll-time="<?php echo esc_attr( $scroll_time ); ?>" data-scroll-distance="<?php echo esc_attr( $scroll_dist ); ?>" data-scroll-offset="<?php echo esc_attr( $scroll_offset ); ?>" data-scroll-moffset="<?php echo esc_attr( $scroll_moffset ); ?>">
<?php
	/*
	 * Mobile Header - seoaalMobileHeader - 10
	 * Mobile Bar - seoaalMobileBar - 20
	 * Secondary Menu Space - seoaalHeaderSecondarySpace - 30
	 * Top Sliding Bar - seoaalHeaderTopSliding - 40
	 */
	do_action('seoaal_body_action');
?>
<?php if( $ahe->seoaalPageLoader() ) : ?>
	<div class="page-loader"></div>
<?php endif; ?>
<div id="page" class="seoaal-wrapper<?php $ahe->seoaalThemeLayout(); ?>">
	<?php $ahe->seoaalHeaderSlider('top'); ?>
	<header class="seoaal-header<?php $ahe->seoaalHeaderLayout(); ?>">
		
			<?php $ahe->seoaalHeaderBar(); ?>
		
	</header>
	<div class="seoaal-content-wrapper">