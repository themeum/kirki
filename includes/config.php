<?php

/**
 * Get the configuration options for the Kirki customizer.
 *
 * @uses 'kirki/config' filter.
 */
function kirki_get_config() {

	$config = apply_filters( 'kirki/config', array() );

	if ( ! isset( $config['stylesheet_id'] ) ) {
		$config['stylesheet_id'] = 'kirki-styles';
	}

	return $config;

}
