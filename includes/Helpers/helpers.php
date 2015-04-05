<?php

/**
 * Helper function
 *
 * removes an item from an array
 */
function kirki_array_delete( $idx, $array ) {

	unset( $array[$idx] );
	return ( is_array( $array ) ) ? array_values( $array ) : null;

}

/**
 * Takes care of all the migration and compatibility issues with previous versions.
 */
function kirki_update() {

	$version = get_option( 'kirki_version' );
	$version = ( ! $version ) ? '0' : $version;
	// < 0.6.1 -> 0.6.2
	if ( ! $version ) {
		/**
		 * In versions 0.6.0 & 0.6.1 there was a bug and some fields were saved as ID_opacity istead if ID
		 * This will fix the wrong settings naming and save new settings.
		 */
		$field_ids = array();
		$fields = Kirki::fields()->get_all();

		foreach ( $fields as $field ) {
			$field = Kirki::field()->sanitize( $field );

			if ( 'background' != $field['type'] ) {
				$field_ids[] = $field['settings'];
			}

		}

		foreach ( $field_ids as $field_id ) {

			if ( get_theme_mod( $field_id . '_opacity' ) && ! get_theme_mod( $field_id ) ) {
				set_theme_mod( $field_id, get_theme_mod( $field_id . '_opacity' ) );
			}

		}

	}

	if ( ! $version || version_compare( Kirki::$version, $version ) ) {
		update_option( 'kirki_version', Kirki::$version );
	}

}
add_action( 'wp', 'kirki_update' );

/**
 * Get the value of a field.
 */
function kirki_get_option( $option = '' ) {

	// Make sure the class is instanciated
	Kirki::get_instance();

	// Get the array of all the fields.
	$fields = Kirki::fields()->get_all();
	// Get the config.
	$config = Kirki::config()->get_all();

	/**
	* If no setting has been defined then return all.
	*/
	if ( '' == $option ) {
		if ( 'option' == $config['options_type'] ) {
			$values = array();
			foreach ( $fields as $field ) {
				$values[] = get_option( $field['settings'], $field['default'] );
			}
		} else {
			$values = get_theme_mods();
		}

		return $values;

	}
	// If a value has been defined then we proceed.

	// Early exit if this option does not exist
	if ( ! isset( $fields[$option] ) ) {
		return;
	}

	$option_name  = $fields[$option]['settings'];
	$default      = $fields[$option]['default'];

	if ( 'option' == $config['options_type'] ) {
		$value = get_option( $option_name, $default );
	} else {
		$value = get_theme_mod( $option_name, $default );
	}

	return $value;

}

/**
 * Load plugin textdomain.
 *
 * @since 0.8.0
 */
function kirki_load_textdomain() {
	$textdomain = 'kirki';

	// Look for WP_LANG_DIR/{$domain}-{$locale}.mo
	if ( file_exists( WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
		$file = WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo';
	}
	// Look for KIRKI_PATH/languages/{$domain}-{$locale}.mo
	if ( ! isset( $file ) && file_exists( KIRKI_PATH . '/languages/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
		$file = KIRKI_PATH . '/languages/' . $textdomain . '-' . get_locale() . '.mo';
	}

	if ( isset( $file ) ) {
		load_textdomain( $textdomain, $file );
	}

	load_plugin_textdomain( $textdomain, false, KIRKI_PATH . '/languages' );
}
add_action( 'plugins_loaded', 'kirki_load_textdomain' );
