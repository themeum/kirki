<?php
class Kirki_Output_Field_Box_Shadow extends Kirki_Output {
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
		
		$value = Kirki_Field_Box_Shadow::sanitize( $value );
		
		$shadow_opts = [];
		
		foreach ( ['h_offset', 'v_offset', 'blur', 'spread', 'color'] as $side )
		{
			$shadow_opts[] = $value[$side];
		}
		
		$this->styles[ 'global' ][ $output['element'] ]['box-shadow'] = join( ' ', $shadow_opts );
	}
}