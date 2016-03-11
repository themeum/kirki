<?php
/**
 * Additional sanitization methods for controls.
 * These are used in the field's 'sanitize_callback' argument.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Sanitize_Values' ) ) {
	class Kirki_Sanitize_Values extends Kirki_Customizer {

		/**
		 * Checkbox sanitization callback.
		 *
		 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
		 * as a boolean value, either TRUE or FALSE.
		 *
		 * @param bool|string $checked Whether the checkbox is checked.
		 * @return bool Whether the checkbox is checked.
		 */
		public static function checkbox( $checked ) {
			return ( ( isset( $checked ) && ( true == $checked || 'on' == $checked ) ) ? true : false );
		}

		/**
		 * Sanitize number options
		 *
		 * @since 0.5
		 */
		public static function number( $value ) {
			return ( is_numeric( $value ) ) ? $value : intval( $value );
		}

		/**
		 * Drop-down Pages sanitization callback.
		 *
		 * - Sanitization: dropdown-pages
		 * - Control: dropdown-pages
		 *
		 * Sanitization callback for 'dropdown-pages' type controls. This callback sanitizes `$page_id`
		 * as an absolute integer, and then validates that $input is the ID of a published page.
		 *
		 * @see absint() https://developer.wordpress.org/reference/functions/absint/
		 * @see get_post_status() https://developer.wordpress.org/reference/functions/get_post_status/
		 *
		 * @param int                  $page_id    Page ID.
		 * @param WP_Customize_Setting $setting Setting instance.
		 * @return int|string Page ID if the page is published; otherwise, the setting default.
		 */
		public static function dropdown_pages( $page_id, $setting ) {
			// Ensure $input is an absolute integer.
			$page_id = absint( $page_id );

			// If $page_id is an ID of a published page, return it; otherwise, return the default.
			return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
		}

		/**
		 * Sanitizes typography controls
		 *
		 * @since 2.2.0
		 * @return array
		 */
		public static function typography( $value ) {
			if ( ! is_array( $value ) ) {
				return array();
			}
			// escape the font-family
			if ( isset( $value['font-family'] ) ) {
				$value['font-family'] = esc_attr( $value['font-family'] );
			}
			// make sure we're using a valid variant.
			// We're adding checks for font-weight as well for backwards-compatibility
			// Versions 2.0 - 2.2 were using an integer font-weight.
			if ( isset( $value['variant'] ) || isset( $value['font-weight'] ) ) {
				if ( isset( $value['font-weight'] ) && ! empty( $value['font-weight'] ) ) {
					if ( ! isset( $value['variant'] ) || empty( $value['variant'] ) ) {
						$value['variant'] = $value['font-weight'];
					}
				}
				$valid_variants = array(
					'regular',
					'italic',
					'100',
					'200',
					'300',
					'500',
					'600',
					'700',
					'700italic',
					'900',
					'900italic',
					'100italic',
					'300italic',
					'500italic',
					'800',
					'800italic',
					'600italic',
					'200italic',
				);
				if ( ! in_array( $value['variant'], $valid_variants ) ) {
					$value['variant'] = 'regular';
				}
			}
			// Make sure we're using a valid subset
			if ( isset( $value['subset'] ) ) {
				$valid_subsets = array(
					'all',
					'greek-ext',
					'greek',
					'cyrillic-ext',
					'cyrillic',
					'latin-ext',
					'latin',
					'vietnamese',
					'arabic',
					'gujarati',
					'devanagari',
					'bengali',
					'hebrew',
					'khmer',
					'tamil',
					'telugu',
					'thai',
				);
				$subsets_ok = array();
				if ( is_array( $value['subset'] ) ) {
					foreach ( $value['subset'] as $subset ) {
						if ( in_array( $subset, $valid_subsets ) ) {
							$subsets_ok[] = $subset;
						}
					}
					$value['subsets'] = $subsets_ok;
				}
			}
			// Sanitize the font-size
			if ( isset( $value['font-size'] ) && ! empty( $value['font-size'] ) ) {
				$value['font-size'] = self::css_dimension( $value['font-size'] );
				if ( $value['font-size'] == self::filter_number( $value['font-size'] ) ) {
					$value['font-size'] .= 'px';
				}
			}
			// Sanitize the line-height
			if ( isset( $value['line-height'] ) && ! empty( $value['line-height'] ) ) {
				$value['line-height'] = self::css_dimension( $value['line-height'] );
			}
			// Sanitize the letter-spacing
			if ( isset( $value['letter-spacing'] ) && ! empty( $value['letter-spacing'] ) ) {
				$value['letter-spacing'] = self::css_dimension( $value['font-size'] );
				if ( $value['letter-spacing'] == self::filter_number( $value['letter-spacing'] ) ) {
					$value['letter-spacing'] .= 'px';
				}
			}
			// Sanitize the color
			if ( isset( $value['color'] ) && ! empty( $value['color'] ) ) {
				$color = ariColor::newColor( $value['color'] );
				$value['color'] = $color->toCSS( 'hex' );
			}

			return $value;

		}

		/**
		 * Sanitizes css dimensions
		 *
		 * @since 2.2.0
		 * @return string
		 */
		public static function css_dimension( $value ) {
			// trim it
			$value = trim( $value );
			// if round, return 50%
			if ( 'round' == $value ) {
				$value = '50%';
			}
			// if empty, return empty
			if ( '' == $value ) {
				return '';
			}
			// If auto, return auto
			if ( 'auto' == $value ) {
				return 'auto';
			}
			// Return empty if there are no numbers in the value.
			if ( ! preg_match( '#[0-9]#' , $value ) ) {
				return '';
			}
			// The raw value without the units
			$raw_value = self::filter_number( $value );
			$unit_used = '';
			// An array of all valid CSS units. Their order was carefully chosen for this evaluation, don't mix it up!!!
			$units = array( 'rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax' );
			foreach ( $units as $unit ) {
				if ( false !== strpos( $value, $unit ) ) {
					$unit_used = $unit;
				}
			}
			return $raw_value . $unit_used;
		}

		/**
		 * @param string $value
		 */
		public static function filter_number( $value ) {
			return filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		}

		/**
		 * Sanitize sortable controls
		 *
		 * @since 0.8.3
		 *
		 * @return mixed
		 */
		public static function sortable( $value ) {
			if ( is_serialized( $value ) ) {
				return $value;
			} else {
				return serialize( $value );
			}
		}

		/**
		 * Sanitize RGBA colors
		 *
		 * @since 0.8.5
		 *
		 * @return string
		 */
		public static function rgba( $value ) {

			// If empty or an array return transparent
			if ( empty( $value ) || is_array( $value ) ) {
				return 'rgba(0,0,0,0)';
			}

			// If string does not start with 'rgba', then treat as hex
			// sanitize the hex color and finally convert hex to rgba
			if ( false === strpos( $value, 'rgba' ) ) {
				return Kirki_Color::get_rgba( Kirki_Color::sanitize_hex( $value ) );
			}

			// By now we know the string is formatted as an rgba color so we need to further sanitize it.
			$value = str_replace( ' ', '', $value );
			sscanf( $value, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
			return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';

		}

		/**
		 * Sanitize colors.
		 * Determine if the current value is a hex or an rgba color and call the appropriate method.
		 *
		 * @since 0.8.5
		 * @return string
		 */
		public static function color( $value ) {

			// Is this an rgba color or a hex?
			$mode = ( false === strpos( $value, 'rgba' ) ) ? 'rgba' : 'hex';

			if ( 'rgba' == $mode ) {
				return Kirki_Color::sanitize_hex( $value );
			} else {
				return self::rgba( $value );
			}

		}

		/**
		 * multicheck callback
		 */
		public static function multicheck( $values ) {

			$multi_values = ( ! is_array( $values ) ) ? explode( ',', $values ) : $values;
			return ( ! empty( $multi_values ) ) ? array_map( 'sanitize_text_field', $multi_values ) : array();

		}

		/**
		 * DOES NOT SANITIZE ANYTHING.
		 *
		 * @since 0.5
		 *
		 * @return mixed
		 */
		public static function unfiltered( $value ) {
			return $value;
		}

	}
}
