<?php
if( !class_exists( "SeoaalThemeStyles" ) ){
	require_once SEOAAL_INC . '/theme-class/theme-style-class.php';
}
$ats = new SeoaalThemeStyles;
echo "
/*
 * Seoaal theme custom style
 */\n\n";
$seoaal_options = get_option( 'seoaal_options' );
echo "\n/* General Styles */\n";
$ats->seoaal_custom_font_check( 'body-typography' );
echo 'body{';
	$ats->seoaal_typo_generate( 'body-typography' );
	$ats->seoaal_bg_settings( 'body-background' );
echo '
}';
$ats->seoaal_custom_font_check( 'h1-typography' );
echo 'h1{';
	$ats->seoaal_typo_generate( 'h1-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h2-typography' );
echo 'h2{';
	$ats->seoaal_typo_generate( 'h2-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h3-typography' );
echo 'h3{';
	$ats->seoaal_typo_generate( 'h3-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h4-typography' );
echo 'h4{';
	$ats->seoaal_typo_generate( 'h4-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h5-typography' );
echo 'h5{';
	$ats->seoaal_typo_generate( 'h5-typography' );
echo '
}';
$ats->seoaal_custom_font_check( 'h6-typography' );
echo 'h6{';
	$ats->seoaal_typo_generate( 'h6-typography' );
echo '
}';
$gen_link = $ats->seoaal_theme_opt('theme-link-color');
if( $gen_link ):
echo 'a{';
	$ats->seoaal_link_color( 'theme-link-color', 'regular' );
echo '
}';
echo 'a:hover{';
	$ats->seoaal_link_color( 'theme-link-color', 'hover' );
echo '
}';
echo 'a:active{';
	$ats->seoaal_link_color( 'theme-link-color', 'active' );
echo '
}';
endif;
echo "\n/* Widget Typography Styles */\n";
$ats->seoaal_custom_font_check( 'widgets-content' );
echo '.widget{';
	$ats->seoaal_typo_generate( 'widgets-content' );
echo '
}';

echo '
.header-inner .main-logo img{
    max-height: '. esc_attr( $ats->seoaal_dimension_height('logo-height') ) .' ;
}';

echo '
.header-inner .sticky-logo img{
    max-height: '. esc_attr( $ats->seoaal_dimension_height('sticky-logo-height') ) .' !important;
}';

echo '
.mobile-header .mobile-header-inner ul > li img ,
.mobile-bar-items .mobile-logo img {
    max-height: '. esc_attr( $ats->seoaal_dimension_height('mobile-logo-height') ) .' !important;
}';


$ats->seoaal_custom_font_check( 'widgets-title' );
echo '.widget .widget-title{';
	$ats->seoaal_typo_generate( 'widgets-title' );
echo '
}';
$page_loader = $ats->seoaal_theme_opt('page-loader') && $ats->seoaal_theme_opt('page-loader-img') != '' ? $seoaal_options['page-loader-img']['url'] : '';
if( $page_loader ):
	echo ".page-loader {background: url('". esc_url( $page_loader ). "') 50% 50% no-repeat rgba(255,255,255, 1);}";
endif;
echo '.container, .boxed-container, .boxed-container .site-footer.footer-fixed, .custom-container {
	width: '. $ats->seoaal_container_width() .';
}';
echo '.seoaal-content > .seoaal-content-inner{';
	$ats->seoaal_padding_settings( 'page-content-padding' );
echo '
}';
echo "\n/* Header Styles */\n";
echo 'header.seoaal-header {';
	$ats->seoaal_bg_settings('header-background');
echo '}';
echo "\n/* Topbar Styles */\n";
$ats->seoaal_custom_font_check( 'header-topbar-typography' );
echo '.topbar{';
	$ats->seoaal_typo_generate( 'header-topbar-typography' );
	$ats->seoaal_bg_rgba( 'header-topbar-background' );
	$ats->seoaal_border_settings( 'header-topbar-border' );
echo '
}';
echo '.topbar .topbar-inner {';
	$ats->seoaal_padding_settings( 'header-topbar-padding' );
echo '
}';
echo '.topbar a{';
	$ats->seoaal_link_color( 'header-topbar-link-color', 'regular' );
echo '
}';
echo '.topbar a:hover {';
	$ats->seoaal_link_color( 'header-topbar-link-color', 'hover' );
echo '
}';
echo '.topbar a:active,.topbar a:focus {';
	$ats->seoaal_link_color( 'header-topbar-link-color', 'active' );
echo '
}';
echo '
.topbar-items > li{
    height: '. esc_attr( $ats->seoaal_dimension_height('header-topbar-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('header-topbar-height') ) .' ;
}
.header-sticky .topbar-items > li,
.sticky-scroll.show-menu .topbar-items > li{
	height: '. esc_attr( $ats->seoaal_dimension_height('header-topbar-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('header-topbar-sticky-height') ) .' ;
}';
echo '
.topbar-items > li img{
	max-height: '. esc_attr(  $ats->seoaal_dimension_height('header-topbar-height') ) .' ;
}';
echo "\n/* Logobar Styles */\n";
$ats->seoaal_custom_font_check( 'header-logobar-typography' );
echo '.logobar{';
	$ats->seoaal_typo_generate( 'header-logobar-typography' );
	$ats->seoaal_bg_rgba( 'header-logobar-background' );
	$ats->seoaal_border_settings( 'header-logobar-border' );
echo '
}';
echo '.logobar .logobar-inner {';
	$ats->seoaal_padding_settings( 'header-logobar-padding' );
echo '
}';
echo '.logobar a{';
	$ats->seoaal_link_color( 'header-logobar-link-color', 'regular' );
echo '
}';
echo '.logobar a:hover{';
	$ats->seoaal_link_color( 'header-logobar-link-color', 'hover' );
echo '
}';
echo '.logobar a:active,
.logobar a:focus, .logobar .seoaal-main-menu > li.current-menu-item > a, .logobar .seoaal-main-menu > li.current-menu-ancestor > a, .logobar a.active {';
	$ats->seoaal_link_color( 'header-logobar-link-color', 'active' );
echo '
}';
echo '
.logobar-items > li{
    height: '. esc_attr( $ats->seoaal_dimension_height('header-logobar-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('header-logobar-height') ) .' ;
}
.header-sticky .logobar-items > li,
.sticky-scroll.show-menu .logobar-items > li{
	height: '. esc_attr( $ats->seoaal_dimension_height('header-logobar-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('header-logobar-sticky-height') ) .' ;
}';
echo '
.logobar-items > li img{
	max-height: '. esc_attr( $ats->seoaal_dimension_height('header-logobar-height') ) .' ;
}';
echo "\n/* Logobar Sticky Styles */\n";
$color = $ats->seoaal_theme_opt('sticky-header-logobar-color');
echo '.header-sticky .logobar, .sticky-scroll.show-menu .logobar{
	'. ( $color != '' ? 'color: '. $color .';' : '' );
	$ats->seoaal_bg_rgba( 'sticky-header-logobar-background' );
	$ats->seoaal_border_settings( 'sticky-header-logobar-border' );
	$ats->seoaal_padding_settings( 'sticky-header-logobar-padding' );
echo '
}';
echo '.header-sticky .logobar a, .sticky-scroll.show-menu .logobar a{';
	$ats->seoaal_link_color( 'sticky-header-logobar-link-color', 'regular' );
echo '
}';
echo '.header-sticky .logobar a:hover, .sticky-scroll.show-menu .logobar a:hover{';
	$ats->seoaal_link_color( 'sticky-header-logobar-link-color', 'hover' );
echo '
}';
echo '.header-sticky .logobar a:active, .sticky-scroll.show-menu .logobar a:active,
.header-sticky .logobar .seoaal-main-menu .current-menu-item > a, .header-sticky .logobar .seoaal-main-menu .current-menu-ancestor > a,
.sticky-scroll.show-menu .logobar .seoaal-main-menu .current-menu-item > a, .sticky-scroll.show-menu .logobar .seoaal-main-menu .current-menu-ancestor > a ,
.header-sticky .logobar a.active, .sticky-scroll.show-menu .logobar a.active{';
	$ats->seoaal_link_color( 'sticky-header-logobar-link-color', 'active' );
echo '
}';
echo "\n/* Navbar Styles */\n";
$ats->seoaal_custom_font_check( 'header-navbar-typography' );
echo '.navbar{';
	$ats->seoaal_typo_generate( 'header-navbar-typography' );
	$ats->seoaal_bg_rgba( 'header-navbar-background' );
	$ats->seoaal_border_settings( 'header-navbar-border' );
echo '
}';
echo '.navbar .navbar-inner {';
	$ats->seoaal_padding_settings( 'header-navbar-padding' );
echo '
}';
echo '.navbar a{';
	$ats->seoaal_link_color( 'header-navbar-link-color', 'regular' );
echo '
}';
echo '.navbar a:hover{';
	$ats->seoaal_link_color( 'header-navbar-link-color', 'hover' );
echo '
}';
echo '.navbar a:active,.navbar a:focus, .seoaal-main-menu > .current-menu-item > a, .seoaal-main-menu > .current-menu-ancestor > a, .navbar a.active {';
	$ats->seoaal_link_color( 'header-navbar-link-color', 'active' );
echo '
}';
$color = $ats->seoaal_theme_opt( 'header-navbar-typography' );
$color = isset( $color['color'] ) && $color['color'] != '' ? $color['color'] : '';
$scolor = $ats->seoaal_theme_opt( 'sticky-header-navbar-color' );
if( $color ):
echo '.navbar .secondary-space-toggle > span{
	background-color: '. esc_attr( $color ) .';
}';
endif;
if( $scolor ):
echo '.header-sticky .navbar .secondary-space-toggle > span,
.sticky-scroll.show-menu .navbar .secondary-space-toggle > span{
	background-color: '. esc_attr( $scolor ) .';
}';
endif;
echo '
.navbar-items > li {
    height: '. esc_attr( $ats->seoaal_dimension_height('header-navbar-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('header-navbar-height') ) .' ;
}
.header-sticky .navbar-items > li,
.sticky-scroll.show-menu .navbar-items > li{
	height: '. esc_attr( $ats->seoaal_dimension_height('header-navbar-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('header-navbar-sticky-height') ) .' ;
}';
echo '
.navbar-items > li img{
	max-height: '. esc_attr( $ats->seoaal_dimension_height('header-navbar-height') ) .' ;
}';
echo "\n/* Navbar Sticky Styles */\n";
$color = $ats->seoaal_theme_opt('sticky-header-navbar-color');
echo '.header-sticky .navbar, .sticky-scroll.show-menu .navbar{
	'. ( $color != '' ? 'color: '. $color .';' : '' );
	$ats->seoaal_bg_rgba( 'sticky-header-navbar-background' );
	$ats->seoaal_border_settings( 'sticky-header-navbar-border' );
	$ats->seoaal_padding_settings( 'sticky-header-navbar-padding' );
echo '
}';
echo '.header-sticky .navbar a, .sticky-scroll.show-menu .navbar a {';
	$ats->seoaal_link_color( 'sticky-header-navbar-link-color', 'regular' );
echo '
}';
echo '.header-sticky .navbar a:hover, .sticky-scroll.show-menu .navbar a:hover {';
	$ats->seoaal_link_color( 'sticky-header-navbar-link-color', 'hover' );
echo '
}';
echo '
.header-sticky .navbar img.custom-logo, .sticky-scroll.show-menu .navbar img.custom-logo{
	max-height: '. esc_attr( $ats->seoaal_dimension_height('header-navbar-sticky-height') ) .' ;
}';
echo "\n/* Secondary Menu Space Styles */\n";
$sec_menu_type = $ats->seoaal_theme_opt('secondary-menu-type');
$ats->seoaal_custom_font_check( 'secondary-space-typography' );
echo '.secondary-menu-area {';
	echo 'width: '. esc_attr( $ats->seoaal_dimension_width('secondary-menu-space-width') ) .' ;';
echo '}';
echo '.secondary-menu-area, .secondary-menu-area .widget {';
	$ats->seoaal_border_settings( 'secondary-space-border' );
	$ats->seoaal_typo_generate( 'secondary-space-typography' );
	$ats->seoaal_bg_settings('secondary-space-background');
	if( $sec_menu_type == 'left-overlay' || $sec_menu_type == 'left-push' ){
		echo 'left: -' . esc_attr( $ats->seoaal_dimension_width('secondary-menu-space-width') ) . ';';
	}elseif( $sec_menu_type == 'right-overlay' || $sec_menu_type == 'right-push' ){
		echo 'right: -' . esc_attr( $ats->seoaal_dimension_width('secondary-menu-space-width') ) . ';';
	}
echo '
}';
echo '.secondary-menu-area.left-overlay, .secondary-menu-area.left-push{';
	if( $sec_menu_type == 'left-overlay' || $sec_menu_type == 'left-push' ){
		echo 'left: -' . esc_attr( $ats->seoaal_dimension_width('secondary-menu-space-width') ) . ';';
	}
echo '
}';
echo '.secondary-menu-area.right-overlay, .secondary-menu-area.right-push{';
	if( $sec_menu_type == 'right-overlay' || $sec_menu_type == 'right-push' ){
		echo 'right: -' . esc_attr( $ats->seoaal_dimension_width('secondary-menu-space-width') ) . ';';
	}
echo '
}';
echo '.secondary-menu-area .secondary-menu-area-inner{';
	$ats->seoaal_padding_settings( 'secondary-space-padding' );
echo '
}';
echo '.secondary-menu-area a{';
	$ats->seoaal_link_color( 'secondary-space-link-color', 'regular' );
echo '
}';
echo '.secondary-menu-area a:hover{';
	$ats->seoaal_link_color( 'secondary-space-link-color', 'hover' );
echo '
}';
echo '.secondary-menu-area a:active{';
	$ats->seoaal_link_color( 'secondary-space-link-color', 'active' );
echo '
}';
echo "\n/* Sticky Header Styles */\n";
if( $ats->seoaal_theme_opt('header-type') != 'default' ):
$sticky_width = $ats->seoaal_dimension_width('header-fixed-width');
echo '.sticky-header-space{
	width: '. esc_attr( $sticky_width ) .';
}';
	if( $ats->seoaal_theme_opt('header-type') == 'left-sticky' ):
	echo 'body, .top-sliding-bar{
		padding-left: '. esc_attr( $sticky_width ) .';
	}';
	else:
	echo 'body, .top-sliding-bar{
		padding-right: '. esc_attr( $sticky_width ) .';
	}';
	endif;
endif;
$ats->seoaal_custom_font_check( 'header-fixed-typography' );
echo '.sticky-header-space{';
	$ats->seoaal_typo_generate( 'header-fixed-typography' );
	$ats->seoaal_bg_settings( 'header-fixed-background' );
	$ats->seoaal_border_settings( 'header-fixed-border' );
	$ats->seoaal_padding_settings( 'header-fixed-padding' );
echo '
}';
echo '.sticky-header-space li a{';
	$ats->seoaal_link_color( 'header-fixed-link-color', 'regular' );
echo '
}';
echo '.sticky-header-space li a:hover{';
	$ats->seoaal_link_color( 'header-fixed-link-color', 'hover' );
echo '
}';
echo '.sticky-header-space li a:active{';
	$ats->seoaal_link_color( 'header-fixed-link-color', 'active' );
echo '
}';
echo "\n/* Mobile Header Styles */\n";
echo '
.mobile-header-items > li{
    height: '. esc_attr( $ats->seoaal_dimension_height('mobile-header-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('mobile-header-height') ) .' ;
}
.mobile-header .mobile-header-inner ul > li img {
	max-height: '. esc_attr( $ats->seoaal_dimension_height('mobile-header-height') ) .' ;
}
.mobile-header{';
	$ats->seoaal_bg_rgba('mobile-header-background');
echo '
}';
echo '.mobile-header-items li a{';
	$ats->seoaal_link_color( 'mobile-header-link-color', 'regular' );
echo '
}';
echo '.mobile-header-items li a:hover{';
	$ats->seoaal_link_color( 'mobile-header-link-color', 'hover' );
echo '
}';
echo '.mobile-header-items li a:active{';
	$ats->seoaal_link_color( 'mobile-header-link-color', 'active' );
echo '
}';
echo '
.header-sticky .mobile-header-items > li, .show-menu .mobile-header-items > li{
    height: '. esc_attr( $ats->seoaal_dimension_height('mobile-header-sticky-height') ) .' ;
    line-height: '. esc_attr( $ats->seoaal_dimension_height('mobile-header-sticky-height') ) .' ;
}
.header-sticky .mobile-header-items > li .mobile-logo img, .show-menu .mobile-header-items > li .mobile-logo img{
	max-height: '. esc_attr( $ats->seoaal_dimension_height('mobile-header-sticky-height') ) .' ;
}
.mobile-header .header-sticky, .mobile-header .show-menu{';
	$ats->seoaal_bg_rgba('mobile-header-sticky-background');
echo '}';
echo '.header-sticky .mobile-header-items li a, .show-menu .mobile-header-items li a{';
	$ats->seoaal_link_color( 'mobile-header-sticky-link-color', 'regular' );
echo '
}';
echo '.header-sticky .mobile-header-items li a:hover, .show-menu .mobile-header-items li a:hover{';
	$ats->seoaal_link_color( 'mobile-header-sticky-link-color', 'hover' );
echo '
}';
echo '.header-sticky .mobile-header-items li a:hover, .show-menu .mobile-header-items li a:hover{';
	$ats->seoaal_link_color( 'mobile-header-sticky-link-color', 'active' );
echo '
}';
$mm_max = $ats->seoaal_dimension_width( 'mobile-menu-max-width' );
if( $mm_max ):
echo '.mobile-bar, .mobile-bar .container{
	max-width: '. $mm_max .';
}';
endif;
echo "\n/* Mobile Bar Styles */\n";
$ats->seoaal_custom_font_check( 'mobile-menu-typography' );
echo '.mobile-bar{';
	$ats->seoaal_typo_generate( 'mobile-menu-typography' );
	$ats->seoaal_bg_settings( 'mobile-menu-background' );
	$ats->seoaal_border_settings( 'mobile-menu-border' );
	$ats->seoaal_padding_settings( 'mobile-menu-padding' );
echo '
}';
echo '.mobile-bar li a{';
	$ats->seoaal_link_color( 'mobile-menu-link-color', 'regular' );
echo '
}';
echo '.mobile-bar li a:hover{';
	$ats->seoaal_link_color( 'mobile-menu-link-color', 'hover' );
echo '
}';
echo '.mobile-bar li a:active, ul > li.current-menu-item > a, 
ul > li.current-menu-parent > a, ul > li.current-menu-ancestor > a,
.seoaal-mobile-menu li.menu-item a.active {';
	$ats->seoaal_link_color( 'mobile-menu-link-color', 'active' );
echo '
}';
echo "\n/* Top Sliding Bar Styles */\n";
$ats->seoaal_custom_font_check( 'top-sliding-typography' );
if( $ats->seoaal_theme_opt( 'header-top-sliding-switch' ) ):
echo '.top-sliding-bar-inner{';
	$ats->seoaal_typo_generate( 'top-sliding-typography' );
	$ats->seoaal_bg_rgba( 'top-sliding-background' );
	$ats->seoaal_border_settings( 'top-sliding-border' );
	$ats->seoaal_padding_settings( 'top-sliding-padding' );
echo '
}';
$ts_bg = $ats->seoaal_theme_opt( 'top-sliding-background' );
echo '.top-sliding-toggle{
	'. ( $ts_bg != '' ? 'border-top-color: '. $ts_bg['rgba'] . ';' : '' ) .'
}';
echo '.top-sliding-bar-inner li a{';
	$ats->seoaal_link_color( 'top-sliding-link-color', 'regular' );
echo '
}';
echo '.top-sliding-bar-inner li a:hover{';
	$ats->seoaal_link_color( 'top-sliding-link-color', 'hover' );
echo '
}';
echo '.top-sliding-bar-inner li a:active{';
	$ats->seoaal_link_color( 'top-sliding-link-color', 'active' );
echo '
}';
endif;
echo "\n/* General Menu Styles */\n";
echo '.menu-tag-hot{
	background-color: '. $ats->seoaal_theme_opt( 'menu-tag-hot-bg' ) .';
}';
echo '.menu-tag-new{
	background-color: '. $ats->seoaal_theme_opt( 'menu-tag-new-bg' ) .';
}';
echo '.menu-tag-trend{
	background-color: '. $ats->seoaal_theme_opt( 'menu-tag-trend-bg' ) .';
}';
echo "\n/* Main Menu Styles */\n";
$ats->seoaal_custom_font_check( 'main-menu-typography' );
echo 'ul.seoaal-main-menu > li > a,
ul.seoaal-main-menu > li > .main-logo{';
	$ats->seoaal_typo_generate( 'main-menu-typography' );
echo '
}';
echo "\n/* Dropdown Menu Styles */\n";
echo 'ul.dropdown-menu{';
	$ats->seoaal_bg_rgba( 'dropdown-menu-background' );
	$ats->seoaal_border_settings( 'dropdown-menu-border' );
echo '
}';
$ats->seoaal_custom_font_check( 'dropdown-menu-typography' );
echo 'ul.dropdown-menu > li{';
	$ats->seoaal_typo_generate( 'dropdown-menu-typography' );
echo '
}';
echo 'ul.dropdown-menu > li a,
ul.mega-child-dropdown-menu > li a,
.header-sticky ul.dropdown-menu > li a, .sticky-scroll.show-menu ul.dropdown-menu > li a,
.header-sticky ul.mega-child-dropdown-menu > li a, .sticky-scroll.show-menu ul.mega-child-dropdown-menu > li a {';
	$ats->seoaal_link_color( 'dropdown-menu-link-color', 'regular' );
echo '
}';
echo 'ul.dropdown-menu > li a:hover,
ul.mega-child-dropdown-menu > li a:hover,
.header-sticky ul.dropdown-menu > li a:hover, .sticky-scroll.show-menu ul.dropdown-menu > li a:hover,
.header-sticky ul.mega-child-dropdown-menu > li a:hover, .sticky-scroll.show-menu ul.mega-child-dropdown-menu > li a:hover {';
	$ats->seoaal_link_color( 'dropdown-menu-link-color', 'hover' );
echo '
}';
echo 'ul.dropdown-menu > li a:active,
ul.mega-child-dropdown-menu > li a:active,
.header-sticky ul.dropdown-menu > li a:active, .sticky-scroll.show-menu ul.dropdown-menu > li a:active,
.header-sticky ul.mega-child-dropdown-menu > li a:active, .sticky-scroll.show-menu ul.mega-child-dropdown-menu > li a:active,
ul.dropdown-menu > li.current-menu-item > a, ul.dropdown-menu > li.current-menu-parent > a, ul.dropdown-menu > li.current-menu-ancestor > a,
ul.mega-child-dropdown-menu > li.current-menu-item > a {';
	$ats->seoaal_link_color( 'dropdown-menu-link-color', 'active' );
echo '
}';
/* Template Page Title Styles */
echo "\n/* Template Page Title Styles */\n";
seoaalPostTitileStyle( 'single-post' );
seoaalPostTitileStyle( 'blog' );
seoaalPostTitileStyle( 'page' );
seoaalPostTitileStyle( 'woo' );
seoaalPostTitileStyle( 'single-product' );
$actived_tmplt = $ats->seoaal_theme_opt('theme-templates');
if( !empty( $actived_tmplt ) && is_array( $actived_tmplt ) ){
	foreach( $actived_tmplt as $template ){
		seoaalPostTitileStyle( $template );
	}
}
$actived_cat_tmplt = $ats->seoaal_theme_opt('theme-categories');
if( !empty( $actived_cat_tmplt ) && is_array( $actived_cat_tmplt ) ){
	foreach( $actived_cat_tmplt as $template ){
		seoaalPostTitileStyle( $template );
	}
}
function seoaalPostTitileStyle( $field ){
	$ats = new SeoaalThemeStyles; 
	echo '.seoaal-'. $field .' .page-title-wrap-inner {
		color: '. $ats->seoaal_theme_opt( 'template-'. $field .'-color' ) .';';
		$ats->seoaal_bg_settings( 'template-'. $field .'-background-all' );
		$ats->seoaal_border_settings( 'template-'. $field .'-border' );
		$ats->seoaal_padding_settings( 'template-'. $field .'-padding' );
	echo '
	}';
	$padding_bottom_opt = $ats->seoaal_theme_opt('template-'. $field .'-padding');
	$padding_bottom = isset( $padding_bottom_opt['padding-bottom'] ) && $padding_bottom_opt['padding-bottom'] != '' ? $padding_bottom_opt['padding-bottom'] : '';
	if( $padding_bottom ){
		$padding_bottom = absint( str_replace("px","", $padding_bottom) );
		$padding_bottom += 0;
		echo '.seoaal-'. $field .' .page-title-inner .breadcrumb-wrap { bottom: -'. esc_attr( $padding_bottom ) .'px; }';
	}
	echo '.seoaal-'. $field .' .page-title-wrap a{';
		$ats->seoaal_link_color( 'template-'. $field .'-link-color', 'regular' );
	echo '
	}';
	echo '.seoaal-'. $field .' .page-title-wrap a:hover{';
		$ats->seoaal_link_color( 'template-'. $field .'-link-color', 'hover' );
	echo '
	}';
	echo '.seoaal-'. $field .' .page-title-wrap a:active{';
		$ats->seoaal_link_color( 'template-'. $field .'-link-color', 'active' );
	echo '
	}';
	echo '.seoaal-'. $field .' .page-title-wrap-inner > .page-title-overlay{';
		$ats->seoaal_bg_rgba( $field .'-page-title-overlay' );
	echo '
	}';
}
/* Template Article Styles */
echo "\n/* Template Article Styles */\n";
seoaalPostArticleStyle( 'single-post' );
seoaalPostArticleStyle( 'blog' );
$actived_tmplt = $ats->seoaal_theme_opt('theme-templates');
if( !empty( $actived_tmplt ) && is_array( $actived_tmplt ) ){
	foreach( $actived_tmplt as $template ){
		seoaalPostArticleStyle( $template );
	}
}
$actived_cat_tmplt = $ats->seoaal_theme_opt('theme-categories');
if( !empty( $actived_cat_tmplt ) && is_array( $actived_cat_tmplt ) ){
	foreach( $actived_cat_tmplt as $template ){
		seoaalPostArticleStyle( $template );
	}
}
function seoaalPostArticleStyle( $field ){
	$ats = new SeoaalThemeStyles; 
	echo '.'. $field .'-template article.post{
		color: '. $ats->seoaal_theme_opt( $field .'-article-color' ) .';';
		$ats->seoaal_bg_rgba( $field .'-article-background' );
		$ats->seoaal_border_settings( $field .'-article-border' );
		$ats->seoaal_padding_settings( $field .'-article-padding' );
	echo '
	}';
	echo '.'. $field .'-template article.post a{';
		$ats->seoaal_link_color( $field .'-article-link-color', 'regular' );
	echo '
	}';
	echo '.'. $field .'-template article.post a:hover{';
		$ats->seoaal_link_color( $field .'-article-link-color', 'hover' );
	echo '
	}';
	echo '.'. $field .'-template article.post a:active{';
		$ats->seoaal_link_color( $field .'-article-link-color', 'active' );
	echo '
	}';
	$post_thumb_margin = $ats->seoaal_theme_opt( $field .'-article-padding' );
	if( $post_thumb_margin ):
		echo '.'. $field .'-template .post-format-wrap{
			'. ( isset( $post_thumb_margin['padding-left'] ) && $post_thumb_margin['padding-left'] != '' ? 'margin-left: -' . $post_thumb_margin['padding-left'] .';' : '' ) .'
			'. ( isset( $post_thumb_margin['padding-right'] ) && $post_thumb_margin['padding-right'] != '' ? 'margin-right: -' . $post_thumb_margin['padding-right'] .';' : '' ) .'
		}';
		echo '.'. $field .'-template .post-quote-wrap > .blockquote, .'. $field .'-template .post-link-inner, .'. $field .'-template .post-format-wrap .post-audio-wrap{
			'. ( isset( $post_thumb_margin['padding-left'] ) && $post_thumb_margin['padding-left'] != '' ? 'padding-left: ' . $post_thumb_margin['padding-left'] .';' : '' ) .'
			'. ( isset( $post_thumb_margin['padding-right'] ) && $post_thumb_margin['padding-right'] != '' ? 'padding-right: ' . $post_thumb_margin['padding-right'] .';' : '' ) .'
		}';
	endif;
}
$theme_color = $ats->seoaalThemeColor();
$secondary_color = $ats->seoaalSecondaryColor();
echo "\n/* Blockquote / Audio / Link Styles */\n";
echo '.post-quote-wrap > .blockquote{
	border-left-color: '. esc_attr( $theme_color ) .';
}';
$rgba_08 = $ats->seoaal_hex2rgba( $theme_color, '0.8' );
// Single Post Blockquote
$blockquote_bg_opt = $ats->seoaal_theme_opt( 'single-post-quote-format' );
seoaalQuoteDynamicStyle( 'single-post', $blockquote_bg_opt, $theme_color, $rgba_08 );
// Blog Blockquote
$blockquote_bg_opt = $ats->seoaal_theme_opt( 'blog-quote-format' );
seoaalQuoteDynamicStyle( 'blog', $blockquote_bg_opt, $theme_color, $rgba_08 );
// Archive Blockquote
$blockquote_bg_opt = $ats->seoaal_theme_opt( 'archive-quote-format' );
seoaalQuoteDynamicStyle( 'archive', $blockquote_bg_opt, $theme_color, $rgba_08 );
// Tag Blockquote
$blockquote_bg_opt = $ats->seoaal_theme_opt( 'tag-quote-format' );
seoaalQuoteDynamicStyle( 'tag', $blockquote_bg_opt, $theme_color, $rgba_08 );
// Search Blockquote
$blockquote_bg_opt = $ats->seoaal_theme_opt( 'search-quote-format' );
seoaalQuoteDynamicStyle( 'search', $blockquote_bg_opt, $theme_color, $rgba_08 );
// Author Blockquote
$blockquote_bg_opt = $ats->seoaal_theme_opt( 'author-quote-format' );
seoaalQuoteDynamicStyle( 'author', $blockquote_bg_opt, $theme_color, $rgba_08 );
// Category Blockquote
$blockquote_bg_opt = $ats->seoaal_theme_opt( 'category-quote-format' );
seoaalQuoteDynamicStyle( 'category', $blockquote_bg_opt, $theme_color, $rgba_08 );
// All Category Blockquote
$actived_cat_tmplt = $ats->seoaal_theme_opt('theme-categories');
if( !empty( $actived_cat_tmplt ) && is_array( $actived_cat_tmplt ) ){
	foreach( $actived_cat_tmplt as $template ){
		$blockquote_bg_opt = $ats->seoaal_theme_opt( $template.'-quote-format' );
		seoaalQuoteDynamicStyle( $template, $blockquote_bg_opt, $theme_color, $rgba_08 );
	}
}
function seoaalQuoteDynamicStyle( $field, $value, $theme_color, $rgba_08 ){
	if( $value == 'none' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: #333;
		}';
	elseif( $value == 'theme' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: '. $theme_color .';
			border-left-color: #333;
		}';
	elseif( $value == 'theme-overlay' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: '. $rgba_08 .';
		}';
	elseif( $value == 'featured' ):
		echo '.'. $field .'-template .post-quote-wrap > .blockquote{
			background-color: rgba(0, 0, 0, 0.7);
		}';
	endif;
}
/* Single Post Link */
$link_bg_opt = $ats->seoaal_theme_opt( 'single-post-link-format' );
seoaalLinkDynamicStyle( 'single-post', $link_bg_opt, $theme_color, $rgba_08 );
/* Blog Link */
$link_bg_opt = $ats->seoaal_theme_opt( 'blog-link-format' );
seoaalLinkDynamicStyle( 'blog', $link_bg_opt, $theme_color, $rgba_08 );
/* Archive Link */
$link_bg_opt = $ats->seoaal_theme_opt( 'archive-link-format' );
seoaalLinkDynamicStyle( 'archive', $link_bg_opt, $theme_color, $rgba_08 );
/* Tag Link */
$link_bg_opt = $ats->seoaal_theme_opt( 'tag-link-format' );
seoaalLinkDynamicStyle( 'tag', $link_bg_opt, $theme_color, $rgba_08 );
/* Author Link */
$link_bg_opt = $ats->seoaal_theme_opt( 'author-link-format' );
seoaalLinkDynamicStyle( 'author', $link_bg_opt, $theme_color, $rgba_08 );
/* Search Link */
$link_bg_opt = $ats->seoaal_theme_opt( 'search-link-format' );
seoaalLinkDynamicStyle( 'search', $link_bg_opt, $theme_color, $rgba_08 );
/* Catgeory Link */
$link_bg_opt = $ats->seoaal_theme_opt( 'category-link-format' );
seoaalLinkDynamicStyle( 'category', $link_bg_opt, $theme_color, $rgba_08 );
// All Category Link
$actived_cat_tmplt = $ats->seoaal_theme_opt('theme-categories');
if( !empty( $actived_cat_tmplt ) && is_array( $actived_cat_tmplt ) ){
	foreach( $actived_cat_tmplt as $template ){
		$link_bg_opt = $ats->seoaal_theme_opt( $template.'-link-format' );
		seoaalLinkDynamicStyle( $template, $link_bg_opt, $theme_color, $rgba_08 );
	}
}
function seoaalLinkDynamicStyle( $field, $value, $theme_color, $rgba_08 ){
	if( $value == 'none' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: #333;
		}';
	elseif( $value == 'theme' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: '. $theme_color .';
		}';
	elseif( $value == 'theme-overlay' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: '. $rgba_08 .';
		}';
	elseif( $value == 'featured' ):
		echo '.'. $field .'-template .post-link-inner{
			background-color: rgba(0, 0, 0, 0.7);
		}';
	endif;
}
echo "\n/* Post Item Overlay Styles */\n";
echo '.post-overlay-items{
	color: '. $ats->seoaal_theme_opt( 'single-post-article-overlay-color' ) .';';
	$ats->seoaal_bg_rgba( 'single-post-article-overlay-background' );
	$ats->seoaal_border_settings( 'single-post-article-overlay-border' );
	$ats->seoaal_padding_settings( 'single-post-article-overlay-padding' );
	$ats->seoaal_margin_settings( 'single-post-article-overlay-margin' );
	
echo '
}';
echo '.post-overlay-items a{';
	$ats->seoaal_link_color( 'single-post-article-overlay-link-color', 'regular' );
echo '
}';
echo '.post-overlay-items a:hover{';
	$ats->seoaal_link_color( 'single-post-article-overlay-link-color', 'hover' );
echo '
}';
echo '.post-overlay-items a:hover{';
	$ats->seoaal_link_color( 'single-post-article-overlay-link-color', 'active' );
echo '
}';
/* Extra Styles */
echo "\n/* Footer Styles */\n";
echo '.site-footer{';
	$ats->seoaal_typo_generate( 'footer-typography' );
	$ats->seoaal_bg_settings( 'footer-background' );
	$ats->seoaal_border_settings( 'footer-border' );
	$ats->seoaal_padding_settings( 'footer-padding' );
echo '
}';
echo '.site-footer .widget{';
	$ats->seoaal_typo_generate( 'footer-typography' );
echo '
}';
$bg_overlay = $ats->seoaal_theme_opt( 'footer-background-overlay' );
if( !empty( $bg_overlay ) && isset( $bg_overlay['rgba'] ) ):
echo '
footer.site-footer:before {
	position: absolute;
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	content: "";
	background-color: '. esc_attr( $bg_overlay['rgba'] ) .';
}';
endif;
echo '.site-footer a{';
	$ats->seoaal_link_color( 'footer-link-color', 'regular' );
echo '
}';
echo '.site-footer a:hover{';
	$ats->seoaal_link_color( 'footer-link-color', 'hover' );
echo '
}';
echo '.site-footer a:hover{';
	$ats->seoaal_link_color( 'footer-link-color', 'active' );
echo '
}';
echo "\n/* Footer Top Styles */\n";
$ats->seoaal_custom_font_check( 'footer-top-typography' );
echo '.footer-top-wrap{';
	$ats->seoaal_typo_generate( 'footer-top-typography' );
	$ats->seoaal_bg_rgba( 'footer-top-background' );
	$ats->seoaal_border_settings( 'footer-top-border' );
	$ats->seoaal_padding_settings( 'footer-top-padding' );
	$ats->seoaal_margin_settings( 'footer-top-margin' );
echo '
}';
echo '.footer-top-wrap .widget{';
	$ats->seoaal_typo_generate( 'footer-top-typography' );
echo '
}';
echo '.footer-top-wrap a{';
	$ats->seoaal_link_color( 'footer-top-link-color', 'regular' );
echo '
}';
echo '.footer-top-wrap a:hover{';
	$ats->seoaal_link_color( 'footer-top-link-color', 'hover' );
echo '
}';
echo '.footer-top-wrap a:hover{';
	$ats->seoaal_link_color( 'footer-top-link-color', 'active' );
echo '
}';
echo '.footer-top-wrap .widget .widget-title {
	color: '. esc_attr( $ats->seoaal_theme_opt( 'footer-top-title-color' ) ) .';
}';
echo "\n/* Footer Middle Styles */\n";
$ats->seoaal_custom_font_check( 'footer-middle-typography' );
echo '.footer-middle-wrap{';
	$ats->seoaal_typo_generate( 'footer-middle-typography' );
	$ats->seoaal_bg_rgba( 'footer-middle-background' );
	$ats->seoaal_border_settings( 'footer-middle-border' );
	$ats->seoaal_padding_settings( 'footer-middle-padding' );
	$ats->seoaal_margin_settings( 'footer-middle-margin' );
echo '
}';
echo '.footer-middle-wrap .widget{';
	$ats->seoaal_typo_generate( 'footer-middle-typography' );
echo '
}';
echo '.footer-middle-wrap a{';
	$ats->seoaal_link_color( 'footer-middle-link-color', 'regular' );
echo '
}';
echo '.footer-middle-wrap a:hover{';
	$ats->seoaal_link_color( 'footer-middle-link-color', 'hover' );
echo '
}';
echo '.footer-middle-wrap a:active{';
	$ats->seoaal_link_color( 'footer-middle-link-color', 'active' );
echo '
}';
echo '.footer-middle-wrap .widget .widget-title {
	color: '. esc_attr( $ats->seoaal_theme_opt( 'footer-middle-title-color' ) ) .';
}';
echo "\n/* Footer Bottom Styles */\n";
$ats->seoaal_custom_font_check( 'footer-bottom-typography' );
echo '.footer-bottom{';
	$ats->seoaal_typo_generate( 'footer-bottom-typography' );
	$ats->seoaal_bg_rgba( 'footer-bottom-background' );
	$ats->seoaal_border_settings( 'footer-bottom-border' );
	$ats->seoaal_padding_settings( 'footer-bottom-padding' );
	$ats->seoaal_margin_settings( 'footer-bottom-margin' );
echo '
}';
echo '.footer-bottom .widget{';
	$ats->seoaal_typo_generate( 'footer-bottom-typography' );
echo '
}';
echo '.footer-bottom a{';
	$ats->seoaal_link_color( 'footer-bottom-link-color', 'regular' );
echo '
}';
echo '.footer-bottom a:hover{';
	$ats->seoaal_link_color( 'footer-bottom-link-color', 'hover' );
echo '
}';
echo '.footer-bottom a:active{';
	$ats->seoaal_link_color( 'footer-bottom-link-color', 'active' );
echo '
}';
echo '.footer-bottom-wrap .widget .widget-title {
	color: '. esc_attr( $ats->seoaal_theme_opt( 'footer-bottom-title-color' ) ) .';
}';
echo "\n/* Theme Extra Styles */\n";
//Here your code
$theme_link_color = $ats->seoaal_get_link_color( 'theme-link-color', 'regular' );
$theme_link_hover = $ats->seoaal_get_link_color( 'theme-link-color', 'hover' );
$theme_link_active = $ats->seoaal_get_link_color( 'theme-link-color', 'active' );
$rgb = $ats->seoaal_hex2rgba( $theme_color, 'none' );
$secondary_rgb = $ats->seoaal_hex2rgba( $secondary_color, 'none' );
/*
 * Theme Color -> $theme_color
 * Secondary Color -> $secondary_color
 * Theme RGBA -> $rgb example -> echo 'body{ background: rgba('. esc_attr( $rgb ) .', 0.5); }';
 * Theme Secondary RGBA -> $rgb example -> echo 'body{ background: rgba('. esc_attr( $secondary_rgb ) .', 0.5); }';
 * Link Colors -> $theme_link_color, $theme_link_hover, $theme_link_active
 */
echo '.theme-color {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.theme-color-bg {
	background: '. esc_attr( $theme_color ) .';
}';

echo '.default-color {
	color: '. esc_attr( $theme_color ) .' !important;
}';

echo '.float-video-wrap .float-video-left-part:after {
	background: rgba('. esc_attr( $secondary_rgb ) .', 0.5);
}';
echo '.float-video-right-part.video-content {
	background: '. esc_attr( $theme_color ) .';
}';






echo "\n/*----------- General Style----------- */\n";
echo '::selection {
	background : '. esc_attr( $theme_color ) .';
}';
echo '.breadcrumb span.current {
	color : '. esc_attr( $secondary_color ) .';
}';
echo '.secondary-space-toggle > span {
	background : '. esc_attr( $theme_color ) .';
}';
echo '.top-sliding-toggle.fa-minus {
	border-top-color : '. esc_attr( $theme_color ) .';
}';
echo '.owl-dot.active span {
	background : '. esc_attr( $theme_color ) .';
	border-color : '. esc_attr( $theme_color ) .';
}';

echo '.owl-prev, .owl-next, .blog-template .owl-carousel .owl-nav .owl-prev, .blog-template .owl-carousel .owl-nav .owl-next, .related-slider-wrapper .owl-carousel .owl-nav .owl-prev, .related-slider-wrapper .owl-carousel .owl-nav .owl-next, .portfolio-related-slider .owl-carousel .owl-nav .owl-prev, .portfolio-related-slider .owl-carousel .owl-nav .owl-next {
	border-color : '. esc_attr( $theme_color ) .';
}';

echo '.owl-prev:hover, .owl-next:hover, .blog-template .owl-carousel .owl-nav .owl-prev:hover, .blog-template .owl-carousel .owl-nav .owl-next:hover, .related-slider-wrapper .owl-carousel .owl-nav .owl-prev:hover, .related-slider-wrapper .owl-carousel .owl-nav .owl-next:hover, .portfolio-related-slider .owl-carousel .owl-nav .owl-prev:hover, .portfolio-related-slider .owl-carousel .owl-nav .owl-next:hover {
	background-color : '. esc_attr( $theme_color ) .';
}';
echo '.owl-prev, .owl-next, .blog-template .owl-carousel .owl-nav .owl-prev, .blog-template .owl-carousel .owl-nav .owl-next, .related-slider-wrapper .owl-carousel .owl-nav .owl-prev, .related-slider-wrapper .owl-carousel .owl-nav .owl-next, .portfolio-related-slider .owl-carousel .owl-nav .owl-prev, .portfolio-related-slider .owl-carousel .owl-nav .owl-next, .owl-carousel .owl-nav .owl-prev:before, .owl-carousel .owl-nav .owl-next:before {
	color : '. esc_attr( $secondary_color ) .';
}';
echo '.mobile-bar {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';

echo "\n/*----------- Header Logobar ----------- */\n";
echo '.header-inner .logobar-inner .media i {
	color : '. esc_attr( $theme_color ) .';
}';
echo 'div.cus-phone {
	background : '. esc_attr( $secondary_color ) .';
}';
echo '.header-inner .navbar .custom-container a.btn.seoaal-btn {
	background : '. esc_attr( $secondary_color ) .';
}';
echo '.header-inner .navbar .custom-container a.btn.seoaal-btn:hover {
	background : '. esc_attr( $theme_color ) .';
	color : '. esc_attr( $secondary_color ) .';
}';


echo "\n/*----------- Menu----------- */\n";
echo "\n/*----------- Search Style----------- */\n";
echo '.search-form .input-group .btn {
	background: '. esc_attr( $secondary_color ) .';
}';
echo 'input[type="submit"] {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo 'input[type="submit"]:hover, .search-form .input-group .btn:hover {
	background: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Button Style----------- */\n";
echo '.btn, button , .btn.bordered:hover {
	background: '. esc_attr( $secondary_color ) .';
}';
echo '.btn.classic:hover,
.post-comments-wrapper p.form-submit input:hover {
	background: '. esc_attr( $theme_color ) .';
}';
echo '.btn-default:hover, .seoaal-btn.btn-default.theme-color-bg:hover {
	box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-webkit-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-moz-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
}';
echo 'input[type="submit"]:hover, .btn:hover, button:hover {
	background: '. esc_attr( $theme_color ) .';
}';
echo '.seoaal-btn.btn-default.theme-color-bg {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.post-comments span.author {
	color: '. esc_attr( $theme_color ) .';
}';

echo '.post-comments-wrapper p.form-submit input:hover,
input[type="submit"]:hover {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.btn.link {
	color: '. esc_attr( $theme_color ) .';
}';

echo '.btn.bordered {
	border-color: '. esc_attr( $theme_color ) .';
	color: '. esc_attr( $theme_color ) .';
}';
echo '.site-footer .cta-btn a.btn:hover {
	border-color: '. esc_attr( $secondary_color ) .';
	background-color: '. esc_attr( $secondary_color ) .';
}';
echo '.rev_slider_wrapper .btn.btn-outline:hover {
	background-color: '. esc_attr( $theme_color ) .';
	border-color: '. esc_attr( $theme_color ) .';
}';

echo "\n/* -----------Pagination Style----------- */\n";
echo '.nav.pagination > li.nav-item a,
.page-links .page-number,.post-comments .page-numbers,
.page-links .post-page-numbers {
	background-color: '. esc_attr( $secondary_color ) .';
}';

echo '.nav.pagination > li.nav-item a:hover,
.nav.pagination > li.nav-item.active a, 
.nav.pagination > li.nav-item.active span,
.page-links > .page-number,
.page-links .page-number:hover,
.post-comments .page-numbers.current,
.page-links span.current .page-number,
.post-comments .page-numbers:hover,
.page-links .post-page-numbers.current,
.page-links .post-page-numbers:hover {
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Select Style ----------- */\n";
echo 'select:focus {
	border-color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Header Styles---------------- */\n";
echo '.close:before, .close:after { 
	background: '. esc_attr( $theme_color ) .';
}';

echo '.header-phone span, .header-email span, .header-address span,.full-overlay .widget_nav_menu .zmm-dropdown-toggle { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.nav-link:focus, .nav-link:hover { 
	color: '. esc_attr( $theme_color ) .';
}';
echo 'ul li.theme-color a {
	color: '. esc_attr( $theme_color ) .' !important;
}';
echo "\n/*----------- Post Style----------- */\n";
echo '.top-meta ul li a:hover, 
.bottom-meta ul li a:hover { 
	color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Post Navigation ---------*/\n";
echo '.post-navigation .nav-links .nav-next a, .post-navigation .nav-links .nav-previous a {
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.post-navigation .nav-links .nav-next a:hover, .post-navigation .nav-links .nav-previous a:hover {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.custom-post-nav > .prev-nav-link > .post-nav-text, .custom-post-nav > .next-nav-link > .post-nav-text {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.post-navigation .custom-post-nav > div > a {
	color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*----------- Calender---------------- */\n";
echo '.calendar_wrap th ,tfoot td { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.widget_calendar caption {
	border-color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Archive---------------- */\n";
echo '.widget_archive li:before { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.comments-wrap > * i { 
	color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Instagram widget---------------- */\n";
echo '.null-instagram-feed p a { 
	background: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Service Menu---------------- */\n";
echo '.widget .menu-item-object-seoaal-service a:hover,
.widget_categories ul li a:before,
.widget-area .widget_categories > ul > li.current-cat a,span.menu-icon { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.widget-area .widget .menu-service-menu-container ul>li>a:hover,
.widget-area .widget .menu-service-menu-container ul>li>a { 
	color: '. esc_attr( $secondary_color ) .';
}';

echo '.services-wrapper.services-2 .invisible-number { 
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.services-wrapper.services-2 .services-inner:hover,
.services-wrapper.services-2 .services-inner .services-read-more { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.services-wrapper.services-2 .services-inner:hover .services-read-more { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.widget-area .widget .menu-service-menu-container ul > li > a:hover,
 .widget-area .widget .menu-service-menu-container ul > li.current-menu-item > a { 
	background: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Post Nav---------------- */\n";
echo '.zozo_advance_tab_post_widget .nav-tabs .nav-item.show .nav-link, .widget .nav-tabs .nav-link.active { 
	background: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Back to top---------------- */\n";
echo "\n/*----------- Shortcodes---------------- */\n";
echo '.entry-title a:hover,.search-template article .entry-title a:hover { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.title-separator.separator-border { 
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.title-separator.separator-border:after,
.title-separator.separator-border:before { 
	background-color: '. esc_attr( $secondary_color ) .';
}';

echo "\n/*----------- Twitter---------------- */\n";
echo '.twitter-3 .tweet-info { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.twitter-wrapper.twitter-dark a { 
	color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*----------- Pricing table---------------- */\n";
echo '.price-text,
.pricing-style-1 ul.pricing-features-list > li:before { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.pricing-table-wrapper.pricing-style-1 .pricing-inner-wrapper { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.pricing-table-wrapper.pricing-style-1 .pricing-title { 
	border-color: '. esc_attr( $secondary_color ) .';
}';
echo '.pricing-table-wrapper.pricing-style-1 .btn { 
	background: '. esc_attr( $secondary_color ) .';
}';
echo '.pricing-style-3 .pricing-inner-wrapper,.pricing-table-wrapper .btn:hover { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.pricing-style-2 .pricing-inner-wrapper { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------Call To Action ---------------- */\n";
echo '.theme-gradient-bg {
	background: -webkit-linear-gradient(-150deg, '. esc_attr( $secondary_color ) .' 35%, '. esc_attr( $theme_color ) .' 65%) !important;
	background: linear-gradient(-150deg, '. esc_attr( $secondary_color ) .' 35%, '. esc_attr( $theme_color ) .' 65%) !important;
}';

echo "\n/*-----------Compare Pricing table---------------- */\n";
echo '.compare-pricing-wrapper .pricing-table-head, .compare-features-wrap { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.compare-pricing-style-3.compare-pricing-wrapper .btn:hover { 
	background: '. esc_attr( $theme_color ) .';
}';
echo "\n/*-----------Counter Style---------------- */\n";
echo '.counter-wrapper.counter-style-1 .counter-suffix {
	color: '. esc_attr( $secondary_color ) .';
}';
echo "\n/*-----------Testimonials---------------- */\n";
echo '.testimonial-wrapper.testimonial-1 .testimonial-excerpt { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.testimonial-wrapper.testimonial-1 .testimonial-excerpt:after { 
	border-color: '. esc_attr( $theme_color ) .' transparent transparent;
}';
echo '.seoaal-content .testimonial-2 .testimonial-inner:hover, .seoaal-content .testimonial-2 .testimonial-inner:hover .testimonial-thumb img {
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.testimonial-2 .testimonial-inner::after {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.testimonial-2 .testimonial-inner:before {
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/quotation-sign-lt.png' ) .'); 
}';

echo '.testimonial-wrapper.testimonial-1 .testimonial-inner:before, .testimonial-wrapper.testimonial-1 .testimonial-inner:after  {
	 background: rgba('. esc_attr( $rgb ) .', 0.4);
}';
echo '.testimonial-wrapper.testimonial-1 .testimonial-inner .testimonial-info-wrap:after {
	 color: rgba('. esc_attr( $rgb ) .', 0.1);
}';

echo '.testimonial-wrapper.testimonial-3 .testimonial-inner:before {
	 color:  rgba('. esc_attr( $secondary_rgb ) .', 0.05);
}';

echo '.testimonial-wrapper.testimonial-3 .testimonial-inner .testimonial-thumb::before {
	 color: '. esc_attr( $secondary_color ) .';
}';

echo '.testimonial-wrapper.testimonial-3 .testimonial-info .client-name {
	 color: '. esc_attr( $theme_color ) .';
}';

echo '.single .testimonial > .testimonial-content-wrap::before {
	 color: '. esc_attr( $secondary_color ) .';
}';

echo '.single .testimonial-info .testimonial-title > * {
	 color: '. esc_attr( $theme_color ) .';
}';

echo '.single .testimonial > .testimonial-content-wrap .testimonial-content::after,
.single .testimonial > .testimonial-content-wrap .testimonial-content::before {
	 background-color: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------schedule-list---------------- */\n";
echo '.schedule-time { 
	color: '. esc_attr( $theme_color ) .';
}';

echo '.schedule-box-wrapper.schedule-box-style-2 {
	 border-color:  rgba('. esc_attr( $secondary_rgb ) .', 0.05);
}';


echo "\n/*-----------Events---------------- */\n";
echo '.events-date { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.single-seoaal-event .event-inner .event-info > p > span.event-subtitle:before, 
.single-seoaal-event .event-inner .event-venue > p > span.event-subtitle:before,.single-seoaal-event .event-title-date-time { 
	background-color: '. esc_attr( $theme_color ) .';
}';

echo 'span.event-time:before,
.events-title .entry-title:hover,.events-wrapper .post-more > a,
.single-seoaal-event blockquote,.single-seoaal-event .event-inner .event-info h4 ,.single-seoaal-event .event-inner .event-venue h4 { 
	color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*-----------Team---------------- */\n";
echo '.team-wrapper.team-3 .team-inner > .team-thumb,.team-2 .team-overlay { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.typo-white .client-name, .team-wrapper.team-1 .team-social-wrap ul.social-icons > li > a { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.team-wrapper.team-1 .team-inner .overlay-bg {
	background: rgba('. esc_attr( $secondary_rgb ) .', 0.92);
}';
echo '.team-1 .team-thumb:before { 
	background: '. esc_attr( $secondary_color ) .';
}';
echo '.team-wrapper.team-1 .team-thumb::after { 
	border-color: transparent '. esc_attr( $secondary_color ) .' transparent transparent;
}';
echo '.single-seoaal-team .team-title { 
	border-color: '. esc_attr( $secondary_color ) .';
}';
echo '.team-wrapper.team-2 .team-inner .team-name-designation::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/team-icon.png' ) .'); 
}';
echo '.team-wrapper.team-2 .team-inner .team-name-designation .client-name { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.single-seoaal-team .team-title > * { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.single-seoaal-team .team-img:after { 
	background: '. esc_attr( $theme_color ) .';
}';
echo "\n/*-----------Timeline---------------- */\n";
echo '.timeline-style-2 .timeline > li > .timeline-panel { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.timeline-style-2 .timeline > li > .timeline-panel:before { 
	border-left-color: '. esc_attr( $theme_color ) .';
	border-right-color: '. esc_attr( $theme_color ) .';
}';
echo '.timeline-style-2 .timeline > li > .timeline-panel:after { 
	border-left-color: '. esc_attr( $theme_color ) .';
	border-right-color: '. esc_attr( $theme_color ) .';
}';

echo '.timeline-style-3 .timeline:before { 
	border-color: '. esc_attr( $theme_color ) .';
}';



echo '.timeline-style-3 .timeline > li > .timeline-sep-title { 
	background: -webkit-linear-gradient(56deg, '. esc_attr( $secondary_color ) .' 35%, '. esc_attr( $theme_color ) .' 65%);
	background: linear-gradient(56deg, '. esc_attr( $secondary_color ) .' 35%, '. esc_attr( $theme_color ) .' 65%);
}';
echo '.cd-horizontal-timeline .filling-line { 
	background: '. esc_attr( $theme_color ) .';
}';


echo '.cd-horizontal-timeline .events-content em { 
	color: '. esc_attr( $theme_color ) .';
}';


echo '.cd-timeline-navigation a { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.cd-timeline-navigation a:hover { 
	background: '. esc_attr( $theme_color ) .';
}';

echo "\n/*-----------POPUP---------------- */\n";
echo '.modal-popup-wrapper .icon-wrap:after,
 .anim .video-play-icon:after,
.modal-popup-wrapper .icon-wrap:before,
 .anim .video-play-icon:before,
.modal-popup-wrapper .icon-wrap,
 .anim .video-play-icon{
	background-color: '. esc_attr( $theme_color ) .';
}';

echo 'span.background-title{
	-webkit-text-stroke-color: '. esc_attr( $theme_color ) .';
}';



echo "\n/*-----------Portfolio---------------- */\n";
echo '.portfolio-masonry-layout .portfolio-angle .portfolio-title h4:after,
.portfolio-icons p a,
.portfolio-content-wrap .portfolio-categories > span{
	background-color: '. esc_attr( $theme_color ) .';
}';

echo '.portfolio-model-4 .portfolio-info .portfolio-meta .portfolio-meta-list > li > .entry-url {
	background-color: '. esc_attr( $secondary_color ) .';
}';

echo '.portfolio-model-4 .portfolio-info .portfolio-meta h6:before,
.portfolio-meta-list .entry-url.btn {
	color: '. esc_attr( $theme_color ) .';
}';

echo '.portfolio-single .custom-post-nav span.abs-title-icon {
	background-color: '. esc_attr( $theme_color ) .';
}';

echo '.service-info-wrap .custom-post-nav a, 
.single-seoaal-portfolio .custom-post-nav a, 
.single-seoaal-team .custom-post-nav a,
.single-seoaal-testimonial .custom-post-nav a, 
.single-seoaal-event .custom-post-nav a {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';

echo '.service-info-wrap .custom-post-nav a:hover, 
.single-seoaal-portfolio .custom-post-nav a:hover, 
.single-seoaal-team .custom-post-nav a:hover, 
.single-seoaal-testimonial .custom-post-nav a:hover,
.single-seoaal-event .custom-post-nav a:hover {
	box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-webkit-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-moz-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
}';

echo '.portfolio-info .custom-post-nav .prev-nav-link > a,
 .portfolio-info .custom-post-nav .next-nav-link > a {
	background-color: '. esc_attr( $secondary_color ) .';
}';
 
echo '.portfolio-model-1 .portfolio-info ul.portfolio-meta-list > li::before,
.portfolio-classic .portfolio-wrap .portfolio-overlay-wrap:after {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';

/*CPT Filter Styles*/
echo '.portfolio-filter.filter-1 ul > li.active > a {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-masonry-layout .portfolio-classic .portfolio-content-wrap {
	background: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-filter.filter-2 .active a.portfolio-filter-item {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-filter.filter-2 li a:after {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-slide .portfolio-content-wrap {
	background: '. esc_attr( $theme_color ) .';
}'; 
echo '.portfolio-minimal .portfolio-overlay-wrap:before,
.portfolio-minimal .portfolio-overlay-wrap:after { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-classic .portfolio-title a:before { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-classic .portfolio-wrap:hover .portfolio-content-wrap { 
	background: '. esc_attr( $secondary_color ) .';
}';
echo '.portfolio-classic .portfolio-overlay-wrap:before {
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-archive-title a:hover {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.portfolio-model-4 .portfolio-info .portfolio-meta {
	border-color: '. esc_attr( $secondary_color ) .';
}';
echo '.portfolio-angle .portfolio-wrap .portfolio-overlay { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';



echo "\n/*-----------Feature Box---------------- */\n";
echo '.feature-box-wrapper.feature-box-style-1 .feature-box-thumb::before,
.feature-box-wrapper.custom-exp.feature-box-style-1 .invisible-number,
.feature-box-wrapper.custom-exp.feature-box-style-1 .invisible-number::before, 
.feature-box-wrapper.custom-exp.feature-box-style-1 .invisible-number::after,
.feature-box-style-2.feature-list-1 .feature-box-thumb { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%) !important;
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%) !important;
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%) !important;
}';
echo '.feature-box-wrapper.feature-box-style-1.feature-list-1 { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.feature-box-wrapper.feature-box-style-1.feature-list-1 .feature-box-btn a {
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.feature-box-wrapper.feature-box-style-1.feature-list-1::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/theme-light.jpg' ) .');
}';
echo '.feature-box-wrapper.custom-exp.feature-box-style-1 .invisible-number { 
	border-color: rgba('. esc_attr( $secondary_rgb ) .', 0.7);
}';
echo 'span.feature-box-ribbon,.feature-box-style-3 h6.invisible-number { 
	background: '. esc_attr( $secondary_color ) .';
}';
echo '.feature-box-wrapper.border-hover-color:hover {
    border-bottom-color: '. esc_attr( $theme_color ) .' !important;
}';
echo '.feature-box-wrapper.feature-box-style-1:hover .section-title > a {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.feature-list-2:hover {
	background-color: '. esc_attr( $secondary_color ) .';
}';
if( $secondary_color ){
	echo '.feature-box-wrapper:hover .feature-box-icon.theme-hcolor-bg1 {
		background: -webkit-linear-gradient(-150deg, '. esc_attr( $secondary_color ) .' 35%, '. esc_attr( $theme_color ) .' 65%);
		background: linear-gradient(-150deg, '. esc_attr( $secondary_color ) .' 35%, '. esc_attr( $theme_color ) .' 65%);
	}';
}else{
	echo '.feature-box-wrapper:hover .feature-box-icon.theme-hcolor-bg {
		background-color: '. esc_attr( $theme_color ) .';
	}';
}
echo '.feature-box-style-3 { 
	box-shadow: 0px 16px 32px rgba('. esc_attr( $rgb ) .', 0.08);
	-webkit-box-shadow: 0px 16px 32px rgba('. esc_attr( $rgb ) .', 0.08);
	-moz-box-shadow: 0px 16px 32px rgba('. esc_attr( $rgb ) .', 0.08);
}';
echo '.feature-box-style-3:hover { 
	box-shadow: 0px 16px 32px rgba('. esc_attr( $rgb ) .', 0.2);
	-webkit-box-shadow: 0px 16px 32px rgba('. esc_attr( $rgb ) .', 0.2);
	-moz-box-shadow: 0px 16px 32px rgba('. esc_attr( $rgb ) .', 0.2);
}';
echo '.feature-box-style-3:hover .feature-box-thumb::before { 
	background: '. esc_attr( $theme_color ) .' !important;
}';
echo '.feature-box-style-3 .feature-box-btn a.btn.link:hover::after { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.feature-box-wrapper.feature-box-style-3 .feature-box-thumb::before,
.feature-box-style-3 .feature-box-btn a.btn.link::after {
	background: rgba('. esc_attr( $rgb ) .', 0.05);
}';

echo "\n/*-----------Flipbox---------------- */\n";
echo "[class^='imghvr-shutter-out-']:before, [class*=' imghvr-shutter-out-']:before,
[class^='imghvr-shutter-in-']:after, [class^='imghvr-shutter-in-']:before, [class*=' imghvr-shutter-in-']:after, [class*=' imghvr-shutter-in-']:before,
[class^='imghvr-reveal-']:before, [class*=' imghvr-reveal-']:before {
	background-color: ". esc_attr( $theme_color ) .";
}";
echo "\n/*-----------Progress Bar---------------- */\n";
echo '.vc_progress_bar .vc_single_bar .vc_bar { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.seoaal-content .vc_progress_bar.vc-progress-bar-default .vc_single_bar .vc_label_units { 
	background: '. esc_attr( $secondary_color ) .';
}';

echo "\n/*-----------Tabs---------------- */\n";
echo '.vc_toggle_round .vc_toggle_icon { 
	background: '. esc_attr( $theme_color ) .';
}';



echo "\n/*-----------Services---------------- */\n";
echo '.services-3 .services-inner > .services-thumb { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.services-read-more .read-more,
.site-footer .widget .menu-item-object-seoaal-service.current-menu-item a {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.services-wrapper.services-dark .services-title .entry-title:hover,
.services-wrapper.services-dark .services-read-more .read-more:hover {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.custom-post-nav > div > a,
.services-wrapper .services-inner:hover .services-title a {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.services-wrapper.services-1 .abs-title-icon,
.seoaal-pagination-carousel .service-icon-wrap {
    color: '. esc_attr( $theme_color ) .';
}';
echo '.services-wrapper.services-1 .services-read-more .read-more,
.services-wrapper.services-1 .services-inner:hover .services-title {
    background: '. esc_attr( $secondary_color ) .';
}';
echo '.custom-service-slider .services-wrapper.services-1 .services-inner .service-overlay-wrap.seoaal-overlay-wrap { 
	background: rgba('. esc_attr( $rgb ) .', 0.75);
}';
echo '.custom-service-slider .services-wrapper .services-inner > div.services-title { 
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.custom-service-slider .services-wrapper.services-1 .services-inner .services-title a, 
ul.social-icons.social-h-white>li a:hover { 
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.widget ul li.menu-item a:before,
.widget .menu-service-menu-container ul li.menu-item a:before { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.widget .menu-service-menu-container ul li.menu-item a:hover:before,
.widget .menu-service-menu-container ul li.menu-item.current-menu-item a:before { 
	color: '. esc_attr( $secondary_color ) .';
}';
echo "\n/*-----------Blog---------------- */\n";

echo '.post-navigation-wrapper .nav-links.custom-post-nav > div:hover:after { 
	background: rgba('. esc_attr( $secondary_rgb ) .', 0.7);
}';
echo '.grid-layout .bottom-meta .post-meta ul li .post-date a, 
.grid-layout .bottom-meta .post-meta ul li .post-comment a, 
.grid-layout .bottom-meta .post-meta.pull-left ul li::before {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.grid-layout .bottom-meta .post-meta .post-more .read-more::before { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo 'blockquote::before { 
	color: '. esc_attr( $theme_color ) .';
}';
echo 'blockquote, .wp-block-quote.is-large { 
	background: rgba('. esc_attr( $rgb ) .', 0.1);
}';
echo '.single-post .top-meta .post-meta>ul>li.nav-item a { 
	border-bottom-color: '. esc_attr( $secondary_color ) .';
}';

echo '.blog-template .entry-title a { 
	color: '. esc_attr( $secondary_color ) .';
}';

echo '.post-navigation-wrapper .nav-links.custom-post-nav>div a { 
	color:  '. esc_attr( $theme_color ) .';
}';
echo '.post-navigation-wrapper .nav-links.custom-post-nav>div a .post-nav-link-sub { 
	color:  '. esc_attr( $secondary_color ) .';
}';
echo '.post-navigation .custom-post-nav > div > a i:hover { 
	background-color:  '. esc_attr( $theme_color ) .';
}';
echo '.post-navigation .custom-post-nav > div > a i { 
	background-color:  '. esc_attr( $secondary_color ) .';
}';

echo '.blog-wrapper.blog-style-3 .post-more a.read-more:after { 
	background:  '. esc_attr( $secondary_color ) .';
}';
echo '.blog-wrapper.blog-style-3 .post-more a.read-more:hover:after { 
	background:  '. esc_attr( $theme_color ) .';
}';
echo '.post-navigation-wrapper .nav-links.custom-post-nav > div:hover:after { 
	background: rgba('. esc_attr( $rgb ) .', 1);
}';
echo '.post-navigation-wrapper .nav-links.custom-post-nav > div:after { 
	background: '. esc_attr( $secondary_color ) .';
}';
echo '.blog-wrapper .post-more a.read-more:hover,
.blog-wrapper.cus-blog-classic.blog-style-1 .top-meta ul li a,
.blog-wrapper.cus-blog-classic.blog-style-1 .top-meta ul li:after { 
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.blog-wrapper.cus-blog-classic.blog-style-1 .top-meta ul li a,
.blog-wrapper.cus-blog-classic.blog-style-1 .top-meta ul li:after { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.blog-wrapper.cus-blog-classic.blog-style-1 .top-meta ul li a:hover,
.blog-wrapper.cus-blog-classic.blog-style-1 .top-meta ul li:hover:after,
.blog-wrapper.cus-blog-classic.blog-style-1 .top-meta ul > li:hover i { 
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.blog-wrapper.blog-style-1 .blog-inner .bottom-meta ul li .post-more a::after {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.single-post-template .top-meta .post-meta ul li a:hover, 
.single-post-template .top-meta .post-meta ul li:hover,
.single-post-template .top-meta ul > li:hover i { 
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.single-post-template .top-meta .post-meta ul li a, 
.single-post-template .top-meta .post-meta ul li { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.blog-wrapper .bottom-meta .post-more a.read-more,.post-meta ul li.nav-item a.read-more,
.blog-classic-wrapper a.read-more,
.blog-wrapper .post-more a.read-more { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.blog-wrapper.cus-blog-classic .bottom-meta .post-more a.read-more { 
	background-color: '. esc_attr( $secondary_color ) .';
}';
echo '.blog-wrapper.cus-blog-classic .bottom-meta .post-more a.read-more:hover { 
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.blog-wrapper.cus-blog-classic .bottom-meta .post-more a.read-more:hover { 
	color: '. esc_attr( $secondary_color ) .' !important;
}';
echo '.blog-wrapper .bottom-meta .post-more a.read-more:hover, .post-meta ul li.nav-item a.read-more:hover, .blog-classic-wrapper a.read-more:hover, .blog-wrapper .post-more a.read-more:hover { 
	color: '. esc_attr( $secondary_color ) .';
}';

echo '.blog-wrapper.blog-style-1 .blog-inner:hover a.post-title { 
	color: '. esc_attr( $secondary_color ) .';
}';	
echo '.blog-wrapper.blog-style-1 .post-author > a:hover,
article.post .article-inner:hover .entry-title a,
.widget_recent_entries span.post-date { 
	color: '. esc_attr( $theme_color ) .';
}';	
echo '.blog-wrapper.blog-style-1 .blog-inner a.post-title:hover { 
	color: '. esc_attr( $theme_color ) .';
}';	
echo '.blog-style-2 .blog-inner:hover {
	border-bottom-color: '. esc_attr( $theme_color ) .';
}';	
echo '.blog-style-2 .author-name { 
	color: '. esc_attr( $theme_color ) .';
}';	
echo '.blog-style-3 .post-thumb { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.blog-wrapper.blog-style-3 .bottom-meta ul > li a:hover { 
	color: '. esc_attr( $theme_color ) .';
}';

echo '.blog-inner .invisible-number { 
	color: '. esc_attr( $secondary_color ) .';
}';



echo '.blog-wrapper.blog-style-1 .blog-inner > .post-thumb::after {
    border-right-color: '. esc_attr( $theme_color ) .';
    border-left-color: '. esc_attr( $theme_color ) .';
}';
echo '.sticky-date .post-date { 
	background-color: '. esc_attr( $secondary_color ) .';
}';	
echo '.post-meta > ul > li.nav-item .post-tags a:hover { 
	background-color: '. esc_attr( $theme_color ) .';
}';	
echo '.blog-style-1 .blog-inner:hover .post-thumb-overlay { 
	background-color: rgba('. esc_attr( $secondary_rgb ) .', 0.8); 
	
}';	
echo '.blog-list-layout .blog-inner:hover .entry-title .post-title,
.blog-classic-wrapper a.read-more { 
	color: '. esc_attr( $theme_color ) .';	
}';
echo '.blog-classic-wrapper .blog-list  { 
	border-color: '. esc_attr( $theme_color ) .';	
}';
echo '.grid-layout .post-meta>ul>li.nav-item .post-category a:after { 
	border-color: '. esc_attr( $secondary_color ) .' transparent transparent;	
}';

echo '.grid-layout .post-meta>ul>li.nav-item .post-category a { 
	background: '. esc_attr( $secondary_color ) .';	
}';

echo "\n/*-----------Blog Center---------------- */\n";

echo "\n/*-----------Tour---------------- */\n";
echo '.vc_tta-style-modern .vc_tta-tab.vc_active a{ 
	background-color: '. esc_attr( $theme_color ) .' !important;
}';

echo '.vc_tta-style-modern .vc_tta-tab a { 
	background-color: '. esc_attr( $secondary_color ) .' !important;
}';
echo '.schedule-tab li.vc_tta-tab.vc_active:before { 
	border-color: '. esc_attr( $theme_color ) .' transparent transparent transparent;
}';



echo "\n/*-----------Tabs---------------- */\n";
echo '.vc_tta.vc_tta-tabs.vc_general.vc_tta-style-classic .vc_active > a {
    border-top-color: '. esc_attr( $theme_color ) .' !important;
}';
echo '.vc_tta-tabs.vc_tta-style-classic ul.vc_tta-tabs-list {
    border-color: '. esc_attr( $theme_color ) .';
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.vc_tta.vc_tta-tabs.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title>a {
	background-color: '. esc_attr( $theme_color ) .' !important;
}';
echo '.vc_tta.vc_tta-tabs.vc_general.vc_tta-style-classic .vc_active > a {
    color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*-----------Accordin---------------- */\n";
echo '.vc_tta.vc_tta-accordion.vc_tta-style-flat .vc_active .vc_tta-controls-icon-position-left.vc_tta-panel-title > a > i,
.wpb-js-composer .vc_tta-accordion.vc_tta-style-flat .vc_active .vc_tta-controls-icon.vc_tta-controls-icon-plus::before,
.wpb-js-composer .vc_tta-accordion.vc_tta-style-flat .vc_tta-controls-icon.vc_tta-controls-icon-plus::before  {
	color: '. esc_attr( $theme_color ) .' !important;
}';
echo "\n/*-----------Contact Info---------------- */\n";
echo '.contact-info-wrapper.contact-info-style-2 .contact-mail a:hover { 
	color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*-----------Mailchimp---------------- */\n";

echo "\n/*-----------Contact form 7---------------- */\n";
echo '.wpcf7 input[type="submit"], .contact-form-default .wpcf7 input[type="submit"]:hover { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.wpcf7 input[type="submit"]:hover { 
	box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-webkit-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-moz-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
}';
echo '.custom-header-form .wpcf7 textarea:focus, .custom-header-form .wpcf7 input:focus, .custom-header-form .wpcf7 select:focus {
	border: 1px solid '. esc_attr( $theme_color ) .';
}';
echo '.contact-form-wrapper.contact-form-classic::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/launch.png' ) .'); 
}';
echo '.contact-form-wrapper.contact-form-classic::after {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/pie-chart.png' ) .'); 
}';

echo "\n/*-----------Shape Arrow---------------- */\n";
echo '.shape-arrow .wpb_column:nth-child(2) .feature-box-wrapper, 
.shape-arrow .wpb_column:last-child .feature-box-wrapper { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.shape-arrow .wpb_column:first-child .feature-box-wrapper::before,
.shape-arrow .wpb_column:nth-child(3) .feature-box-wrapper::before { 
	border-top-color: '. esc_attr( $theme_color ) .';
	border-bottom-color: '. esc_attr( $theme_color ) .';
}';
echo '.shape-arrow .wpb_column .feature-box-wrapper::before,
.shape-arrow .wpb_column .feature-box-wrapper::after,
.shape-arrow .wpb_column:nth-child(2) .feature-box-wrapper::before,
.shape-arrow .wpb_column:nth-child(2) .feature-box-wrapper::after,
.shape-arrow .wpb_column:last-child .feature-box-wrapper::before, 
.shape-arrow .wpb_column:last-child .feature-box-wrapper::after { 
	border-left-color: '. esc_attr( $theme_color ) .';
}';
echo "\n/*-----------Woocommerce---------------- */\n";

echo '.woocommerce ul.products li.product .price,
.woocommerce .product .price { 
	color: '. esc_attr( $secondary_color ) .';
}';

echo '.woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';

echo '.woocommerce .product .onsale,.cart-dropdown-menu .product-remove { 
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.woocommerce ul.products li.product .woocommerce-loop-product__title {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.woocommerce ul.products li.product .loop-product-wrap .add_to_cart_button { 
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.woocommerce.single .quantity input { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.woocommerce ul.products li.product .woocommerce-loop-product__title:hover,
.woocommerce ul.products li.product:hover .woocommerce-loop-product__title {
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.woocommerce .widget_price_filter .ui-slider .ui-slider-range { 
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.woocommerce #respond input#submit.alt:hover, 
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover { 
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-webkit-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-moz-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
}';

echo '.dropdown-menu.cart-dropdown-menu .mini-view-cart a { 
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.woocommerce #content input.button, .woocommerce #respond input#submit, 
.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, 
.woocommerce-page #content input.button, .woocommerce-page #respond input#submit, 
.woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button,
.woocommerce input.button.alt, .woocommerce input.button.disabled, .woocommerce input.button:disabled[disabled],
.cart_totals .wc-proceed-to-checkout a.checkout-button {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.woocommerce-info,
.woocommerce-message {
	border-top-color: '. esc_attr( $theme_color ) .';
}';
echo '.woocommerce-info::before,
.woocommerce-message::before {
	color: '. esc_attr( $theme_color ) .';
}';
echo '.form-control:focus {
	border-color: '. esc_attr( $theme_color ) .' !important;
}';

echo '.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a {
	background-color: '. esc_attr( $secondary_color ) .';
}';
echo '.woocommerce nav.woocommerce-pagination ul li a:hover, 
.woocommerce nav.woocommerce-pagination ul li a:active, 
.woocommerce nav.woocommerce-pagination ul li a:focus,
.woocommerce nav.woocommerce-pagination ul li span.page-numbers.current:hover
{
	background-color: '. esc_attr( $theme_color ) .';
}';

echo '.woocommerce .product .button:hover, 
.woocommerce.single .product .button:hover, 
.woocommerce button.button:hover,
.woocommerce #respond input#submit:hover, 
.woocommerce a.button:hover, 
.woocommerce button.button:hover, 
.woocommerce input.button:hover, 
.woocommerce #review_form #respond .form-submit input:hover,
.woocommerce ul.products li.product .woo-thumb-wrap .added_to_cart:hover,
.woocommerce-page .woocommerce-message .button:hover,
.woocommerce a.added_to_cart:hover {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-webkit-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-moz-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
}';

echo '.woocommerce nav.woocommerce-pagination ul li span,
.woocommerce nav.woocommerce-pagination ul li span.page-numbers.current,
.woocommerce a.added_to_cart,li.woocommerce-MyAccount-navigation-link.is-active a  {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo 'li.woocommerce-MyAccount-navigation-link a {
	background-color: '. esc_attr( $secondary_color ) .';
}';
echo '.woocommerce ul.products li.product .woo-thumb-wrap .added_to_cart {
	background: rgba('. esc_attr( $rgb ) .', 0.14);
}';
echo '.woocommerce nav.woocommerce-pagination ul li a {
	background: '. esc_attr( $secondary_color ) .';
}';

echo '.vc_row div.wps-slider-section .add_to_cart_button:hover {
	background-color: '. esc_attr( $theme_color ) .' !important;
}';
echo 'div#wps-slider-section #sp-woo-product-slider-5301 .wpsf-product-title a:hover,
.wps-slider-section span.woocommerce-Price-amount.amount {
	color: '. esc_attr( $theme_color ) .' !important;
}';

echo '.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, .woocommerce button.button.alt,
.woocommerce input.button.alt, .woocommerce .related.products h2:before {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
}';
echo '.woocommerce .star-rating span::before,
.woocommerce .star-rating::before {
	color: '. esc_attr( $secondary_color ) .';
}';
echo '.woocommerce .product .button:hover, 
.woocommerce.single .product .button:hover, 
.woocommerce button.button:hover, 
.woocommerce #review_form #respond .form-submit input:hover,
.woocommerce .quantity .btn:hover {
	background: -webkit-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: -moz-linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	background: linear-gradient(-215deg, '. esc_attr( $theme_color ) .' 4%, '. esc_attr( $secondary_color ) .' 96%);
	box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-webkit-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
	-moz-box-shadow: 0px 16px 24px 0px rgba('. esc_attr( $secondary_rgb ) .', 0.3);
}';
echo '.woocommerce div.product .woocommerce-tabs ul.tabs li {
	background-color: '. esc_attr( $theme_color ) .';
}';

echo '.woocommerce .widget.widget_product_categories li a:hover,
.woocommerce ul.product_list_widget li a:hover {
	color: '. esc_attr( $theme_color ) .';
}';

echo '.woo-top-meta select {     background-image: url('. esc_url( SEOAAL_ASSETS . '/images/icon-select.png' ) .'); }';

echo "\n/*-----------Widget---------------- */\n";
echo '.vc_row .widgettitle,.widget_meta li a:hover {
	color : '. esc_attr( $theme_color ) .';
}';

echo '.widget.widget_tag_cloud a.tag-cloud-link {
	background-color : '. esc_attr( $secondary_color ) .';
}';
echo '.widget.widget_tag_cloud a.tag-cloud-link:hover {
	background-color : '. esc_attr( $theme_color ) .';
}';
echo '.widget-area .widget:hover .widget-title:after {
	color : '. esc_attr( $secondary_color ) .';
}';
echo 'span.w-date:before,
span.w-cmt:before {
	color : '. esc_attr( $theme_color ) .';
}';
echo '.widget-area .widget .widget-title {
	border-bottom-color: '. esc_attr( $secondary_color ) .';
}';
echo '.widget-area .widget-title:after {
	background-color : '. esc_attr( $secondary_color ) .';
}';
echo '.widget-area .widget.widget_nav_menu .menu-services-menu-container ul.menu li.current-menu-item a,
.widget-area .widget.widget_nav_menu .menu-services-menu-container li a:hover,
.widget-area .widget.widget_nav_menu .menu-services-menu-container li a:active,
.widget-area .widget.widget_nav_menu .menu-services-menu-container li a:focus {
	background: rgba('. esc_attr( $secondary_rgb ) .', 0.6);
}';
echo '.widget-area .widget.widget_nav_menu .menu-services-menu-container li a {
	background: rgba('. esc_attr( $rgb ) .', 0.6);
}';

echo "\n/*-----------Mailchimp Widget---------------- */\n";
echo '.zozo-mc.btn:hover {
	background-color: '. esc_attr( $secondary_color ) .';
}';
echo '.zozo-mc.btn {
	background-color: '. esc_attr( $theme_color ) .';
	color: '. esc_attr( $secondary_color ) .';
}';
echo "\n/*-----------Footer---------------- */\n";

echo '.current_page_item a { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.mptt-shortcode-wrapper ul.mptt-menu.mptt-navigation-tabs li.active a, .mptt-shortcode-wrapper ul.mptt-menu.mptt-navigation-tabs li:hover a { 
	border-color: '. esc_attr( $theme_color ) .';
}';
echo '.err-content .btn:hover {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo '.err-content .btn { 
	border-color: '. esc_attr( $theme_color ) .';
	color : '. esc_attr( $theme_color ) .';
}';
echo "\n/*-----------Social Widget---------------- */\n";

echo 'ul.social-icons.social-hbg-theme > li a:hover,
ul.social-icons.social-bg-light > li a:hover {
	background-color: '. esc_attr( $theme_color ) .';
	border-color: '. esc_attr( $theme_color ) .'; 
}';
echo 'footer ul.social-icons.social-bg-transparent>li > a {
	border: 2px solid '. esc_attr( $theme_color ) .'; 
}';
echo 'ul.social-icons.social-hbg-theme > li a {
	border-color: '. esc_attr( $theme_color ) .'; 
}';
echo 'ul.social-icons.social-bg-light > li a:hover,
ul.social-icons.social-bg-theme>li a {
	background-color: '. esc_attr( $theme_color ) .';
}';
echo 'ul.social-icons.social-theme > li a, 
ul.social-icons.social-h-theme > li a:hover,
.custom-post-nav ul.social-icons > li > a:hover,
.topbar-items ul.social-icons > li > a:hover,
.top-meta ul li a:hover i,
.bottom-meta ul li a:hover i { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.widget-area .widget_categories ul li a:before, .widget-area .widget_archive ul li a:before { 
	color: '. esc_attr( $theme_color ) .';
}';
echo '.comment-text span.reply a { 
	background-color: '. esc_attr( $secondary_color ) .';
}';
echo '.comment-text span.reply a:hover { 
	background-color: '. esc_attr( $theme_color ) .';
}';

$field = 'template-single-post-background-all';
if( isset( $seoaal_options[$field]['background-image'] ) && $seoaal_options[$field]['background-image'] != '' ){
	echo '.seoaal-single-post .float-video-left-part { background-image: url('. esc_url( $seoaal_options[$field]['background-image'] ) .'); }';
} 
$field = 'template-page-background-all';
if( isset( $seoaal_options[$field]['background-image'] ) && $seoaal_options[$field]['background-image'] != '' ){
	echo '.seoaal-page .float-video-left-part { background-image: url('. esc_url( $seoaal_options[$field]['background-image'] ) .'); }';
} 

echo "\n/*----------- Extra Style ---------------- */\n";
echo '.rounds-img::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/rounds.png' ) .'); 
}';
echo '.bg-pattern::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/dot-pattern.png' ) .');
    background-repeat: repeat;
}';
echo '.widget .sidebar-contact {
    background-image: url('. esc_url( SEOAAL_ASSETS . '/images/contact-bg.jpg' ) .');
    background-size: cover;
}';
echo '.overflow-ct-img::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/round-gd.png' ) .'); 
}';
echo '.overflow-ct2-img::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/hexa-gd.png' ) .'); 
}';
echo '.overflow-ct3-img::before {    
	background-image: url('. esc_url( SEOAAL_ASSETS . '/images/wave-shape-gd.png' ) .'); 
}';

echo "\n/*----------- Gutenberg ---------------- */\n";
echo '.wp-block-button__link,.wp-block-file .wp-block-file__button { 
	background: '. esc_attr( $theme_color ) .';
}';
echo '.is-style-outline, .wp-block-button .wp-block-button__link { 
	color: '. esc_attr( $theme_color ) .';
}';