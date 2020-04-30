<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Field overrides.
 */
class Kirki_Field_FontAwesome extends Kirki_Field_Select {

	/**
	 * Set dropdown choices from the FA JSON.
	 *
	 * @access protected
	 * @since 3.0.42
	 * @return void
	 */
	protected function set_choices() {
		ob_start();
		$json_path = wp_normalize_path( Kirki::$path . '/assets/vendor/fontawesome/fontawesome.json' );
		include $json_path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
		$font_awesome_json = ob_get_clean();

		$fa_array = (array) json_decode( $font_awesome_json, true );

		$this->choices = array();
		foreach ( $fa_array['icons'] as $icon ) {
			if ( ! isset( $icon['id'] ) || ! isset( $icon['name'] ) ) {
				continue;
			}
			$this->choices[ $icon['id'] ] = $icon['name'];
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
