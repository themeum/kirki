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
class Kirki_Field_Spacing extends Kirki_Field_Number {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-dimensions';

	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		// If a custom sanitize_callback has been defined,
		// then we don't need to proceed any further.
		if ( ! empty( $this->sanitize_callback ) ) {
			return;
		}
		$this->sanitize_callback = array( $this, 'sanitize_value' );

	}

	/**
	 * Sanitizes the value.
	 *
	 * @access public
	 * @param array $value The value.
	 * @return array
	 */
	public function sanitize_value( $value ) {

		// Sanitize each sub-value separately.
		foreach ( $value as $key => $sub_value ) {
			$value[ $key ] = Kirki_Sanitize_Values::css_dimension( $sub_value );
		}
		return $value;

	}

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 */
	protected function set_choices() {

		$default_args = array(
			'controls' => array(
				'top'    => ( isset( $this->default['top'] ) ),
				'bottom' => ( isset( $this->default['top'] ) ),
				'left'   => ( isset( $this->default['top'] ) ),
				'right'  => ( isset( $this->default['top'] ) ),
			),
			'labels'   => array(
				'top'    => esc_attr__( 'Top', 'kirki' ),
				'bottom' => esc_attr__( 'Bottom', 'kirki' ),
				'left'   => esc_attr__( 'Left', 'kirki' ),
				'right'  => esc_attr__( 'Right', 'kirki' ),
			),
		);

		$this->choices = wp_parse_args( $this->choices, $default_args );

	}
}
