<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-code
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Core\Field;

/**
 * Field overrides.
 */
class Code extends Field {

	/**
	 * The code_type (MIME type).
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $code_type = 'text/css';

	/**
	 * Code editor settings.
	 *
	 * @see wp_enqueue_code_editor()
	 * @since 1.0
	 * @access public
	 * @var array|false
	 */
	public $editor_settings = [];

	/**
	 * Custom input attributes (defined as an array).
	 *
	 * @access public
	 * @since 1.0
	 * @var array
	 */
	public $input_attrs = [
		'aria-describedby' => 'kirki-code editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
	];

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'code_editor';
	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_choices() {
		if ( ! isset( $this->choices['language'] ) ) {
			return;
		}
		$language = $this->choices['language'];
		switch ( $language ) {
			case 'json':
			case 'xml':
				$language = 'application/' . $language;
				break;
			case 'http':
				$language = 'message/' . $language;
				break;
			case 'js':
			case 'javascript':
				$language = 'text/javascript';
				break;
			case 'txt':
				$language = 'text/plain';
				break;
			case 'css':
			case 'jsx':
			case 'html':
				$language = 'text/' . $language;
				break;
			default:
				$language = ( 'js' === $language ) ? 'javascript' : $language;
				$language = ( 'htm' === $language ) ? 'html' : $language;
				$language = ( 'yml' === $language ) ? 'yaml' : $language;
				$language = 'text/x-' . $language;
				break;
		}
		if ( ! isset( $this->editor_settings['codemirror'] ) ) {
			$this->editor_settings['codemirror'] = [];
		}
		if ( ! isset( $this->editor_settings['codemirror']['mode'] ) ) {
			$this->editor_settings['codemirror']['mode'] = $language;
		}

		if ( 'text/x-scss' === $this->editor_settings['codemirror']['mode'] ) {
			$this->editor_settings['codemirror'] = array_merge(
				$this->editor_settings['codemirror'],
				[
					'lint'              => false,
					'autoCloseBrackets' => true,
					'matchBrackets'     => true,
				]
			);
		}
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
			/**
			 * Code fields should not be filtered by default.
			 * Their values usually contain CSS/JS and it it the responsibility
			 * of the theme/plugin that registers this field
			 * to properly apply any necessary sanitization.
			 */
			$this->sanitize_callback = function( $value ) {
				return $value;
			};
		}
	}
}
