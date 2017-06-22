<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Switch extends Kirki_Field_Checkbox {

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
			$this->choices = array();
		}

		$l10n = array(
			'on'  => esc_attr__( 'On', 'kirki' ),
			'off' => esc_attr__( 'Off', 'kirki' ),
		);

		if ( ! isset( $this->choices['on'] ) ) {
			$this->choices['on'] = $l10n['on'];
		}

		if ( ! isset( $this->choices['off'] ) ) {
			$this->choices['off'] = $l10n['off'];
		}

		if ( ! isset( $this->choices['round'] ) ) {
			$this->choices['round'] = false;
		}

	}
}
