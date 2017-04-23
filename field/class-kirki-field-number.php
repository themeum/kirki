<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
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

		$value = ( is_numeric( $value ) ) ? $value : intval( $value );

		// Minimum value limit.
		if ( isset( $this->choices['min'] ) ) {
			$min = ( is_numeric( $this->choices['min'] ) ) ? $this->choices['min'] : intval( $this->choices['min'] );
			if ( $value < $min ) {
				$value = $min;
			}
		}

		// Maximum value limit.
		if ( isset( $this->choices['max'] ) ) {
			$max = ( is_numeric( $this->choices['max'] ) ) ? $this->choices['max'] : intval( $this->choices['max'] );
			if ( $value > $max ) {
				$value = $max;
			}
		}

		// Step divider.
		if ( isset( $this->choices['min'] ) && isset( $this->choices['step'] ) ) {
			$min   = ( is_numeric( $this->choices['min'] ) ) ? $this->choices['min'] : intval( $this->choices['min'] );
			$max   = ( is_numeric( $this->choices['max'] ) ) ? $this->choices['max'] : intval( $this->choices['max'] );
			$step  = ( is_numeric( $this->choices['step'] ) ) ? $this->choices['step'] : intval( $this->choices['step'] );
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
