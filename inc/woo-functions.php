<?php
/**
 * Custom Woo Function
 */
 

function seoaal_woocommerce_show_page_title( $show_page ) {
    // Maybe modify $example in some way.
  return false;
}
add_filter( 'woocommerce_show_page_title', 'seoaal_woocommerce_show_page_title' );
 
add_action( 'after_setup_theme', 'seoaal_woocommerce_support' );
function seoaal_woocommerce_support() {
    add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
//Single Product Page
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );
add_action('woocommerce_single_product_summary',  'woocommerce_template_single_meta', 10 );
add_action('woocommerce_single_product_summary',  'woocommerce_template_single_rating', 15 );
//Normal Woo Actions
remove_action( 'woocommerce_before_main_content','woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content','woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');

if( SeoaalThemeOpt::seoaalStaticThemeOpt('woo-single-page-breadcrumb') == false ){
	remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20);
}
add_action('woocommerce_before_main_content',  'seoaal_woocommerce_before_main_content', 10 );
function seoaal_woocommerce_before_main_content(){
	
	$woo_class = '';
	if( is_product() ){
		$woo_class = ' seoaal-single-product';
	}else{
		$woo_class = ' seoaal-woo';
	}
	
	echo '<div class="seoaal-content'. esc_attr( $woo_class ) .'">';	
	
	$custom_title = '';
	$page_id = '';
	$template_class = array();
	if( is_shop() ){
		ob_start();
		woocommerce_page_title();
		$custom_title = ob_get_clean();
		$custom_title = apply_filters( "seoaal_shop_page_custom_title", esc_html__( "Products", "seoaal" ) );
		$page_id = get_option( 'woocommerce_shop_page_id' ); 
		
		$page_id = $page_id ? $page_id : get_the_ID();
	
		$template = 'woo';
		$aps = new SeoaalPostSettings;
		$aps->seoaalSetPostTemplate( $template );
		$template_class = $aps->seoaalTemplateContentClass( $page_id );
		$ahe = new SeoaalHeaderElements;
		$ahe->seoaalPageTitle( $template, $custom_title, $page_id );
		
	}elseif( is_product_category() || is_product_tag() ){
		$template = 'wooarchive';
		$aps = new SeoaalPostSettings;
		$aps->seoaalSetPostTemplate( $template );
		$template_class = $aps->seoaalTemplateContentClass();
		$ahe = new SeoaalHeaderElements;
		$ahe->seoaalPageTitle( "woo", $custom_title );
	}elseif( is_product() ){
		$template = 'woo-single';
		$aps = new SeoaalPostSettings;
		$aps->seoaalSetPostTemplate( $template );
		$template_class = $aps->seoaalTemplateContentClass();
		$custom_title = get_the_title();
		$ahe = new SeoaalHeaderElements;
		$page_id = get_the_ID();
		$ahe->seoaalPageTitle( "single-product", $custom_title, $page_id );
	}
	
	if( isset( $template_class['content_class'] ) && $template_class['content_class'] != '' ){
		$content_class = str_replace("md", "lg", $template_class['content_class'] );
	}else{
		$content_class = 'col-lg-12';
	}
	
	echo '<div class="seoaal-content-inner">
			<div class="container">	
				<div class="row">
					<div class="'. esc_attr( $content_class ) .'">';
					
	if( is_shop() || is_product_category() || is_product_tag() ){
		echo '<div class="woo-top-meta">';
	}
}
add_action('woocommerce_after_main_content',  'seoaal_woocommerce_after_main_content', 10 );
function seoaal_woocommerce_after_main_content(){
	if( is_shop() || is_product_category() || is_product_tag() ){
		echo '</div><!-- .woo-top-meta -->';
	}
	$page_id = '';
	$template_class = array();
	if( is_shop() ){
		$page_id = get_option( 'woocommerce_shop_page_id' ); 
		
		$page_id = $page_id ? $page_id : get_the_ID();
	
		$template = 'woo';
		$aps = new SeoaalPostSettings;
		$aps->seoaalSetPostTemplate( $template );
		$template_class = $aps->seoaalTemplateContentClass( $page_id );
		
		$page_layout_opt = get_post_meta( $page_id, 'seoaal_page_template_opt', true );
		if( $page_layout_opt == 'custom' ){
			$template_class['left_sidebar'] = get_post_meta( $page_id, 'seoaal_page_left_sidebar', true );
			$template_class['right_sidebar'] = get_post_meta( $page_id, 'seoaal_page_right_sidebar', true );
		}
		
	}elseif( is_product_category() || is_product_tag() ){
		$template = 'wooarchive';
		$aps = new SeoaalPostSettings;
		$aps->seoaalSetPostTemplate( $template );
		$template_class = $aps->seoaalTemplateContentClass();
	}elseif( is_product() ){
		$template = 'woo-single';
		$aps = new SeoaalPostSettings;
		$aps->seoaalSetPostTemplate( $template );
		$template_class = $aps->seoaalTemplateContentClass();
	}
	
				echo '</div><!-- main col -->';
				
				if( isset( $template_class['lsidebar_class'] ) && $template_class['lsidebar_class'] != '' ) : 
					$lsidebar_class = str_replace("md", "lg", $template_class['lsidebar_class'] );
				?>
				<div class="<?php echo esc_attr( $lsidebar_class ); ?>">
					<aside class="widget-area left-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
						<?php dynamic_sidebar( $template_class['left_sidebar'] ); ?>
					</aside>
				</div><!-- sidebar col -->
				<?php endif; ?>
				
				<?php if( isset( $template_class['rsidebar_class'] ) && $template_class['rsidebar_class'] != '' ) : 
					$rsidebar_class = str_replace("md", "lg", $template_class['rsidebar_class'] );
				?>
				<div class="<?php echo esc_attr( $rsidebar_class ); ?>">
					<aside class="widget-area right-widget-area<?php echo esc_attr( $template_class['sticky_class'] ); ?>">
						<?php dynamic_sidebar( $template_class['right_sidebar'] ); ?>
					</aside>
				</div><!-- sidebar col -->
				<?php endif;
			
			echo '</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .seoaal-content-inner -->
	</div><!-- .seoaal-content -->';
}
add_action('woocommerce_before_shop_loop_item_title',  'seoaal_woocommerce_before_shop_loop_item_title_start', 5 );
function seoaal_woocommerce_before_shop_loop_item_title_start(){
 echo '<div class="woo-thumb-wrap">';
}


remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
//add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action('woocommerce_before_shop_loop_item_title',  'seoaal_woocommerce_before_shop_loop_item_title_end', 20 );
function seoaal_woocommerce_before_shop_loop_item_title_end(){
 echo '</div><!-- .woo-thumb-wrap -->';
}
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );
add_action( 'woocommerce_before_shop_loop_item', 'seoaal_woocommerce_template_loop_product_link_open', 10 );
function seoaal_woocommerce_template_loop_product_link_open(){
 echo '<div class="loop-product-wrap">';
}
add_action( 'woocommerce_after_shop_loop_item', 'seoaal_woocommerce_template_loop_product_link_close', 5 );
function seoaal_woocommerce_template_loop_product_link_close(){
 echo '</div><!-- .loop-product-wrap -->';
}
function seoaal_woo_set_columns($columns){
	
	$ato = new SeoaalThemeOpt;
	
	$woo_col = 4;
	if ( is_product_category() || is_product_tag() ) {
		$woo_col = $ato->seoaalThemeOpt('woo-shop-archive-columns');
	}else {
		$woo_col = $ato->seoaalThemeOpt('woo-shop-columns');
	}
	return $woo_col;
}
add_filter('loop_shop_columns','seoaal_woo_set_columns');
add_filter( 'woocommerce_output_related_products_args', 'seoaal_related_products_args' );
  function seoaal_related_products_args( $args ) {
  	$ato = new SeoaalThemeOpt;
	$related_ppp = $ato->seoaalThemeOpt('woo-related-ppp');
	$related_ppp = $related_ppp ? $related_ppp : 4;
	$args['posts_per_page'] = $related_ppp;
	$args['columns'] = 1;//$related_count; // arranged in 4 columns
	return $args;
}
function seoaal_woocommerce_catalog_page_ordering() {
	$def_count = '';
	if (isset($_POST['woocommerce-sort-by-columns'])) {
		setcookie('shop_pageResults', $_POST['woocommerce-sort-by-columns'], time()+1209600 );
		$count = sanitize_text_field($_POST['woocommerce-sort-by-columns']);
	}elseif (isset($_COOKIE['shop_pageResults'])) { // if normal page load with cookie
		$count = $_COOKIE['shop_pageResults'];
	}else{
		$ato = new SeoaalThemeOpt;
		$shop_ppp = $ato->seoaalThemeOpt('woo-shop-ppp');
		$count = $def_count = $shop_ppp ? $shop_ppp : 9;
	}?>
	
	<form action="" method="POST" name="results">
		<select name="woocommerce-sort-by-columns" id="woocommerce-sort-by-columns" class="sortby" onchange="this.form.submit()">
			<?php
				$shopCatalog_orderby = apply_filters('woocommerce_sortby_page', array(
					$def_count       => esc_html__('Default', 'seoaal'),
					'12'    => esc_html__('12 per page', 'seoaal'),
					'24'        => esc_html__('24 per page', 'seoaal'),
					'36'        => esc_html__('36 per page', 'seoaal'),
					'48'        => esc_html__('48 per page', 'seoaal'),
					'64'        => esc_html__('64 per page', 'seoaal'),
				));
				
				foreach ( $shopCatalog_orderby as $sort_id => $sort_name ){
					echo '<option value="' . $sort_id . '" ' . ( $count == $sort_id ? 'selected="selected"' : '' ) . ' >' . $sort_name . '</option>';
				}
			?>
		</select>
	</form>
<?php
} 
// now we set our cookie if we need to
function seoaal_loop_shop_per_page( $count ) {
	if (isset($_COOKIE['shop_pageResults'])) { // if normal page load with cookie
		$count = $_COOKIE['shop_pageResults'];
	}else{
		$site_url = get_site_url();		
		if (isset($_POST['woocommerce-sort-by-columns'])) { //if form submitted
			setcookie('shop_pageResults', $_POST['woocommerce-sort-by-columns'], time()+1209600 ); //this will fail if any part of page has been output- hope this works!
			$count = sanitize_text_field($_POST['woocommerce-sort-by-columns']);
		}else{
			$ato = new SeoaalThemeOpt;
			$shop_ppp = $ato->seoaalThemeOpt('woo-shop-ppp');
			$count = $shop_ppp ? $shop_ppp : 9;
		}
	}
  // else normal page load and no cookie
  return $count;
}
add_filter('loop_shop_per_page','seoaal_loop_shop_per_page');
add_action( 'woocommerce_before_shop_loop', 'seoaal_woocommerce_catalog_page_ordering', 20 );

/**
 * Add Cart icon and count to header if WC is active
 */
function seoaal_cart_items(){
	$empty_cart = '<li class="cart-item"><p class="text-center no-cart-items">'. apply_filters( 'seoaal_woo_mini_cart_empty', esc_html__('No items in cart', 'seoaal') ) .'</p></li>';
	if ( WC()->cart->get_cart_contents_count() == 0 ) return $empty_cart;
	ob_start();
	
	$shop_page_url = get_permalink( wc_get_page_id( 'cart' ) );
	$remove_loader = apply_filters('woo_mini_cart_loader', SEOAAL_ASSETS . '/images/cart-remove.gif');
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		?>
			<li class="cart-item">
			<?php
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			?>
				<div class="product-thumbnail">
					<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						if ( ! $product_permalink ) {
							echo ( ''. $thumbnail );
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
						}
					?>
					<span class="remove-item-overlay text-center"><img src="<?php echo esc_url($remove_loader); ?>" alt="<?php esc_attr_e('Loader..', 'seoaal') ?>" /></span>
				</div>
				<div class="product-name" data-title="<?php esc_attr_e( 'Product', 'seoaal' ); ?>">
					<?php echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key ); ?>
					<p>
						<span><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?> &#9747; <?php echo esc_attr( $cart_item['quantity'] ); ?></span>
					</p>
				</div>
				<div class="product-remove">
					<?php
						echo 
						sprintf(
							'<a href="%s" class="remove-cart-item" title="%s" data-product_id="%s" data-product_sku="%s" data-url="%s"><i class="icon-trash"></i></a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'seoaal' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() ),
							esc_url($remove_loader)
						);
					?>
				</div>
			<?php
				}//if
			?>
			</li>
			<?php
			}//foreach
		?>
	<li class="text-center mini-view-cart"><a href="<?php echo esc_url( $shop_page_url ); ?>" title="<?php esc_attr_e('Cart', 'seoaal'); ?>"><?php esc_html_e('View Cart', 'seoaal'); ?></a></li>
	<?php 
	$out = ob_get_clean();
	return $out;
}
function seoaal_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count = WC()->cart->cart_contents_count;
		$cart_link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
        ?>
		<a class="cart-contents" href="<?php echo esc_url( $cart_link ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'seoaal' ); ?>"><i class="icon-handbag"></i> <?php if ( $count > 0 ) echo '(' . $count . ')'; ?></a>
		<ul class="dropdown-menu cart-dropdown-menu">
		<?php
			echo ( seoaal_cart_items() );
		?>
		</ul>
		<?php
    }
 
}
add_action( 'seoaal_woo_cart_icon', 'seoaal_wc_cart_count' ); 
/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function seoaal_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    $count = WC()->cart->cart_contents_count;
	$cart_link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
    ?>
		<li class="menu-item dropdown mini-cart-items">
			<a class="cart-contents" href="<?php echo esc_url( $cart_link ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'seoaal' ); ?>"><i class="icon-handbag"></i> <?php if ( $count > 0 ) echo '(' . $count . ')'; ?></a>
			<ul class="dropdown-menu cart-dropdown-menu">
			<?php
			echo ( seoaal_cart_items() );
			?>
			</ul>
		</li>
	<?php
	$fragments['li.mini-cart-items'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'seoaal_header_add_to_cart_fragment' );
function seoaal_wc_cart_ajax() {
 	$output = '';
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count = WC()->cart->cart_contents_count;
		$cart_link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
		ob_start();
        ?>
		<a class="cart-contents" href="<?php echo esc_url( $cart_link ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'seoaal' ); ?>"><i class="icon-handbag"></i> <?php if ( $count > 0 ) echo '(' . $count . ')'; ?></a>
		<ul class="dropdown-menu cart-dropdown-menu">
		<?php
			echo ( seoaal_cart_items() );
		?>
		</ul>
		<?php
		$output = ob_get_clean();
    }
	return  $output;
}
/*Woo Cart Item Remove Through Ajax*/
add_action( 'wp_ajax_seoaal_product_remove', 'seoaal_product_remove' );
add_action( 'wp_ajax_nopriv_seoaal_product_remove', 'seoaal_product_remove' );
function seoaal_product_remove() {
    global $wpdb, $woocommerce;
    session_start();
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
        if($cart_item['product_id'] == sanitize_text_field($_POST['product_id']) ){
            // Remove product in the cart using  cart_item_key. 
			$woocommerce->cart->remove_cart_item($cart_item_key);
        }
    }
	$return["mini_cart"] = seoaal_wc_cart_ajax();
	echo json_encode($return);
    exit();
}
add_action( 'wp_enqueue_scripts', 'seoaal_zozo_manage_woocommerce_styles', 99 );  
 
function seoaal_zozo_manage_woocommerce_styles() { 
 //remove generator meta tag
 if( isset( $GLOBALS['woocommerce'] ) ){
 	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
 }
 
 //first check that woo exists to prevent fatal errors
 if ( function_exists( 'is_woocommerce' ) ) { 
 
 	global $post;
	$woo_stat = 0;
	if ( 
		 isset( $post->post_content ) && ( has_shortcode( $post->post_content, 'products') || 
		 has_shortcode( $post->post_content, 'product_category') ||
		 has_shortcode( $post->post_content, 'recent_products') ||
		 has_shortcode( $post->post_content, 'featured_products') ||
		 has_shortcode( $post->post_content, 'top_rated_products') ||
		 has_shortcode( $post->post_content, 'best_selling_products') ||
		 has_shortcode( $post->post_content, 'sale_products') ||
		 has_shortcode( $post->post_content, 'product_categories') ||
		 has_shortcode( $post->post_content, 'product_attribute') )
	) {
		$woo_stat = 1;
	}
 
	 //dequeue scripts and styles
	 if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && !$woo_stat ) {
		 wp_dequeue_style( 'woocommerce_frontend_styles' );
		 wp_dequeue_style( 'woocommerce_fancybox_styles' );
		 wp_dequeue_style( 'woocommerce_chosen_styles' );
		 wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		 wp_dequeue_script( 'wc_price_slider' );
		 wp_dequeue_script( 'wc-single-product' );
		 wp_dequeue_script( 'wc-add-to-cart' );
		 wp_dequeue_script( 'wc-checkout' );
		 wp_dequeue_script( 'wc-add-to-cart-variation' );
		 wp_dequeue_script( 'wc-single-product' );
		 wp_dequeue_script( 'wc-cart' );
		 wp_dequeue_script( 'wc-chosen' );
		 wp_dequeue_script( 'woocommerce' );
		 wp_dequeue_script( 'prettyPhoto' );
		 wp_dequeue_script( 'prettyPhoto-init' );
		 wp_dequeue_script( 'jquery-blockui' );
		 wp_dequeue_script( 'jquery-placeholder' );
		 wp_dequeue_script( 'fancybox' );
		 wp_dequeue_script( 'jqueryui' );
	 }
 }
 
}