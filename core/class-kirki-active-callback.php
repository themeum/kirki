<?php
/**
 * Active callback used with the "required" argument in fields
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 */

if ( ! class_exists( 'Kirki_Active_Callback' ) ) {

	/**
	 * Callback class for use with the "required" argument
	 */
	class Kirki_Active_Callback {

		/**
		 * Figure out whether the current object should be displayed or not.
		 *
		 * @param  WP_Customize_Setting $object The current field.
		 * @return boolean
		 */
		public static function evaluate( $object ) {

			// Get all fields.
			$fields = Kirki::$fields;

			// Make sure the current object matches a registered field.
			if ( ! isset( $object->setting->id ) || ! isset( $fields[ $object->setting->id ] ) ) {
				return true;
			}

			$show = true;

			$field = $fields[ $object->setting->id ];

			if ( isset( $field['required'] ) ) {

				foreach ( $field['required'] as $requirement ) {
					// Handles "AND" functionality.
					$show = self::evaluate_requirement( $object, $field, $requirement );
					// No need to process further if one requirement returns false.
					if ( ! $show ) {
						return false;
					}
				}
			}

			return $show;

		}

		/**
		 * Figure out whether the current object should be displayed or not.
		 * We're only parsing a single requirement here from the array of requirements.
		 * This is a proxy function that facilitates evaluating and/or conditions.
		 *
		 * @param  WP_Customize_Setting $object      The current field.
		 * @param  object               $field       The current object.
		 * @param  array                $requirement A single requirement.
		 * @return boolean
		 */
		private static function evaluate_requirement( $object, $field, $requirement ) {

			$show = true;
			// Test for callables first.
			if ( is_callable( $requirement ) ) {

				$show = call_user_func_array( $requirement, array( $field, $object ) );

			// Look for comparison array.
			} elseif ( is_array( $requirement ) && isset( $requirement['operator'], $requirement['value'], $requirement['setting'] ) ) {

				if ( isset( $field['option_name'] ) && '' !== $field['option_name'] ) {
					if ( false === strpos( $requirement['setting'], '[' ) ) {
						$requirement['setting'] = $field['option_name'] . '[' . $requirement['setting'] . ']';
					}
				}

				$current_setting = $object->manager->get_setting( $requirement['setting'] );

				/**
				 * Depending on the 'operator' argument we use,
				 * we'll need to perform the appropriate comparison
				 * and figure out if the control will be shown or not.
				 */
				$show = self::compare( $requirement['value'], $current_setting->value(), $requirement['operator'] );

			} else {

				if ( is_array( $requirement ) ) {
					// Handles "OR" functionality.
					$show = false;
					foreach ( $requirement as $sub_requirement ) {
						$show = self::evaluate_requirement( $object, $field, $sub_requirement );
						// No need to go on if one sub_requirement returns true.
						if ( $show ) {
							return true;
						}
					}
				} else {
					return true;
				}
			}

			return $show;
		}

		/**
		 * Compares the 2 values given the condition
		 *
		 * @param mixed  $value1   The 1st value in the comparison.
		 * @param mixed  $value2   The 2nd value in the comparison.
		 * @param string $operator The operator we'll use for the comparison.
		 * @return boolean whether The comparison has succeded (true) or failed (false).
		 */
		public static function compare( $value1, $value2, $operator ) {
			switch ( $operator ) {
				case '===':
					$show = ( $value1 === $value2 ) ? true : false;
					break;
				case '==':
				case '=':
				case 'equals':
				case 'equal':
					$show = ( $value1 == $value2 ) ? true : false;
					break;
				case '!==':
					$show = ( $value1 !== $value2 ) ? true : false;
					break;
				case '!=':
				case 'not equal':
					$show = ( $value1 != $value2 ) ? true : false;
					break;
				case '>=':
				case 'greater or equal':
				case 'equal or greater':
					$show = ( $value1 >= $value2 ) ? true : false;
					break;
				case '<=':
				case 'smaller or equal':
				case 'equal or smaller':
					$show = ( $value1 <= $value2 ) ? true : false;
					break;
				case '>':
				case 'greater':
					$show = ( $value1 > $value2 ) ? true : false;
					break;
				case '<':
				case 'smaller':
					$show = ( $value1 < $value2 ) ? true : false;
					break;
				case 'contains':
				case 'in':
					if ( is_array( $value1 ) && ! is_array( $value2 ) ) {
						$array  = $value1;
						$string = $value2;
					} elseif ( is_array( $value2 ) && ! is_array( $value1 ) ) {
						$array  = $value2;
						$string = $value1;
					}
					if ( isset( $array ) && isset( $string ) ) {
						if ( ! in_array( $string, $array ) ) {
							$show = false;
						}
					} else {
						if ( false === strrpos( $value1, $value2 ) && false === strpos( $value2, $value1 ) ) {
							$show = false;
						}
					}
					break;
				default:
					$show = ( $value1 == $value2 ) ? true : false;

			}

			if ( isset( $show ) ) {
				return $show;
			}

			return true;
		}
	}
}
