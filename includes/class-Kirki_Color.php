<?php

class Kirki_Color {

	/**
	 * Sanitize hex colors
	 */
	public static function sanitize_hex( $color ) {

		// Remove any spaces and special characters before and after the string
		$color = trim( $color. ' \t\n\r\0\x0B' );
		// Remove any trailing '#' symbols from the color value
		$color = str_replace( '#', '', $color );
		// If there are more than 6 characters, only keep the first 6.
		$color = ( strlen( $color ) > 6 ) ? substr( $color, 0, 6 ) : $color;

		if ( strlen( $color ) == 6 ) {

			$hex = $color; // If string consists of 6 characters, then this is our color

		} else {

			// String is shorter than 6 characters.
			// We will have to do some calculations below to get the actual 6-digit hex value.

			// If the string is longer than 3 characters, only keep the first 3.
			$color = ( strlen( $color ) > 3 ) ? substr( $color, 0, 3 ) : $color;

			// If this is a 3-character string, format it to 6 characters.
			if ( 3 == strlen( $color ) ) {

				$red    = substr( $color, 0, 1 ) . substr( $color, 0, 1 );
				$green  = substr( $color, 1, 1 ) . substr( $color, 1, 1 );
				$blue   = substr( $color, 2, 1 ) . substr( $color, 2, 1 );

				$hex = $red . $green . $blue;

			}

			// If this is shorter than 3 characters, do some voodoo.
			if ( 2 == strlen( $color ) ) {
				$hex = $color . $color . $color;
			} else if ( 1 == strlen( $color ) ) {
				$hex = $color . $color . $color . $color . $color . $color;
			}

		}

		return '#' . $hex;

	}

	/*
	 * Gets the rgb value of the $hex color.
	 * Returns an array.
	 */
	public static function get_rgb( $hex, $implode = false ) {

		// Remove any trailing '#' symbols from the color value
		$hex = str_replace( '#', '', self::sanitize_hex( $hex ) );

		$red    = hexdec( substr( $hex, 0, 2 ) );
		$green  = hexdec( substr( $hex, 2, 2 ) );
		$blue   = hexdec( substr( $hex, 4, 2 ) );

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
	public static function get_rgba( $hex = '#fff', $opacity = 100 ) {

		$hex = self::sanitize_hex( $hex );

		if ( 100 <= $opacity ) { // Set the opacity to 100 if a larger value has been entered by mistake.
			$opacity = 100;
		} elseif ( 0 > $opacity ) { // If a negative value is used, then set to 0.
			$opacity = 0;
		} elseif ( $opacity < 1 && $opacity != 0 ) { // If an opacity value is entered in a decimal form (for example 0.25), then multiply by 100.
			$opacity = ( $opacity * 100 );
		} else { // Normal value has been entered
			$opacity = $opacity;
		}

		// Divide the opacity by 100 to end-up with a CSS value for the opacity
		$opacity = ( $opacity / 100 );

		$color = 'rgba(' . self::get_rgb( $hex, true ) . ', ' . $opacity . ')';

		return $color;

	}

	/*
	 * Gets the brightness of the $hex color.
	 * Returns a value between 0 and 255
	 */
	public static function get_brightness( $hex ) {

		$hex = self::sanitize_hex( $hex );
		// returns brightness value from 0 to 255
		// strip off any leading #
		$hex = str_replace( '#', '', $hex );

		$red   = hexdec( substr( $hex, 0, 2 ) );
		$green = hexdec( substr( $hex, 2, 2 ) );
		$blue  = hexdec( substr( $hex, 4, 2 ) );

		return ( ( $red * 299 ) + ( $green * 587 ) + ( $blue * 114 ) ) / 1000;

	}

}
