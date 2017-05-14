<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Number extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-number';

	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		$this->sanitize_callback = array( $this, 'sanitize' );

	}

	/**
	 * Sanitizes numeric values.
	 *
	 * @access public
	 * @param boolean|integer|string|null $value The checkbox value.
	 * @return bool
	 */
	public function sanitize( $value = null ) {

		// Make sure min, max & step are all numeric.
		$min  = ( isset( $this->choices['min'] ) && ! is_numeric( $this->choices['min'] ) ) ? filter_var( $this->choices['min'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) : -999999999;
		$max  = ( isset( $this->choices['max'] ) && ! is_numeric( $this->choices['max'] ) ) ? filter_var( $this->choices['max'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) : 999999999;
		$step = ( isset( $this->choices['step'] ) && ! is_numeric( $this->choices['step'] ) ) ? filter_var( $this->choices['step'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) : 1;

		if ( ! is_numeric( $value ) ) {
			$value = filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
		}

		// Minimum value limit.
		if ( $value < $min ) {
			return $min;
		}

		// Maximum value limit.
		if ( $value > $max ) {
			return $max;
		}

		// Step divider.
		if ( isset( $this->choices['min'] ) && isset( $this->choices['step'] ) ) {
			$valid = range( $min, $max, $step );

			$smallest = array();
			foreach ( $valid as $possible_value ) {
				$smallest[ $possible_value ] = abs( $possible_value - $value );
			}
			asort( $smallest );
			$value = key( $smallest );
		}

		return $value;

	}

}
