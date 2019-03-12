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
class Dimension extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-dimension';
	}

	/**
	 * Sanitizes the value.
	 *
	 * @access public
	 * @param string $value The value.
	 * @return string
	 */
	public function sanitize( $value ) {
		return sanitize_text_field( $value );
	}
}
