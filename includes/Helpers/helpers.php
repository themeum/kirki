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

	if ( 'option' == $config['options_type'] ) {

		// We're using options instead of theme_mods
		if ( '' == $config['option_name'] ) {

			// No option name has been defined.
			// Each option is saved individually in the database
			$value = get_option( $option, $fields[$option]['default'] );

		} else {
			// 'option_name' has been defined.
			// Our options are all saved as an array in the db under that 'option_name'

			// Get all options
			$values = get_option( $config['option_name'], array() );
			$value  = ( isset( $values[$option] ) ) ? $values[$option] : $fields[$option]['default'];

		}

	} else {

		// We're using theme_mods
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
