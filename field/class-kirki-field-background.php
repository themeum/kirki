<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Field overrides.
 */
class Kirki_Field_Background extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-background';

	}

	/**
	 * Sets the $transport
	 *
	 * @access protected
	 */
	protected function set_transport() {

		// Force using 'refresh' (WIP).
		$this->transport = 'refresh';

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
	 * Sanitizes typography controls
	 *
	 * @since 2.2.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {

		if ( ! is_array( $value ) ) {
			return array();
		}
		return array(
			'background-color'      => ( isset( $value['background-color'] ) ) ? esc_attr( $value['background-color'] ) : '',
			'background-image'      => ( isset( $value['background-image'] ) ) ? esc_url_raw( $value['background-image'] ) : '',
			'background-repeat'     => ( isset( $value['background-repeat'] ) ) ? esc_attr( $value['background-repeat'] ) : '',
			'background-position'   => ( isset( $value['background-position'] ) ) ? esc_attr( $value['background-position'] ) : '',
			'background-size'       => ( isset( $value['background-size'] ) ) ? esc_attr( $value['background-size'] ) : '',
			'background-attachment' => ( isset( $value['background-attachment'] ) ) ? esc_attr( $value['background-attachment'] ) : '',
		);
	}
}
