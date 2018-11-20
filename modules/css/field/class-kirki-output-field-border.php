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
		$border_style = $value['style'];
		if ( empty ( $border_style ) )
			return;
		
		if ( $border_style == 'none' )
		{
			$this->styles[ 'global' ][ $output['element'] ]['border-style'] = $border_style;
			return;
		}
		
		$border_color = isset( $value['color'] ) ? $value['color'] : '';
		$border_width = [];
		
		foreach ( ['top', 'right', 'bottom', 'left'] as $pos )
			$border_width[] = $value[$pos];
		
		$this->styles[ 'global' ][ $output['element'] ]['border-style'] = $border_style;
		$this->styles[ 'global' ][ $output['element'] ]['border-width'] = join ( ' ', $border_width );
		$this->styles[ 'global' ][ $output['element'] ]['border-color'] = $border_color;
	}
}