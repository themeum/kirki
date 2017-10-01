var kirki = kirki || {};
kirki.value = {
	set: {

		/**
		 * Sets the value in wp-customize settings.
		 *
		 * @param {object} [control] The control.
		 * @param {mixed}  [value]   The value.
		 * @param {string} [key]     A key if we only want to change part of an object value.
		 * @returns {void}
		 */
		defaultControl: function( control, value, key ) {
			var valObj;

			// Calculate the value if we've got a key defined.
			if ( ! _.isUndefined( key ) ) {
				if ( ! _.isUndefined( control.setting ) && ! _.isUndefined( control.setting._value ) ) {
					valObj = control.setting._value;
				} else if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.value ) ) {
					valObj = control.params.value;
				} else if ( ! _.isUndefined( control.value ) ) {
					valObj = control.value;
				}
				valObj[ key ] = value;
				value = valObj;
			}

			// Reset the value.
			if ( _.isUndefined( key ) ) {
				control.setting.set( '' );
			} else {
				control.setting.set( {} );
			}

			// Set the value.
			control.setting.set( value );
		}
	}
};
