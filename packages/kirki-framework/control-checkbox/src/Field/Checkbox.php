<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/checkbox
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
class Checkbox extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'checkbox';
	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_sanitize_callback() {
		if ( ! $this->sanitize_callback ) {
			$this->sanitize_callback = [ '\Kirki\Field\Checkbox', 'sanitize' ];
		}
	}

	/**
	 * Sanitizes checkbox values.
	 *
	 * @access public
	 * @param boolean|integer|string|null $value The value.
	 * @return bool
	 */
	public static function sanitize( $value = null ) {
		return ( '0' === $value || 'false' === $value ) ? false : (bool) $value;
	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 */
	protected function set_default() {
		$this->default = (bool) in_array( $this->default, [ 1, '1', true, 'true', 'on' ], true );
	}
}
