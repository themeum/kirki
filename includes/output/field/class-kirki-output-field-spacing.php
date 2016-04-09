<?php
/**
 * Handles CSS output for spacing fields.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'Kirki_Output_Field_Spacing' ) ) {

	/**
	 * Output overrides.
	 */
	class Kirki_Output_Field_Spacing extends Kirki_Output {

		/**
		 * Processes a single item from the `output` array.
		 *
		 * @access protected
		 * @param array $output The `output` item.
		 * @param array $value  The field's value.
		 */
		protected function process_output( $output, $value ) {

			foreach ( $value as $key => $sub_value ) {

				if ( ! isset( $output['property'] ) || empty( $output['property'] ) ) {
					$property = $key;
				} elseif ( false !== strpos( $output['property'], '%%' ) ) {
					$property = str_replace( '%%', $key, $output['property'] );
				} else {
					$property = $output['property'] . '-' . $key;
				}
				$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
				$this->styles[ $output['media_query'] ][ $output['element'] ][ $property ] = $sub_value;

			}
		}
	}
}
