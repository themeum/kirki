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
class Checkbox_Switch extends Checkbox {

	/**
	 * Sets the control type.
	 *
	 * @access protected
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
