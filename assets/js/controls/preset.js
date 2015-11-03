/**
 * KIRKI CONTROL: PRESET
 */

wp.customize.controlConstructor['preset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = this.container.find( 'select' );

		jQuery( element ).selectize();

		this.container.on( 'change', 'select', function() {

			/**
			 * First of all we have to get the control's value
			 */
			var select_value = jQuery( this ).val();
			/**
			 * Update the value using the customizer API and trigger the "save" button
			 */
			control.setting.set( select_value );
			/**
			 * We have to get the choices of this control
			 * and then start parsing them to see what we have to do for each of the choices.
			 */
			jQuery.each( control.params.choices, function( key, value ) {
				/**
				 * If the current value of the control is the key of the choice,
				 * then we can continue processing.
				 * Otherwise there's no reason to do anything.
				 */
				if ( select_value == key ) {
					/**
					 * Each choice has an array of settings defined in it.
					 * We'll have to loop through them all and apply the changes needed to them.
					 */
					jQuery.each( value['settings'], function( preset_setting, preset_setting_value ) {
						/**
						 * Get the control of the sub-setting.
						 * This will be used to get properties we need from that control,
						 * and determine if we need to do any further work based on those.
						 */
						var sub_control = wp.customize.settings.controls[ preset_setting ];
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
						var sub_control_type = sub_control['type'];

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
						if ( 'checkbox' == sub_control_type || 'switch' == sub_control_type || 'toggle' == sub_control_type || 'kirki-checkbox' == sub_control_type ) {

							var input_element = wp.customize.control( preset_setting ).container.find( 'input' );
							if ( 1 == preset_setting_value ) {
								/**
								 * Update the value visually in the control
								 */
								jQuery( input_element ).prop( "checked", true );
								/**
								 * Update the value in the customizer object
								 */
								wp.customize.instance( preset_setting ).set( true );
							} else {
								/**
								 * Update the value visually in the control
								 */
								jQuery( input_element ).prop( "checked", false );
								/**
								 * Update the value in the customizer object
								 */
								wp.customize.instance( preset_setting ).set( false );
							}

						}
						/**
						 * Control types:
						 *     select
						 *     select2
						 *     select2-multiple
						 *     kirki-select
						 */
						else if ( 'select' == sub_control_type || 'select2' == sub_control_type || 'select2-multiple' == sub_control_type || 'kirki-select' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'select' );
							var $select = jQuery( input_element ).selectize();
							var selectize = $select[0].selectize;
							selectize.setValue( preset_setting_value, true );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     slider
						 */
						else if ( 'slider' == sub_control_type ) {

							/**
							 * Update the value visually in the control (slider)
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input' );
							jQuery( input_element ).prop( "value", preset_setting_value );
							/**
							 * Update the value visually in the control (number)
							 */
							var numeric_element = wp.customize.control( preset_setting ).container.find( '.kirki_range_value .value' );
							jQuery( numeric_element ).html( preset_setting_value );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     textarea
						 *     kirki-textarea
						 */
						else if ( 'textarea' == sub_control_type || 'kirki-textarea' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'textarea' );
							jQuery( input_element ).prop( "value", preset_setting_value );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     color
						 *     kirki-color
						 */
						else if ( 'color' == sub_control_type || 'kirki-color' == sub_control_type ) {

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );
							/**
							 * Update the value visually in the control
							 */

							wp.customize.control( preset_setting ).container.find( '.color-picker-hex' )
								.attr( 'data-default-color', preset_setting_value )
								.data( 'default-color', preset_setting_value )
								.wpColorPicker( 'color', preset_setting_value );

						}
						else if ( 'color-alpha' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var alphaColorControl = wp.customize.control( preset_setting ).container.find( '.kirki-color-control' );

							alphaColorControl
								.attr( 'data-default-color', preset_setting_value )
								.data( 'default-color', preset_setting_value )
								.wpColorPicker( 'color', preset_setting_value );

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     dimension
						 */
						else if ( 'dimension' == sub_control_type ) {

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );
							/**
							 * Update the numeric value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input[type=number]' );
							var numeric_value = parseFloat( preset_setting_value );
							jQuery( input_element ).prop( "value", numeric_value );
							/**
							 * Update the units value visually in the control
							 */
							var select_element = wp.customize.control( preset_setting ).container.find( 'select' );
							var units_value    = preset_setting_value.replace( parseFloat( preset_setting_value ), '' );
							jQuery( select_element ).prop( "value", units_value );

						}
						/**
						 * Control types:
						 *     multicheck
						 */
						else if ( 'multicheck' == sub_control_type ) {

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );
							/**
							 * Update the value visually in the control.
							 * This value is an array so we'll have to go through each one of the items
							 * in order to properly apply the value and check each checkbox separately.
							 *
							 * First we uncheck ALL checkboxes in the control
							 * Then we check the ones that we want.
							 */
							wp.customize.control( preset_setting ).container.find( 'input' ).each(function() {
								jQuery( this ).prop( "checked", false );
							});

							for	( index = 0; index < preset_setting_value.length; index++ ) {
								var input_element = wp.customize.control( preset_setting ).container.find( 'input[value="' + preset_setting_value[ index ] + '"]' );
								jQuery( input_element ).prop( "checked", true );
							}

						}
						/**
						 * Control types:
						 *     radio-buttonset
						 *     radio-image
						 *     radio
						 *     kirki-radio
						 */
						else if ( 'radio-buttonset' == sub_control_type || 'radio-image' == sub_control_type || 'radio' == sub_control_type || 'kirki-radio' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input[value="' + preset_setting_value + '"]' );
							jQuery( input_element ).prop( "checked", true );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Fallback for all other controls.
						 */
						else {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input' );
							jQuery( input_element ).prop( "value", preset_setting_value );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}

					});

				}

			});

			wp.customize.previewer.refresh();

		});

	}
});
