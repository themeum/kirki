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
class Kirki_Output_Field_Typography extends Kirki_Output {

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

		if ( ! isset( $value['variant'] ) || ! isset( $value['font-weight'] ) || ! isset( $value['font-style'] ) ) {
			$value = Kirki_Field_Typography::sanitize( $value );
			$this->value = $value;
		}

		$properties = array(
			'font-family',
			'font-size',
			'font-weight',
			'font-style',
			'letter-spacing',
			'word-spacing',
			'line-height',
			'text-align',
			'text-transform',
			'color',
		);

		if ( isset( $value['font-family'] ) && isset( $value['font-backup'] ) && ! empty( $value['font-family'] ) ) {
			$value['font-family'] .= ', ' . $value['font-backup'];
		}
		foreach ( $properties as $property ) {
			if ( ! isset( $value[ $property ] ) || '' === $value[ $property ] ) {
				continue;
			}
			if ( isset( $output['choice'] ) && $output['choice'] !== $property ) {
				continue;
			}

			$this->styles[ $output['media_query'] ][ $output['element'] ][ $property ] = $output['prefix'] . $this->process_property_value( $property, $value[ $property ] ) . $output['suffix'];
		}
	}
}
