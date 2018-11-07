<?php
class Kirki_Output_Field_Border extends Kirki_Output {
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
				'element'     => ''
			)
		);
		
		if ( !is_array( $value ) || empty( $output['element'] ) )
			return;
		
		$value = Kirki_Field_Border::sanitize( $value );
		
		$border_style = $value['border-style'];
		if ( empty ( $border_style ) )
			return;

		$color = isset( $value['border-color'] ) ? $value['border-color'] : '';

		$border_pos = ['border-top', 'border-right', 'border-bottom', 'border-left'];

		foreach ( $border_pos as $pos )
		{
			$size = $value[$pos];
			$this->styles[ 'global' ][ $output['element'] ][$pos] =
				"{$size}px {$border_style} {$color} ";
		}
	}
}