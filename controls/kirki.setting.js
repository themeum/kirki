var kirki = kirki || {};
kirki.setting = {
	/**
	 * Gets the value of a setting.
	 *
	 * This is a helper function that allows us to get the value of
	 * control[key1][key2] for example, when the setting used in the
	 * customizer API is "control".
	 *
	 * @since 3.1.0
	 * @param {string} [setting] The setting for which we're getting the value.
	 * @returns {(string|array|object|bool)} Depends on the value.
	 */
	get: function( setting ) {
		var parts = setting.split( '[' ),
			foundSetting = '',
			foundInStep  = 0,
			currentVal   = '';

		_.each( parts, function( part, i ) {
			part = part.replace( ']', '' );

			if ( 0 === i ) {
				foundSetting = part;
			} else {
				foundSetting += '[' + part + ']';
			}

			if ( ! _.isUndefined( wp.customize.instance( foundSetting ) ) ) {
				currentVal  = wp.customize.instance( foundSetting ).get();
				foundInStep = i;
			}

			if ( foundInStep < i ) {
				if ( _.isObject( currentVal ) && ! _.isUndefined( currentVal[ part ] ) ) {
					currentVal = currentVal[ part ];
				}
			}
		});

		return currentVal;
	},

	/**
	 * Sets the value of a setting.
	 *
	 * This function is a bit complicated because there any many scenarios to consider.
	 * Example: We want to save the value for my_setting[something][3][something-else].
	 * The control's setting is my_setting[something].
	 * So we need to find that first, then figure out the remaining parts,
	 * merge the values recursively to avoid destroying my_setting[something][2]
	 * and also take into account any defined "key" arguments which take this even deeper.
	 *
	 * @since 3.1.0
	 * @param {object}                     [element] The DOM element whose value has changed.
	 *                                               Format: {element:value, context:id|element}.
	 *                                               We'll use this to find the setting.
	 * @param {(string|array|bool|object)} [value]   Depends on the control-type.
	 * @param {string}                     [key]     If we only want to save an item in an object
	 *                                               we can define the key here.
	 * @returns {void}
	 */
	set: function( element, value, key ) {
		var setting,
			parts,
			currentNode   = '',
			foundNode     = '',
			subSettingObj = {},
			currentVal,
			subSetting,
			subSettingParts;

		// Get the setting from the element.
		if ( jQuery( element ).attr( 'data-id' ) ) {
			setting = jQuery( element ).attr( 'data-id' );
		} else {
			setting = jQuery( element ).parents( '.kirki-control-wrapper' ).attr( 'data-id' );
		}
		parts = setting.split( '[' ),

		// Find the setting we're using in the control using the customizer API.
		_.each( parts, function( part, i ) {
			part = part.replace( ']', '' );

			// The current part of the setting.
			currentNode = ( 0 === i ) ? part : '[' + part + ']';

			// When we find the node, get the value from it.
			// In case of an object we'll need to merge with current values.
			if ( ! _.isUndefined( wp.customize.instance( currentNode ) ) ) {
				foundNode  = currentNode;
				currentVal = wp.customize.instance( foundNode ).get();
			}
		} );

		// Get the remaining part of the setting that was unused.
		subSetting = setting.replace( foundNode, '' );

		// If subSetting is not empty, then we're dealing with an object
		// and we need to dig deeper and recursively merge the values.
		if ( '' !== subSetting ) {
			if ( ! _.isObject( currentVal ) ) {
				currentVal = {};
			}
			if ( '[' === subSetting.charAt( 0 ) ) {
				subSetting = subSetting.replace( '[', '' );
			}
			subSettingParts = subSetting.split( '[' );
			_.each( subSettingParts, function( subSettingPart, i ) {
				subSettingParts[ i ] = subSettingPart.replace( ']', '' );
			} );

			// If using a key, we need to go 1 level deeper.
			if ( key ) {
				subSettingParts.push( key );
			}

			// Converting to a JSON string and then parsing that to an object
			// may seem a bit hacky and crude but it's efficient and works.
			subSettingObj = '{"' + subSettingParts.join( '":{"' ) + '":"' + value + '"' + '}'.repeat( subSettingParts.length );
			subSettingObj = JSON.parse( subSettingObj );

			// Recursively merge with current value.
			jQuery.extend( true, currentVal, subSettingObj );
			value = currentVal;

		} else {
			if ( key ) {
				currentVal = ( ! _.isObject( currentVal ) ) ? {} : currentVal;
				currentVal[ key ] = value;
				value = currentVal;
			}
		}

		wp.customize.control( foundNode ).setting.set( value );
	}
};
