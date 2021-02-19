/*
 * Admin Screen
 * 
 */

( function( $ ) {
	"use strict";
	
	$(document).on( 'click', '.button-uninstall-demo', function(e) {
		
		var current	= this;
		
		$.confirm({
			theme: 'supervan',
			title: false,
			content: seoaal_admin_ajax_var.unins_confirm,
			confirmButtonClass: 'btn-success',
			cancelButtonClass: 'btn-danger',
			confirmButton: seoaal_admin_ajax_var.yes,
   			cancelButton: seoaal_admin_ajax_var.no,
			confirm: function(){
				
				var choosed_demo = $(this).data('demo-id');
				var loading_wrap = $(current).parents('.demo-inner').find('.zozo-demo-import-loader');
				var progress = $(current).parents('.zozothemes-demo-item').find('.installation-progress .progress');
				var progress_text = $(current).parents('.zozothemes-demo-item').find('.installation-progress p');
				progress.css('width', '0%');
				progress_text.text(seoaal_admin_ajax_var.uninstalling);
				loading_wrap.show();
				
				//Delete Attachments
				$.ajax({
					type: 'POST',
					url: seoaal_admin_ajax_var.admin_ajax_url,
					data: {
						action: 'seoaal_uninstall',
					},
					success: function(response){
						if( response && response.indexOf('success') == -1 ) {
							loading_wrap.hide();
							alert(response);
						}else{
							$('.zozothemes-demo-item').removeClass('demo-actived demo-inactive').addClass('demo-active');
							loading_wrap.hide();
							progress_text.text(seoaal_admin_ajax_var.uninstalled);
						}
					},
					error: function(response, errorThrown){
						loading_wrap.hide();
						alert(seoaal_admin_ajax_var.unins_pbm);
					}
				});
			}
		});

		return false;
	});

	var zozo_admin_screen = {

		install_demos: function() {
			$(document).on( 'click', '.button-install-demo', function(e) {
				
				e.preventDefault();
				var current			= this;
				var progress = $(current).parents('.zozothemes-demo-item').find('.installation-progress .progress');
				var progress_text = $(current).parents('.zozothemes-demo-item').find('.installation-progress p');
				var choosed_demo 	= $(this).data('demo-id');
				var loading_wrap 	= $('.zozo-preview-' + choosed_demo);
				var requirement 	= $(this).parents('.demo-inner').find('.theme-requirements').data('requirements');
				var revslider = $(this).data('revslider');
				progress.css('width', '0%');
				if( choosed_demo !== null ) {
					
					$.confirm({
						theme: 'supervan',
						title: false,
						content: requirement,
						confirmButtonClass: 'btn-success',
    					cancelButtonClass: 'btn-danger',
						confirmButton: seoaal_admin_ajax_var.proceed,
   						cancelButton: seoaal_admin_ajax_var.cancel,
						confirm: function(){
							loading_wrap.show();
							$(current).parents('.zozothemes-demo-item').find('.installation-progress p').text(seoaal_admin_ajax_var.downloading);
							$('.zozo-importer-notice').hide();
							
							/*Demo Files Download*/
							$.ajax({
								type: 'POST',
								url: seoaal_admin_ajax_var.admin_ajax_url,
								data: {
									action: 'seoaal_download',
									demo_type: choosed_demo,
									revslider: revslider
								},
								success: function(response){
									
									if( response && response.indexOf('success') == -1 ) {
										alert(response);
									}else{
										progress.animate({'width' : "10%"});
										progress_text.text(seoaal_admin_ajax_var.import_theme_opt); //import_theme_opt
										
										/*Theme Option Import*/
										$.ajax({
											type: 'POST',
											url: seoaal_admin_ajax_var.admin_ajax_url,
											data: {
												action: 'seoaal_theme_option',
											},
											success: function(response){
												if( response && response.indexOf('success') == -1 ) {
													alert(response);
												}else{
													progress.animate({'width' : "20%"});
													progress_text.text(seoaal_admin_ajax_var.import_xml); //import_xml
										
													/*Theme Xml Import*/
													$.ajax({
														type: 'POST',
														url: seoaal_admin_ajax_var.admin_ajax_url,
														data: {
															action: 'seoaal_theme_xml',
														},
														success: function(response){
															if( response && response.indexOf('success') == -1 ) {
																alert(response);
															}else{
																progress.animate({'width' : "60%"});
																progress_text.text(seoaal_admin_ajax_var.import_sidebars); //import_sidebars
																			
																/*Custom Sidebars Import*/
																$.ajax({
																	type: 'POST',
																	url: seoaal_admin_ajax_var.admin_ajax_url,
																	data: {
																		action: 'seoaal_custom_sidebars',
																	},
																	success: function(response){
																		if( response && response.indexOf('success') == -1 ) {
																			alert(response);
																		}else{
																			progress.animate({'width' : "70%"});
																			progress_text.text(seoaal_admin_ajax_var.import_widg);
																			
																			/*Widgets Import*/
																			$.ajax({
																				type: 'POST',
																				url: seoaal_admin_ajax_var.admin_ajax_url,
																				data: {
																					action: 'seoaal_widgets',
																				},
																				success: function(response){
																					if( response && response.indexOf('success') == -1 ) {
																						alert(response);
																					}else{

																						if( revslider != '' && revslider != 0 ){
																							
																							progress.animate({'width' : "80%"});
																							progress_text.text(seoaal_admin_ajax_var.import_revslider);
																							
																							/*Revolution Slider Import*/
																							$.ajax({
																								type: 'POST',
																								url: seoaal_admin_ajax_var.admin_ajax_url,
																								data: {
																									action: 'seoaal_rev_slider',
																									demo_type: choosed_demo,
																									revslider: revslider
																								},
																								success: function(response){
																									if( response && response.indexOf('success') == -1 ) {
																										alert(response);
																									}else{
																										progress.animate({'width' : "100%"});
																										progress.animate({'opacity' : "0"});
																										$('.zozothemes-demo-item').removeClass('demo-actived demo-inactive demo-active');
																										$(current).parents('.zozothemes-demo-item').addClass('demo-actived');
																										$('.zozothemes-demo-item:not(.demo-actived)').addClass('demo-inactive');
																										progress.find('.progress-bar').removeClass('active');
																										$('.regenerate-thumb').attr('style','display: block !important');
																										progress_text.text(seoaal_admin_ajax_var.imported);
																										
																									}
																									loading_wrap.hide();
																								},
																								error: function(response, errorThrown){
																									alert(seoaal_admin_ajax_var.import_pbm);
																								}
																							});	// Revolution Slider End
																						} // if revslider exists
																						else{
																							progress.animate({'width' : "100%"});
																							progress.animate({'opacity' : "0"});
																							$('.zozothemes-demo-item').removeClass('demo-actived demo-inactive demo-active');
																							$(current).parents('.zozothemes-demo-item').addClass('demo-actived');
																							$('.zozothemes-demo-item:not(.demo-actived)').addClass('demo-inactive');
																							progress.find('.progress-bar').removeClass('active');
																							$('.regenerate-thumb').attr('style','display: block !important');
																							progress_text.text(seoaal_admin_ajax_var.imported);
																							loading_wrap.hide();
																						}
																						
																					}
																				},
																				error: function(response, errorThrown){
																					alert(seoaal_admin_ajax_var.import_pbm);
																				}
																			});	// Widget Import End																	
																		}
																	},
																	error: function(response, errorThrown){
																		alert(seoaal_admin_ajax_var.import_pbm);
																	}
																}); // Custom Sidebars Import End
																		
															}
														},
														error: function(response, errorThrown){
															alert(seoaal_admin_ajax_var.import_pbm);
														}
													}); // Theme Xml Import End
												}
											},
											error: function(response, errorThrown){
												alert(seoaal_admin_ajax_var.import_pbm);
											}
										}); // Theme Option Import End
									}
								},
								error: function(response, errorThrown){
									alert(seoaal_admin_ajax_var.access_pbm);
								}
							}); // Demo Files Download End
						},
						cancel: function(){}
					});
					
				}
				
			});
		},
		
	};
	
	$(document).ready(function(){
	
		zozo_admin_screen.install_demos();
		
	});
	
})( jQuery );