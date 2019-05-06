<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-dimensions
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Compatibility\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Dimensions extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-dimensions';
	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_sanitize_callback() {
		if ( empty( $this->sanitize_callback ) ) {
			$this->sanitize_callback = [ '\Kirki\Field\Dimensions', 'sanitize' ];
		}
	}

	/**
	 * Sanitizes the value.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {

		// Sanitize each sub-value separately.
		foreach ( $value as $key => $sub_value ) {
			$value[ $key ] = sanitize_text_field( $sub_value );
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
		$this->choices['controls'] = [];
		if ( is_array( $this->default ) ) {
			foreach ( $this->default as $key => $value ) {
				$this->choices['controls'][ $key ] = true;
			}
		}
	}
}
