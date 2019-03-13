<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

namespace Kirki\Field;

/**
 * Field overrides.
 */
class Text extends Generic {

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 */
	protected function set_choices() {
		if ( ! is_array( $this->choices ) ) {
			$this->choices = [];
		}
		$this->choices['element'] = 'input';
		$this->choices['type']    = 'text';
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
		$this->sanitize_callback = 'sanitize_textarea_field';
	}
}
