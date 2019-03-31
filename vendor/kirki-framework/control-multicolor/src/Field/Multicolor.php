<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-multicolor
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Core\Field;
use Kirki\Field\Color;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Multicolor extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-multicolor';
	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_choices() {

		// Make sure choices are defined as an array.
		if ( ! is_array( $this->choices ) ) {
			$this->choices = [];
		}
	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_sanitize_callback() {
		if ( empty( $this->sanitize_callback ) ) {
			$this->sanitize_callback = [ $this, 'sanitize' ];
		}
	}

	/**
	 * The method that will be used as a `sanitize_callback`.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param array $value The value to be sanitized.
	 * @return array The value.
	 */
	public static function sanitize( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}
		foreach ( $value as $key => $val ) {
			$value[ $key ] = Color::sanitize( $val );
		}
		return $value;
	}
}
