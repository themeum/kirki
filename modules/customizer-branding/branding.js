/* global kirkiBranding */
jQuery( document ).ready( function() {

	'use strict';

	if ( '' !== kirkiBranding.logoImage ) {
		jQuery( 'div#customize-info .preview-notice' ).replaceWith( '<img src="' + kirkiBranding.logoImage + '">' );
	}

	if ( '' !== kirkiBranding.description ) {
		jQuery( 'div#customize-info > .customize-panel-description' ).replaceWith( '<div class="customize-panel-description">' + kirkiBranding.description + '</div>' );
	}

});
