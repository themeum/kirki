<?php

/**
 * Sanitize hex colors
 */
function kirki_sanitize_hex( $color ) {
	// Remove any spaces and special characters before and after the string
	$color = trim( $color. ' \t\n\r\0\x0B' );

	// Remove any trailing '#' symbols from the color value
	$color = str_replace( '#', '', $color );

	// If there are more than 6 characters, only keep the first 6.
	if ( strlen( $color ) > 6 ) {

		$color = substr( $color, 0, 6 );

	}

	if ( strlen( $color ) == 6 ) {

		$hex = $color; // If string consists of 6 characters, then this is our color

	} else {

		// String is shorter than 6 characters.
		// We will have to do some calculations below to get the actual 6-digit hex value.

		// If the string is longer than 3 characters, only keep the first 3.
		if ( strlen( $color ) > 3 ) {
			$color = substr( $color, 0, 3 );
		}

		// If this is a 3-character string, format it to 6 characters.
		if ( strlen( $color ) == 3 ) {

			$red    = substr( $color, 0, 1 ) . substr( $color, 0, 1 );
			$green  = substr( $color, 1, 1 ) . substr( $color, 1, 1 );
			$blue   = substr( $color, 2, 1 ) . substr( $color, 2, 1 );

			$hex = $red . $green . $blue;

		}

		// If this is shorter than 3 characters, do some voodoo.
		if ( strlen( $color ) == 2 ) {

			$hex = $color . $color . $color;

		} else if ( strlen( $color ) == 1 ) {

			$hex = $color . $color . $color . $color . $color . $color;

		}

	}

	return '#' . $hex;
}

/*
 * Gets the rgb value of the $hex color.
 * Returns an array.
 */
function kirki_get_rgb( $hex, $implode = false ) {
	// Remove any trailing '#' symbols from the color value
	$hex = str_replace( '#', '', kirki_sanitize_hex( $hex ) );

	if ( strlen( $hex ) == 3 ) {
		// If the color is entered using a short, 3-character format,
		// then find the rgb values from them
		$red    = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$green  = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$blue   = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		// If the color is entered using a 6-character format,
		// then find the rgb values from them
		$red    = hexdec( substr( $hex, 0, 2 ) );
		$green  = hexdec( substr( $hex, 2, 2 ) );
		$blue   = hexdec( substr( $hex, 4, 2 ) );
	}

	// rgb is an array
	$rgb = array( $red, $green, $blue );
	if ( $implode ) {
		return implode( ',', $rgb );
	} else {
		return $rgb;
	}
}

/*
 * Gets the rgba value of a color.
 */
function kirki_get_rgba( $hex = '#fff', $opacity = 100 ) {
	$hex = kirki_sanitize_hex( $hex );
	// Make sure that opacity is properly formatted :
	// Set the opacity to 100 if a larger value has been entered by mistake.
	// If a negative value is used, then set to 0.
	// If an opacity value is entered in a decimal form (for example 0.25), then multiply by 100.
	if ( $opacity >= 100 ) {

		$opacity = 100;

	} elseif ( $opacity < 0 ) {

		$opacity = 0;

	} elseif ( $opacity < 1 && $opacity != 0 ) {

		$opacity = ( $opacity * 100 );

	} else {

		$opacity = $opacity;

	}

	// Divide the opacity by 100 to end-up with a CSS value for the opacity
	$opacity = ( $opacity / 100 );

	$color = 'rgba(' . kirki_get_rgb( $hex, true ) . ', ' . $opacity . ')';

	return $color;

}

/*
 * Gets the brightness of the $hex color.
 * Returns a value between 0 and 255
 */
function kirki_get_brightness( $hex ) {
	$hex = kirki_sanitize_hex( $hex );
	// returns brightness value from 0 to 255
	// strip off any leading #
	$hex = str_replace( '#', '', $hex );

	$red    = hexdec( substr( $hex, 0, 2 ) );
	$green  = hexdec( substr( $hex, 2, 2 ) );
	$blue   = hexdec( substr( $hex, 4, 2 ) );

	return ( ( $red * 299 ) + ( $green * 587 ) + ( $blue * 114 ) ) / 1000;
}