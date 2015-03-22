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
		$controls = kirki_get_controls();

		foreach ( $controls as $control ) {
			$control = Kirki_Controls::control_clean( $control );

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

	// if ( version_compare( $this->version, $version ) ) {
	// 	update_option( 'kirki_version', $this->version );
	// }

}
