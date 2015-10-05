<?php
/**
 * Color Calculations class for Kirki
 * Initially built for the Shoestrap-3 theme and then tweaked for Kirki.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Color' ) ) {
	return;
}

class Kirki_Color {

	/**
	 * Sanitises a HEX value.
	 * The way this works is by splitting the string in 6 substrings.
	 * Each sub-string is individually sanitized, and the result is then returned.
	 *
	 * @var     string      The hex value of a color
	 * @param   boolean     Whether we want to include a hash (#) at the beginning or not
	 * @return  string      The sanitized hex color.
	 */
	 public static function sanitize_hex( $color = '#FFFFFF', $hash = true ) {

		// Remove any spaces and special characters before and after the string
		$color = trim( $color );

		// Remove any trailing '#' symbols from the color value
		$color = str_replace( '#', '', $color );

		// If the string is 6 characters long then use it in pairs.
		if ( 3 == strlen( $color ) ) {
			$color = substr( $color, 0, 1 ) . substr( $color, 0, 1 ) . substr( $color, 1, 1 ) . substr( $color, 1, 1 ) . substr( $color, 2, 1 ) . substr( $color, 2, 1 );
		}

		$substr = array();
		for ( $i = 0; $i <= 5; $i++ ) {
			$default = ( 0 == $i ) ? 'F' : ( $substr[ $i - 1 ] );
			$substr[ $i ] = substr( $color, $i, 1 );
			$substr[ $i ] = ( false === $substr[ $i ] || ! ctype_xdigit( $substr[ $i ] ) ) ? $default : $substr[ $i ];
		}
		$hex = implode( '', $substr );

		return ( ! $hash ) ? $hex : '#' . $hex;

	}

	/**
	 * Gets the rgb value of the $hex color.
	 *
	 * @var     string      The hex value of a color
	 * @param   boolean     Whether we want to implode the values or not
	 * @return  mixed       array|string
	 */
	public static function get_rgb( $hex, $implode = false ) {

		// Remove any trailing '#' symbols from the color value
		$hex = self::sanitize_hex( $hex, false );

		// rgb is an array
		$rgb = array(
			hexdec( substr( $hex, 0, 2 ) ),
			hexdec( substr( $hex, 2, 2 ) ),
			hexdec( substr( $hex, 4, 2 ) ),
		);

		return ( $implode ) ? implode( ',', $rgb ) : $rgb;

	}

	/**
	 * Converts an rgba color to hex
	 * This is an approximation and not completely accurate.
	 *
	 * @var     string  The rgba color formatted like rgba(r,g,b,a)
	 * @return  string  The hex value of the color.
	 */
	public static function rgba2hex( $color, $apply_opacity = false ) {

		// Remove parts of the string
		$color = str_replace( array( 'rgba', '(', ')', ' ' ), '', $color );
		// Convert to array
		$color = explode( ',', $color );
		// This is not a valid rgba definition, so return white.
		if ( 4 != count( $color ) ) {
			return '#ffffff';
		}
		// Convert dec. to hex.
		$red   = dechex( (int) $color[0] );
		$green = dechex( (int) $color[1] );
		$blue  = dechex( (int) $color[2] );
		$alpha = $color[3];

		// Make sure all colors are 2 digits
		$red   = ( 1 == strlen( $red ) ) ? $red . $red : $red;
		$green = ( 1 == strlen( $green ) ) ? $green . $green : $green;
		$blue  = ( 1 == strlen( $blue ) ) ? $blue . $blue : $blue;

		// Combine hex parts
		$hex = $red . $green . $blue;
		if ( $apply_opacity ) {
			// Get the opacity value on a 0-100 basis instead of 0-1.
			$mix_level = intval( $alpha * 100 );
			// Apply opacity - mix with white.
			$hex = self::mix_colors( $hex, '#ffffff', $mix_level );
		}

		return '#' . str_replace( '#', '', $hex );

	}

	/**
	 * Get the alpha channel from an rgba color
	 *
	 * @var     string  The rgba color formatted like rgba(r,g,b,a)
	 * @return  string  The alpha value of the color.
	 */
	public static function get_alpha_from_rgba( $color ) {
		// Remove parts of the string
		$color = str_replace( array( 'rgba', '(', ')', ' ' ), '', $color );
		// Convert to array
		$color = explode( ',', $color );

		if ( isset ( $color[3] ) ) {
			return (string) $color[3];
		} else {
			return '1';
		}
	}

	/**
	 * Gets the rgb value of the $hex color.
	 *
	 * @var     string      The hex value of a color
	 * @param   int         Opacity level (1-100)
	 * @return  string
	 */
	public static function get_rgba( $hex = '#fff', $opacity = 100 ) {

		$hex = self::sanitize_hex( $hex, false );
		/**
		 * Make sure that opacity is properly formatted :
		 * Set the opacity to 100 if a larger value has been entered by mistake.
		 * If a negative value is used, then set to 0.
		 * If an opacity value is entered in a decimal form (for example 0.25), then multiply by 100.
		 */
		$opacity = ( 1 >= $opacity && 0 < $opacity ) ? $opacity * 100 : $opacity;
		$opacity = max( 0, min( 100, $opacity ) );

		// Divide the opacity by 100 to end-up with a CSS value for the opacity
		$opacity = ( $opacity / 100 );

		$color = 'rgba(' . self::get_rgb( $hex, true ) . ',' . $opacity . ')';

		return $color;

	}

	/**
	 * Gets the brightness of the $hex color.
	 *
	 * @var     string      The hex value of a color
	 * @return  int         value between 0 and 255
	 */
	public static function get_brightness( $hex ) {

		$hex = self::sanitize_hex( $hex, false );
		// returns brightness value from 0 to 255
		return intval( ( ( hexdec( substr( $hex, 0, 2 ) ) * 299 ) + ( hexdec( substr( $hex, 2, 2 ) ) * 587 ) + ( hexdec( substr( $hex, 4, 2 ) ) * 114 ) ) / 1000 );

	}

	/**
	 * Adjusts brightness of the $hex color.
	 *
	 * @var     string      The hex value of a color
	 * @var     int         a value between -255 (darken) and 255 (lighten)
	 * @return  string      returns hex color
	 */
	public static function adjust_brightness( $hex, $steps ) {

		$hex = self::sanitize_hex( $hex, false );
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max( -255, min( 255, $steps ) );
		// Adjust number of steps and keep it inside 0 to 255
		$red   = max( 0, min( 255, hexdec( substr( $hex, 0, 2 ) ) + $steps ) );
		$green = max( 0, min( 255, hexdec( substr( $hex, 2, 2 ) ) + $steps ) );
		$blue  = max( 0, min( 255, hexdec( substr( $hex, 4, 2 ) ) + $steps ) );

		$red_hex   = str_pad( dechex( $red ), 2, '0', STR_PAD_LEFT );
		$green_hex = str_pad( dechex( $green ), 2, '0', STR_PAD_LEFT );
		$blue_hex  = str_pad( dechex( $blue ), 2, '0', STR_PAD_LEFT );

		return self::sanitize_hex( $red_hex . $green_hex . $blue_hex );

	}

	/**
	 * Mixes 2 hex colors.
	 * the "percentage" variable is the percent of the first color
	 * to be used it the mix. default is 50 (equal mix)
	 *
	 * @var     string      The hex value of color 1
	 * @var     string      The hex value of color 2
	 * @var     int         a value between 0 and 100
	 * @return  string      returns hex color
	 */
	public static function mix_colors( $hex1, $hex2, $percentage ) {

		$hex1 = self::sanitize_hex( $hex1, false );
		$hex2 = self::sanitize_hex( $hex2, false );

		$red   = ( $percentage * hexdec( substr( $hex1, 0, 2 ) ) + ( 100 - $percentage ) * hexdec( substr( $hex2, 0, 2 ) ) ) / 100;
		$green = ( $percentage * hexdec( substr( $hex1, 2, 2 ) ) + ( 100 - $percentage ) * hexdec( substr( $hex2, 2, 2 ) ) ) / 100;
		$blue  = ( $percentage * hexdec( substr( $hex1, 4, 2 ) ) + ( 100 - $percentage ) * hexdec( substr( $hex2, 4, 2 ) ) ) / 100;

		$red_hex   = str_pad( dechex( $red ), 2, '0', STR_PAD_LEFT );
		$green_hex = str_pad( dechex( $green ), 2, '0', STR_PAD_LEFT );
		$blue_hex  = str_pad( dechex( $blue ), 2, '0', STR_PAD_LEFT );

		return self::sanitize_hex( $red_hex . $green_hex . $blue_hex );

	}

	/**
	 * Convert hex color to hsv
	 *
	 * @var     string      The hex value of color 1
	 * @return  array       returns array( 'h', 's', 'v' )
	 */
	public static function hex_to_hsv( $hex ) {
		$rgb = (array) (array) self::get_rgb( self::sanitize_hex( $hex, false ) );
		return self::rgb_to_hsv( $rgb );
	}

	/**
	 * Convert hex color to hsv
	 *
	 * @var     array       The rgb color to conver array( 'r', 'g', 'b' )
	 * @return  array       returns array( 'h', 's', 'v' )
	 */
	public static function rgb_to_hsv( $color = array() ) {

		$var_r = ( $color[0] / 255 );
		$var_g = ( $color[1] / 255 );
		$var_b = ( $color[2] / 255 );

		$var_min = min( $var_r, $var_g, $var_b );
		$var_max = max( $var_r, $var_g, $var_b );
		$del_max = $var_max - $var_min;

		$h = 0;
		$s = 0;
		$v = $var_max;

		if ( 0 != $del_max ) {
			$s = $del_max / $var_max;

			$del_r = ( ( ( $var_max - $var_r ) / 6 ) + ( $del_max / 2 ) ) / $del_max;
			$del_g = ( ( ( $var_max - $var_g ) / 6 ) + ( $del_max / 2 ) ) / $del_max;
			$del_b = ( ( ( $var_max - $var_b ) / 6 ) + ( $del_max / 2 ) ) / $del_max;

			if ( $var_r == $var_max ) {
				$h = $del_b - $del_g;
			} elseif ( $var_g == $var_max ) {
				$h = ( 1 / 3 ) + $del_r - $del_b;
			} elseif ( $var_b == $var_max ) {
				$h = ( 2 / 3 ) + $del_g - $del_r;
			}

			if ( $h < 0 ) {
				$h++;
			}

			if ( $h > 1 ) {
				$h--;
			}
		}

		return array( 'h' => round( $h, 2 ), 's' => round( $s, 2 ), 'v' => round( $v, 2 ) );

	}

	/*
	 * This is a very simple algorithm that works by summing up the differences between the three color components red, green and blue.
	 * A value higher than 500 is recommended for good readability.
	 */
	public static function color_difference( $color_1 = '#ffffff', $color_2 = '#000000' ) {

		$color_1 = self::sanitize_hex( $color_1, false );
		$color_2 = self::sanitize_hex( $color_2, false );

		$color_1_rgb = self::get_rgb( $color_1 );
		$color_2_rgb = self::get_rgb( $color_2 );

		$r_diff = max( $color_1_rgb[0], $color_2_rgb[0] ) - min( $color_1_rgb[0], $color_2_rgb[0] );
		$g_diff = max( $color_1_rgb[1], $color_2_rgb[1] ) - min( $color_1_rgb[1], $color_2_rgb[1] );
		$b_diff = max( $color_1_rgb[2], $color_2_rgb[2] ) - min( $color_1_rgb[2], $color_2_rgb[2] );

		$color_diff = $r_diff + $g_diff + $b_diff;

		return $color_diff;

	}

	/*
	 * This function tries to compare the brightness of the colors.
	 * A return value of more than 125 is recommended.
	 * Combining it with the color_difference function above might make sense.
	 */
	public static function brightness_difference( $color_1 = '#ffffff', $color_2 = '#000000' ) {

		$color_1 = self::sanitize_hex( $color_1, false );
		$color_2 = self::sanitize_hex( $color_2, false );

		$color_1_rgb = self::get_rgb( $color_1 );
		$color_2_rgb = self::get_rgb( $color_2 );

		$br_1 = ( 299 * $color_1_rgb[0] + 587 * $color_1_rgb[1] + 114 * $color_1_rgb[2] ) / 1000;
		$br_2 = ( 299 * $color_2_rgb[0] + 587 * $color_2_rgb[1] + 114 * $color_2_rgb[2] ) / 1000;

		return intval( abs( $br_1 - $br_2 ) );

	}

	/*
	 * Uses the luminosity to calculate the difference between the given colors.
	 * The returned value should be bigger than 5 for best readability.
	 */
	public static function lumosity_difference( $color_1 = '#ffffff', $color_2 = '#000000' ) {

		$color_1 = self::sanitize_hex( $color_1, false );
		$color_2 = self::sanitize_hex( $color_2, false );

		$color_1_rgb = self::get_rgb( $color_1 );
		$color_2_rgb = self::get_rgb( $color_2 );

		$l1 = 0.2126 * pow( $color_1_rgb[0] / 255, 2.2 ) + 0.7152 * pow( $color_1_rgb[1] / 255, 2.2 ) + 0.0722 * pow( $color_1_rgb[2] / 255, 2.2 );
		$l2 = 0.2126 * pow( $color_2_rgb[0] / 255, 2.2 ) + 0.7152 * pow( $color_2_rgb[1] / 255, 2.2 ) + 0.0722 * pow( $color_2_rgb[2] / 255, 2.2 );

		$lum_diff = ( $l1 > $l2 ) ? ( $l1 + 0.05 ) / ( $l2 + 0.05 ) : ( $l2 + 0.05 ) / ( $l1 + 0.05 );

		return round( $lum_diff, 2 );

	}

}
