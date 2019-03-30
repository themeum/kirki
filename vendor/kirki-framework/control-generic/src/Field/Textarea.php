<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-generic
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

/**
 * Field overrides.
 */
class Textarea extends Generic {

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_choices() {
		$this->choices = [
			'element' => 'textarea',
			'rows'    => 5,
		];
	}
}
