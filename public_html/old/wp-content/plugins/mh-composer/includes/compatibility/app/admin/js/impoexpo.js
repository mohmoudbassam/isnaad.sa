( function( $ ) {

	"use strict";

	// Extend mhAppImpoExpo since it is declared by localization.
	window.mhApp.impoexpo = $.extend( mhAppImpoExpo, {

		cancelled: false,

		boot: function( $instance ) {
			var $this = this;

			$( '[data-mh-app-impoexpo]' ).each( function() {
				$this.listen( $( this ) );
			} );

			// Release unecessary cache.
			mhAppImpoExpo = null;
		},

		listen: function( $el ) {
			var $this = this;

			$el.find( '[data-mh-app-impoexpo-export]' ).click( function( e ) {
				e.preventDefault();

				if ( ! $this.actionsDisabled() ) {
					$this.disableActions();
					$this.export();
				}
			} );


			$el.find( '.mh-app-impoexpo-export-form input[type="text"]' ).on( 'keydown', function( e ) {
				if ( 13 === e.keyCode ) {
					e.preventDefault();
					$el.find( '[data-mh-app-impoexpo-export]' ).click();
				}
			} );

			// Import & Export (impoexpo) populate import.
			$el.find( '.mh-app-impoexpo-import-form input[type="file"]' ).on( 'change', function( e ) {
				$this.populateImport( $( this ).get( 0 ).files[0] );
			} );

			$el.find( '.mh-app-impoexpo-import' ).click( function( e ) {
				e.preventDefault();

				if ( ! $this.actionsDisabled() ) {
					$this.disableActions();
					$this.import();
				}
			} );

			// Trigger file window.
			$el.find( '.mh-app-impoexpo-import-form button' ).click( function( e ) {
				e.preventDefault();
				$this.instance( 'input[type="file"]' ).trigger( 'click' );
			} );

			// Cancel request.
			$el.find( '[data-mh-app-impoexpo-cancel]' ).click( function( e ) {
				e.preventDefault();
				$this.cancel();
			} )
		},

		validateImportFile: function( file ) {
			if ( undefined !== file && 'undefined' != typeof file.name  && 'undefined' != typeof file.type && 'json' == file.name.split( '.' ).slice( -1 )[0] ) {

				return true;
			}
			mhApp.modalContent( '<p>' + this.text.invalideFile + '</p>', false, 3000, '#mh-app-impoexpo-import' );

			this.enableActions();

			return false;
		},

		populateImport: function( file ) {
			if ( ! this.validateImportFile( file ) ) {
				return;
			}

			$( '.mh-app-impoexpo-import-placeholder' ).text( file.name );
		},

		import: function( noBackup ) {
			var $this = this,
				file = $this.instance( 'input[type="file"]' ).get( 0 ).files[0];

			if ( undefined === window.FormData ) {
				mhApp.modalContent( '<p>' + this.text.browserSupport + '</p>', false, 3000, '#mh-app-impoexpo-import' );

				$this.enableActions();

				return;
			}

			if ( ! $this.validateImportFile( file ) ) {
				return;
			}

			$this.addProgressBar( $this.text.importing );

			// Export Backup if set.
			if ( $this.instance( '[name="mh-app-impoexpo-import-backup"]' ).is( ':checked' ) && ! noBackup ) {
				$this.export( true );

				$( $this ).on( 'exported', function() {
					$this.import( true );
				} );

				return;
			}

			$this.ajaxAction( {
				action: 'mh_app_impoexpo_import',
				file: file,
			}, function( response ) {
				mhApp.modalContent( '<div class="mh-app-loader mh-app-loader-success"></div>', false, 3000, '#mh-app-impoexpo-import' );
				$this.toggleCancel();

				$( document ).delay( 3000 ).queue( function() {
					mhApp.modalContent( '<div class="mh-app-loader"></div>', false, false, '#mh-app-impoexpo-import' );

					$( this ).dequeue().delay( 2000 ).queue( function() {
						// Save post content for individual content.
						if ( 'undefined' !== typeof response.data.postContent ) {
							var save = $( '#save-action #save-post' );

							if ( save.length === 0 ) {
								save = $( '#publishing-action input[type="submit"]' );
							}

							if ( 'undefined' !== typeof window.tinyMCE && window.tinyMCE.get( 'content' ) && ! window.tinyMCE.get( 'content' ).isHidden() ) {
								var editor = window.tinyMCE.get( 'content' );

								editor.setContent( $.trim( response.data.postContent ), { format: 'html'  } );
							} else {
								$( '#content' ).val( $.trim( response.data.postContent ) );
							}

							save.trigger( 'click' );

							window.onbeforeunload = function() {
								$( 'body' ).fadeOut( 500 );
							}
						} else {
							$( 'body' ).fadeOut( 500, function() {
								// Remove confirmation popup before relocation.
								$( window ).unbind( 'beforeunload' );

								window.location = window.location.href;
							} )
						}
					} );
				} );
			}, true );
		},

		export: function( backup ) {
			var $this = this,
				progressBarMessages = backup ? $this.text.backuping : $this.text.exporting;

			$this.addProgressBar( progressBarMessages );

			$this.save( function() {
				var posts = {},
					content = false;

				// Include selected posts.
				if ( $this.instance( '[name="mh-app-impoexpo-posts"]' ).is( ':checked' ) ) {
					$( '#posts-filter [name="post[]"]:checked:enabled' ).each( function() {
						posts[this.id] = this.value;
					} );
				}

				// Get post layout.
				if ( 'undefined' !== typeof window.tinyMCE && window.tinyMCE.get( 'content' ) && ! window.tinyMCE.get( 'content' ).isHidden() ) {
					content = window.tinyMCE.get( 'content' ).getContent();
				} else if ( $( 'textarea#content' ).length > 0 ) {
					content = $( 'textarea#content' ).val();
				}

				if ( false !== content ) {
					content = content.replace( /^([^\[]*){1}/, '' );
					content = content.replace( /([^\]]*)$/, '' );
				}

				$this.ajaxAction( {
					action: 'mh_app_impoexpo_export',
					content: content,
					selection: $.isEmptyObject( posts ) ? false : JSON.stringify( posts ),
				}, function( response ) {
					var time = ' ' + new Date().toJSON().replace( 'T', ' ' ).replace( ':', 'h' ).substring( 0, 16 ),
						downloadURL = $this.instance( '[data-mh-app-impoexpo-export]' ).data( 'mh-app-impoexpo-export' ),
						query = {
							'timestamp': response.data.timestamp,
							'name': encodeURIComponent( $this.instance( '.mh-app-impoexpo-export-form input' ).val() + ( backup ? time : '' ) ),
						};

					$.each( query, function( key, value ) {
						if ( value ) {
							downloadURL = downloadURL + '&' + key + '=' + value;
						}
					} );

					// Remove confirmation popup before relocation.
					$( window ).unbind( 'beforeunload' );

					window.location.assign( encodeURI( downloadURL ) );

					if ( ! backup ) {
						mhApp.modalContent( '<div class="mh-app-loader mh-app-loader-success"></div>', false, 3000, '#mh-app-impoexpo-export' );
						$this.toggleCancel();
					}

					$( $this ).trigger( 'exported' );
				} );
			} );
		},

		ajaxAction: function( data, callback, fileSupport ) {
			var $this = this;

			// Reset cancelled.
			this.cancelled = false;

			data = $.extend( {
				nonce: $this.nonce,
				file: null,
				content: false,
				timestamp: 0,
				post: $( '#post_ID' ).val(),
				context: $this.instance().data( 'mh-app-impoexpo' ),
				page: 1,
			}, data );

			var	ajax = {
				type: 'POST',
				url: mhApp.ajaxurl,
				data: data,
				success: function( response ) {
					// The error is unknown but most of the time it would be cased by the server max size being exceeded.
					if ( 'string' === typeof response && '0' === response ) {
						mhApp.modalContent( '<p>' + $this.text.maxSizeExceeded + '</p>', false, true, '#' + $this.instance( '.ui-tabs-panel:visible' ).attr( 'id'  ) );

						$this.enableActions();

						return;
					}
					// Memory size set on server is exhausted.
					else if ( 'string' === typeof response && response.toLowerCase().indexOf( 'memory size' ) >= 0 ) {
						mhApp.modalContent( '<p>' + $this.text.memoryExhausted + '</p>', false, true, '#' + $this.instance( '.ui-tabs-panel:visible' ).attr( 'id'  ) );

						$this.enableActions();

						return;
					}
					// Paginate.
					else if ( 'undefined' !== typeof response.page ) {
						var progress = Math.ceil( ( response.page * 100 ) / response.total_pages );

						if ( $this.cancelled ) {
							return;
						}

						$this.toggleCancel( true );

						$this.ajaxAction( $.extend( data, {
							page: parseInt( response.page ) + 1,
							timestamp: response.timestamp,
							file: null,
						} ), callback, false );

						$this.instance( '.mh-app-progress-bar' )
							.width( progress + '%' )
							.text( progress + '%' );

						$this.instance( '.mh-app-progress-subtext span' ).text( Math.ceil( ( ( response.total_pages - response.page ) * 6 ) / 60 ) );

						return;
					} else if ( 'undefined' !== typeof response.data && 'undefined' !== typeof response.data.message ) {
						mhApp.modalContent( '<p>' + $this.text[response.data.message] + '</p>', false, 3000, '#' + $this.instance( '.ui-tabs-panel:visible' ).attr( 'id'  ) );

						$this.enableActions();

						return;
					}

					$this.instance( '.mh-app-progress' )
						.removeClass( 'mh-app-progress-striped' )
						.find( '.mh-app-progress-bar' ).width( '100%' )
						.text( '100%' )
						.delay( 1000 ).queue( function() {

							$this.enableActions();

							if ( 'undefined' === typeof response.data || ( 'undefined' !== typeof response.data && ! response.data.timestamp ) ) {
								mhApp.modalContent( '<div class="mh-app-loader mh-app-loader-fail"></div>', false, 3000, '#' + $this.instance( '.ui-tabs-panel:visible' ).attr( 'id' ) );
								return;
							}

							$( this ).dequeue();

							callback( response );
						} );
				}
			};

			if ( fileSupport ) {
				var fileSize = Math.ceil( ( data.file.size / ( 1024 * 1024 ) ).toFixed( 2 ) ),
					formData = new FormData();

				// Max size set on server is exceeded.
				if ( fileSize >= $this.postMaxSize || fileSize >= $this.uploadMaxSize ) {
					mhApp.modalContent( '<p>' + $this.text.maxSizeExceeded + '</p>', false, true, '#' + $this.instance( '.ui-tabs-panel:visible' ).attr( 'id'  ) );

					$this.enableActions();

					return;
				}

				$.each( ajax.data, function( name, value ) {
					formData.append( name, value);
				} )

				ajax = $.extend( ajax, {
					data: formData,
					processData: false,
					contentType : false,
				} );
			}

			$.ajax( ajax );
		},

		// This function should be overwritten for options impoexpo type to make sure data are saved before exporting.
		save: function( callback ) {
			if ( 'undefined' !== typeof wp && 'undefined' !== typeof wp.customize ) {
				var saveCallback = function() {
					callback();
					wp.customize.unbind( 'saved', saveCallback );
				}

				$( '#save' ).click();

				wp.customize.bind( 'saved', saveCallback );
			} else {
				// Add a slight delay for animation purposes.
				setTimeout( function() {
					callback();
				}, 1000 )
			}
		},

		addProgressBar: function( message ) {
			mhApp.modalContent( '<div class="mh-app-progress mh-app-progress-striped mh-app-active"><div class="mh-app-progress-bar" style="width: 10%;">1%</div><span class="mh-app-progress-subtext">' + message + '</span></div>', false, false, '#' + this.instance( '.ui-tabs-panel:visible' ).attr( 'id' ) );
		},

		actionsDisabled: function() {
			if ( this.instance( '.mh-app-modal-action' ).hasClass( 'mh-app-disabled' ) ) {
				return true;
			}

			return false;
		},

		disableActions: function() {
			this.instance( '.mh-app-modal-action' ).addClass( 'mh-app-disabled' );
		},

		enableActions: function() {
			this.instance( '.mh-app-modal-action' ).removeClass( 'mh-app-disabled' );
		},

		toggleCancel: function( cancel ) {
			var $target = this.instance( '.ui-tabs-panel:visible [data-mh-app-impoexpo-cancel]' );

			if ( cancel && ! $target.is( ':visible' ) ) {
				$target.show().animate( { opacity: 1 }, 600 );
			} else if ( ! cancel && $target.is( ':visible' ) ) {
				$target.animate( { opacity: 0 }, 600, function() {
					$( this ).hide();
				} );
			}
		},

		cancel: function( cancel ) {
			this.cancelled = true;

			// Remove all temp files. Set a delay as temp files might still be in the process of being added.
			setTimeout( function() {
				$.ajax( {
					type: 'POST',
					url: mhApp.ajaxurl,
					data: {
						nonce: this.nonce,
						context: this.instance().data( 'mh-app-impoexpo' ),
						action: 'mh_app_impoexpo_cancel',
					}
				} );
			}.bind( this ), 3000 );
			mhApp.modalContent( '<div class="mh-app-loader mh-app-loader-success"></div>', false, 3000, '#' + this.instance( '.ui-tabs-panel:visible' ).attr( 'id' ) );
			this.toggleCancel();
			this.enableActions();
		},

		instance: function( element ) {
			return $( '.mh-app-active[data-mh-app-impoexpo]' + ( element ? ' ' + element : '' ) );
		},

	} );

	$( document ).ready( function() {
		window.mhApp.impoexpo.boot();
	});

})( jQuery );