<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       2.3.2
 */

namespace Kirki\Field;

use Kirki\Core\Field;

/**
 * Field overrides.
 */
class Sortable extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-sortable';
	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {
		$this->sanitize_callback = [ $this, 'sanitize' ];
	}

	/**
	 * Sanitizes sortable values.
	 *
	 * @access public
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
