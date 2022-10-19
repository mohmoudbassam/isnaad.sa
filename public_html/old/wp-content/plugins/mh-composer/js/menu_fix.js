(function($){
	$( document ).ready( function() {
		var $menu_item = $( '#toplevel_page_mh_panel' );

		if ( $menu_item.length ) {
			var $first_menu_item = $menu_item.find( '.wp-first-item' );

			if ( 'Theme Panel' === $first_menu_item.find( 'a' ).text() ) {
				$first_menu_item.remove();
			}
		}
	});
})(jQuery)