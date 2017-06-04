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
class Kirki_Field_Image extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-image';

	}

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 */
	protected function set_choices() {

		if ( ! is_array( $this->choices ) ) {
			$this->choices = (array) $this->choices;
		}
		if ( ! isset( $this->choices['save_as'] ) ) {
			$this->choices['save_as'] = 'url';
		}
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
	 * The sanitize method that will be used as a falback
	 *
	 * @param string|array $value The control's value.
	 */
	public function sanitize( $value ) {

		if ( isset( $this->choices['save_as'] ) && 'array' === $this->choices['save_as'] ) {
			return array(
				'id'     => ( isset( $value['id'] ) && '' !== $value['id'] ) ? (int) $value['id'] : '',
				'url'    => ( isset( $value['url'] ) && '' !== $value['url'] ) ? esc_url_raw( $value['url'] ) : '',
				'width'  => ( isset( $value['width'] ) && '' !== $value['width'] ) ? (int) $value['width'] : '',
				'height' => ( isset( $value['height'] ) && '' !== $value['height'] ) ? (int) $value['height'] : '',
			);
		}
		if ( isset( $this->choices['save_as'] ) && 'id' === $this->choices['save_as'] ) {
			return absint( $value );
		}
		if ( is_string( $value ) ) {
			return esc_url_raw( $value );
		}
		return $value;
	}
}
