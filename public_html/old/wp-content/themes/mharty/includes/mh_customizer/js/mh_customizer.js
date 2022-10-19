(function($){
	$(document).ready(function() {

        $.wp.wpColorPicker.prototype.options = {
            width: 275,
            mode: 'hsv',
			palettes: mh_customizer_settigs.default_color_scheme.split( '|' )
	   };

	});
})(jQuery);