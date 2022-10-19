(function($){
	$(document).ready(function() {
		var $page_temps          = $('#page_template');

		$('.color-picker-hex').wpColorPicker({   
            palettes: mh_admin_settigs.default_color_scheme.split( '|' )
        });
        
        $('#page_template').change(function() {
            $('#mhc_page_menu_color_settings').toggle($(this).val() == 'page-template-trans.php');
        }).change();
	});

})(jQuery);