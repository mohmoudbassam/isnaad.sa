( function( $ ) {

	"use strict";

	// Extend mhApp since it is declared by localization.
	$.extend( mhApp, {

		init: function() {
			this.tabs();
			this.listen();
		},

		listen: function() {
			var $this = this;

			$( document ).on( 'click', '[data-mh-app-modal]', function( e ) {
				e.preventDefault();

				var $button = $(this),
					$overlay = $( $button.data( 'mh-app-modal' ) );

				if ( $button.hasClass( 'mh-app-disabled' ) ) {
					return;
				}

				$overlay.addClass( 'mh-app-active' );
				$( 'body' ).addClass( 'mh-app-nbfc');

				// Wait until it has been displayed but still transitioned
				setTimeout( function() {
					var $modal = $overlay.find('.mh-app-modal'),
						modal_height = $modal.outerHeight(),
						modal_height_adjustment = 0 - ( modal_height / 2 );

					$modal.css({
						top : '50%',
						bottom : 'auto',
						marginTop : modal_height_adjustment
					});
				}, 100 );
			} );

			$( document ).on( 'click', '[data-mh-app-modal="close"], .mh-app-modal-overlay', function( e ) {
				$this.modalClose( e, this );
			} );

			// Distroy listener to make sure it is only called once.
			$this.listen = function() {};
		},

		modalClose: function( e, self ) {
			// Prevent default and propagation.
			if ( e && self ) {
				var $element = $( self );

				if ( self !== e.target ) {
					return;
				} else {
					e.preventDefault();
				}
			}

			$( '.mh-app-modal-overlay.mh-app-active' ).addClass( 'mh-app-closing' ).delay( 600 ).queue( function() {
				var $overlay = $( this );

				$overlay.removeClass( 'mh-app-active mh-app-closing' ).dequeue();
				$( 'body' ).removeClass( 'mh-app-nbfc');
				$overlay.find( '.mh-app-modal' ).removeAttr( 'style' );
			} );
		},

		modalTitle: function( text ) {
			$( '.mh-app-modal-overlay.mh-app-active .mh-app-modal-title' ).html( text );
		},

		modalContent: function( text, replace, remove, parent ) {
			var parent = parent ? parent + ' ' : '',
				$modal = $( '.mh-app-modal-overlay.mh-app-active' ),
				$content = $modal.find( parent + '.mh-app-modal-content' ),
				tempContent = parent + '.mh-app-modal-temp-content',
				contentHeight = $content.height();

			if ( replace ) {
				$content.html( text );
			} else {
				var displayTempContent = function() {
					var removeContent = function( delay ) {
						$content.delay( delay ).queue( function() {
							$modal.find( tempContent ).fadeOut( 200, function() {
								$content.fadeIn( 200 );
								$( this ).remove();
							} );
							$( this ).dequeue();
						} );
					}

					if ( true === remove ) {
						text = text + '<p><a class="mh-app-modal-remove-temp-content" href="#">' + mhApp.text.modalTempContentCheck + '</a></p>';
					}

					$content.stop().fadeOut( 200, function() {
						$( this ).before( '<div class="mh-app-modal-temp-content"><div>' + text + '</div></div>' );
						$modal.find( tempContent ).height( contentHeight ).hide().fadeIn( 200 );
						$modal.find( '.mh-app-modal-remove-temp-content' ).click( function( e ) {
							removeContent( 0 );
						} );
					} );

					if ( $.isNumeric( remove ) ) {
						removeContent( remove );
					}
				}

				if ( $modal.find( tempContent ).length > 0 ) {
					$modal.find( tempContent ).fadeOut( 200, function() {
						$( this ).remove();
						displayTempContent();
					} );
				} else {
					displayTempContent();
				}
			}
		},

		tabs: function() {
			$( '[data-mh-app-tabs]' ).tabs( {
				fx: {
					opacity: 'toggle',
					duration:'fast'
				},
				selected: 0,
				beforeActivate: function( event, ui ) {
					ui.newPanel.addClass( 'mh-app-tabs-transition' );
				}
			} );
		},

	} );

	$( document ).ready( function() {
		mhApp.init();
	});

} )( jQuery );