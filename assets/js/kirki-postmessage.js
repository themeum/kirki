jQuery(document).ready(function($) { "use strict";
	var controls = wp.customize.settings.controls;
	// Loop controls
	for ( var control in controls ) {
		// Get the control object
		var control_obj = wp.customize.settings.controls[ control ];

		// if ( 'color-alpha' == control_obj.type ) {
			// Check that we have js_vars
			if ( 0 < control_obj.js_vars.length ) {
				// Loop the js_vars
				for ( var i in control_obj.js_vars ) {
					if ( control_obj.js_vars.hasOwnProperty( i ) ) {
						// Define the vars we'll use
						var element  = control_obj.js_vars[ i ]['element'];
						var property = control_obj.js_vars[ i ]['property'];
						// apply the CSS changes
						wp.customize( control_obj.id, function( value ) {
							value.bind( function( newval ) {
								jQuery( element ).css( property, newval );
							});
						});
					}
				}
			}
		// }
	}
});
