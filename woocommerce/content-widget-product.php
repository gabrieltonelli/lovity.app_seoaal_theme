<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
	
	<div class="media">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
			<?php echo ( ''. $product->get_image() ); ?>
		</a>
		<div class="media-body align-self-center">
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<h6 class="product-title"><?php echo esc_html( $product->get_name() ); ?></h6>
			</a>
			<?php 
				$pro_price = $product->get_price_html(); 
				$htm_tags = ["<ins>", "</ins>"];
				$removed_tags   = ["", ""];
				echo str_replace( $htm_tags, $removed_tags, $pro_price );
			?>
		</div>
	</div>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
