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
	if ( 'undefined' === typeof subControl ) {
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

	if ( 'checkbox' === controlType || 'kirki-switch' === controlType || 'kirki-toggle' === controlType ) {

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

	} else if ( 'kirki-select' === controlType || 'kirki-preset' === controlType ) {

		// Update the value visually in the control
		$select = jQuery( wp.customize.control( setting ).container.find( 'select' ) ).select2().val( value );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	} else if ( 'kirki-slider' === controlType ) {

		// Update the value visually in the control (slider)
		jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( 'value', value );

		// Update the value visually in the control (number)
		jQuery( wp.customize.control( setting ).container.find( '.kirki_range_value .value' ) ).html( value );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	} else if ( 'kirki-generic' === controlType && 'undefined' !== typeof subControl.choices && 'undefined' !== typeof subControl.choices.element && 'textarea' === subControl.choices.element ) {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'textarea' ) ).prop( 'value', value );

		// Update the value in the customizer object
		wp.customize( setting ).set( value );

	} else if ( 'kirki-color' === controlType ) {

		// Update the value visually in the control
		alphaColorControl = wp.customize.control( setting ).container.find( '.kirki-color-control' );

		alphaColorControl
			.attr( 'data-default-color', value )
			.data( 'default-color', value )
			.wpColorPicker( 'color', value );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	} else if ( 'kirki-multicheck' === controlType ) {

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

	} else if ( 'kirki-radio-buttonset' === controlType || 'kirki-radio-image' === controlType || 'kirki-radio' === controlType || 'kirki-dashicons' === controlType || 'kirki-color-palette' === controlType || 'kirki-palette' === controlType ) {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'input[value="' + value + '"]' ) ).prop( 'checked', true );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	} else if ( 'kirki-typography' === controlType ) {

		if ( 'undefined' !== typeof value['font-family'] ) {

			$select = jQuery( wp.customize.control( setting ).container.find( '.font-family select' ) ).select2().val( value['font-family'] );

		}

		if ( 'undefined' !== typeof value.variant ) {

			$select = jQuery( wp.customize.control( setting ).container.find( '.variant select' ) ).select2().val( value.variant );

		}

		if ( 'undefined' !== typeof value.subsets ) {

			$select = jQuery( wp.customize.control( setting ).container.find( '.subset select' ) ).select2().val( value.subset );

		}

		if ( 'undefined' !== typeof value['font-size'] ) {

			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.font-size input' ) ).prop( 'value', value['font-size'] );

		}

		if ( 'undefined' !== typeof value['line-height'] ) {

			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.line-height input' ) ).prop( 'value', value['line-height'] );

		}

		if ( 'undefined' !== typeof value['letter-spacing'] ) {

			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.letter-spacing input' ) ).prop( 'value', value['letter-spacing'] );

		}

		if ( 'undefined' !== typeof value['word-spacing'] ) {

			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.word-spacing input' ) ).prop( 'value', value['word-spacing'] );

		}

		if ( 'undefined' !== typeof value.color ) {

			// Update the value visually in the control
			typographyColor = wp.customize.control( setting ).container.find( '.kirki-color-control' );

			typographyColor
				.attr( 'data-default-color', value )
				.data( 'default-color', value )
				.wpColorPicker( 'color', value );
		}

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	} else if ( 'kirki-dimensions' === controlType ) {

		_.each( value, function( subValue, id ) {
			jQuery( wp.customize.control( setting ).container.find( '.' + id + ' input' ) ).prop( 'value', subValue );
		} );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	} else if ( 'kirki-repeater' === controlType ) {

		// Do nothing
	}

	/**
	 * Fallback for all other controls.
	 */
	else {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( 'value', value );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}

}
