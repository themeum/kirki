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
						 * Update the value of the defined setting.
						 * This will only update the value in the global customizer object.
						 * However, it will not help us live-update the value on the control itself.
						 * We'll need to do some extra work for that below
						 */
						wp.customize( preset_setting ).set( preset_setting_value );
						/**
						 * Get the control of the sub-setting.
						 * This will be used to get properties we need from that control,
						 * and determine if we need to do any further work based on those.
						 */
						var sub_control = wp.customize.settings.controls[ preset_setting ];
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
						 *     color
						 *     color-alpha
						 *     kirki-color
						 */
						if ( 'color-alpha' == sub_control_type || 'color' == sub_control_type || 'kirki-color' == sub_control_type ) {

							var input_element = wp.customize.control( preset_setting ).container.find( '.color-picker-hex' );
							input_element.data( 'data-default-color', preset_setting_value ).wpColorPicker( 'defaultColor', preset_setting_value );

						}
						/**
						 * Control types:
						 *     select
						 *     select2
						 *     select2-multiple
						 *     kirki-select
						 */
						else if ( 'select' == sub_control_type || 'select2' == sub_control_type || 'select2-multiple' == sub_control_type || 'kirki-select' == sub_control_type ) {

							var input_element = wp.customize.control( preset_setting ).container.find( 'select' );

						}
						/**
						 * Control types:
						 *     code
						 *     textarea
						 *     kirki-textarea
						 */
						else if ( 'code' == sub_control_type || 'textarea' == sub_control_type || 'kirki-textarea' == sub_control_type ) {

							var input_element = wp.customize.control( preset_setting ).container.find( 'textarea' );

						}
						/**
						 * Control types:
						 *     palette
						 *     radio-buttonset
						 *     radio-image
						 *     radio
						 *     kirki-radio
						 */
						else if ( 'palette' == sub_control_type || 'radio-buttonset' == sub_control_type || 'radio-image' == sub_control_type || 'radio' == sub_control_type || 'kirki-radio' == sub_control_type ) {

							var input_element = wp.customize.control( preset_setting ).container.find( 'input[value="' + preset_setting_value + '"]' );

						}
						/**
						 * Control types:
						 *     typography
						 */
						else if ( 'typography' == sub_control_type ) {

							// var input_element = wp.customize.control( preset_setting ).container.find( 'input' );

						}
						/**
						 * Control types:
						 *     dimension
						 */
						else if ( 'dimension' == sub_control_type ) {

							// var input_element = wp.customize.control( preset_setting ).container.find( 'input' );

						}
						/**
						 * Control types:
						 *     multicheck
						 */
						else if ( 'multicheck' == sub_control_type ) {

							// var input_element = wp.customize.control( preset_setting ).container.find( 'input' );

						}
						/**
						 * Control types:
						 *     repeater
						 */
						else if ( 'repeater' == sub_control_type ) {

							// var input_element = wp.customize.control( preset_setting ).container.find( 'input' );

						}
						/**
						 * Control types:
						 *     sortable
						 */
						else if ( 'sortable' == sub_control_type ) {

							// var input_element = wp.customize.control( preset_setting ).container.find( 'input' );

						}
						/**
						 * Control types:
						 *     spacing
						 */
						else if ( 'spacing' == sub_control_type ) {

							// var input_element = wp.customize.control( preset_setting ).container.find( 'input' );

						}
						/**
						 * Fallback for all other controls.
						 */
						else {

							// var input_element = wp.customize.control( preset_setting ).container.find( 'input' );

						}

					});

				}

			});

			wp.customize.previewer.refresh();

		});

	}
});
