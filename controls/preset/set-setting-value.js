function kirkiSetSettingValue( setting, value ) {
	/**
	 * Get the control of the sub-setting.
	 * This will be used to get properties we need from that control,
	 * and determine if we need to do any further work based on those.
	 */
	var subControl = wp.customize.settings.controls[ setting ],
	    $select,
	    controlType,
	    alphaColorControl,
	    typographyColor;
	/**
	 * Check if the control we want to affect actually exists.
	 * If not then skip the item,
	 */
	if ( _.isUndefined( subControl ) ) {
		return true;
	}

	/**
	 * Get the control-type of this sub-setting.
	 * We want the value to live-update on the controls themselves,
	 * so depending on the control's type we'll need to do different things.
	 */
	controlType = subControl.type;

	/**
	 * Below we're starting to check the control tyype and depending on what that is,
	 * make the necessary adjustments to it.
	 */
	switch ( controlType ) {

		case 'kirki-background':
			if ( ! _.isUndefined( value['background-color'] ) ) {
				wp.customize.control( setting ).container.find( '.kirki-color-control' ).wpColorPicker( 'color', value['background-color'] );
			}
			wp.customize.control( setting ).container.find( '.placeholder, .thumbnail' ).removeClass().addClass( 'placeholder' ).html( 'No file selected' );

			// Update the value in the customizer object
			wp.customize.instance( setting ).set({});
			setTimeout( function() {
				wp.customize.instance( setting ).set( value );
			}, 100 );
			break;

		case 'checkbox':
		case 'kirki-switch':
		case 'kirki-toggle':
			if ( 1 === value || '1' === value || true === value ) {

				// Update the value visually in the control
				jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( 'checked', true );

				// Update the value in the customizer object
				wp.customize.instance( setting ).set( true );
			} else {

				// Update the value visually in the control
				jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( 'checked', false );

				// Update the value in the customizer object
				wp.customize.instance( setting ).set( false );

			}
			break;

		case 'kirki-select':
		case 'kirki-preset':
		case 'kirki-fontawesome':

			// Update the value visually in the control
			$select   = jQuery( wp.customize.control( setting ).container.find( 'select' ) ).select2().val( value );

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );
			break;

		case 'kirki-slider':

			// Update the value visually in the control (slider)
			jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( 'value', value );

			// Update the value visually in the control (number)
			jQuery( wp.customize.control( setting ).container.find( '.kirki_range_value .value' ) ).html( value );

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );
			break;

		case 'kirki-generic':
			if ( ! _.isUndefined( subControl.choices ) && ! _.isUndefined( subControl.choices.element ) && 'textarea' === subControl.choices.element ) {

				// Update the value visually in the control
				jQuery( wp.customize.control( setting ).container.find( 'textarea' ) ).prop( 'value', value );

				// Update the value in the customizer object
				wp.customize( setting ).set( value );
			}
			break;

		case 'kirki-color':

			// Update the value visually in the control
			alphaColorControl = wp.customize.control( setting ).container.find( '.kirki-color-control' );

			alphaColorControl
				.attr( 'data-default-color', value )
				.data( 'default-color', value )
				.wpColorPicker( 'color', value );

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );
			break;

		case 'kirki-multicheck':

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );

			/**
			 * Update the value visually in the control.
			 * This value is an array so we'll have to go through each one of the items
			 * in order to properly apply the value and check each checkbox separately.
			 *
			 * First we uncheck ALL checkboxes in the control
			 * Then we check the ones that we want.
			 */
			wp.customize.control( setting ).container.find( 'input' ).each(function() {
				jQuery( this ).prop( 'checked', false );
			});

			_.each( value, function( subValue, i ) {
				jQuery( wp.customize.control( setting ).container.find( 'input[value="' + value[ i ] + '"]' ) ).prop( 'checked', true );
			});
			break;

		case 'kirki-radio-buttonset':
		case 'kirki-radio-image':
		case 'kirki-radio':
		case 'kirki-dashicons':
		case 'kirki-color-palette':
		case 'kirki-palette':

			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( 'input[value="' + value + '"]' ) ).prop( 'checked', true );

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );
			break;

		case 'kirki-typography':

			if ( ! _.isUndefined( value['font-family'] ) ) {
				$select = jQuery( wp.customize.control( setting ).container.find( '.font-family select' ) ).select2().val( value['font-family'] );
			}

			if ( ! _.isUndefined( value.variant ) ) {
				$select = jQuery( wp.customize.control( setting ).container.find( '.variant select' ) ).select2().val( value.variant );
			}

			if ( ! _.isUndefined( value.subsets ) ) {
				$select = jQuery( wp.customize.control( setting ).container.find( '.subset select' ) ).select2().val( value.subset );
			}

			if ( ! _.isUndefined( value['font-size'] ) ) {
				jQuery( wp.customize.control( setting ).container.find( '.font-size input' ) ).prop( 'value', value['font-size'] );
			}

			if ( ! _.isUndefined( value['line-height'] ) ) {
				jQuery( wp.customize.control( setting ).container.find( '.line-height input' ) ).prop( 'value', value['line-height'] );
			}

			if ( ! _.isUndefined( value['letter-spacing'] ) ) {
				jQuery( wp.customize.control( setting ).container.find( '.letter-spacing input' ) ).prop( 'value', value['letter-spacing'] );
			}

			if ( ! _.isUndefined( value['word-spacing'] ) ) {
				jQuery( wp.customize.control( setting ).container.find( '.word-spacing input' ) ).prop( 'value', value['word-spacing'] );
			}

			if ( ! _.isUndefined( value.color ) ) {
				typographyColor = wp.customize.control( setting ).container.find( '.kirki-color-control' );

				typographyColor
					.attr( 'data-default-color', value )
					.data( 'default-color', value )
					.wpColorPicker( 'color', value );
			}

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );
			break;

		case 'kirki-dimensions':

			_.each( value, function( subValue, id ) {
				jQuery( wp.customize.control( setting ).container.find( '.' + id + ' input' ) ).prop( 'value', subValue );
			} );

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );
			break;

		case 'kirki-repeater':

			// Not yet implemented.
			break;

		default:
			/**
			 * Fallback for all other controls.
			 */

			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( 'value', value );

			// Update the value in the customizer object
			wp.customize.instance( setting ).set( value );
			break;

	}
}
