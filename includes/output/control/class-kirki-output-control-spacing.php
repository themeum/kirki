<?php

class Kirki_Output_Control_Spacing extends Kirki_Output {

	protected function process_output( $output, $value ) {

		foreach ( $value as $key => $sub_value ) {
			if ( false !== strpos( $output['property'], '%%' ) ) {
				$property = str_replace( '%%', $key, $output['property'] );
			} else {
				$property = $output['property'] . '-' . $key;
			}
			$this->styles[ $output['media_query'] ][ $output['element'] ][ $property ] = $sub_value;
		}

	}

}
