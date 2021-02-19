(function( $ ) {
	"use strict";
	
	/*Meta Drag and Drop Multi Field*/
	$('.vc-switcher').change(function() {
        if($(this).is(":checked")) {
			$(this).parents('.vc-switch').find('.vc-switcher-stat').val('on');
        }else{
			$(this).parents('.vc-switch').find('.vc-switcher-stat').val('off');
		}
    });
	
})(jQuery);

