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
	class Kirki_Color extends Kirki_WP_Color {

		/**
		 * Sanitises a HEX value.
		 *
		 * @var     string      The hex value of a color
		 * @param   boolean     Whether we want to include a hash (#) at the beginning or not
		 * @return  string      The sanitized hex color.
		 */
		 public static function sanitize_hex( $color = '#FFFFFF', $hash = true ) {
		 	$obj = kirki_wp_color( $color );
		 	if ( ! $hash ) {
		 		return ltrim( $obj->get_css( 'hex' ), '#' );
		 	}
		 	return $obj->get_css( 'hex' );
		}

		public static function sanitize_rgba( $value ) {
			$obj = kirki_wp_color( $value );
			return $obj->get_css( 'rgba' );
		}

		/**
		 * Sanitize colors.
		 * Determine if the current value is a hex or an rgba color and call the appropriate method.
		 *
		 * @since 0.8.5
		 *
		 * @param  $color   string  hex or rgba color
		 * @param  $default string  hex or rgba color
		 * @return string
		 */
		public static function sanitize_color( $color ) {
			if ( is_string( $color ) && 'transparent' == trim( $color ) ) {
				return 'transparent';
			}
			$obj = kirki_wp_color( $color );
			return $obj->get_css( $obj->mode );
		}

		/**
		 * Gets the rgb value of the $hex color.
		 *
		 * @var     string      The hex value of a color
		 * @param   boolean     Whether we want to implode the values or not
		 * @return  mixed       array|string
		 */
		public static function get_rgb( $hex, $implode = false ) {
			$obj = kirki_wp_color( $hex );
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
		public static function rgba2hex( $color ) {
			$obj = kirki_wp_color( $color );
			return $obj->get_css( 'hex' );
		}

		/**
		 * Get the alpha channel from an rgba color
		 *
		 * @var     string  The rgba color formatted like rgba(r,g,b,a)
		 * @return  string  The alpha value of the color.
		 */
		public static function get_alpha_from_rgba( $color ) {
			$obj = kirki_wp_color( $color );
			return $obj->alpha;
		}

		/**
		 * Gets the rgba value of the $color.
		 *
		 * @var     string      The hex value of a color
		 * @param   int         Opacity level (0-1)
		 * @return  string
		 */
		public static function get_rgba( $color = '#fff', $alpha = 1 ) {
			$obj = kirki_wp_color( $color );
			if ( 1 == $alpha ) {
				return $obj->get_css( 'rgba' );
			}
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
			$obj = kirki_wp_color( $color );
			return $obj->get_css( 'rgb' );
		}

		/**
		 * Gets the brightness of the $hex color.
		 *
		 * @var     string      The hex value of a color
		 * @return  int         value between 0 and 255
		 */
		public static function get_brightness( $color ) {
			$obj = kirki_wp_color( $color );
			return $obj->brightness['total'];
		}

		/**
		 * Adjusts brightness of the $hex color.
		 *
		 * @param   string  $hex    The hex value of a color
		 * @param   integer $steps  should be between -255 and 255. Negative = darker, positive = lighter
		 * @return  string          returns hex color
		 */
		public static function adjust_brightness( $hex, $steps ) {
			$obj = kirki_wp_color( $hex );
			if ( 0 == $steps ) {
				return $obj->get_css( 'hex' );
			}
			$new_brightness = ( 0 < $steps ) ? $obj->brightness['total'] - $steps : $obj->brightness['total'] + $steps;
			$new_brightness = max( 0, min( 255, $brightness ) );
			$new_obj = $obj->get_new_object_by( 'brightness', $new_brightness );
			return $new_obj->get_css( 'hex' );
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
