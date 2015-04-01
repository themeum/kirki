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
				update_theme_mod( $field_id, get_theme_mod( $field_id . '_opacity' ) );
			}

		}

	}

	if ( ! $version || version_compare( Kirki::$version, $version ) ) {
		update_option( 'kirki_version', Kirki::$version );
	}

}
add_action( 'wp', 'kirki_update' );

/**
 * A wrapper function for get_theme_mod.
 *
 * This will be a bit more generic and will future-proof the plugin
 * in case we ever decide to switch to using options instead of theme mods.
 *
 * An additional benefit is that it also gets the default values
 * without the need to manually define them like in get_theme_mod();
 *
 * It's recommended that you add the following to your theme/plugin before using this function:
 *
if ( ! function_exists( 'kirki_get_option' ) ) :
function kirki_get_option( $option ) {
	get_theme_mod( $option, '' );
}
endif;
 *
 * If the plugin is not installed, the above function will NOT get the right value,
 * but at least no fatal errors will occur.
 */
function kirki_get_option( $option ) {

	// Get the array of controls
	$fields = Kirki::fields()->get_all();
	foreach ( $fields as $field ) {
		$setting = $field['settings'];
		$default = ( isset( $field['default'] ) ) ? $field['default'] : '';
		// Get the theme_mod and pass the default value as well
		if ( $option == $setting ) {
			$value = get_theme_mod( $option, $default );
		}
	}

	if ( isset( $value ) ) {
		return $value;
	}

	// fallback to returning an empty string
	return '';

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
