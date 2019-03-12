<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       2.3.2
 */

namespace Kirki\Field;

use Kirki\Core\Field;

/**
 * Field overrides.
 */
class Color_Palette extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-color-palette';
	}
}
