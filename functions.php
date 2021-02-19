<?php
/**
 * Seoaal functions and definitions
 *
 */
/**
 * Seoaal predifined vars
 */
define('SEOAAL_ADMIN', get_template_directory().'/admin');
define('SEOAAL_INC', get_template_directory().'/inc');
define('SEOAAL_THEME_ELEMENTS', get_template_directory().'/admin/theme-elements');
define('SEOAAL_ADMIN_URL', get_template_directory_uri().'/admin');
define('SEOAAL_INC_URL', get_template_directory_uri().'/inc');
define('SEOAAL_ASSETS', get_template_directory_uri().'/assets');
/* Custom Inline Css */
$seoaal_custom_styles = "";
//Theme Default
require_once SEOAAL_ADMIN . '/theme-default/theme-default.php';
require_once SEOAAL_THEME_ELEMENTS . '/theme-options.php';
require_once SEOAAL_INC . '/theme-class/theme-class.php';
require_once SEOAAL_INC . '/walker/wp_bootstrap_navwalker.php';
require_once SEOAAL_ADMIN . '/mega-menu/custom_menu.php';
//CUSTOM SIDEBAR
require_once SEOAAL_ADMIN . '/custom-sidebar/sidebar-generator.php';
//TGM
require_once SEOAAL_ADMIN . '/tgm/tgm-init.php'; 
require_once SEOAAL_ADMIN . '/welcome-page/welcome.php';
//ZOZO IMPORTER
if( class_exists( 'Seoaal_Zozo_Admin_Page' ) ){
	require_once SEOAAL_ADMIN . '/welcome-page/importer/zozo-importer.php'; 	
}
//VC SHORTCODES
if ( class_exists( 'Vc_Manager' ) ) {
	require_once SEOAAL_INC . '/vc/vc-init.php'; 	
}
//Woo
if ( class_exists( 'WooCommerce' ) ) {
	require_once SEOAAL_INC . "/woo-functions.php";
}
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function seoaal_setup() {
	/* Seoaal Text Domain */
	load_theme_textdomain( 'seoaal', get_template_directory() . '/languages' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	
	/* Custom background */
	$defaults = array(
		'default-color'          => '',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $defaults );
	
	/* Custom header */
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $defaults );
	
	/* Content width */
	if ( ! isset( $content_width ) ) $content_width = 640;
	
	$ao = new SeoaalThemeOpt;
	$grid_large = $ao->seoaalThemeOpt('seoaal-grid-large');
	$grid_medium = $ao->seoaalThemeOpt('seoaal-grid-medium');
	$grid_small = $ao->seoaalThemeOpt('seoaal-grid-small');
	$port_masonry = $ao->seoaalThemeOpt('seoaal-portfolio-masonry');
	
	if( !empty( $grid_large ) && is_array( $grid_large ) ) add_image_size( 'seoaal-grid-large', $grid_large['width'], $grid_large['height'], true );
	if( !empty( $grid_medium ) && is_array( $grid_medium ) ) add_image_size( 'seoaal-grid-medium', $grid_medium['width'], $grid_medium['height'], true );
	if( !empty( $grid_small ) && is_array( $grid_small ) ) add_image_size( 'seoaal-grid-small', $grid_small['width'], $grid_small['height'], true );
	
	//Team
	$team_medium = $ao->seoaalThemeOpt('seoaal-team-medium');
	if( !empty( $team_medium ) && is_array( $team_medium ) ) add_image_size( 'seoaal-team-medium', $team_medium['width'], $team_medium['height'], true );
	update_option( 'large_size_w', 1170 );
	update_option( 'large_size_h', 694 );
	update_option( 'large_crop', 1 );
	update_option( 'medium_size_w', 768 );
	update_option( 'medium_size_h', 456 );
	update_option( 'medium_crop', 1 );
	update_option( 'thumbnail_size_w', 80 );
	update_option( 'thumbnail_size_h', 80 );
	update_option( 'thumbnail_crop', 1 );
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top-menu'		=> esc_html__( 'Top Bar Menu', 'seoaal' ),
		'primary-menu'	=> esc_html__( 'Primary Menu', 'seoaal' ),
		'footer-menu'	=> esc_html__( 'Footer Menu', 'seoaal' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	/*
	 * Enable support for Post Formats.
	 *
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );
	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo' );
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );	

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );
	
}
add_action( 'after_setup_theme', 'seoaal_setup' );
/**
 * Register widget area.
 *
 */
function seoaal_widgets_init() {
	
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'seoaal' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'seoaal' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Menu Sidebar', 'seoaal' ),
		'id'            => 'secondary-menu-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your secondary menu area.', 'seoaal' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'seoaal' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'seoaal' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'seoaal' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'seoaal' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'seoaal' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'seoaal' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'seoaal_widgets_init' );
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Seoaal 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function seoaal_excerpt_more( $link ) {
	return '';
}
add_filter( 'excerpt_more', 'seoaal_excerpt_more' );
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function seoaal_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'seoaal_pingback_header' );
/**
 * Admin Enqueue scripts and styles.
 */
function seoaal_enqueue_admin_script() { 
	wp_enqueue_style( 'seoaal-admin-style', get_theme_file_uri( '/admin/assets/css/admin-style.css' ), array(), '1.0' );
	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/assets/css/font-awesome.min.css' ), array(), '4.7.0' );
	
	// Meta Drag and Drop Script
	wp_enqueue_script( 'seoaal-admin-scripts', get_theme_file_uri( '/admin/assets/js/admin-scripts.js' ), array( 'jquery' ), '1.0', true ); 
	
	//Admin Localize Script
	wp_localize_script('seoaal-admin-scripts', 'seoaal_admin_ajax_var', array(
		'admin_ajax_url' => esc_url( admin_url('admin-ajax.php') ),
		'featured_nonce' => wp_create_nonce('seoaal-post-featured'), 
		'sidebar_nounce' => wp_create_nonce('seoaal-sidebar-featured'), 
		'redux_themeopt_import' => wp_create_nonce('seoaal-redux-import'),
		'unins_confirm' => esc_html__('Please backup your files and database before uninstall. Are you sure want to uninstall current demo?.', 'seoaal'),
		'yes' => esc_html__('Yes', 'seoaal'),
		'no' => esc_html__('No', 'seoaal'),
		'proceed' => esc_html__('Proceed', 'seoaal'),
		'cancel' => esc_html__('Cancel', 'seoaal'),
		'process' => esc_html__( 'Processing', 'seoaal' ),
		'uninstalling' => esc_html__('Uninstalling...', 'seoaal'),
		'uninstalled' => esc_html__('Uninstalled.', 'seoaal'),
		'unins_pbm' => esc_html__('Uninstall Problem!.', 'seoaal'),
		'downloading' => esc_html__('Downloading Demo Files...', 'seoaal'), 
		'import_xml' => esc_html__('Importing Xml...', 'seoaal'),
		'import_theme_opt' => esc_html__('Importing Theme Option...', 'seoaal'),
		'import_widg' => esc_html__('Importing Widgets...', 'seoaal'),
		'import_sidebars' => esc_html__('Importing Sidebars...', 'seoaal'),
		'import_revslider' => esc_html__('Importing Revolution Sliders...', 'seoaal'),
		'imported' => esc_html__('Successfully Imported, Check Above Message.', 'seoaal'),
		'import_pbm' => esc_html__('Import Problem.', 'seoaal'),
		'access_pbm' => esc_html__('File access permission problem.', 'seoaal')
	));
	
}
add_action( 'admin_enqueue_scripts', 'seoaal_enqueue_admin_script' );
/**
 * Enqueue scripts and styles.
 */
function seoaal_scripts() { 

	/*Visual Composer CSS*/
	if ( class_exists( 'Vc_Manager' ) ) {
		wp_enqueue_style( 'js_composer_front' );
		wp_enqueue_style( 'js_composer_custom_css' );
	}
	
	$rto = new SeoaalThemeOpt;
	
	// Seoaal Style Libraries
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ), array(), '4.1.1' );
	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/assets/css/font-awesome.min.css' ), array(), '4.7.0' );
	wp_enqueue_style( 'themify-icons', get_theme_file_uri( '/assets/css/themify-icons.css' ), array(), '1.0.1' );
		wp_enqueue_style( 'simple-line-icons', get_theme_file_uri( '/assets/css/simple-line-icons.css' ), array(), '1.0' );
	wp_enqueue_style( 'animate', get_theme_file_uri( '/assets/css/animate.min.css' ), array(), '3.5.1' );
	
	wp_register_style( 'owl-carousel', get_theme_file_uri( '/assets/css/owl-carousel.min.css' ), array(), '2.2.1' );
	wp_register_style( 'ytplayer', get_theme_file_uri( '/assets/css/ytplayer.min.css' ), array(), '1.0' );
	wp_register_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.min.css' ), array(), '1.0' );
	wp_register_style( 'image-hover', get_theme_file_uri( '/assets/css/image-hover.min.css' ), array(), '1.0' );
	
	$lazy_load = $rto->seoaalThemeOpt('lazy-load');
	if( $lazy_load ) wp_enqueue_script( 'imagesloaded' );

	// Theme stylesheet.
	wp_enqueue_style( 'seoaal-style', get_template_directory_uri() . '/style.css', array(), '1.0' );
	
	// Shortcode Styles
	wp_enqueue_style( 'seoaal-shortcode', get_theme_file_uri( '/assets/css/shortcode.css' ), array(), '1.0' );
	
	/* Seoaal theme script files */
	
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	
	// Seoaal JS Libraries
	wp_enqueue_script( 'jquery-easing', get_theme_file_uri( '/assets/js/jquery.easing.min.js' ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'jquery-appear', get_theme_file_uri( '/assets/js/jquery.appear.min.js' ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'smart-resize', get_theme_file_uri( '/assets/js/smart-resize.min.js' ), array( 'jquery' ), '1.0', true );
	
	wp_register_script( 'smoothscroll', get_theme_file_uri( '/assets/js/smoothscroll.min.js' ), array( 'jquery' ), '1.20.2', true );
	wp_register_script( 'owl-carousel', get_theme_file_uri( '/assets/js/owl.carousel.min.js' ), array( 'jquery' ), '2.2.1', true );
	wp_register_script( 'isotope-pkgd', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array( 'jquery' ), '3.0.3', true );
	wp_register_script( 'infinite-scroll', get_theme_file_uri( '/assets/js/infinite-scroll.pkgd.min.js' ), array( 'jquery' ), '2.0', true );
	wp_register_script( 'jquery-stellar', get_theme_file_uri( '/assets/js/jquery.stellar.min.js' ), array( 'jquery' ), '0.6.2', true );
	wp_register_script( 'sticky-kit', get_theme_file_uri( '/assets/js/sticky-kit.min.js' ), array( 'jquery' ), '1.1.3', true );
	wp_register_script( 'jquery-mb-ytplayer', get_theme_file_uri( '/assets/js/jquery.mb.YTPlayer.min.js' ), array( 'jquery' ), '1.0', true );	
	wp_register_script( 'jquery-magnific', get_theme_file_uri( '/assets/js/jquery.magnific.popup.min.js' ), array( 'jquery' ), '1.1.0', true );
	wp_register_script( 'jquery-easy-ticker', get_theme_file_uri( '/assets/js/jquery.easy.ticker.min.js' ), array( 'jquery' ), '2.0', true );
	wp_register_script( 'jquery-countdown', get_theme_file_uri( '/assets/js/jquery.countdown.min.js' ), array( 'jquery' ), '2.2.0', true );
	wp_register_script( 'jquery-circle-progress', get_theme_file_uri( '/assets/js/jquery.circle.progress.min.js' ), array( 'jquery' ), '1.0', true );
	wp_register_script( 'seoaal-timeline', get_theme_file_uri( '/assets/js/timeline.min.js' ), array( 'jquery' ), '1.0', true );
	
	// Theme Js
	wp_enqueue_script( 'seoaal-theme', get_theme_file_uri( '/assets/js/theme.js' ), array( 'jquery' ), '1.0', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Theme option stylesheet.
	$upload_dir = seoaal_fn_get_upload_dir_var('baseurl');
	$seoaal = wp_get_theme();
	$theme_style = $upload_dir . '/seoaal/theme_'.get_current_blog_id().'.css';
	wp_enqueue_style( 'seoaal-theme-style', esc_url( $theme_style ), array(), $seoaal->get( 'Version' ) );
	
	$seoaal_option = get_option( 'seoaal_options' );
	
	//Google Map Script
	$google_stat = false;
	if( isset( $seoaal_option['google-api'] ) && $seoaal_option['google-api'] != '' ){
		wp_register_script( 'seoaal-gmaps', '//maps.googleapis.com/maps/api/js?key='. esc_attr( $seoaal_option['google-api'] ) , array('jquery'), null, true );
	}
		
	$infinite_image = isset( $seoaal_option['infinite-loader-img']['url'] ) && $seoaal_option['infinite-loader-img']['url'] != '' ? $seoaal_option['infinite-loader-img']['url'] : get_theme_file_uri( '/assets/images/infinite-loder.gif' );
	$lazy_opt = isset( $seoaal_option['lazy-load'] ) && $seoaal_option['lazy-load'] ? true : false;
	//Localize Script
	wp_localize_script('seoaal-theme', 'seoaal_ajax_var', array(
		'admin_ajax_url' => esc_url( admin_url('admin-ajax.php') ),
		'like_nonce' => wp_create_nonce('seoaal-post-like'), 
		'fav_nonce' => wp_create_nonce('seoaal-post-fav'),
		'infinite_loader' => $infinite_image,
		'load_posts' => apply_filters( 'infinite_load_msg', esc_html__( 'Loading next set of posts.', 'seoaal' ) ),
		'no_posts' => apply_filters( 'infinite_finished_msg', esc_html__( 'No more posts to load.', 'seoaal' ) ),
		'cmt_nonce' => wp_create_nonce('seoaal-comment-like'),
		'mc_nounce' => wp_create_nonce('seoaal-mailchimp'), 
		'wait' => esc_html__('Wait..', 'seoaal'),
		'must_fill' => esc_html__('Must Fill Required Details.', 'seoaal'),
		'valid_email' => esc_html__('Enter Valid Email ID.', 'seoaal'),
		'cart_update_pbm' => esc_html__('Cart Update Problem.', 'seoaal'),
		'google_stat'	=> $google_stat		
	));
	
}
add_action( 'wp_enqueue_scripts', 'seoaal_scripts' );

/**
 * Enqueue supplemental block editor styles.
 */
function seoaal_editor_customizer_styles() {
	wp_enqueue_style( 'seoaal-google-fonts', seoaal_redux_fonts_url(), array(), null, 'all' );
	wp_enqueue_style( 'seoaal-editor-customizer-styles', get_theme_file_uri( '/style-editor-customizer.css' ), false, '1.0', 'all' );
	
	ob_start();
	require_once SEOAAL_THEME_ELEMENTS . '/theme-customizer-styles.php';
	$custom_styles = ob_get_clean();
	
	wp_add_inline_style( 'seoaal-editor-customizer-styles', $custom_styles );
}
add_action( 'enqueue_block_editor_assets', 'seoaal_editor_customizer_styles' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );
/*Theme Code*/
/*Search Form Filter*/
if( ! function_exists('seoaal_zozo_search_form') ) {
	function seoaal_zozo_search_form( $form ) {
		$search_placeholder = SeoaalThemeOpt::seoaalStaticThemeOpt( 'search-placeholder' );
		$search_out = '
		<form method="get" class="search-form" action="'. esc_url( home_url( '/' ) ) .'">
			<div class="input-group">
				<input type="text" class="form-control" name="s" value="'. get_search_query() .'" placeholder="'. esc_attr( $search_placeholder ) .'">
				<span class="input-group-btn">
					<button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
				</span>
			</div>
		</form>';
		return $search_out;
	}
	add_filter( 'get_search_form', 'seoaal_zozo_search_form' );
}

if( ! function_exists('seoaalPostComments') ) {
	function seoaalPostComments( $comment, $args, $depth ) {
	
		$GLOBALS['comment'] = $comment;
		
		$aps = new SeoaalPostSettings;		
		
		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			)
		);
		
		?>
		<li <?php comment_class('clearfix'); ?> id="comment-<?php comment_ID() ?>">
			
			<div class="media thecomment">
						
				<div class="media-left author-img">
					<?php echo get_avatar($comment,$args['avatar_size']); ?>
				</div>
				
				<div class="media-body comment-text">
					<p class="comment-meta">
					<span class="author"><?php echo get_comment_author_link(); ?></span>
					<span class="date"><?php printf( wp_kses( __( '%1$s at %2$s', 'seoaal' ), $allowed_html ), get_comment_date(), get_comment_time( 'g:i a' )) ?></span>
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><i class="icon-info-sign"></i> <?php esc_html_e( 'Comment awaiting approval', 'seoaal' ); ?></em>
						<br />
					<?php endif; ?>
					<?php if( $depth < $args['max_depth'] ) : ?>
					<span class="reply">
						<?php 	
						comment_reply_link( array_merge( $args, array('reply_text' => esc_html__('Reply ', 'seoaal'), 'depth' => $depth, 'max_depth' => $args['max_depth'])), $comment->comment_ID ); 
						?>
					</span>
					<?php endif; ?>
					</p>
					<?php comment_text(); ?>					
				</div>
						
			</div>
			
			
		</li>
		<?php
		
	} 
}

/* Custom Notice */
if( is_admin() ){
	function zozo_theme_option_save_notice() {
		?>
		<div class="notice notice-warning is-dismissible">
			<p><?php _e( 'Did you know? After theme option save, make hard refresh to get better result!', 'mist' ); ?></p>
		</div>
		<?php
	}
	if( isset( $_GET['page'] ) && $_GET['page'] == '_options' ){
		add_action( 'admin_notices', 'zozo_theme_option_save_notice', 10 );
	}
}
function my_favicon() {
	if(get_current_blog_id()=="1")
		echo '<link rel="shortcut icon" href="/wp-content/uploads/favicon.png" />';
	else
		echo '<link rel="shortcut icon" href="/wp-content/uploads/sites/'.get_current_blog_id().'/favicon.png" />';

}
add_action('wp_head', 'my_favicon');


add_action('restrict_manage_posts','location_filtering',10);






function location_filtering($post_type){
    if('my-custom-post' !== $post_type){
     // return; //filter your post
    }
    $selected = '';
    $request_attr = 'my_loc';
    if ( isset($_REQUEST[$request_attr]) ) {
      $selected = $_REQUEST[$request_attr];
    }
    //get unique values of the meta field to filer by.
    $meta_key = 'color';
    global $wpdb;
    $results = $wpdb->get_col( 
        $wpdb->prepare( "
            SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
            LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = '%s'
            AND p.post_status IN ('publish', 'draft')
            ORDER BY pm.meta_value", 
            $meta_key
        ) 
    );

   //build a custom dropdown list of values to filter by
    echo '<select id="my_loc" name="my_loc">';
    echo '<option value="0">' . __( 'Show all locations', 'my-custom-domain' ) . ' </option>';
    foreach($results as $location){
      $select = ($location == $selected) ? ' selected="selected"':'';
      echo '<option value="'.$location.'"'.$select.'>' . $location . ' </option>';
    }
    echo '</select>';
  }
/*
  


function wisdom_sort_plugins_by_slug( $query ) {
  global $pagenow;

  // Get the post type
  $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
  if ( is_admin() && $pagenow=='edit.php' && $post_type == '' && isset( $_GET['my_loc'] ) && $_GET['my_loc'] !=0 ) {
    $query->query_vars['meta_key'] = 'color';
    $query->query_vars['meta_value'] = $_GET['my_loc'];
    $query->query_vars['meta_compare'] = '=';
  }
}*/

add_action( 'restrict_manage_posts', 'my_post_type_filter', 10, 2 );
function my_post_type_filter( $post_type, $which ) {
    if ( 'post' !== $post_type ) {
        return; //check to make sure this is your cpt
    }
 
    $taxonomy_slug = 'category';
    $taxonomy      = get_taxonomy($taxonomy_slug);
    $selected      = '';
    $request_attr  = 'my_type'; //this will show up in the url
  
    if ( isset( $_REQUEST[ $request_attr ] ) ) {
        $selected = $_REQUEST[ $request_attr ]; //in case the current page is already filtered
    }
     
    wp_dropdown_categories(array(
        'show_option_all' =>  __("Show All {$taxonomy->label}"),
        'taxonomy'        =>  $taxonomy_slug,
        'name'            =>  $request_attr,
        'orderby'         =>  'name',
        'selected'        =>  $selected,
        'hierarchical'    =>  true,
        'depth'           =>  3,
        'show_count'      =>  true, // Show number of post in parent term
        'hide_empty'      =>  false, // Don't show posts w/o terms
    ) );
}
add_filter( 'parse_query', 'wisdom_sort_plugins_by_slug' );




function filter_request_query($query){
    //modify the query only if it admin and main query.
    
    if( !(is_admin() AND $query->is_main_query()) ){ 
      return $query;
    }
    //we want to modify the query for the targeted custom post and filter option
    //if( !('my-custom-post' === $query->query['post_type'] AND isset($_REQUEST['my_loc']) ) ){
    if( !isset($_REQUEST['my_loc'])){
      return $query;
    }
    //for the default value of our filter no modification is required
    
    if(0 == $_REQUEST['my_loc']){
      return $query;
    }


	$query->query_vars['meta_key'] 		= 'color';
    $query->query_vars['meta_value'] 	= $_REQUEST['my_loc'];
    $query->query_vars['meta_compare'] 	= '=';

   //modify the query_vars.
    $query->query_vars = array(array(
      'field' => 'color',
      'value' => $_REQUEST['my_loc'],
      'compare' => '=',
      'type' => 'CHAR'
    ));
    
    return $query;
  }
add_filter( 'parse_query', 'filter_request_query' , 10);




  add_filter('use_block_editor_for_post', '__return_false', 10);


//////////////////////////////////////////////////////////

function wporg_options_page_html() {
    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'wporg' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
    </div>
    <?php
}
add_action( 'admin_menu', 'wporg_options_page' );
function wporg_options_page() {
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html',
        plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
        20
    );
}
