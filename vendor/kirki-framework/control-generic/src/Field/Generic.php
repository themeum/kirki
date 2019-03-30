<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-generic
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
class Generic extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-generic';
	}


	/**
	 * Sets the $choices
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_choices() {
		if ( ! is_array( $this->choices ) ) {
			$this->choices = [];
		}
		if ( ! isset( $this->choices['element'] ) ) {
			$this->choices['element'] = 'input';
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
			$this->sanitize_callback = 'wp_kses_post';
		}
	}
}
