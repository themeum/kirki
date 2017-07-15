<?php
/**
 * Handles CSS output for background fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Output overrides.
 */
class Kirki_Output_Field_Background extends Kirki_Output {

	/**
	 * Processes a single item from the `output` array.
	 *
	 * @access protected
	 * @param array $output The `output` item.
	 * @param array $value  The field's value.
	 */
	protected function process_output( $output, $value ) {

		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
		$output['element']     = ( isset( $output['element'] ) ) ? $output['element'] : 'body';
		$output['prefix']      = ( isset( $output['prefix'] ) ) ? $output['prefix'] : '';
		$output['suffix']      = ( isset( $output['suffix'] ) ) ? $output['suffix'] : '';
		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';

		foreach ( array( 'image', 'color', 'repeat', 'position', 'size', 'attachment' ) as $key ) {
			$key = 'background-' . $key;
			if ( isset( $value[ $key ] ) && ! empty( $value[ $key ] ) ) {
				$this->styles[ $output['media_query'] ][ $output['element'] ][ $key ] = $output['prefix'] . $this->process_property_value( $key, $value[ $key ] ) . $output['suffix'];
			}
		}
	}
}
