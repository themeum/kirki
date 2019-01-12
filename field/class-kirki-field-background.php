<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Field overrides.
 */
class Kirki_Field_Background extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-background';
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

	/**
	 * Sanitizes typography controls
	 *
	 * @since 2.2.0
	 * @param array $value The value.
	 * @return array
	 */
	public function sanitize( $value ) {
		if ( ! is_array( $value ) ) {
			return array();
		}
		return array(
			'background-color'      => ( isset( $value['background-color'] ) ) ? sanitize_text_field( $value['background-color'] ) : '',
			'background-image'      => ( isset( $value['background-image'] ) ) ? esc_url_raw( $value['background-image'] ) : '',
			'background-repeat'     => ( isset( $value['background-repeat'] ) ) ? sanitize_text_field( $value['background-repeat'] ) : '',
			'background-position'   => ( isset( $value['background-position'] ) ) ? sanitize_text_field( $value['background-position'] ) : '',
			'background-size'       => ( isset( $value['background-size'] ) ) ? sanitize_text_field( $value['background-size'] ) : '',
			'background-attachment' => ( isset( $value['background-attachment'] ) ) ? sanitize_text_field( $value['background-attachment'] ) : '',
		);
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
