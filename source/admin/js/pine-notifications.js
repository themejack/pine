( function( $ ) {
	'use strict';

	$( document )
		.on( 'click', '.notice.is-dismissible.pine-notice .notice-dismiss', function() {
			$.ajax( {
				method: 'POST',
				url: ajaxurl,
				data: {
					action: 'pine_notification_dismiss',
				},
				dataType: 'json',
				global: false,
			} );
		} );
}( jQuery ) );
