/**
 * KIRKI CONTROL: PRESET
 */

wp.customize.controlConstructor['preset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = this.container.find( 'select' );

		jQuery( element ).selectize();

		this.container.on( 'change', 'select', function() {

			// Get the selected value
			var select_value = jQuery( this ).val();
			// Set the value of this control to the selected value
			control.setting.set( select_value );
			// Loop through our choices.
			jQuery.each( control.params.choices, function( key, value ) {

				// Only process if the current value is the one we want.
				if ( select_value == key ) {

					// Loop through the settings defined in this choice.
					jQuery.each( value['settings'], function( preset_setting, preset_setting_value ) {

						// Set the value of the sub-setting to the defined value
						wp.customize.instance( preset_setting ).set( preset_setting_value );

						// Get the control of the sub-setting
						var sub_control = wp.customize.settings.controls[ preset_setting ];
						// Get the control-type of this control
						var sub_control_type = sub_control['type'];
						// Get the sub-control's container
						var sub_control_container = wp.customize.instance( preset_setting ).container;

						if ( 'color-alpha' == sub_control_type || 'color' == sub_control_type || 'kirki-color' == sub_control_type ) {

							var input_element = jQuery( sub_control_container ).find( '.color-picker-hex' );

						} else if ( 'select' == sub_control_type || 'select2' == sub_control_type || 'select2-multiple' == sub_control_type || 'kirki-select' == sub_control_type ) {

							var input_element = jQuery( sub_control_container ).find( 'select' );

						} else if ( 'code' == sub_control_type || 'textarea' == sub_control_type || 'kirki-textarea' == sub_control_type ) {

							var input_element = jQuery( sub_control_container ).find( 'textarea' );

						} else if ( 'palette' == sub_control_type || 'radio-buttonset' == sub_control_type || 'radio-image' == sub_control_type || 'radio' == sub_control_type || 'kirki-radio' == sub_control_type ) {

							var input_element = jQuery( sub_control_container ).find( 'input[value="' + preset_setting_value + '"]' );

						} else if ( 'typography' == sub_control_type ) {

							var input_element = jQuery( sub_control_container ).find( 'input' );

						// } else if ( 'dimension' == sub_control_type ) {

						// 	var input_element = jQuery( sub_control_container ).find( 'input' );

						// } else if ( 'multicheck' == sub_control_type ) {

						// 	var input_element = jQuery( sub_control_container ).find( 'input' );

						// } else if ( 'repeater' == sub_control_type ) {

						// 	var input_element = jQuery( sub_control_container ).find( 'input' );

						// } else if ( 'sortable' == sub_control_type ) {

						// 	var input_element = jQuery( sub_control_container ).find( 'input' );

						// } else if ( 'spacing' == sub_control_type ) {

						// 	var input_element = jQuery( sub_control_container ).find( 'input' );

						} else {

							var input_element = jQuery( sub_control_container ).find( 'input' );

						}

						jQuery( input_element ).val( preset_setting_value );

					});

				}

			});

			wp.customize.previewer.refresh();

		});

	}
});
