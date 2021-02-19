<?php
/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
 
class Seoaal_Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl(&$output, $depth = 0, $args = array()) {	
	}
	
	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl(&$output, $depth = 0, $args = array()) {
	}
	
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
	    global $_wp_nav_menu_max_depth;
	   
	    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	
	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
	    ob_start();
	    $item_id = esc_attr( $item->ID );
	    $removed_args = array(
	        'action',
	        'customlink-tab',
	        'edit-menu-item',
	        'menu-item',
	        'page-tab',
	        '_wpnonce',
	    );
	
	    $original_title = '';
	    if ( 'taxonomy' == $item->type ) {
	        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
	        if ( is_wp_error( $original_title ) )
	            $original_title = false;
	    } elseif ( 'post_type' == $item->type ) {
	        $original_object = get_post( $item->object_id );
	        $original_title = $original_object->post_title;
	    }
	
	    $classes = array(
	        'menu-item menu-item-depth-' . $depth,
	        'menu-item-' . esc_attr( $item->object ),
	        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
	    );
	
	    $title = $item->title;
	
	    if ( ! empty( $item->_invalid ) ) {
	        $classes[] = 'menu-item-invalid';
	        /* translators: %s: title of menu item which is invalid */
	        $title = sprintf( esc_html__( '%s (Invalid)', 'seoaal' ), $item->title );
	    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	        $classes[] = 'pending';
	        /* translators: %s: title of menu item in draft status */
	        $title = sprintf( esc_html__('%s (Pending)', 'seoaal'), $item->title );
	    }
	
	    $title = empty( $item->label ) ? $title : $item->label;
	
	    ?>
	    <li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode(' ', $classes ); ?>">
	        <div class="menu-item-bar">
	            <div class="menu-item-handle">
	                <span class="item-title"><?php echo esc_html( $title ); ?></span>
	                <span class="item-controls">
	                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
	                    <span class="item-order hide-if-js">
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-up-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'seoaal'); ?>">&#8593;</abbr></a>
	                        |
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                add_query_arg(
	                                    array(
	                                        'action' => 'move-down-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                ),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'seoaal'); ?>">&#8595;</abbr></a>
	                    </span>
	                    <a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_attr_e('Edit Menu Item', 'seoaal'); ?>" href="<?php
	                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
	                    ?>"><?php esc_html_e( 'Edit Menu Item', 'seoaal' ); ?></a>
	                </span>
	            </div>
	        </div>
	
	        <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
	            <?php if( 'custom' == $item->type ) : ?>
	                <p class="field-url description description-wide">
	                    <label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
	                        <?php esc_html_e( 'URL', 'seoaal' ); ?><br />
	                        <input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                    </label>
	                </p>
	            <?php endif; ?>
	            <p class="description description-wide">
	                <label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Navigation Label', 'seoaal' ); ?><br />
	                    <input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                </label>
	            </p>
	            <p class="description description-wide">
	                <label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Title Attribute', 'seoaal' ); ?><br />
	                    <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                </label>
	            </p>
				
	            <p class="field-link-target description description-wide">
	                <label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
	                    <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
	                    <?php esc_html_e( 'Open link in a new window/tab', 'seoaal' ); ?>
	                </label>
	            </p>
	            <p class="field-css-classes description description-wide">
	                <label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'CSS Classes (optional)', 'seoaal' ); ?><br />
	                    <input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                </label>
	            </p>
	            <p class="field-xfn description description-wide">
	                <label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Link Relationship (XFN)', 'seoaal' ); ?><br />
	                    <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                </label>
	            </p>
	            <p class="field-description description description-wide">
	                <label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Description', 'seoaal' ); ?><br />
	                    <textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
	                    <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'seoaal'); ?></span>
	                </label>
	            </p>        
	            <?php
	            /* New fields insertion starts here */
				
				$seoaal_options =  get_option( 'seoaal_options' );
				if( isset( $seoaal_options['menu-tag'] ) && $seoaal_options['menu-tag'] == 1 ):
	            ?> 
				
				<p class="menu-item-popbtn description description-wide">
	                <label for="edit-menu-item-popbtn-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Hot/Pop', 'seoaal' ); ?><br />
						<input type="radio" class="widefat edit-menu-item-popbtn" name="menu-item-popbtn[<?php echo esc_attr( $item_id ); ?>]" <?php checked( '', esc_attr( $item->popbtn ), true ); ?> value="" /> <?php esc_html_e( 'Default', 'seoaal'); ?>
						<input type="radio" class="widefat edit-menu-item-popbtn" name="menu-item-popbtn[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'hot', esc_attr( $item->popbtn ), true ); ?> value="hot" /> <?php esc_html_e( 'Hot', 'seoaal'); ?>
	                    <input type="radio" class="widefat edit-menu-item-popbtn" name="menu-item-popbtn[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'new', esc_attr( $item->popbtn ), true ); ?> value="new" /> <?php esc_html_e( 'New', 'seoaal'); ?>
						<input type="radio" class="widefat edit-menu-item-popbtn" name="menu-item-popbtn[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'trend', esc_attr( $item->popbtn ), true ); ?> value="trend" /> <?php esc_html_e( 'Trend', 'seoaal'); ?>
						<br />
						<?php esc_html_e( 'Enable Hot/Pop/Trend button to this menu item.', 'seoaal'); ?>
	                </label>
	            </p>
				<?php endif; ?>
				
				<p class="menu-item-megamenulogo description description-wide">
	                <label for="edit-menu-item-megamenulogo-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Mega Menu Logo', 'seoaal' ); ?><br />
	                    <input type="checkbox" id="edit-menu-item-megamenulogo-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-megamenulogo" name="menu-item-megamenulogo[<?php echo esc_attr( $item_id ); ?>]" <?php checked( (bool) $item->megamenulogo, true ); ?> /> <?php esc_html_e('Enable this option to show logo instead of current item.', 'seoaal'); ?>
						
	                </label>
	            </p>
			
				<p class="menu-item-megamenu description description-wide">
	                <label for="edit-menu-item-megamenu-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Mega Menu', 'seoaal' ); ?><br />
	                    <input type="checkbox" id="edit-menu-item-megamenu-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-megamenu" name="menu-item-megamenu[<?php echo esc_attr( $item_id ); ?>]" <?php checked( (bool) $item->megamenu, true ); ?> /> <?php esc_html_e('Enable mega menu.', 'seoaal'); ?>
						
	                </label>
	            </p>
				
				<p class="menu-item-submegamenu description description-wide">
	                <label for="edit-menu-item-submegamenu-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Sub Mega Menu', 'seoaal' ); ?><br />
	                    <input type="checkbox" id="edit-menu-item-submegamenu-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-submegamenu" name="menu-item-submegamenu[<?php echo esc_attr( $item_id ); ?>]" <?php checked( (bool) $item->submegamenu, true ); ?> /> <?php esc_html_e('Enable sub mega menu.', 'seoaal'); ?>
						
	                </label>
	            </p>
				
				<p class="menu-item-submegamenupos description description-wide">
	                <label for="edit-menu-item-submegamenupos-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Sub Mega Menu Child Column Position', 'seoaal' ); ?><br />
	                    <select id="edit-menu-item-submegamenupos-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-submegamenupos" name="menu-item-submegamenupos[<?php echo esc_attr( $item_id ); ?>]" >
							 <option value="right" <?php selected( 'right', esc_attr( $item->submegamenupos ), true ); ?>><?php esc_html_e('Right.', 'seoaal'); ?></option>
							 <option value="left" <?php selected( 'left', esc_attr( $item->submegamenupos ), true ); ?>><?php esc_html_e('Left.', 'seoaal'); ?></option>
						</select>
	                </label>
	            </p>
				
				<p class="menu-item-submegamenucol description description-wide">
	                <label for="edit-menu-item-submegamenucol-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Sub Mega Menu Child Column', 'seoaal' ); ?><br />
	                    <select id="edit-menu-item-submegamenucol-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-submegamenucol" name="menu-item-submegamenucol[<?php echo esc_attr( $item_id ); ?>]" >
							 <option value="1" <?php selected( '1', esc_attr( $item->submegamenucol ), true ); ?>>1</option>
							 <option value="2" <?php selected( '2', esc_attr( $item->submegamenucol ), true ); ?>>2</option>
							 <option value="3" <?php selected( '3', esc_attr( $item->submegamenucol ), true ); ?>>3</option>
							 <option value="4" <?php selected( '4', esc_attr( $item->submegamenucol ), true ); ?>>4</option>
						</select>
	                </label>
	            </p>
				
				<p class="menu-item-megafull description description-wide">
	                <label for="edit-menu-item-megafull-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Mega Menu Fullwidth', 'seoaal' ); ?><br />
	                    <input type="checkbox" id="edit-menu-item-megafull-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-megafull" name="menu-item-megafull[<?php echo esc_attr( $item_id ); ?>]" <?php checked( (bool) $item->megafull, true ); ?> /> <?php esc_html_e('Mega Menu Fullwidth(Overrides Container)', 'seoaal'); ?>
	                </label>
	            </p>
				
				<p class="menu-item-megabgimg field-custom description description-wide">
	                <label for="edit-menu-item-megabgimg-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Mega Menu Background Image URL', 'seoaal' ); ?><br />
	                    <input type="text" id="edit-menu-item-megabgimg-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megabgimg" name="menu-item-megabgimg[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->megabgimg ); ?>" />
	                </label>
	            </p>
				
				<p class="menu-item-megatitopt description description-wide">
	                <label for="edit-menu-item-megatitopt-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Title Hide/Disable', 'seoaal' ); ?><br />
						<input type="radio" class="widefat edit-menu-item-megatitopt" name="menu-item-megatitopt[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'default', esc_attr( $item->megatitopt ), true ); ?> value="default" /> <?php esc_html_e( 'Default', 'seoaal'); ?>
	                    <input type="radio" class="widefat edit-menu-item-megatitopt" name="menu-item-megatitopt[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'hide', esc_attr( $item->megatitopt ), true ); ?> value="hide" /> <?php esc_html_e( 'Hide', 'seoaal'); ?>
						<input type="radio" class="widefat edit-menu-item-megatitopt" name="menu-item-megatitopt[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'disable', esc_attr( $item->megatitopt ), true ); ?> value="disable" /> <?php esc_html_e( 'Disable Link', 'seoaal'); ?>
						<br />
						<?php esc_html_e( 'Hide option not for mobile menu.', 'seoaal'); ?>
	                </label>
	            </p>
				<p class="menu-item-megadropdowntit description description-wide">
	                <label for="edit-menu-item-megadropdowntit-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Heading or Divider', 'seoaal' ); ?><br />
						<input type="radio" class="widefat edit-menu-item-megadropdowntit" name="menu-item-megadropdowntit[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'default', esc_attr( $item->megadropdowntit ), true ); ?> value="default" /> <?php esc_html_e( 'Default', 'seoaal'); ?>
	                    <input type="radio" class="widefat edit-menu-item-megadropdowntit" name="menu-item-megadropdowntit[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'heading', esc_attr( $item->megadropdowntit ), true ); ?> value="heading" /> <?php esc_html_e( 'Heading', 'seoaal'); ?>
						<input type="radio" class="widefat edit-menu-item-megadropdowntit" name="menu-item-megadropdowntit[<?php echo esc_attr( $item_id ); ?>]" <?php checked( 'divider', esc_attr( $item->megadropdowntit ), true ); ?> value="divider" /> <?php esc_html_e( 'Divider', 'seoaal'); ?>
						<br />
						<?php esc_html_e( 'Choose this item react as heading or divider.', 'seoaal'); ?>
	                </label>
	            </p>
				
				<p class="menu-item-megachildcol description description-wide">
	                <label for="edit-menu-item-megachildcol-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Mega Child Column', 'seoaal' ); ?><br />
	                    <select id="edit-menu-item-megachildcol-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-megachildcol" name="menu-item-megachildcol[<?php echo esc_attr( $item_id ); ?>]" >
							 <option value="12" <?php selected( '12', esc_attr( $item->megachildcol ), true ); ?>>1/1</option>
							 <option value="6" <?php selected( '6', esc_attr( $item->megachildcol ), true ); ?>>1/2</option>
							 <option value="4" <?php selected( '4', esc_attr( $item->megachildcol ), true ); ?>>1/3</option>
							 <option value="3" <?php selected( '3', esc_attr( $item->megachildcol ), true ); ?>>1/4</option>
						</select>
	                </label>
	            </p>
				
				<p class="menu-item-megawidget description description-wide">
	                <label for="edit-menu-item-megawidget-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Mega Menu Widget', 'seoaal' ); ?><br />
	                    <select id="edit-menu-item-megawidget-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-megawidget" name="menu-item-megawidget[<?php echo esc_attr( $item_id ); ?>]" >
							<option value=""><?php esc_html_e( 'Choose Widget', 'seoaal' ); ?></option>
							<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
								 <option value="<?php echo ucwords( $sidebar['id'] ); ?>" <?php selected( esc_attr( ucwords( $sidebar['id'] ) ), esc_attr( $item->megawidget ), true ); ?>>
								 	<?php echo ucwords( $sidebar['name'] ); ?>
								 </option>
							<?php } ?>
						</select>
	                </label>
	            </p>
				
				<p class="menu-item-megamenuicon description description-wide">
	                <label for="edit-menu-item-megamenuicon-<?php echo esc_attr( $item_id ); ?>">
	                    <?php esc_html_e( 'Menu Icons', 'seoaal' ); ?><br />
	                    <select id="edit-menu-item-megamenuicon-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-megamenuicon" name="menu-item-megamenuicon[<?php echo esc_attr( $item_id ); ?>]" style="font-family: 'FontAwesome', 'Helvetica';" >
							<option value=""><?php esc_html_e( 'Choose Menu Icon', 'seoaal' ); ?></option>
							<?php 
								$menu_ico = seoaal_menuFaIcons();
								foreach($menu_ico as $icons){
								$cont = str_replace("\\","&#x",$icons[2]).';'; // &#x\f000
								$ico_class = str_replace("fa-","",$icons[1]); 
								
							?>
								<option value="fa <?php echo esc_attr( $icons[1] ); ?>" <?php selected( 'fa '.$icons[1], esc_attr( $item->megamenuicon ), true ); ?>><?php echo esc_attr( $ico_class. ' - '.$cont ); ?></option>
							<?php
								}
							?>
						</select>
	                </label>
	            </p>
								
	            <?php
	            /* New fields insertion ends here */
	            ?>
	            <div class="menu-item-actions description-wide submitbox">
	                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                    <p class="link-to-original">
	                        <?php printf( __('Original: %s', 'seoaal'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
	                    </p>
	                <?php endif; ?>
	                <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
	                echo wp_nonce_url(
	                    add_query_arg(
	                        array(
	                            'action' => 'delete-menu-item',
	                            'menu-item' => esc_attr( $item_id),
	                        ),
	                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                    ),
	                    'delete-menu_item_' . esc_attr( $item_id )
	                ); ?>"><?php esc_html_e('Remove', 'seoaal'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
	                    ?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e('Cancel', 'seoaal'); ?></a>
	            </div>
	
	            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
	            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	        </div><!-- .menu-item-settings-->
	        <ul class="menu-item-transport"></ul> 
	    <?php 
	    
	    $output .= ob_get_clean();
	    }
} 
function seoaal_menuFaIcons(){
	$pattern = '/\.(fa\-(?:\w+(?:\-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
	$fontawesome_path = get_template_directory_uri() . '/assets/css/font-awesome.css';  
		
	$response = wp_remote_get( $fontawesome_path );
	if( is_array($response) ) {
		$file = $response['body']; // use the content
	}
	preg_match_all($pattern, $file, $str, PREG_SET_ORDER);
	return $str;
}