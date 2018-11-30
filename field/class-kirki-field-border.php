<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Field overrides.
 */
class Kirki_Field_Border extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-border';

	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {
		// If a custom sanitize_callback has been defined,
		// then we don't need to proceed any further.
		if ( ! empty( $this->sanitize_callback ) ) {
			return;
		}
		$this->sanitize_callback = array( $this, 'sanitize' );
	}
	
	protected function set_choices()
	{
		if ( is_array( $this->default ) ) {
			foreach ( $this->default as $key => $value ) {
				$this->choices[ $key ] = $value;
			}
		}
	}

	/**
	 * Sanitizes border controls
	 *
	 * @since 2.2.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {

		if ( ! is_array( $value ) ) {
			return array();
		}
		return array(
			'style'     => ( isset( $value['style'] ) ) ? esc_attr( $value['style'] ) : '',
			'top'       => ( isset( $value['top'] ) ) ? esc_attr( $value['top'] ) : 0,
			'right'     => ( isset( $value['right'] ) ) ? esc_attr ( $value['right'] ) : 0,
			'bottom'    => ( isset( $value['bottom'] ) ) ? esc_attr( $value['bottom'] ) : 0,
			'left'      => ( isset( $value['left'] ) ) ? esc_attr( $value['left'] ) : 0,
			'color'     => ( isset( $value['color'] ) ) ? esc_attr( $value['color'] ) : 'transparent',
			'unit'      => ( isset( $value['unit'] ) ) ? esc_attr( $value['unit'] ) : ''
		);
	}
	
	public static function normalize_default( $value, $field )
	{
		if ( $value['style'] === 'none' )
			return $value;
		
		if ( !isset( $value['unit'] ) || empty( $value['unit'] ) )
		{
			if ( isset( $field['choices']['units'] ) && is_array( $field['choices']['units'] ) )
				$value['unit'] = array_keys( $field['choices']['units'] )[0];
		}
		foreach ( array('top', 'right', 'bottom', 'left') as $side )
		{
			if ( isset( $value[$side] ) && is_numeric( $value[$side] ) && $value[$side] != 0 )
				$value[$side] = $value[$side] . $value['unit'];
			else if ( !isset( $value[$side] ) )
				$value[$side] = 0;
		}
		return $value;
	}

	/**
	 * Sets the $js_vars
	 *
	 * @access protected
	 */
	protected function set_js_vars() {

		// Typecast to array.
		$this->js_vars = (array) $this->js_vars;

		// Check if transport is set to auto.
		// If not, then skip the auto-calculations and exit early.
		if ( 'auto' !== $this->transport ) {
			return;
		}

		// Set transport to refresh initially.
		// Serves as a fallback in case we failt to auto-calculate js_vars.
		$this->transport = 'refresh';

		$js_vars = array();

		// Try to auto-generate js_vars.
		// First we need to check if js_vars are empty, and that output is not empty.
		if ( empty( $this->js_vars ) && ! empty( $this->output ) ) {

			// Start going through each item in the $output array.
			foreach ( $this->output as $output ) {

				// If 'element' is not defined, skip this.
				if ( ! isset( $output['element'] ) ) {
					continue;
				}
				if ( is_array( $output['element'] ) ) {
					$output['element'] = implode( ',', $output['element'] );
				}

				// If there's a sanitize_callback defined, skip this.
				if ( isset( $output['sanitize_callback'] ) && ! empty( $output['sanitize_callback'] ) ) {
					continue;
				}

				// If we got this far, it's safe to add this.
				$js_vars[] = $output;
			}

			// Did we manage to get all the items from 'output'?
			// If not, then we're missing something so don't add this.
			if ( count( $js_vars ) !== count( $this->output ) ) {
				return;
			}
			$this->js_vars   = $js_vars;
			$this->transport = 'postMessage';

		}
	}
}
