<?php

/**
 * Build the controls
 */
function kirki_customizer_controls( $wp_customize ) {

	$controls = apply_filters( 'kirki/controls', array() );

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {
			Kirki_Settings::add_setting( $wp_customize, $control );
			Kirki_Controls::add_control( $wp_customize, $control );
		}
	}
}
add_action( 'customize_register', 'kirki_customizer_controls', 99 );
