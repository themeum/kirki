function kirkiArrayToObject( arr ) {
	var obj = {};
	if ( null !== arr ) {
		for ( var i = 0; i < arr.length; ++i ) {
			if ( undefined !== arr[ i ] ) {
				obj[ i ] = arr[ i ];
			}
		}
	}
	return obj;
}

function kirkiObjectToArray( obj ) {
	var arr = [];
	if ( null !== obj ) {
		for ( var i = 0; i < obj.length; ++i ) {
			if ( undefined !== obj[ i ] ) {
				arr.push( obj[ i ] );
			}
		}
	}
	return arr;
}

function kirkiValidateCSSValue( value ) {
	// 0 is always a valid value
	if ( '0' == value ) {
		return true;
	}
	// if we're using calc() just return true.
	if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
		return true;
	}

	var validUnits   = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'];
	// Get the numeric value
	var numericValue = parseFloat( value );
	// Get the unit
	var unit = value.replace( numericValue, '' );
	// Check the validity of the numeric value
	if ( NaN === numericValue ) {
		return false;
	}
	// Check the validity of the units
	if ( -1 === jQuery.inArray( unit, validUnits ) ) {
		return false;
	}
	return true;
}

function kirkiSetValue( setting, value ) {
	/**
	 * Get the control of the sub-setting.
	 * This will be used to get properties we need from that control,
	 * and determine if we need to do any further work based on those.
	 */
	var sub_control = wp.customize.settings.controls[ setting ];
	/**
	 * Check if the control we want to affect actually exists.
	 * If not then skip the item,
	 */
	if ( typeof sub_control === undefined ) {
		return true;
	}

	/**
	 * Get the control-type of this sub-setting.
	 * We want the value to live-update on the controls themselves,
	 * so depending on the control's type we'll need to do different things.
	 */
	var control_type = sub_control['type'];

	/**
	 * Below we're starting to check the control tyype and depending on what that is,
	 * make the necessary adjustments to it.
	 */

	/**
	 * Control types:
	 *     checkbox
	 *     switch
	 *     toggle
	 *     kirki-checkbox
	 */
	if ( 'checkbox' == control_type || 'switch' == control_type || 'toggle' == control_type || 'kirki-checkbox' == control_type ) {

		if ( 1 == value ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "checked", true );
			// Update the value in the customizer object
			wp.customize.instance( setting ).set( true );
		} else {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "checked", false );
			// Update the value in the customizer object
			wp.customize.instance( setting ).set( false );
		}

	}
	/**
	 * Control types:
	 *     select
	 *     select2
	 *     select2-multiple
	 *     kirki-select
	 */
	else if ( 'select' == control_type || 'select2' == control_type || 'select2-multiple' == control_type || 'kirki-select' == control_type || 'preset' == control_type ) {

		// Update the value visually in the control
		var $select = jQuery( wp.customize.control( setting ).container.find( 'select' ) ).selectize();
		var selectize = $select[0].selectize;
		selectize.setValue( value, true );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     slider
	 */
	else if ( 'slider' == control_type ) {

		// Update the value visually in the control (slider)
		jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "value", value );
		// Update the value visually in the control (number)
		jQuery( wp.customize.control( setting ).container.find( '.kirki_range_value .value' ) ).html( value );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     textarea
	 *     kirki-textarea
	 */
	else if ( 'textarea' == control_type || 'kirki-textarea' == control_type ) {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'textarea' ) ).prop( "value", value );
		// Update the value in the customizer object
		wp.customize( setting ).set( value );

	}
	/**
	 * Control types:
	 *     color
	 *     kirki-color
	 *     color-alpha
	 */
	else if ( 'color-alpha' == control_type || 'kirki-color' == control_type || 'color' == control_type ) {

		// Update the value visually in the control
		var alphaColorControl = wp.customize.control( setting ).container.find( '.kirki-color-control' );

		alphaColorControl
			.attr( 'data-default-color', value )
			.data( 'default-color', value )
			.wpColorPicker( 'color', value );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     multicheck
	 */
	else if ( 'multicheck' == control_type ) {

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
			jQuery( this ).prop( "checked", false );
		});

		for	( index = 0; index < value.length; index++ ) {
			jQuery( wp.customize.control( setting ).container.find( 'input[value="' + value[ index ] + '"]' ) ).prop( "checked", true );
		}

	}
	/**
	 * Control types:
	 *     radio-buttonset
	 *     radio-image
	 *     radio
	 *     kirki-radio
	 *     dashicons
	 *     color-pallette
	 *     palette
	 */
	else if ( 'radio-buttonset' == control_type || 'radio-image' == control_type || 'radio' == control_type || 'kirki-radio' == control_type || 'dashicons' == control_type || 'color-palette' == control_type || 'palette' == control_type ) {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'input[value="' + value + '"]' ) ).prop( "checked", true );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     typography
	 */
	else if ( 'typography' == control_type ) {
		if ( undefined !== value['font-family'] ) {
			var $select = jQuery( wp.customize.control( setting ).container.find( '.font-family select' ) ).selectize();
			var selectize = $select[0].selectize;
			// Update the value visually in the control
			selectize.setValue( value['font-family'], true );
		}
		if ( undefined !== value['variant'] ) {
			var $select = jQuery( wp.customize.control( setting ).container.find( '.variant select' ) ).selectize();
			var selectize = $select[0].selectize;
			// Update the value visually in the control
			selectize.setValue( value['variant'], true );
		}
		if ( undefined !== value['subset'] ) {
			var $select = jQuery( wp.customize.control( setting ).container.find( '.subset select' ) ).selectize();
			var selectize = $select[0].selectize;
			// Update the value visually in the control
			selectize.setValue( value['subset'], true );
		}
		if ( undefined !== value['font-size'] ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.font-size input' ) ).prop( "value", value['font-size'] );
		}
		if ( undefined !== value['line-height'] ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.line-height input' ) ).prop( "value", value['line-height'] );
		}
		if ( undefined !== value['letter-spacing'] ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.letter-spacing input' ) ).prop( "value", value['letter-spacing'] );
		}
		if ( undefined !== value['color'] ) {
			// Update the value visually in the control
			var typographyColor = wp.customize.control( setting ).container.find( '.kirki-color-control' );

			typographyColor
				.attr( 'data-default-color', value )
				.data( 'default-color', value )
				.wpColorPicker( 'color', value );
		}
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );
	}
	/**
	 * Control types:
	 *     repeater
	 */
	else if ( 'repeater' == control_type ) {
		// Do nothing
	}
	/**
	 * Fallback for all other controls.
	 */
	else {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "value", value );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}

}
