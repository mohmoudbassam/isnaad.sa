(function($){
	$(document).ready(function() {
        
        $( '.mh_customizer_reset_slider' ).click( function () {
			var $this_input = $( this ).closest( 'label' ).find( 'input' ),
				input_name = $this_input.data( 'customize-setting-link' ),
				input_default = $this_input.data( 'reset_value' );

			$this_input.val( input_default );
			$this_input.change();
		});
        
        
        $( 'input[type=range]' ).on( 'mousedown', function() {
            var $range = $(this),
                $range_input = $range.parent().children( '.mh-customizer-range-input' );

            value = $( this ).attr( 'value' );
            $range_input.val( value );

            $( this ).mousemove(function() {
                value = $( this ).attr( 'value' );
                $range_input.val( value );
            });
        });

        var mh_range_input_number_timeout;
        
        function mh_autocorrect_range_input_number( input_number, timeout ) {
			$range_input = input_number,
			$range       = $range_input.parent().find('input[type="range"]'),
			value        = parseFloat( $range_input.val() ),
			reset        = parseFloat( $range.attr('data-reset_value') ),
			step         = parseFloat( $range_input.attr('step') ),
			min          = parseFloat( $range_input.attr('min') ),
			max          = parseFloat( $range_input.attr('max') );

			clearTimeout( mh_range_input_number_timeout );

			mh_range_input_number_timeout = setTimeout( function() {
				if ( isNaN( value ) ) {
					$range_input.val( reset );
					$range.val( reset ).trigger( 'change' );
					return;
				}

				if ( step >= 1 && value % 1 !== 0 ) {
					value = Math.round( value );
					$range_input.val( value );
					$range.val( value );
				}

				if ( value > max ) {
					$range_input.val( max );
					$range.val( max ).trigger( 'change' );
				}

				if ( value < min ) {
					$range_input.val( min );
					$range.val( min ).trigger( 'change' );
				}
			}, timeout );

			$range.val( value ).trigger( 'change' );
		}

		$('input.mh-customizer-range-input').on( 'change keyup', function() {
			mh_autocorrect_range_input_number( $(this), 1000 );
		}).on( 'focusout', function() {
			mh_autocorrect_range_input_number( $(this), 0 );
		});
        
	});

})(jQuery);