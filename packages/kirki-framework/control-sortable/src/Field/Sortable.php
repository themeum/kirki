<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-sortable
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
class Sortable extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-sortable';
	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_sanitize_callback() {
		$this->sanitize_callback = [ $this, 'sanitize' ];
	}

	/**
	 * Sanitizes sortable values.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $value The checkbox value.
	 * @return array
	 */
	public function sanitize( $value = [] ) {
		if ( is_string( $value ) || is_numeric( $value ) ) {
			return [
				sanitize_text_field( $value ),
			];
		}
		$sanitized_value = [];
		foreach ( $value as $sub_value ) {
			if ( isset( $this->choices[ $sub_value ] ) ) {
				$sanitized_value[] = sanitize_text_field( $sub_value );
			}
		}
		return $sanitized_value;
	}
}
