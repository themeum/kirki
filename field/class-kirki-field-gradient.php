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
class Kirki_Field_Gradient extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-gradient';

	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 */
	protected function set_choices() {

		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}

		$defaults = array(
			'alpha'     => true,
			'direction' => 'top-to-bottom',
		);
		$this->choices = wp_parse_args( $this->choices, $defaults );

	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		$this->sanitize_callback = array( $this, 'sanitize' );

	}

	/**
	 * Sanitizes checkbox values.
	 *
	 * @access public
	 * @param boolean|integer|string|null $value The checkbox value.
	 * @return bool
	 */
	public function sanitize( $value = null ) {

		// Make sure value in an array.
		$value = ( ! is_array( $value ) ) ? array() : $value;

		// Make sure start & end values are arrays.
		$value['start'] = ( ! isset( $value['start'] ) ) ? array() : $value['start'];
		$value['end']   = ( ! isset( $value['end'] ) )   ? array() : $value['end'];

		// Sanitie colors.
		$value['start']['color'] = ( ! isset( $value['start']['color'] ) ) ? '' : esc_attr( $value['start']['color'] );
		$value['end']['color']   = ( ! isset( $value['end']['color'] ) ) ? '' : esc_attr( $value['end']['color'] );

		// Sanitize positions.
		$value['start']['position'] = ( ! isset( $value['start']['position'] ) ) ? 0 : (int) $value['start']['position'];
		$value['start']['position'] = ( 0 > $value['start']['position'] ) ? 0 : $value['start']['position'];
		$value['start']['position'] = ( 100 < $value['start']['position'] ) ? 100 : $value['start']['position'];
		$value['end']['position']   = ( ! isset( $value['end']['position'] ) ) ? 0 : (int) $value['end']['position'];
		$value['end']['position']   = ( 0 > $value['end']['position'] ) ? 0 : $value['end']['position'];
		$value['end']['position']   = ( 100 < $value['end']['position'] ) ? 100 : $value['end']['position'];

		// Sanitize angle.
		$value['angle'] = ( ! isset( $value['angle'] ) ) ? 0 : (int) $value['angle'];
		$value['angle'] = ( -90 > $value['angle'] ) ? -90 : $value['angle'];
		$value['angle'] = ( 90 < $value['angle'] ) ? 90 : $value['angle'];

		// Sanitize the type.
		$value['type'] = ( ! isset( $value['type'] ) || 'linear' !== $value['type'] || 'radial' !== $value['type'] ) ? 'linear' : $value['type'];

		return $value;

	}

}
