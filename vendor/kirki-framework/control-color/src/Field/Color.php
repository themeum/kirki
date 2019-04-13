<?php
/**
 * Object used by the Kirki framework to instantiate the control.
 *
 * This is a man-in-the-middle class, nothing but a proxy to set sanitization
 * callbacks and any usother properties we may need.
 *
 * @package   kirki-framework/control-color
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Core\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Color extends Field {

	/**
	 * Mode (hue)
	 *
	 * @access protected
	 * @since 1.0
	 * @var string
	 */
	protected $mode = 'full';

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-color';
	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_choices() {

		// Make sure choices is an array.
		if ( ! is_array( $this->choices ) ) {
			$this->choices = [];
		}

		$this->choices['alpha'] = isset( $this->choices['alpha'] ) ? (bool) $this->choices['alpha'] : false;
		$this->choices['mode']  = isset( $this->choices['mode'] ) && \in_array( $this->choices['mode'], [ 'hex', 'hue' ], true ) ? $this->choices['mode'] : 'hex';
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

			// If this is a hue control then things are pretty simple,
			// we just need to sanitize as an integer.
			if ( 'hue' === $this->mode ) {
				$this->sanitize_callback = 'absint';
				return;
			}

			// Set the callback.
			$this->sanitize_callback = [ '\kirki\Field\Color', 'sanitize' ];
		}
	}

	/**
	 * Sanitize colors.
	 *
	 * @static
	 * @access public
	 * @since 1.0.2
	 * @param string $value The color.
	 * @return string
	 */
	public static function sanitize( $value ) {

		// This pattern will check and match 3/6/8-character hex, rgb, rgba, hsl, & hsla colors.
		$pattern = '/^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/';
		$values  = \preg_match( $pattern, $value, $matches );

		// Return the 1st match found.
		if ( isset( $matches[0] ) ) {
			if ( is_string( $matches[0] ) ) {
				return $matches[0];
			}
			if ( is_array( $matches[0] ) && isset( $matches[0][0] ) ) {
				return $matches[0][0];
			}
		}

		// If no match was found, return an empty string.
		return '';
	}
}
