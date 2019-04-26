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

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Checkbox_Switch extends Checkbox {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-switch';
	}

	/**
	 * Sets the control choices.
	 *
	 * @access protected
	 */
	protected function set_choices() {
		if ( ! is_array( $this->choices ) ) {
			$this->choices = [];
		}

		$this->choices = wp_parse_args(
			$this->choices,
			[
				'on'    => esc_html__( 'On', 'kirki' ),
				'off'   => esc_html__( 'Off', 'kirki' ),
				'round' => false,
			]
		);
	}
}
