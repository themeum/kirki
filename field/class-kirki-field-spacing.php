<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Spacing extends Kirki_Field_Dimensions {

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 */
	protected function set_choices() {

		$default_args = array(
			'controls' => array(
				'top'    => ( isset( $this->default['top'] ) ),
				'bottom' => ( isset( $this->default['top'] ) ),
				'left'   => ( isset( $this->default['top'] ) ),
				'right'  => ( isset( $this->default['top'] ) ),
			),
			'labels'   => array(
				'top'    => esc_attr__( 'Top', 'kirki' ),
				'bottom' => esc_attr__( 'Bottom', 'kirki' ),
				'left'   => esc_attr__( 'Left', 'kirki' ),
				'right'  => esc_attr__( 'Right', 'kirki' ),
			),
		);

		$this->choices = wp_parse_args( $this->choices, $default_args );

	}
}
