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
class Palette extends Radio {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-palette';
	}
}
