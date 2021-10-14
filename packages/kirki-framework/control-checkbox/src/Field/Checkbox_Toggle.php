<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/checkbox
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
class Checkbox_Toggle extends Checkbox_Switch {

	/**
	 * Filter arguments before creating the control.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_control_args( $args, $wp_customize ) {

		if ( $args['settings'] === $this->args['settings'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			/**
			 * Toggle is from Kirki 3.
			 * In Kirki 4, toggle is just a switch.
			 *
			 * To maintain backwards compatibility, we need to achieve the same design:
			 * - Toggle should be aligned horizontally
			 * - That means, it shouldn't use a text.
			 */
			$args['checkbox_type'] = 'toggle';
		}

		return $args;

	}

}
