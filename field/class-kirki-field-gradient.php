<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Gradient extends Kirki_Field_Color {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-gradient';

	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 */
	protected function set_choices() {

		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}

		$defaults = array(
			'alpha'     => true,
			'direction' => 'top-to-bottom',
			'colors'    => array(
				'rgba(255,255,255,0)',
				'rgba(255,255,255,0)',
			),
		);
		$this->choices = wp_parse_args( $this->choices, $defaults );

	}
}
