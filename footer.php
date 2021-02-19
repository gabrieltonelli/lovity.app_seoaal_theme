<?php
/**
 * The template for displaying the footer
 *
 */
$afe = new SeoaalFooterElements;
?>
	</div><!-- .seoaal-content-wrapper -->
	<footer class="site-footer<?php $afe->seoaalFooterLayout(); ?>">
		<?php echo do_shortcode( seoaal_ads_out( $afe->seoaalThemeOpt( 'footer-ads-list' ) ) );	?>
		<?php $afe->seoaalFooterElements(); ?>
		
		<?php $afe->seoaalFooterBacktoTop(); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php
	/*
	 * Full Search - seoaalFullSearchWrap - 10
	 */
	echo apply_filters( 'seoaal_footer_search_filter', '' );
	
	/*
	 * VC Google Fonts - seoaalVcGoogleFonts - 10
	 */
	do_action('seoaal_footer_action');
	
?>
<?php wp_footer(); ?>
</body>
</html>