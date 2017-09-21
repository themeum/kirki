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
class Kirki_Field_Textarea extends Kirki_Field_Kirki_Generic {

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 */
	protected function set_choices() {

		if ( ! is_customize_preview() ) {
			return;
		}
		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}
		$this->choices['element'] = 'textarea';
		$this->choices['rows']    = '5';

	}
}
