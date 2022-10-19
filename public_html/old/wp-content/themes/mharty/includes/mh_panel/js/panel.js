/* <![CDATA[ */
	var clearpath = mhPanelSettings.clearpath;

	jQuery(document).ready(function($){
		var $scheme_inputs = $( '.mh_color_scheme_main_input' );

		$('#mh-panel-content,#mh-panel-content > div').tabs({
			fx: {
				opacity: 'toggle',
				duration:'fast'
			},
			selected: 0,
			activate: function( event, ui ) {
				$mhpanel = $('#mh-panel');

				if ( $mhpanel.hasClass('onload') ) {
					$mhpanel.removeClass('onload');
				}
			}
		});

		$(".box-description").click(function(){
			var descheading = $(this).html();
			var desctext = $(this).next(".box-descr").html();

			$('body').append("<div id='custom-lbox'><div class='box-desc'><div class='box-desc-top'>"+ descheading+"</div><div class='box-desc-content'>"+desctext+"<div class='lightboxclose'></div> </div> <div class='box-desc-bottom'></div>	</div></div>");

			mhc_center_modal( $( '.box-desc' ) );

			$( '.lightboxclose' ).click( function() {
				mhc_close_modal( $( '#custom-lbox' ) );
			});
		});

		$(".mh-app-defaults-button.mh-panel-reset").click(function(e) {
			e.preventDefault();
			$(".reset-popup-overlay, .defaults-hover").addClass('active');

			mhc_center_modal( $( '.defaults-hover' ) );
		});

		$( '.no' ).click( function() {
			mhc_close_modal( $( '.reset-popup-overlay' ), 'no_remove' );

			//clean the modal classes when animation complete
			setTimeout( function() {
				$( '.reset-popup-overlay, .defaults-hover' ).removeClass( 'active mhc_modal_closing' );
			}, 600 );
		});

		// ":not([safari])" is desirable but not necessary selector
		// ":not([safari])" is desirable but not necessary selector
		$('#mh-panel input:checkbox:not([safari]):not(.switch_button)').checkbox();
		$('#mh-panel input[safari]:checkbox:not(.switch_button)').checkbox({cls:'jquery-safari-checkbox'});
		$('#mh-panel input:radio:not(.switch_button)').checkbox();

		// Yes - No button UI
		$('.switch_button').each(function() {
			$checkbox = $(this),
			value     = $checkbox.is(':checked'),
			state     = value ? 'mhc_on_state' : 'mhc_off_state',
			$template = $($('#mh-panel-yes-no-button-template').html()).find('.mhc_switch_button').addClass(state);

			$checkbox.hide().after($template);
		});

		$('.box-content').on( 'click', '.mhc_switch_button', function(e){
			e.preventDefault();

			var $click_area = $(this),
				$box_content = $click_area.parents('.box-content'),
				$checkbox    = $box_content.find('input[type="checkbox"]'),
				$state       = $box_content.find('.mhc_switch_button');

			$state.toggleClass('mhc_on_state mhc_off_state');

			if ( $checkbox.is(':checked' ) ) {
				$checkbox.prop('checked', false);
			} else {
				$checkbox.prop('checked', true);
			}

		});

		var $save_message = $("#mh-panel-ajax-saving");

		$('#mh-panel-save-top').click(function(e){
			e.preventDefault();

			$('#mh-panel-save').trigger('click');
		})

		$('#mh-panel-save').click(function(){
			mh_panel_save( false, true );
			return false;
		});

		function mh_panel_save( callback, message ) {
			var options_fromform = $('#main_options_form').formSerialize(),
				add_nonce = '&_ajax_nonce='+mhPanelSettings.mh_panel_nonce;

			options_fromform += add_nonce;

			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: options_fromform,
				beforeSend: function ( xhr ){
					if ( message ) {
						$save_message.removeAttr('class').fadeIn('fast');
					}
				},
				success: function(response){
					if ( message ) {
						$save_message.addClass('success-animation');

						setTimeout(function(){
							$save_message.fadeOut();
						},500);
					}

					if ( $.isFunction( callback ) ) {
						callback();
					}
				}
			});
		}

		function mhc_close_modal( $overlay, no_overlay_remove ) {
			var $modal_container = $overlay;

			// add class to apply the closing animation to modal
			$modal_container.addClass( 'mhc_modal_closing' );

			//remove the modal with overlay when animation complete
			setTimeout( function() {
				if ( 'no_remove' !== no_overlay_remove ) {
					$modal_container.remove();
				}
			}, 600 );
		}

		if ( $scheme_inputs.length ) {
			$scheme_inputs.each( function() {
				var	$this_input                    = $( this ),
					$scheme_wrapper               = $this_input.closest( '.box-content' ),
					$colorscheme_colorpickers     = $scheme_wrapper.find( '.input-colorscheme-colorpicker' ),
					colorscheme_colorpicker_index = 0,
					saved_scheme                  = $this_input.val().split('|');

				$colorscheme_colorpickers.each( function(){
					var $colorscheme_colorpicker      = $(this),
						colorscheme_colorpicker_color = saved_scheme[ colorscheme_colorpicker_index ];

					$colorscheme_colorpicker.val( colorscheme_colorpicker_color ).wpColorPicker({
						hide : false,
						default : $(this).data( 'default-color' ),
						width: 313,
						palettes : false,
						change : function( event, ui ) {
							var $input     = $(this),
								data_index = $input.attr( 'data-index'),
								$preview   = $scheme_wrapper.find( '.colorscheme-item-' + data_index ),
								color      = ui.color.toString();

							$input.val( color );
							$preview.css({ 'backgroundColor' : color });
							saved_scheme[ data_index - 1 ] = color;
							$this_input.val( saved_scheme.join( '|' ) );
						}
					});

					$colorscheme_colorpicker.trigger( 'change' );

					colorscheme_colorpicker_index++;
				} );

				$scheme_wrapper.on( 'click', '.colorscheme-item', function(e){
					e.preventDefault();

					var $colorscheme_item = $(this),
						data_index         = $colorscheme_item.attr('data-index');

					// Hide other colorscheme colorpicker
					$scheme_wrapper.find( '.colorscheme-colorpicker' ).removeClass( 'active' );

					// Display selected colorscheme colorpicker
					$scheme_wrapper.find( '.colorscheme-colorpicker[data-index="' + data_index + '"]' ).addClass( 'active' );
				});
			});
		}

		function mhc_center_modal( $modal ) {
			var modal_height = $modal.outerHeight(),
				modal_height_adjustment = 0 - ( modal_height / 2 );

			$modal.css({
				top : '50%',
				bottom : 'auto',
				marginTop : modal_height_adjustment
			});
		}
	});
/* ]]> */