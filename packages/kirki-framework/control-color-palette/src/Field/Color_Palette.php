<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-color-palette
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
class Color_Palette extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 */
	protected function set_type() {
		$this->type = 'kirki-color-palette';
	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_sanitize_callback() {

		// Check if a sanitization callback is defined or not.
		// Only proceed if no custom callback has been defined.
		if ( empty( $this->sanitize_callback ) ) {
			$this->sanitize_callback = [ '\kirki\Field\Color_Palette', 'sanitize' ];
		}
	}

	/**
	 * Sanitization callback.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param string $value The color value.
	 * @return string
	 */
	public static function sanitize( $value ) {
		if ( class_exists( '\Kirki\Field\Color' ) ) {
			return \Kirki\Field\Color::sanitize( $value );
		}
		return esc_attr( $value );
	}
}
