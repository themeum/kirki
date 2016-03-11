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
	final class Kirki_Color extends ariColor {

		/**
		 * A proxy for the sanitize_color method.
		 *
		 * @param   mixed       The color
		 * @param   boolean     Whether we want to include a hash (#) at the beginning or not
		 *
		 * @return  string      The sanitized hex color.
		 */
		 public static function sanitize_hex( $color = '#FFFFFF', $hash = true ) {
		 	if ( ! $hash ) {
		 		return ltrim( self::sanitize_color( $color, 'hex' ), '#' );
		 	}
		 	return self::sanitize_color( $color, 'hex' );
		}

		/**
		 * A proxy the sanitize_color method.
		 *
		 * @param  $color
		 *
		 * @return string
		 */
		public static function sanitize_rgba( $color ) {
			return self::sanitize_color( $color, 'rgba' );
		}

		/**
		 * Sanitize colors.
		 * Determine if the current value is a hex or an rgba color and call the appropriate method.
		 *
		 * @since 0.8.5
		 *
		 * @param  $color   mixed
		 *
		 * @return string
		 */
		public static function sanitize_color( $color = '', $mode = 'auto' ) {
			if ( is_string( $color ) && 'transparent' == trim( $color ) ) {
				return 'transparent';
			}
			$obj = kirki_wp_color( $color );
			if ( 'auto' == $mode ) {
				$mode = $obj->mode;
			}
			return $obj->toCSS( $mode );
		}

		/**
		 * Gets the rgb value of a color.
		 *
		 * @param   string      The color
		 * @param   boolean     Whether we want to implode the values or not
		 *
		 * @return  mixed       array|string
		 */
		public static function get_rgb( $color, $implode = false ) {
			$obj = kirki_wp_color( $color );
			if ( $implode ) {
				return $obj->toCSS( 'rgb' );
			}
			return array( $obj->red, $obj->green, $obj->blue );
		}

		/**
		 * A proxy for the sanitize_color method
		 *
		 * @param   mixed
		 *
		 * @return  string  The hex value of the color.
		 */
		public static function rgba2hex( $color ) {
			return self::sanitize_color( $color, 'hex' );
		}

		/**
		 * Get the alpha channel from an rgba color
		 *
		 * @param   string     The rgba color formatted like rgba(r,g,b,a)
		 *
		 * @return  int|float  The alpha value of the color.
		 */
		public static function get_alpha_from_rgba( $color ) {
			$obj = kirki_wp_color( $color );
			return $obj->alpha;
		}

		/**
		 * Gets the rgba value of the $color.
		 *
		 * @param   string      The hex value of a color
		 * @param   int         Opacity level (0-1)
		 *
		 * @return  string
		 */
		public static function get_rgba( $color = '#fff', $alpha = 1 ) {
			$obj = kirki_wp_color( $color );
			if ( 1 == $alpha ) {
				return $obj->toCSS( 'rgba' );
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
			$new_obj = $obj->getNew( 'alpha', $alpha );
			return $new_obj->toCSS( 'rgba' );
		}

		/**
		 * Strips the alpha value from an RGBA color string.
		 *
		 * @param 	string $color	The RGBA color string.
		 *
		 * @return  string			The corresponding RGB string.
		 */
		public static function rgba_to_rgb( $color ) {
			$obj = kirki_wp_color( $color );
			return $obj->toCSS( 'rgb' );
		}

		/**
		 * Gets the brightness of the $hex color.
		 *
		 * @param   string      The hex value of a color
		 *
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
		 *
		 * @return  string          returns hex color
		 */
		public static function adjust_brightness( $hex, $steps ) {
			$obj = kirki_wp_color( $hex );
			if ( 0 == $steps ) {
				return $obj->toCSS( 'hex' );
			}
			$new_brightness = ( 0 < $steps ) ? $obj->brightness['total'] - $steps : $obj->brightness['total'] + $steps;
			$new_brightness = max( 0, min( 255, $new_brightness ) );
			$new_obj = $obj->getNew( 'brightness', $new_brightness );
			return $new_obj->toCSS( 'hex' );
		}

		/**
		 * Mixes 2 hex colors.
		 * the "percentage" variable is the percent of the first color
		 * to be used it the mix. default is 50 (equal mix)
		 *
		 * @param   string       $color1
		 * @param   string       $color2
		 * @param   integer      $percentage        a value between 0 and 100
		 *
		 * @return  string       returns hex color
		 */
		public static function mix_colors( $color1, $color2, $percentage ) {
			$obj_1     = kirki_wp_color( $color1 );
			$obj_2     = kirki_wp_color( $color2 );
			$new_color = kirki_wp_color( array(
				( $percentage * $obj_1->red + ( 100 - $percentage ) * $obj_2->red ) / 100,
				( $percentage * $obj_1->green + ( 100 - $percentage ) * $obj_2->green ) / 100,
				( $percentage * $obj_1->blue + ( 100 - $percentage ) * $obj_2->blue ) / 100,
			) );
			return $new_color->toCSS( 'hex' );
		}

		/**
		 * Convert color to hsl
		 *
		 * @param   mixed   color
		 *
		 * @return  string  css-formated hsl color
		 */
		public static function to_hsl( $color ) {
			$obj = kirki_wp_color( $color );
			return $obj->toCSS( 'hsl' );
		}

		/*
		 * This is a very simple algorithm that works by summing up the differences between the three color components red, green and blue.
		 * A value higher than 500 is recommended for good readability.
		 */
		public static function color_difference( $color_1 = '#ffffff', $color_2 = '#000000' ) {
			$obj_1 = kirki_wp_color( $color_1 );
			$obj_2 = kirki_wp_color( $color_2 );

			$r_diff = max( $obj_1->red, $obj_2->red ) - min( $obj_1->red, $obj_2->red );
			$g_diff = max( $obj_1->green, $obj_2->green ) - min( $obj_1->green, $obj_2->green );
			$b_diff = max( $obj_1->blue, $obj_2->blue ) - min( $obj_1->blue, $obj_2->blue );

			$color_diff = $r_diff + $g_diff + $b_diff;

			return $color_diff;
		}

		/*
		 * This function tries to compare the brightness of the colors.
		 * A return value of more than 125 is recommended.
		 * Combining it with the color_difference function above might make sense.
		 */
		public static function brightness_difference( $color_1 = '#ffffff', $color_2 = '#000000' ) {
			$obj1 = kirki_wp_color( $color_1 );
			$obj2 = kirki_wp_color( $color_2 );
			return intval( abs( $obj1->brightness['total'] - $obj2->brightness['total'] ) );
		}

		/*
		 * Uses the ligghtness to calculate the difference between the given colors.
		 * The returned value should be bigger than 5 for best readability.
		 */
		public static function lightness_difference( $color_1 = '#ffffff', $color_2 = '#000000' ) {
			$obj1 = kirki_wp_color( $color_1 );
			$obj2 = kirki_wp_color( $color_2 );
			return abs( $obj1->lightness - $obj2->lightness );
		}

	}
}
