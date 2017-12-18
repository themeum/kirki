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
class Kirki_Field_Select extends Kirki_Field {

	/**
	 * Use only on select controls.
	 * Defines if this is a multi-select or not.
	 * If value is > 1, then the maximum number of selectable options
	 * is the number defined here.
	 *
	 * @access protected
	 * @var integer
	 */
	protected $multiple = 1;

	/**
	 * Placeholder text.
	 *
	 * @access protected
	 * @since 3.0.21
	 * @var string|false
	 */
	protected $placeholder = false;

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-select';

	}

	/**
	 * Sets the $multiple
	 *
	 * @access protected
	 */
	protected function set_multiple() {
		$this->multiple = absint( $this->multiple );
	}

	/**
	 * The placeholder text.
	 *
	 * @access protected
	 * @since 3.0.21
	 */
	protected function set_placeholder() {
		$this->placeholder = esc_attr( $this->placeholder );
	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		// If a custom sanitize_callback has been defined,
		// then we don't need to proceed any further.
		if ( ! empty( $this->sanitize_callback ) ) {
			return;
		}
		$this->sanitize_callback = array( $this, 'sanitize' );

	}

	/**
	 * Sanitizes select control values.
	 *
	 * @since 2.2.8
	 * @access public
	 * @param array $value The value.
	 * @return string|array
	 */
	public function sanitize( $value ) {

		if ( is_array( $value ) ) {
			foreach ( $value as $key => $subvalue ) {
				if ( '' !== $subvalue || isset( $this->choices[''] ) ) {
					$key = sanitize_key( $key );
					$value[ $key ] = esc_attr( $subvalue );
				}
			}
			return $value;
		}
		return esc_attr( $value );

	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function set_default() {

		if ( 1 < $this->multiple && ! is_array( $this->default ) ) {
			$this->default = array( $this->default );
		}
	}
}
