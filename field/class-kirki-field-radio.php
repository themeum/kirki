<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Radio extends Kirki_Field {

	/**
	 * Whitelisting for backwards-compatibility.
	 *
	 * @access protected
	 * @var string
	 */
	protected $mode = '';

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-radio';

		// Tweaks for backwards-compatibility:
		// Prior to version 0.8 radio-buttonset & radio-image were part of the radio control.
		if ( in_array( $this->mode, array( 'buttonset', 'image' ), true ) ) {
			/* translators: %1$s represents the field ID where the error occurs. %2%s is buttonset/image. */
			_doing_it_wrong( __METHOD__, sprintf( esc_html__( 'Error in field %1$s. The "mode" argument has been deprecated since Kirki v0.8. Use the "radio-%2$s" type instead.', 'kirki' ), esc_html( $this->settings ), esc_html( $this->mode ) ), '3.0.10' );
			$this->type = 'radio-' . $this->mode;
		}
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
		$this->sanitize_callback = 'sanitize_text_field';
	}
}
