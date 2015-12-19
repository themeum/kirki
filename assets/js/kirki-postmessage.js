jQuery(document).ready(function($) {
	"use strict";

	var api = parent.wp.customize;
	var controls = api.settings.controls;
	// Loop controls
	for ( var control in controls ) {
		// Get the control object
		var control_obj = api.settings.controls[ control ];

		// Check that we have js_vars
		if ( undefined !== control_obj.js_vars ) {
			if ( 0 < control_obj.js_vars.length ) {
				// Loop the js_vars
				for ( var i in control_obj.js_vars ) {
					if ( control_obj.js_vars.hasOwnProperty( i ) ) {
						// Make sure everything is properly defined.
						if ( undefined === control_obj.js_vars[ i ]["element"] ) {
							control_obj.js_vars[ i ]["element"] = "";
						}
						if ( undefined === control_obj.js_vars[ i ]["property"] ) {
							control_obj.js_vars[ i ]["property"] = "";
						}
						if ( undefined === control_obj.js_vars[ i ]["prefix"] ) {
							control_obj.js_vars[ i ]["prefix"] = "";
						}
						if ( undefined === control_obj.js_vars[ i ]["suffix"] ) {
							control_obj.js_vars[ i ]["suffix"] = "";
						}
						if ( undefined === control_obj.js_vars[ i ]["units"] ) {
							control_obj.js_vars[ i ]["units"] = "";
						}
						if ( undefined === control_obj.js_vars[ i ]["function"] ) {
							control_obj.js_vars[ i ]["function"] = "css";
						}
						// apply the changes only if element is not empty
						if ( "" != control_obj.js_vars[ i ]["element"] ) {
							wp.customize( control_obj.id, function( value ) {
								value.bind( function( newval ) {
									Kirki_PostMessage_calc(
										control_obj.id,
										control_obj.js_vars[ i ]["function"],
										control_obj.js_vars[ i ]["element"],
										control_obj.js_vars[ i ]["property"],
										control_obj.js_vars[ i ]["prefix"],
										newval,
										control_obj.js_vars[ i ]["units"],
										control_obj.js_vars[ i ]["suffix"]
									);
								});
							});
						}
					}
				}
			}
		}
	}
});

function Kirki_PostMessage_calc( id, functionName, element, property, prefix, newval, units, suffix  ) {
	if ( "css" === functionName ) {
		jQuery( element ).css( property, prefix + newval + units + suffix );
	} else if ( "html" === functionName ) {
		jQuery( element ).html( prefix + newval + units + suffix );
	} else if ( "style" === functionName ) {
		if ( ! jQuery( "#kirki-style-" + id ).size() ) {
			jQuery( "head" ).append( '<style id="#kirki-style-' + id + '"></style>' );
		}
		if ( newval !== "" ) {
			jQuery( "#kirki-style-" + id ).text( element + "{" + property + ":" + prefix + newval + units + suffix + ";}" );
		} else {
			jQuery( "#kirki-style-" + id ).text( "" );
		}
	}
}
