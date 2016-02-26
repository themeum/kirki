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

if ( ! class_exists( 'Kirki_Color' ) ) {
	class Kirki_Color {

		/**
		 * Sanitises a HEX value.
		 *
		 * @var     string      The hex value of a color
		 * @param   boolean     Whether we want to include a hash (#) at the beginning or not
		 * @return  string      The sanitized hex color.
		 */
		 public static function sanitize_hex( $color = '#FFFFFF', $hash = true ) {
		 	$obj = Kirki_WP_Color::get_instance( $color );
		 	if ( ! $hash ) {
		 		return ltrim( $obj->get_css( 'hex' ), '#' );
		 	}
		 	return $obj->get_css( 'hex' );
		}

		public static function sanitize_rgba( $value ) {
			$obj = Kirki_WP_Color::get_instance( $value );
			return $obj->get_css( 'rgba' );
		}

		/**
		 * Sanitize colors.
		 * Determine if the current value is a hex or an rgba color and call the appropriate method.
		 *
		 * @since 0.8.5
		 *
		 * @param  $value   string  hex or rgba color
		 * @param  $default string  hex or rgba color
		 * @return string
		 */
		public static function sanitize_color( $value ) {

			if ( is_array( $value ) ) {
				// for Redux & SMOF compatibility
				if ( isset( $value['rgba'] ) ) {
					$value = $value['rgba'];
				} elseif ( isset( $value['color'] ) ) {
					$opacity = ( isset( $value['opacity'] ) ) ? $value['opacity'] : null;
					$opacity = ( ! is_null( $opacity ) && isset( $value['alpha'] ) ) ? $value['alpha'] : null;
					$opacity = ( is_null( $opacity ) ) ? 1 : filter_var( $opacity, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value = self::get_rgba( $value['color'], $opacity );
				} else {
					return;
				}
			}

			if ( 'transparent' == $value ) {
				return 'transparent';
			}

			// Is this an rgba color or a hex?
			$mode = ( false === strpos( $value, 'rgba' ) ) ? 'hex' : 'rgba';

			if ( 'rgba' == $mode ) {
				return self::sanitize_rgba( $value );
			} else {
				return self::sanitize_hex( $value );
			}

		}

		/**
		 * Gets the rgb value of the $hex color.
		 *
		 * @var     string      The hex value of a color
		 * @param   boolean     Whether we want to implode the values or not
		 * @return  mixed       array|string
		 */
		public static function get_rgb( $hex, $implode = false ) {
			$obj = Kirki_WP_Color::get_instance( $hex );
			if ( $implode ) {
				return $obj->get_css( 'rgb' );
			}
			return array( $obj->red, $obj->green, $obj->blue );
		}

		/**
		 * Converts an rgba color to hex
		 * This is an approximation and not completely accurate.
		 *
		 * @var     string  The rgba color formatted like rgba(r,g,b,a)
		 * @return  string  The hex value of the color.
		 */
		public static function rgba2hex( $color, $apply_opacity = false ) {
			$obj = Kirki_WP_Color::get_instance( $color );
			if ( ! $apply_opacity ) {
				return $obj->get_css( 'hex' );
			}

			if ( is_array( $color ) ) {
				return ( isset( $color['color'] ) ) ? $color['color'] : '#ffffff';
			}

			// if not rgba, sanitize as HEX
			if ( false === strpos( $color, 'rgba' ) ) {
				return self::sanitize_hex( $color );
			}

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
			if ( is_array( $color ) ) {
				if ( isset( $color['opacity'] ) ) {
					return $color['opacity'];
				} elseif ( isset( $color['alpha'] ) ) {
					return $color['alpha'];
				} else {
					return 1;
				}
			}
			if ( false === strpos( $color, 'rgba' ) ) {
				return '1';
			}
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
		 * @param   int         Opacity level (0-1)
		 * @return  string
		 */
		public static function get_rgba( $hex = '#fff', $alpha = 1 ) {

			// Make sure that opacity is properly formatted.
			// Converts 1-100 values to 0-1
			if ( $alpha > 1 || $alpha < -1 ) {
				// divide by 100
				$alpha /= 100;
			}
			// get absolute value
			$alpha = abs( $alpha );
			// max 1
			if ( 1 < $alpha ) {
				$alpha = 1;
			}

			$obj = Kirki_WP_Color::get_instance( $hex );
			$new_obj = $obj->get_new_object_by( 'alpha', $alpha );

			return $new_obj->get_css( 'rgba' );

		}

		/**
		 * Strips the alpha value from an RGBA color string.
		 *
		 * @param 	string $rgba	The RGBA color string.
		 * @return  string			The corresponding RGB string.
		 */
		public static function rgba_to_rgb( $color ) {
			$obj = Kirki_WP_Color::get_instance( $color );
			return $obj->get_css( 'rgb' );
		}

		/**
		 * Gets the brightness of the $hex color.
		 *
		 * @var     string      The hex value of a color
		 * @return  int         value between 0 and 255
		 */
		public static function get_brightness( $color ) {
			$obj = Kirki_WP_Color::get_instance( $color );
			$brightness = $obj->get_brightness_array();
			return $brightness['total'];
		}

		/**
		 * Adjusts brightness of the $hex color.
		 *
		 * @param   string  $hex    The hex value of a color
		 * @param   integer $steps  should be between -255 and 255. Negative = darker, positive = lighter
		 * @return  string          returns hex color
		 */
		public static function adjust_brightness( $hex, $steps ) {

			$hex = self::sanitize_hex( $hex, false );
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
		 * @param   string|false $hex1
		 * @param   string       $hex2
		 * @param   integer      $percentage        a value between 0 and 100
		 * @return  string       returns hex color
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
}
