( function($) {

	$( document ).ready( function() {
		$( '.widget-liquid-right' ).append( mhc_options.widget_strings );

		var $create_box = $( '#mhc_widget_area_create' ),
			$widget_name_input = $create_box.find( '#mhc_new_widget_area_name' ),
			$mhc_sidebars = $( 'div[id^=mhc_widget_area_]' );

		$create_box.find( '.mhc_create_widget_area' ).click( function( event ) {
			var $this_el = $(this);

			event.preventDefault();

			if ( $widget_name_input.val() === '' ) return;

			$.ajax( {
				type: "POST",
				url: mhc_options.ajaxurl,
				data:
				{
					action : 'mhc_add_widget_area',
					mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
					mh_widget_area_name : $widget_name_input.val()
				},
				success: function( data ){
					$this_el.siblings( '.mhc_widget_area_result' ).hide().html( data ).slideToggle();
				}
			} );
		} );

		$mhc_sidebars.each( function() {
			if ( $(this).is( '#mhc_widget_area_create' ) || $(this).closest( '.inactive-sidebar' ).length ) return true;

            $(this).closest('.widgets-holder-wrap').find('.sidebar-name h2, .sidebar-name h3').before( '<a href="#" class="mhc_widget_area_remove">' + mhc_options.delete_string + '</a>' );

			$( '.mhc_widget_area_remove' ).click( function( event ) {
				var $this_el = $(this);

				event.preventDefault();

				$.ajax( {
					type: "POST",
					url: mhc_options.ajaxurl,
					data:
					{
						action : 'mhc_remove_widget_area',
						mh_admin_load_nonce : mhc_options.mh_admin_load_nonce,
						mh_widget_area_name : $this_el.closest( '.widgets-holder-wrap' ).find( 'div[id^=mhc_widget_area_]' ).attr( 'id' )
					},
					success: function( data ){
						$( '#' + data ).closest( '.widgets-holder-wrap' ).remove();
					}
				} );
                
                return false;
			} );
		} );
	} );

} )(jQuery);