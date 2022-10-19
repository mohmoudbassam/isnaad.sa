(function($){
	$( document ).ready( function() {
		var $container             = $( '.mhc_roles_options_container' ),
			$switch_button_wrapper = $container.find( '.mhc_switch_button_wrapper' ),
			$switch_button         = $container.find( '.mhc_switch_button' ),
			$switch_select         = $container.find( 'select' ),
			$body                  = $( 'body' );

		$switch_button_wrapper.each( function() {
			var $this_el = $( this ),
				$this_switcher = $this_el.find( '.mhc_switch_button' ),
				selected_value = $this_el.find( 'select' ).val();

			if ( 'on' === selected_value ) {
				$this_switcher.removeClass( 'mhc_off_state' );
				$this_switcher.addClass( 'mhc_on_state' );
			} else {
				$this_switcher.removeClass( 'mhc_on_state' );
				$this_switcher.addClass( 'mhc_off_state' );
			}
		});

		$switch_button.click( function() {
			var $this_el = $( this ),
				$this_select = $this_el.closest( '.mhc_switch_button_wrapper' ).find( 'select' );

			if ( $this_el.hasClass( 'mhc_off_state') ) {
				$this_el.removeClass( 'mhc_off_state' );
				$this_el.addClass( 'mhc_on_state' );
				$this_select.val( 'on' );
			} else {
				$this_el.removeClass( 'mhc_on_state' );
				$this_el.addClass( 'mhc_off_state' );
				$this_select.val( 'off' );
			}

			$this_select.trigger( 'change' );
		});

		$switch_select.change( function() {
			var $this_el = $( this ),
				$this_switcher = $this_el.closest( '.mhc_switch_button_wrapper' ).find( '.mhc_switch_button' ),
				new_value = $this_el.val();

			if ( 'on' === new_value ) {
				$this_switcher.removeClass( 'mhc_off_state' );
				$this_switcher.addClass( 'mhc_on_state' );
			} else {
				$this_switcher.removeClass( 'mhc_on_state' );
				$this_switcher.addClass( 'mhc_off_state' );
			}

		});

		$( '.mhc-layout-buttons:not(.mhc-layout-buttons-reset)' ).click( function() {
			var $clicked_tab = $( this ),
				open_tab = $clicked_tab.data( 'open_tab' );

			$( '.mhc_roles_options_container.active-container' ).css( { 'display' : 'block', 'opacity' : 1 } ).stop( true, true ).animate( { opacity : 0 }, 300, function() {
				var $this_container = $( this );
				$this_container.css( 'display', 'none' );
				$this_container.removeClass( 'active-container' );
				$( '.' + open_tab ).addClass( 'active-container' ).css( { 'display' : 'block', 'opacity' : 0 } ).stop( true, true ).animate( { opacity : 1 }, 300 );
			});

			$( '.mhc-layout-buttons' ).removeClass( 'mhc_roles_active_menu' );

			$clicked_tab.addClass( 'mhc_roles_active_menu' );
		});

		$( '#mhc_save_roles' ).click( function() {
            mhc_save_roles( false, true );
			return false;
		} );
        
        function mhc_save_roles( callback, message ) {
			var $all_options = $( '.mhc_roles_container_all' ).find( 'form' ),
				all_options_array = {},
				options_combined = '';

			$all_options.each( function() {
				var this_form = $( this ),
					form_id = this_form.data( 'role_id' ),
					form_settings = this_form.serialize();

				all_options_array[form_id] = form_settings;
			});

			options_combined = JSON.stringify( all_options_array );

			$.ajax({
				type: 'POST',
				url: mhc_roles_options.ajaxurl,
				dataType: 'json',
				data: {
					action : 'mhc_save_role_settings',
					mhc_options_all : options_combined,
					mhc_save_roles_nonce : mhc_roles_options.mhc_roles_nonce
				},
				beforeSend: function ( xhr ){
                    if ( message ) {
                        $( '#mhc_loading_animation' ).removeClass( 'mhc_hide_loading' );
                        $( '#mhc_success_animation' ).removeClass( 'mhc_active_success' );
                        $( '#mhc_loading_animation' ).show();
                    }
				},
				success: function( data ){
                    if ( message ) {
                        $( '#mhc_loading_animation' ).addClass( 'mhc_hide_loading' );
                        $( '#mhc_success_animation' ).addClass( 'mhc_active_success' ).show();

                        setTimeout( function(){
                            $( '#mhc_success_animation' ).fadeToggle();
                            $( '#mhc_loading_animation' ).fadeToggle();
                        }, 1000 );
                    }
                    
                    if ( $.isFunction( callback ) ) {
						callback();
					}
				}
			});
		}

		$( '.mhc_toggle_all' ).click( function() {
			var $options_section = $( this ).closest( '.mhc_roles_section_container' ),
				$toggles = $options_section.find( '.mhc-main-setting' ),
				on_buttons_count = 0,
				off_buttons_count = 0;

			$toggles.each( function() {
				if ( 'on' === $( this ).val() ) {
					on_buttons_count++;
				} else {
					off_buttons_count++;
				}
			});

			if ( on_buttons_count >= off_buttons_count ) {
				$toggles.val( 'off' );
			} else {
				$toggles.val( 'on' );
			}

			$toggles.change();
		});

		$( '.mhc-layout-buttons-reset' ).click( function() {
			var $confirm_modal =
				"<div class='mhc_modal_overlay' data-action='reset_roles'>\
					<div class='mhc_prompt_modal'>\
					<h3>" + mhc_roles_options.modal_title + "</h3>\
					<p>" + mhc_roles_options.modal_message + "</p>\
						<a href='#' class='mhc_prompt_dont_proceed mhc-modal-close'>\
							<span>" + mhc_roles_options.modal_no + "<span>\
						</span></span></a>\
						<div class='mhc_prompt_buttons'>\
							<a href='#' class='mhc_prompt_proceed'>" + mhc_roles_options.modal_yes + "</a>\
						</div>\
					</div>\
				</div>";

			$( 'body' ).append( $confirm_modal );
			window.mhc_align_vertical_modal( $( '.mhc_prompt_modal' ) );

			return false;
		});

		$( 'body' ).on( 'click', '.mhc-modal-close', function() {
			mhc_close_modal( $( this ) );
		});

		$( 'body' ).on( 'click', '.mhc_prompt_proceed', function() {
			var $all_toggles = $( '.mhc-main-setting' );

			$all_toggles.val( 'on' );
			$all_toggles.change();

			mhc_close_modal( $( this ) );
		});

		$body.append( '<div id="mhc_loading_animation"></div>' );
		$body.append( '<div id="mhc_success_animation"></div>' );

		$( '#mhc_loading_animation' ).hide();
		$( '#mhc_success_animation' ).hide();
        
        function mhc_close_modal( $button ) {
			var $modal_overlay = $button.closest( '.mhc_modal_overlay' );

			// add class to apply the closing animation to modal
			$modal_overlay.addClass( 'mhc_modal_closing' );

			//remove the modal with overlay when animation complete
			setTimeout( function() {
				$modal_overlay.remove();
			}, 600 );
		}
		// (impoexpo)
//		mhApp.impoexpo.save = function( callback ) {
//			mhc_save_roles( callback, false );
//		}
	});
})(jQuery)