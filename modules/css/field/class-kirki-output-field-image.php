<?php
/**
 * Handles CSS output for image fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.10
 */

/**
 * Output overrides.
 */
class Kirki_Output_Field_Image extends Kirki_Output {

	/**
	 * Processes a single item from the `output` array.
	 *
	 * @access protected
	 * @param array $output The `output` item.
	 * @param array $value  The field's value.
	 */
	protected function process_output( $output, $value ) {

		if ( ! isset( $output['element'] ) || ! isset( $output['property'] ) ) {
			return;
		}
		$output = wp_parse_args( $output, array(
			'media_query' => 'global',
			'prefix'      => '',
			'units'       => '',
			'suffix'      => '',
		) );
		if ( is_array( $value ) ) {
			if ( isset( $output['choice'] ) && $output['choice'] ) {
				$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $this->process_property_value( $output['property'], $value[ $output['choice'] ] ) . $output['units'] . $output['suffix'];
				return;
			}
			if ( isset( $value['url'] ) ) {
				$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $this->process_property_value( $output['property'], $value['url'] ) . $output['units'] . $output['suffix'];
				return;
			}
			return;
		}
		$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $this->process_property_value( $output['property'], $value ) . $output['units'] . $output['suffix'];
	}
}
