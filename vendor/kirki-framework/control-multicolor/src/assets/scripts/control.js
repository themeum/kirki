/* global kirkiControlLoader */
wp.customize.controlConstructor['kirki-multicolor'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control = this,
			colors  = control.params.choices,
			keys    = Object.keys( colors ),
			value   = this.params.value,
			i       = 0;

		// Proxy function that handles changing the individual colors
		function kirkiMulticolorChangeHandler( control, value, subSetting ) {

			var picker = control.container.find( '.multicolor-index-' + subSetting ),
				args   = {
					change: function() {

						// Color controls require a small delay.
						setTimeout( function() {
							if ( ! control.setting._value || ! control.setting._value[ subSetting ] || control.setting._value[ subSetting ] !== picker.val() ) {

								// Set the value.
								control.saveValue( subSetting, picker.val() );

								// Trigger the change.
								control.container.find( '.multicolor-index-' + subSetting ).trigger( 'change' );
							}
						}, 50 );
					}
				};

			if ( _.isObject( colors.irisArgs ) ) {
				_.each( colors.irisArgs, function( irisValue, irisKey ) {
					args[ irisKey ] = irisValue;
				} );
			}

			// Did we change the value?
			picker.wpColorPicker( args );
		}

		// Colors loop
		while ( i < Object.keys( colors ).length ) {
			kirkiMulticolorChangeHandler( this, value, keys[ i ] );
			i++;
		}
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			input   = control.container.find( '.multicolor-hidden-value' ),
			val     = control.setting._value;

		val[ property ] = value;

		jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );
		control.setting.set( val );
	}
} );
