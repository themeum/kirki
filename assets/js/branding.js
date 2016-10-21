jQuery( document ).ready( function() {

	'use strict';

	if ( '' !== xtkirkiBranding.logoImage ) {
		jQuery( 'div#customize-info .preview-notice' ).replaceWith( '<img src="' + xtkirkiBranding.logoImage + '">' );
	}

	if ( '' !== xtkirkiBranding.description ) {
		jQuery( 'div#customize-info > .customize-panel-description' ).replaceWith( '<div class="customize-panel-description">' + xtkirkiBranding.description + '</div>' );
	}

});
