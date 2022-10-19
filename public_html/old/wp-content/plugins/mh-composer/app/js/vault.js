(function($){
	$( document ).ready( function() {
		var url = window.location.href,
			tab_link = url.split( 'edit.php' )[1];

		if ( typeof tab_link !== 'undefined' ) {
			var $menu_items = $( '#toplevel_page_mh_mharty_vault' ).find( '.wp-submenu li' );
			$menu_items.removeClass( 'current' );
			$menu_items.find( 'a' ).each( function() {
				var $this_el = $( this ),
					this_href = $this_el.attr( 'href' ),
					full_tab_link = 'edit.php' + tab_link;
				if ( -1 !== full_tab_link.indexOf( this_href ) ) {
					$this_el.closest( 'li' ).addClass( 'current' );
				}
			});
			$( '#toplevel_page_mh_mharty_vault' ).removeClass( 'wp-not-current-submenu' ).addClass( 'wp-has-current-submenu' );
			$( 'a.toplevel_page_mh_mharty_vault' ).removeClass( 'wp-not-current-submenu' ).addClass( 'wp-has-current-submenu wp-menu-open' );
		}

		$( 'body' ).on( 'click', '.add-new-h2, a.page-title-action', function() {
            $( 'body' ).append( mhc_vault_options.modal_output );
			return false;
		} );

		$( 'body' ).on( 'click', '.mhc_prompt_dont_proceed', function() {
			var $modal_overlay = $( this ).closest( '.mhc_modal_overlay' );

			//Model closing animation class
			$modal_overlay.addClass( 'mhc_modal_closing' );

			//remove after complete
			setTimeout( function() {
                $( 'body' ).removeClass( 'mh-app-nbfc' );
				$modal_overlay.remove();
			}, 600 );
		} );

		$( 'body' ).on( 'change', '#new_template_type', function() {
			var selected_type = $( this ).val();

			if ( 'module' === selected_type || 'fullwidth_module' === selected_type ) {
				$( '.mh_module_tabs_options' ).css( 'display', 'block' );
			} else {
				$( '.mh_module_tabs_options' ).css( 'display', 'none' );
			}
		} );

		$( 'body' ).on( 'click', '.mhc_create_template:not(.clicked_button)', function() {
			var $this_button = $( this ),
				$this_form = $this_button.closest( '.mhc_prompt_modal' ),
				template_name = $this_form.find( '#mhc_new_template_name' ).val();

			if ( '' === template_name ) {
				$this_form.find( '#mhc_new_template_name' ).focus();
			} else {
				var	template_shortcode = '',
					layout_type = $this_form.find( '#new_template_type' ).val(),
					selected_tabs = '',
					selected_cats = '',
					fields_data = [];
                
                // push all the data from inputs into array
				$this_form.find('input, select').each( function() {
					var $this_input = $( this );

					if ( typeof $this_input.attr('id') !== 'undefined' && '' !== $this_input.val()) {
						// add only values from checked checkboxes
						if ( 'checkbox' === $this_input.attr('type') && !$this_input.is( ':checked' ) ) {
							return;
						}
						fields_data.push({
							'field_id': $this_input.attr('id'),
							'field_val': $this_input.val()
						});
					}
				});

				if ( 'module' === layout_type || 'fullwidth_module' === layout_type ) {
					if ( ! $( '.mh_module_tabs_options input' ).is( ':checked' ) ) {
						$( '.mhc_error_message_save_template' ).css( "display", "block" );
						return;
					} else {
						selected_tabs = '';

						$( '.mh_module_tabs_options input' ).each( function() {
							var this_input = $( this );

							if ( this_input.is( ':checked' ) ) {
								selected_tabs += '' !== selected_tabs ? ',' + this_input.val() : this_input.val();
							}

						});

						selected_tabs = 'general,advanced,css' === selected_tabs ? 'all' : selected_tabs;
					}
				}

				if ( $( '.layout_cats_container input' ).is( ':checked' ) ) {

					$( '.layout_cats_container input' ).each( function() {
						var this_input = $( this );

						if ( this_input.is( ':checked' ) ) {
							selected_cats += '' !== selected_cats ? ',' + this_input.val() : this_input.val();
						}
					});

				}

				// add processed data into array of values
				fields_data.push(
					{
						'field_id': 'selected_tabs',
						'field_val': selected_tabs
					},
					{
						'field_id': 'selected_cats',
						'field_val': selected_cats
					}
				);

				$this_button.addClass( 'clicked_button' );
				$this_button.closest( '.mhc_prompt_buttons' ).find( '.spinner' ).addClass( 'mhc_visible_spinner' );

				$.ajax( {
					type: "POST",
					url: mhc_vault_options.ajaxurl,
					dataType: 'json',
					data:
					{
						action : 'mhc_add_new_layout',
						mh_admin_load_nonce : mhc_vault_options.mh_admin_load_nonce,
						mh_layout_options : JSON.stringify(fields_data),
					},
					success: function( data ) {
						if ( typeof data !== 'undefined' && '' !== data ) {
							window.location.href = decodeURIComponent( unescape( data.edit_link ) );
						}
                    }
				} );
			}
		} );
        
        if ( $('html').attr('lang') == 'ar' ) {
            $(".column-taxonomy-layout_type a[href*='layout']").text('تنسيق');
            $(".column-taxonomy-layout_type a[href*='module']").text('مكون');
            $(".column-taxonomy-layout_type a[href*='row']").text('صف');
            $(".column-taxonomy-layout_type a[href*='section']").text('قسم');
        } else {
            $(".column-taxonomy-layout_type a[href*='layout']").text('Layout');
             $(".column-taxonomy-layout_type a[href*='module']").text('Component');
            $(".column-taxonomy-layout_type a[href*='section']").text('Section');
            $(".column-taxonomy-layout_type a[href*='row']").text('Row');
        };
        
	});
})(jQuery)