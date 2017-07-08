<?php
/**
 * Handles CSS output for dimensions fields.
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
class Kirki_Output_Field_Gradient extends Kirki_Output {

	/**
	 * Processes a single item from the `output` array.
	 *
	 * @access protected
	 * @param array $output The `output` item.
	 * @param array $value  The field's value.
	 */
	protected function process_output( $output, $value ) {
		// Make sure we've got everything by defining some defaults.
		$value = wp_parse_args( $value, array(
			'angle' => 0,
			'start' => array(
				'color'    => 'rgba(0,0,0,0)',
				'position' => 0,
			),
			'end' => array(
				'color'    => 'rgba(0,0,0,0)',
				'position' => 100,
			),
			'mode' => 'linear',
		) );

		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';

		$this->styles[ $output['media_query'] ][ $output['element'] ]['background'] = $value['start']['color'];
		switch ( $value['mode'] ) {

			case 'linear':
				$this->styles[ $output['media_query'] ][ $output['element'] ]['background'] = 'linear-gradient(' . intval( $value['angle'] ) . 'deg, ' . $value['start']['color'] . ' ' . $value['start']['position'] . '%,' . $value['end']['color'] . ' ' . $value['end']['position'] . '%)';
				break;
			case 'radial':
				$this->styles[ $output['media_query'] ][ $output['element'] ]['background'] = 'radial-gradient(ellipse at center,' . $value['start']['color'] . ' ' . $value['start']['position'] . '%,' . $value['end']['color'] . ' ' . $value['end']['position'] . '%)';
				break;
		}
	}
}
