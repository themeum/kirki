/* global kirkiPresetControls */
( function() {
	function initPreset() {
		_.each( kirkiPresetControls, function( children, parentControl ) {
			wp.customize( parentControl, function( value ) {
				value.bind( function( to ) {
					_.each( children, function( preset, valueToListen ) {
						if ( valueToListen === to ) {
							_.each( preset.settings, function( controlValue, controlID ) {
								wp.customize( controlID ).set( controlValue );
							} );
						}
					} );
				} );
			} );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initPreset );
	} else {
		initPreset();
	}
} )();
