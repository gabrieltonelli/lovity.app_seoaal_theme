/*
 * Zozo Megamenu Framework
 * 
 */
( function( $ ) {
	"use strict";
	
	var zozo_megamenu = {
		menu_item_move: function() {
			$(document).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
				if( ! $(event.target).is('a') ) {
					setTimeout( zozo_megamenu.update_megamenu_fields, 200 );
				}
			});
		},
		update_megamenu_status: function() {
			
			$(document).on( 'click', '.edit-menu-item-submegamenu', function() {
				var submegamenu = $( this ).parents( '.menu-item' );
				if( $( this ).is( ':checked' ) ) {
					submegamenu.addClass( 'zozo-submegamenu-active' );
				} else 	{
					submegamenu.removeClass( 'zozo-submegamenu-active' );
				}
			});
			$(document).on( 'click', '.edit-menu-item-megamenu', function() {
				var parent_menu_item = $( this ).parents( '.menu-item:eq(0)' );
				if( $( this ).is( ':checked' ) ) {
					parent_menu_item.addClass( 'zozo-megamenu-active' );
				} else 	{
					parent_menu_item.removeClass( 'zozo-megamenu-active' );
				}
				zozo_megamenu.update_megamenu_fields();
			});
		},
		
		update_megamenu_fields: function() {
			var menu_items = $( '.menu-item');
			
			menu_items.each( function( i ) 	{
				var zozo_megamenu_status = $( '.edit-menu-item-megamenu', this );
				if( ! $(this).is( '.menu-item-depth-0' ) ) {
					var check_against = menu_items.filter( ':eq('+(i-1)+')' );
					if( check_against.is( '.zozo-megamenu-active' ) ) {
						zozo_megamenu_status.attr( 'checked', 'checked' );
						$(this).addClass( 'zozo-megamenu-active' );
					} else {
						zozo_megamenu_status.removeAttr( "checked" );
						$(this).removeClass( 'zozo-megamenu-active' );
					}
				} else {
					if( zozo_megamenu_status.attr( 'checked' ) ) {
						$(this).addClass( 'zozo-megamenu-active' );
					}
				}
			});
			
			$( ".menu-item" ).not( ".menu-item-depth-0" ).each(function() {
				$(this).find('input.edit-menu-item-megamenu').removeAttr( 'checked' );						
			});
			
			setTimeout(function(){
				$( ".menu-item.menu-item-depth-0.zozo-megamenu-active" ).each(function() {
					if( ! $(this).find('input.edit-menu-item-megamenu:checked').length ){
						$(this).removeClass('zozo-megamenu-active');
					}
				});				
			}, 100);
			
			/* Sub Megamenu Checked Code */
			$( ".edit-menu-item-submegamenu" ).each(function() {
				var submegamenu = $( this ).parents( '.menu-item' );
				if( $( this ).is( ':checked' ) ) {
					submegamenu.addClass( 'zozo-submegamenu-active' );
				} else 	{
					submegamenu.removeClass( 'zozo-submegamenu-active' );
				}
			});
			
		}
	};
	
	$(document).ready(function(){
	
		zozo_megamenu.menu_item_move();
		zozo_megamenu.update_megamenu_status();
		zozo_megamenu.update_megamenu_fields();
		
	});
	
})( jQuery );