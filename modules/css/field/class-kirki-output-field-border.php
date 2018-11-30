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
		$value = Kirki_Field_Border::normalize_default( $value, $this->field );
		
		$border_style = $value['style'];
		if ( empty ( $border_style ) )
			return;
		
		$this->styles[ 'global' ][ $output['element'] ]['border-style'] = $border_style;
		
		if ( $border_style === 'none' )
			return;
		
		$border_width = array();
		foreach ( ['top', 'right', 'bottom', 'left'] as $side )
		{
			$border_width[$side] = $value[$side];
		}
		$this->styles[ 'global' ][ $output['element'] ]['border-width'] = join( ' ', $border_width );
		$this->styles[ 'global' ][ $output['element'] ]['border-color'] = $value['color'];
	}
}