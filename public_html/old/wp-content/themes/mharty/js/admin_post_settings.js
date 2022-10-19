(function($){
	$(document).ready(function() {
		var $post_format          = $('input[name="post_format"]'),
			$settings             = $('.mh_mharty_format_setting'),
			$use_bg_color_setting = $('#mh_post_use_bg_color');

        $('.color-picker-hex').wpColorPicker({   
            palettes: mh_admin_settigs.default_color_scheme.split( '|' )
        });

		$post_format.change( function() {
			var $this = $(this);

			$settings.hide();

			$( '.mh_mharty_format_setting' + '.mh_mharty_' + $this.val() + '_settings' ).show();

			$use_bg_color_setting.trigger( 'change' );
		} );

		$use_bg_color_setting.change( function() {
			var $this = $(this);

			$( '.mh_post_bg_color_setting' ).toggle( $this.is(':checked') );
		} );

		$post_format.filter(':checked').trigger( 'change' );
	});
})(jQuery);