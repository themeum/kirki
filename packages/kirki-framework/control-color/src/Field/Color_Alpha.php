<?php
/**
 * Object used by the Kirki framework to instantiate the control.
 *
 * This is a man-in-the-middle class, nothing but a proxy to set sanitization
 * callbacks and any usother properties we may need.
 *
 * @package   kirki-framework/control-color
 * @copyright opyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Color_Alpha extends Color {

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
		$this->choices['alpha'] = true;
	}
}
