jQuery(document).ready(function($) { "use strict";

	var settings = window._wpCustomizeSettings;

	jQuery.each( settings.values, function( key, value ) {
	} );
});

function KirkiPostMessage( js_vars, newval ) {
	if ( undefined !== js_vars && 0 < js_vars.length ) {
		jQuery.each( js_vars, function( i, js_var ) {

			// Make sure everything is properly defined.
			if ( undefined === js_vars[ i ]["element"] ) {
				js_vars[ i ]["element"] = "";
			}
			if ( undefined === js_vars[ i ]["property"] ) {
				js_vars[ i ]["property"] = "";
			}
			if ( undefined === js_vars[ i ]["prefix"] ) {
				js_vars[ i ]["prefix"] = "";
			}
			if ( undefined === js_vars[ i ]["suffix"] ) {
				js_vars[ i ]["suffix"] = "";
			}
			if ( undefined === js_vars[ i ]["units"] ) {
				js_vars[ i ]["units"] = "";
			}
			if ( undefined === js_vars[ i ]["function"] ) {
				js_vars[ i ]["function"] = "css";
			}

			jQuery.each( js_vars, function( i, args ) {
				if ( "css" === args.functionName ) {
					jQuery( args.element ).css( args.property, args.prefix + newval + args.units + args.suffix );
				} else if ( "html" === args.functionName ) {
					jQuery( args.element ).html( args.prefix + newval + args.units + args.suffix );
				} else if ( "style" === args.functionName ) {
					if ( ! jQuery( "#kirki-style-" + args.id ).size() ) {
						jQuery( "head" ).append( '<style id="#kirki-style-' + args.id + '"></style>' );
					}
					if ( newval !== "" ) {
						jQuery( "#kirki-style-" + args.id ).text( args.element + "{" + args.property + ":" + args.prefix + args.newval + args.units + args.suffix + ";}" );
					} else {
						jQuery( "#kirki-style-" + args.id ).text( "" );
					}
				}
			});
		});
	}
}
