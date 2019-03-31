<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-select
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Preset extends Select {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 */
	protected function set_type() {
		$this->type = 'kirki-select';
	}

	/**
	 * Set the preset.
	 *
	 * @access protected
	 * @since 1.0
	 */
	protected function set_preset() {

		// Set preset from the choices.
		$this->preset = $this->choices;

		// We're using a flat select.
		foreach ( $this->choices as $key => $args ) {
			$this->choices[ $key ] = $args['label'];
		}
	}
}
