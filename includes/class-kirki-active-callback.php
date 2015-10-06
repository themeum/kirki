<?php

class Kirki_Active_Callback extends Kirki_Customizer {

	/**
	 * Figure out whether the current object should be displayed or not.
	 *
	 * @param $object 	the current field
	 * @return boolean
	 */
	public static function evaluate( $object ) {

		// Get all fields
		$fields = Kirki::$fields;

		if ( ! isset( $fields[ $object->id ] ) ) {
			return true;
		}

		$current_object = $fields[ $object->id ];

		if ( isset( $current_object['required'] ) ) {

			foreach ( $current_object['required'] as $requirement ) {

				/**
				 * If the setting required does not exist, then show the control.
				 * This ensures that even if we enter the wrong settings,
				 * the field will not mysteriously disappear.
				 */
				if ( ! is_object( $object->manager->get_setting( $fields[ $requirement['setting'] ]['settings'] ) ) ) {
					$show = true;
				}

				/**
				 * If one of the conditions is false,
				 * then we don't need to further proceed.
				 * ALL conditions must be met in order to show the control,
				 * so we'll return early and terminate the loop.
				 */
				if ( isset( $show ) && ! $show ) {
					return false;
				}

				/**
				 * Depending on the 'operator' argument we use,
				 * we'll need to perform the appropriate comparison
				 * and figure out if the control will be shown or not.
				 */
				$show = self::compare(
					$requirement['value'],
					$object->manager->get_setting( $fields[ $requirement['setting'] ]['settings'] )->value(),
					$requirement['operator']
				);

			}

		}

		return ( isset( $show ) && ( false === $show ) ) ? false : true;

	}

	/**
	 * @param mixed $value1 the 1st value in the comparison
	 * @param mixed $value2 the 2nd value in the comparison
	 * @param string $operator the operator we'll use for the comparison.
	 * @return boolean whether the comparison has succeded (true) or failed (false).
	 */
	public static function compare( $value1, $value2, $operator ) {
		switch ( $operator ) {
			case '===':
				$show = ( $value1 === $value2 ) ? true : false;
				break;
			case '==':
				$show = ( $value1 == $value2 ) ? true : false;
				break;
			case '!==':
				$show = ( $value1 !== $value2 ) ? true : false;
				break;
			case '!=':
				$show = ( $value1 != $value2 ) ? true : false;
				break;
			case '>=':
				$show = ( $value1 >= $value2 ) ? true : false;
				break;
			case '<=':
				$show = ( $value1 <= $value2 ) ? true : false;
				break;
			case '>':
				$show = ( $value1 > $value2 ) ? true : false;
				break;
			case '<':
				$show = ( $value1 < $value2 ) ? true : false;
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
