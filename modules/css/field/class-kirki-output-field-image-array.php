<?php
/**
 * Handles CSS output for typography fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

/**
 * Output overrides.
 */
class Kirki_Output_Field_Image_Array extends Kirki_Output {

	/**
	 * Returns the value.
	 *
	 * @access protected
	 * @param string|array $value The value.
	 * @param array        $output The field "output".
	 * @return string|array
	 */
	protected function process_value( $value, $output ) {
		if ( isset( $value['url'] ) ) {
			return $value['url'];
		}
		return '';
	}
}
