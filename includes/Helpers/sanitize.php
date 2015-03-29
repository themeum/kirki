<?php

/**
 * Sanitize checkbox options
 *
 * @since 0.5
 */
function kirki_sanitize_checkbox( $value ) {
	return ( 'on' != $value ) ? false : $value;
}

/**
 * Sanitize number options
 *
 * @since 0.5
 */
function kirki_sanitize_number( $value ) {
	return ( is_int( $value ) || is_float( $value ) ) ? $value : intval( $value );
}

/**
 * Sanitize a value from a list of allowed values.
 *
 * @since 0.5
 *
 * @param  mixed    $input      The value to sanitize.
 * @param  mixed    $setting    The setting for which the sanitizing is occurring.
 */
function kirki_sanitize_choice( $input, $setting ) {

	global $wp_customize;
	$control = $wp_customize->get_control( $setting->id );

    return ( array_key_exists( $input, $control->choices ) ) ? $input : $setting->default;

}

/**
 * Sanitize background repeat values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_repeat( $value ) {
	$valid = array(
		'no-repeat' => __( 'No Repeat', 'kirki' ),
		'repeat'    => __( 'Repeat All', 'kirki' ),
		'repeat-x'  => __( 'Repeat Horizontally', 'kirki' ),
		'repeat-y'  => __( 'Repeat Vertically', 'kirki' ),
		'inherit'   => __( 'Inherit', 'kirki' )
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background size values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_size( $value ) {
	$valid = array(
		'inherit' => __( 'Inherit', 'kirki' ),
		'cover'   => __( 'Cover', 'kirki' ),
		'contain' => __( 'Contain', 'kirki' ),
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background attachment values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_attach( $value ) {
	$valid = array(
		'inherit' => __( 'Inherit', 'kirki' ),
		'fixed'   => __( 'Fixed', 'kirki' ),
		'scroll'  => __( 'Scroll', 'kirki' ),
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background position values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_position( $value ) {
	$valid = array(
		'left-top'      => __( 'Left Top', 'kirki' ),
		'left-center'   => __( 'Left Center', 'kirki' ),
		'left-bottom'   => __( 'Left Bottom', 'kirki' ),
		'right-top'     => __( 'Right Top', 'kirki' ),
		'right-center'  => __( 'Right Center', 'kirki' ),
		'right-bottom'  => __( 'Right Bottom', 'kirki' ),
		'center-top'    => __( 'Center Top', 'kirki' ),
		'center-center' => __( 'Center Center', 'kirki' ),
		'center-bottom' => __( 'Center Bottom', 'kirki' ),
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'center-center';

}

/**
 * DOES NOT SANITIZE ANYTHING.
 *
 * @since 0.5
 */
function kirki_sanitize_unfiltered( $value ) {
	return $value;
}
