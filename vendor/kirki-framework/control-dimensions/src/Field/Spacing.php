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
class Spacing extends Dimensions {

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 */
	protected function set_choices() {
		$default_args = [
			'controls' => [
				'top'    => ( isset( $this->default['top'] ) ),
				'bottom' => ( isset( $this->default['top'] ) ),
				'left'   => ( isset( $this->default['top'] ) ),
				'right'  => ( isset( $this->default['top'] ) ),
			],
			'labels'   => [
				'top'    => esc_html__( 'Top', 'kirki' ),
				'bottom' => esc_html__( 'Bottom', 'kirki' ),
				'left'   => esc_html__( 'Left', 'kirki' ),
				'right'  => esc_html__( 'Right', 'kirki' ),
			],
		];

		$this->choices = wp_parse_args( $this->choices, $default_args );
	}
}
