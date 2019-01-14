<?php
/**
 * Handles CSS output for dimensions fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

/**
 * Output overrides.
 */
class Kirki_Output_Field_Dimensions extends Kirki_Output {

	/**
	 * Processes a single item from the `output` array.
	 *
	 * @access protected
	 * @param array $output The `output` item.
	 * @param array $value  The field's value.
	 */
	protected function process_output( $output, $value ) {
		$output = wp_parse_args(
			$output, array(
				'element'     => '',
				'property'    => '',
				'media_query' => 'global',
				'prefix'      => '',
				'suffix'      => '',
			)
		);

		if ( ! is_array( $value ) ) {
			return;
		}

		foreach ( array_keys( $value ) as $key ) {

			$property = ( empty( $output['property'] ) ) ? $key : $output['property'] . '-' . $key;
			if ( isset( $output['choice'] ) && $output['property'] ) {
				if ( $key === $output['choice'] ) {
					$property = $output['property'];
				} else {
					continue;
				}
			}
			if ( false !== strpos( $output['property'], '%%' ) ) {
				$property = str_replace( '%%', $key, $output['property'] );
			}
			$this->styles[ $output['media_query'] ][ $output['element'] ][ $property ] = $output['prefix'] . $this->process_property_value( $property, $value[ $key ] ) . $output['suffix'];
		}
	}
}
