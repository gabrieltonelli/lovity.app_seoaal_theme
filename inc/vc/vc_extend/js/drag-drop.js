(function( $ ) {
	"use strict";
	
	/*Meta Drag and Drop Multi Field*/
	$( ".meta-drag-drop-multi-field .meta-items" ).each(function( index ) {
		var cur_items = this;
		var auth = $( cur_items ).parent( ".meta-drag-drop-multi-field" ).children( ".meta-items" );
		var part = $( cur_items ).data( "part" );
		var final_val = '';
		var t_json = '';
		final_val = $( cur_items ).parent('.meta-drag-drop-multi-field').children( ".meta-drag-drop-multi-value" );
		final_val.val( JSON.stringify( final_val.data( "params" ) ) );
		$( cur_items ).sortable({
		  connectWith: auth,
		  update: function () {

			t_json = jQuery.parseJSON( final_val.val() );
			t_json[part] = '';
			var t = {};
			$( this ).children( "li" ).each(function( index ) {
				var data_id = $(this).attr('data-id');
				var data_val = $(this).attr('data-val');
				t[data_id] = data_val;
			});
			console.log(t);
			t_json[part] = t;
			final_val.val( JSON.stringify( t_json ) );

		  }
		});
	});
	
})(jQuery);

