(function($){
	// Turn of all hrefs which point to another page
	$('body').on( 'click', 'a', function( event ){
		var href  = $(this).attr( 'href'),
			start = href.substr( 0, 1 );

		// Stop the link if it points to another URL
		if ( start !== '#' && start !== '' ) {
			event.preventDefault();

			// Display notification
			$('.link-disabled').addClass('active');
		}
	});

	// Prompt closing mechanism
	$('body').on( 'click', '.mhc_prompt_proceed', function() {
		$('.link-disabled').removeClass('active');
	});

	// Build preview screen
	MH_PageComposer_Preview = function( e ) {
		// Create form on the fly
        var $form = $('<form id="preview-data-submission" method="POST" style="display: none;"></form>'),
			value,
			data = e.data,
			msie = document.documentMode;

		// Origins should be matched
		if ( e.origin !== mhc_preview_options.preview_origin ) {
			$('.mhc-preview-loading').replaceWith( $('<h4 />', { 'style' : 'text-align: center;' } ).html( mhc_preview_options.alert_origin_not_matched ) );
			return;
		}

		// IE9 below fix. They have postMessage, but it has to be in string
		if ( typeof msie !== 'undefined' && msie < 10 ) {
			data = JSON.parse( data );
		}

		// Loop postMessage data and append it to $form
		for ( name in data ) {
			$textarea = $('<textarea />', { name : name, style : "display: none; " }).val( data[name] );
			$textarea.appendTo( $form );
		}

		$form.append( '<input type="submit" value="submit" style="display: none;" />' );

		$form.appendTo( '.container' );

		// Submit the form
		$('#preview-data-submission').submit();
	}

	// listen to data passed from composer
	window.addEventListener( 'message', MH_PageComposer_Preview, false );
    
})(jQuery)