<?php

class Kirki_Controls {

	/**
	 * Get the controls for the Kirki customizer.
	 *
	 * @uses  'kirki/controls' filter.
	 */
	public static function get_controls() {

		$controls = apply_filters( 'kirki/controls', array() );
		$final_controls = array();

		if ( ! empty( $controls ) ) {
			foreach ( $controls as $control ) {
				$final_controls[] = Kirki_Control::sanitize( $control );
			}
		}

		return $final_controls;

	}

}
