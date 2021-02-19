(function( $ ) {
	"use strict";
	
	/*Meta Drag and Drop Multi Field*/
	$( "ul.img-select > li > img" ).on( "click", function() {
		var cur_items = this;
		var parents = $( cur_items ).parents('ul.img-select');
		$( parents ).find('li').removeClass('selected');
		$( cur_items ).parent('li').addClass('selected');
		$( parents ).next('input').val( $( cur_items ).parent('li').data('id') );
	});
	
})(jQuery);

