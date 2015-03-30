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
	$textdomain = kirki_textdomain();
	$valid = array(
		'no-repeat' => __( 'No Repeat', $textdomain ),
		'repeat'    => __( 'Repeat All', $textdomain ),
		'repeat-x'  => __( 'Repeat Horizontally', $textdomain ),
		'repeat-y'  => __( 'Repeat Vertically', $textdomain ),
		'inherit'   => __( 'Inherit', $textdomain )
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background size values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_size( $value ) {
	$textdomain = kirki_textdomain();
	$valid = array(
		'inherit' => __( 'Inherit', $textdomain ),
		'cover'   => __( 'Cover', $textdomain ),
		'contain' => __( 'Contain', $textdomain ),
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background attachment values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_attach( $value ) {
	$textdomain = kirki_textdomain();
	$valid = array(
		'inherit' => __( 'Inherit', $textdomain ),
		'fixed'   => __( 'Fixed', $textdomain ),
		'scroll'  => __( 'Scroll', $textdomain ),
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background position values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_position( $value ) {
	$textdomain = kirki_textdomain();
	$valid = array(
		'left-top'      => __( 'Left Top', $textdomain ),
		'left-center'   => __( 'Left Center', $textdomain ),
		'left-bottom'   => __( 'Left Bottom', $textdomain ),
		'right-top'     => __( 'Right Top', $textdomain ),
		'right-center'  => __( 'Right Center', $textdomain ),
		'right-bottom'  => __( 'Right Bottom', $textdomain ),
		'center-top'    => __( 'Center Top', $textdomain ),
		'center-center' => __( 'Center Center', $textdomain ),
		'center-bottom' => __( 'Center Bottom', $textdomain ),
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
