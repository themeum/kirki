<?php
/**
 * Active callback used with the "required" argument in fields
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 */

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

		$show = true;

		// Get all fields.
		$fields = Kirki::$fields;

		// Make sure the current object matches a registered field.
		if ( ! isset( $object->setting->id ) || ! isset( $fields[ $object->setting->id ] ) ) {
			return true;
		}

		$field = $fields[ $object->setting->id ];

		if ( isset( $field['required'] ) ) {

			foreach ( $field['required'] as $requirement ) {
				$show = self::evaluate_requirement( $object, $field, $requirement, 'AND' );
				// The 1st level uses "AND" so no need to process further
				// if one requirement returns false.
				if ( ! $show ) {
					return false;
				}
			}
		}

		return true;

	}

	/**
	 * Figure out whether the current object should be displayed or not.
	 * We're only parsing a single requirement here from the array of requirements.
	 * This is a proxy function that facilitates evaluating and/or conditions.
	 *
	 * @param WP_Customize_Setting $object      The current field.
	 * @param object               $field       The current object.
	 * @param array                $requirement A single requirement.
	 * @param string               $relation    Can be "AND" or "OR".
	 * @return boolean
	 */
	private static function evaluate_requirement( $object, $field, $requirement, $relation ) {

		// Test for callables first.
		if ( is_callable( $requirement ) ) {
			return call_user_func_array( $requirement, array( $field, $object ) );
		}

		// Look for comparison array.
		if ( is_array( $requirement ) && isset( $requirement['operator'], $requirement['value'], $requirement['setting'] ) ) {

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
			if ( method_exists( $current_setting, 'value' ) ) {
				return self::compare( $requirement['value'], $current_setting->value(), $requirement['operator'] );
			}
		} else {
			if ( ! is_array( $requirement ) ) {
				return true;
			}

			// Handles "OR/AND" functionality & switching.
			$show = false;
			$sub_relation = ( 'AND' === $relation ) ? 'OR' : 'AND';
			foreach ( $requirement as $sub_requirement ) {
				$show = self::evaluate_requirement( $object, $field, $sub_requirement, $sub_relation );
				if ( 'OR' === $sub_relation && $show ) {
					return true;
				}
				if ( 'AND' === $sub_relation && ! $show ) {
					return false;
				}
			}
			return $show;
		} // End if().

		return true;
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
				$show = ( $value2 >= $value1 ) ? true : false;
				break;
			case '<=':
			case 'smaller or equal':
			case 'equal or smaller':
				$show = ( $value2 <= $value1 ) ? true : false;
				break;
			case '>':
			case 'greater':
				$show = ( $value2 > $value1 ) ? true : false;
				break;
			case '<':
			case 'smaller':
				$show = ( $value2 < $value1 ) ? true : false;
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
					if ( ! in_array( $string, $array, true ) ) {
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

		} // End switch().

		if ( isset( $show ) ) {
			return $show;
		}

		return true;
	}
}
