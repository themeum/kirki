<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-multicheck
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
class Multicheck extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-multicheck';
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
			$this->sanitize_callback = [ '\Kirki\Field\Multicheck', 'sanitize' ];
		}
	}

	/**
	 * The sanitize method that will be used as a falback
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param string|array $value The control's value.
	 * @return array
	 */
	public static function sanitize( $value ) {
		$value = ( ! is_array( $value ) ) ? explode( ',', $value ) : $value;
		return ( ! empty( $value ) ) ? array_map( 'sanitize_text_field', $value ) : [];
	}
}
