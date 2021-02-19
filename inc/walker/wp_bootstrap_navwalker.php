<?php
/**
 * Class Name: wp_bootstrap_navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.5
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
class seoaal_wp_bootstrap_navwalker extends Walker_Nav_Menu {
	private $megamenu = '';
	private $megabgimg = '';
	private $megafull = '';
	private $submegamenu = '';
	private $seoaal_options;
	public function __construct(){
		$this->seoaal_options =  get_option( 'seoaal_options' );
	}
	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		
		$indent = str_repeat( "\t", $depth );
		
		if ( class_exists( 'Seoaal_Walker_Nav_Menu_Edit_Custom' ) ) {
			
			if( $depth == 0 && $this->megamenu == 'on' ){
				$bg_img = $this->megabgimg != '' ? "style=\"background-image:url(". esc_url( $this->megabgimg ) .");\"" : '';
				$m_full = isset( $this->megafull ) && $this->megafull == 'on' ? ' mega-dropdown-full' : '';
			
				$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu mega-dropdown-menu container". esc_attr( $m_full ) ."\" $bg_img>\n";
			}elseif( $depth > 0 && $this->megamenu == 'on' ){
				$output .= "\n$indent<ul role=\"menu\" class=\" mega-child-dropdown-menu\">\n";
			}else{
				if( $depth == 1 && $this->megamenu != 'on' && $this->submegamenu == 'on' )
					$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu mega-sub-dropdown-menu\">\n";
				elseif( $depth == 2 && $this->megamenu != 'on' && $this->submegamenu == 'on' )
					$output .= "\n$indent<ul role=\"menu\" class=\" mega-sub-child-inner\">\n";
				else
					$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
			}
		}else{
			$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
		}
		
	}
	
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	
		$indent = str_repeat( "\t", $depth );
		$output	   .= "\n$indent</ul>";
	}
	
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		if ( class_exists( 'Seoaal_Walker_Nav_Menu_Edit_Custom' ) ) {
			
			if($depth == 0){
				$this->megamenu = $item->megamenu;
				$this->megabgimg = $item->megabgimg;
				$this->megafull = $item->megafull;
			}			
			 
			if($depth == 1 && $this->megamenu != 'on'){
				$this->submegamenu = $item->submegamenu;
			}
			 
			if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
				$output .= $indent . '<li class="divider">';
			} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
				$output .= $indent . '<li class="divider">';
			} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
				$output .= $indent . '<li class="dropdown-header">' . esc_html( $item->title );
			} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
				$output .= $indent . '<li class="disabled"><a href="#">' . esc_html( $item->title ) . '</a>';
			} else {
	
				$class_names = $value = '';
	
				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'nav-item';
				$classes[] = 'menu-item-' . $item->ID;
	
				if ( $args->has_children ){
					if( $depth == 0 && $this->megamenu == 'on' ){
						$classes[] ='dropdown mega-dropdown';
					}elseif( $depth > 0 && $this->megamenu == 'on' ){
						$classes[] ='mega-child-dropdown';
					}else{
						$classes[] ='dropdown';
					}
				}
				
				if( $depth == 0 && $item->megamenulogo == 'on' ){
					$classes[] ='menu-item-logo';
				}
				
				if( $depth == 1 && $this->megamenu != 'on' && $this->submegamenu == 'on' ){
					$classes[] ='mega-sub-dropdown';
					$max_col = isset( $item->submegamenucol ) && $item->submegamenucol != '' ? $item->submegamenucol : '1';
					$classes[] ='max-col-' . esc_attr( $max_col );
					$classes[] = isset( $item->submegamenupos ) && $item->submegamenupos == 'left' ? 'left-side' : '';
				}elseif( $depth == 2 && $this->megamenu != 'on' && $this->submegamenu == 'on' ){
					$classes[] ='mega-sub-child';
				}
				
				
				if( $depth > 1 && $this->megamenu == 'on' ){
					if( $item->megadropdowntit == 'heading' ){
						$classes[] ='mega-child-heading';
					}elseif( $item->megadropdowntit == 'divider' ){
						$classes[] ='mega-child-divider';
					}
				}
				
				//for mega menu chiildren column
				if( $depth == 1 && $this->megamenu == 'on' ){
					$classes[] = 'col-sm-' . $item->megachildcol;
				}
				
				if ( in_array( 'current-menu-item', $classes ) )
					$class_names .= ' active';
				
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
				
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	
				$output .= $indent . '<li' . $id . $value . $class_names .'>';
	
				$atts = array();
				$atts['target'] = ! empty( $item->target )	? $item->target	: '';
				$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
	
				// If item has_children add atts to a.
				if ( $args->has_children && $depth === 0 ) {
					$atts['class']			= 'nav-link dropdown-toggle';
				} else {
					$atts['class'] = 'nav-link';
				}
				
				if(  $depth == 1 && $this->megamenu == 'on' && $item->megatitopt == 'hide' ){
					$atts['class'] .= ' hidden-xs-up';
				}
	
				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
	
				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
	
				$item_output = $args->before;
	
				/*
				 * Glyphicons
				 * ===========
				 * Since the the menu item is NOT a Divider or Header we check the see
				 * if there is a value in the attr_title property. If the attr_title
				 * property is NOT null we apply it as the class name for the glyphicon.
				 */
				 
				$menu_icon = '';
				if( $item->megamenuicon != '' ){$menu_icon = '<span class="'.$item->megamenuicon.' menu-icon"></span>';}
				
				$hot_icon = '';
				if( $item->popbtn != '' && isset( $this->seoaal_options['menu-tag'] ) && $this->seoaal_options['menu-tag'] == 1 ){
					$tag_text = '';
					if( $this->seoaal_options['menu-tag-'.$item->popbtn.'-text'] != '' )
						$tag_text = esc_html( $this->seoaal_options['menu-tag-'.$item->popbtn.'-text'] );
						
					$hot_icon = '<span class="menu-tag menu-tag-'.$item->popbtn.'">'. $tag_text .'</span>';
				}
				
				if( $depth == 0 && $item->megamenulogo == 'on' ){
				
					$ahe = new SeoaalHeaderElements;
					$item_output .= $ahe->seoaalHeaderLogo();
					$item_output .= '<div class="sticky-logo">'. $ahe->seoaalAdditionalLogo('sticky-logo') .'</div>';
					
				}elseif( $depth > 1 && $this->megamenu == 'on' && $item->megadropdowntit == 'divider' ){
					$item_output .= '<hr />';
				}elseif( $depth == 1 && $this->megamenu == 'on' && $item->megawidget != '' ){
					ob_start();
					dynamic_sidebar( $item->megawidget );
					$sidebar = ob_get_clean();
					$item_output .= '<div class="mega-child-widget">'. $sidebar .'</div>';
				}else{
					
					if(  $depth == 1 && $this->megamenu == 'on' && $item->megatitopt == 'disable' ){
						$item_output .= '<span class="mega-child-item-disabled">' . $menu_icon . apply_filters( 'the_title', $item->title, $item->ID ) .'</span>';
					}else{				
						$item_output .= '<a'. $attributes .'>' . $menu_icon;
						
						$title = apply_filters( 'the_title', $item->title, $item->ID );
						$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
						$item_output .= $args->link_before . $title . $args->link_after;
						$item_output .= $hot_icon . '</a>';
					}
				}
				
				$item_output .= $args->after;
	
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}else{
			
			if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
				$output .= $indent . '<li class="divider">';
			} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
				$output .= $indent . '<li class="divider">';
			} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
				$output .= $indent . '<li class="dropdown-header">' . esc_html( $item->title );
			} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
				$output .= $indent . '<li class="disabled"><a href="#">' . esc_html( $item->title ) . '</a>';
			} else {
	
				$class_names = $value = '';
	
				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'nav-item';
				$classes[] = 'menu-item-' . $item->ID;
	
				if ( $args->has_children ){
					$classes[] ='dropdown';
				}
				
				if ( in_array( 'current-menu-item', $classes ) )
					$class_names .= ' active';
				
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
				
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	
				$output .= $indent . '<li' . $id . $value . $class_names .'>';
	
				$atts = array();
				$atts['target'] = ! empty( $item->target )	? $item->target	: '';
				$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
	
				// If item has_children add atts to a.
				if ( $args->has_children && $depth === 0 ) {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
					$atts['class']			= 'nav-link dropdown-toggle';
				} else {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
					$atts['class'] = 'nav-link';
				}
	
				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
	
				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
	
				$item_output = $args->before;
	
				/*
				 * Glyphicons
				 * ===========
				 * Since the the menu item is NOT a Divider or Header we check the see
				 * if there is a value in the attr_title property. If the attr_title
				 * property is NOT null we apply it as the class name for the glyphicon.
				 */
				 
				$item_output .= '<a'. $attributes .'>';
				
				$title = apply_filters( 'the_title', $item->title, $item->ID );
				$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
				$item_output .= $args->link_before . $title . $args->link_after;
				
				$item_output .= '</a>';
				
				$item_output .= $args->after;
	
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
			
		}
	}
	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;
        $id_field = $this->db_fields['id'];
        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {
			extract( $args );
			$fb_output = null;
			if ( $container ) {
				$fb_output = '<' . $container;
				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';
				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';
				$fb_output .= '>';
			}
			$fb_output .= '<ul';
			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';
			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';
			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">'. esc_html__('Add a menu', 'seoaal') .'</a></li>';
			$fb_output .= '</ul>';
			if ( $container )
				$fb_output .= '</' . $container . '>';
			echo ( ''. $fb_output );
		}
	}
}