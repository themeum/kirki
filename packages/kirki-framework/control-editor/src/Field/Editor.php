<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-editor
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Compatibility\Field;

/**
 * Field overrides.
 */
class Editor extends Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		global $wp_version;

		if ( version_compare( $wp_version, '4.8' ) >= 0 ) {
			$this->type = 'kirki-editor';
			return;
		}

		// Fallback for older WordPress versions.
		$this->type = 'kirki-generic';
		if ( ! is_array( $this->choices ) ) {
			$this->choices = [];
		}
		$this->choices['element'] = 'textarea';
		$this->choices['rows']    = '5';
	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_sanitize_callback() {
		if ( empty( $this->sanitize_callback ) ) {
			$this->sanitize_callback = 'wp_kses_post';
		}
	}
}
