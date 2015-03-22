<?php
/**
 * Build the controls
 */
function kirki_customizer_builder( $wp_customize ) {

	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-group-title-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-multicheck-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-number-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-buttonset-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-image-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-sortable-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-switch-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-toggle-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-palette-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-custom-control.php' );

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
