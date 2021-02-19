(function( $ ) {
	"use strict";
	jQuery( document ).ready(function() {
		$(".seoaal-post-featured-status").change(function(){
												 
			var postid = $(this).attr('data-post');
			var stat;
			if( $(this).is( ":checked" ) ) {
				stat = 1;
			}else{
				stat = 0;
			}
			$( "#post-featured-stat-msg-" + postid ).text( seoaal_admin_ajax_var.process + "..." );
			if( postid ){
				// Ajax call
				$.ajax({
					type: "post",
					url: seoaal_admin_ajax_var.admin_ajax_url,
					data: "action=seoaal-post-featured-active&nonce="+seoaal_admin_ajax_var.featured_nonce+"&featured-stat="+ stat +"&postid="+ postid,
					success: function(data){
						$( "#post-featured-stat-msg-"+ postid ).text( "" );
					}
				});
			}
		});
		$( document ).on( "click", ".export-custom-sidebar", function() {
			// Ajax call
			$.ajax({
				type: "post",
				url: seoaal_admin_ajax_var.admin_ajax_url,
				data: "action=seoaal-custom-sidebar-export&nonce="+seoaal_admin_ajax_var.sidebar_nounce,
				success: function( data ){
					
					$("<a />", {
						"download": "custom-sidebars.json",
						"href" : "data:application/json," + encodeURIComponent( data )
					}).appendTo("body").on( "click", function() {
						$(this).remove();
					})[0].click();
				}
			});
			return false;
		});
		
		if( $( '#import-code-value' ).length ){
			$( document ).on( "click", "#redux-import", function( e ) {
				$( '#redux-import' ).attr( "disabled", "disabled" );
				if ( $( '#import-code-value' ).val() === "" && $( '#import-link-value' ).val() === "" ) {
					e.preventDefault();
					return false;
				}else{
					var json_data = '';
					var stat = '';
					if( $( '#import-code-value' ).val() != "" ){
						json_data = $( '#import-code-value' ).val();
						stat = 'data';
					}else if( $( '#import-link-value' ).val() != "" ){
						json_data = $( '#import-link-value' ).val()
						stat = 'url';
					}
					var post_data = { action: "seoaal-redux-themeopt-import", nonce: seoaal_admin_ajax_var.redux_themeopt_import, json_data : json_data, stat: stat };
					jQuery.post(seoaal_admin_ajax_var.admin_ajax_url, post_data, function( response ) {
						location.reload(true);
						$( '#redux-import' ).removeAttr( "disabled" );
					});
					
					return false;
				}
			});
		}
	
	});
	
})(jQuery);