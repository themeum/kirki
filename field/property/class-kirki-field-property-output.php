<?php
/**
 * Properly format the "output" argument.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Properly format the "output" argument.
 */
class Kirki_Field_Property_Output extends Kirki_Field_Property {

	/**
	 * Gets the property.
	 *
	 * @access public
	 */
	public function get_property() {

		if ( empty( $this->args['output'] ) ) {
			return array();
		}
		if ( ! empty( $this->args['output'] ) && ! is_array( $this->args['output'] ) ) {
			/* translators: %s represents the field ID where the error occurs. */
			_doing_it_wrong( __METHOD__, sprintf( esc_attr__( '"output" invalid format in field %s. The "output" argument should be defined as an array of arrays.', 'kirki' ), esc_attr( $this->settings ) ), '3.0.10' );
			$this->args['output'] = array(
				array(
					'element' => $this->args['output'],
				),
			);
		}
		// Convert to array of arrays if needed.
		if ( isset( $this->args['output']['element'] ) ) {
			/* translators: %s represents the field ID where the error occurs. */
			_doing_it_wrong( __METHOD__, sprintf( esc_attr__( '"output" invalid format in field %s. The "output" argument should be defined as an array of arrays.', 'kirki' ), esc_attr( $this->settings ) ), '3.0.10' );
			$this->args['output'] = array( $this->args['output'] );
		}
		$outputs = array();
		foreach ( $this->args['output'] as $output ) {
			$outputs[] = $this->get_output( $output );
		}
		return $outputs;
	}

	/**
	 * Properly format each output sub-array.
	 *
	 * @access private
	 * @since 3.0.10
	 * @param array $output The output argument.
	 * @return array
	 */
	private function get_output( $output ) {
		if ( ! isset( $output['element'] ) ) {
			return array();
		}
		if ( ! isset( $output['sanitize_callback'] ) && isset( $output['callback'] ) ) {
			$output['sanitize_callback'] = $output['callback'];
		}
		// Convert element arrays to strings.
		if ( is_array( $output['element'] ) ) {
			$output['element'] = array_unique( $output['element'] );
			sort( $output['element'] );
			$output['element'] = implode( ',', $output['element'] );
		}
		return array(
			'element'           => $output['element'],
			'property'          => ( isset( $output['property'] ) ) ? $output['property'] : '',
			'media_query'       => ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global',
			'sanitize_callback' => ( isset( $output['sanitize_callback'] ) ) ? $output['sanitize_callback'] : '',
			'units'             => ( isset( $output['units'] ) ) ? $output['units'] : '',
			'prefix'            => ( isset( $output['prefix'] ) ) ? $output['prefix'] : '',
			'suffix'            => ( isset( $output['suffix'] ) ) ? $output['suffix'] : '',
			'exclude'           => ( isset( $output['exclude'] ) ) ? $output['exclude'] : false,
			'value_pattern'     => ( isset( $output['value_pattern'] ) ) ? $output['value_pattern'] : '$',
			'pattern_replace'   => ( isset( $output['pattern_replace'] ) ) ? $output['pattern_replace'] : array(),
		);
	}
}
