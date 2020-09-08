<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-color-palette
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Field;
use Kirki\Field\ReactColor;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class ColorPalette extends Field {

	/**
	 * The field type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-color-palette';

	/**
	 * Extra logic for the field.
	 *
	 * Converts this to a react-color control.
	 *
	 * @access public
	 * @param array $args The arguments of the field.
	 */
	public function init( $args = [] ) {

		// Make sure choices are defined.
		$args['choices'] = ( ! isset( $args['choices'] ) ) ? [] : $args['choices'];

		// Set the react component.
		$args['choices']['formComponent'] = 'CirclePicker';

		// Change size if we have one defined.
		if ( isset( $args['choices']['size'] ) ) {
			$args['choices']['circleSize'] = $args['choices']['size'];
		}

		// Change the spacing between colors.
		$args['choices']['circleSpacing'] = ( isset( $args['choices']['circleSpacing'] ) ) ? $args['choices']['circleSpacing'] : 10;

		new ReactColor( $args );
	}
}
