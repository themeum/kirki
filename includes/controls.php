<?php

/**
 * Build the controls
 */
function kirki_customizer_builder( $wp_customize ) {

	$controls = Kirki_Controls::get_controls();

	// Early exit if controls are not set or if they're empty
	if ( empty( $controls ) ) {
		return;
	}

	foreach ( $controls as $control ) {
		Kirki_Setting::register( $wp_customize, $control );
		Kirki_Control::register( $wp_customize, $control );
	}

}
add_action( 'customize_register', 'kirki_customizer_builder', 99 );
