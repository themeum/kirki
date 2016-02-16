jQuery(document).ready(function($) { "use strict";
	if ( '' != kirkiBranding.logoImage ) {
		jQuery( "div#customize-info .preview-notice" ).replaceWith( '<img src="' + kirkiBranding.logoImage + '">' );
	}
	if ( '' != kirkiBranding.description ) {
		jQuery( "div#customize-info .accordion-section-content" ).replaceWith( '<div class="accordion-section-content"><div class="theme-description">' + kirkiBranding.description + '</div></div>' );
	}
});
