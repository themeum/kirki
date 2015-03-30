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
	if ( ! get_option( 'kirki_version' ) ) {
		/**
		 * In versions 0.6.0 & 0.6.1 there was a bug and some fields were saved as ID_opacity istead if ID
		 * This will fix the wrong settings naming and save new settings.
		 */
		$control_ids = array();
		$controls = Kirki::controls()->get_all();

		foreach ( $controls as $control ) {
			$control = \Kirki\Control::sanitize( $control );

			if ( 'background' != $control['type'] ) {
				$control_ids[] = $control['settings'];
			}

		}

		foreach ( $control_ids as $control_id ) {

			if ( get_theme_mod( $control_id . '_opacity' ) && ! get_theme_mod( $control_id ) ) {
				update_theme_mod( $control_id, get_theme_mod( $control_id . '_opacity' ) );
			}

		}

	}

	if ( version_compare( Kirki::$version, $version ) ) {
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
	$controls = Kirki::controls()->get_all();
	foreach ( $controls as $control ) {
		$setting = $control['settings'];
		$default = ( isset( $control['default'] ) ) ? $control['default'] : '';
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
 * Helper function to get the translation textdomain
 */
function kirki_textdomain() {

	$config = apply_filters( 'kirki/config', array() );
	return ( isset( $config['textdomain'] ) ) ? $config['textdomain'] : 'kirki';

}
