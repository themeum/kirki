<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       2.3.2
 */

/**
 * Field overrides.
 */
class Kirki_Field_Sortable extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-sortable';

	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		$this->sanitize_callback = array( $this, 'sanitize' );

	}

	/**
	 * Sanitizes sortable values.
	 *
	 * @access public
	 * @param array $value The checkbox value.
	 * @return array
	 */
	public function sanitize( $value = array() ) {
		
		if ( is_string( $value ) || is_numeric( $value ) ) {
			return array(
				esc_attr( $value ),
			);
		}
		
		$sanitized_value = array();
		foreach ( $value as $sub_value ) {
			if ( $this->mode === 'text' )
			{
				$obj = json_decode( $sub_value, true );
				if ( !$obj )
					continue;
				if ( isset( $this->choices[ $obj['id'] ] ) )
					$sanitized_value[$obj['id']] = esc_attr( $obj['val'] );
			}
			else
			{
				if ( isset( $this->choices[ $v ] ) )
					$sanitized_value[] = esc_attr( $v );
			}
		}
		return $sanitized_value;

	}
}
