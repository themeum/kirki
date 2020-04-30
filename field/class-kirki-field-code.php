<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Code extends Kirki_Field {

	/**
	 * The code_type (MIME type).
	 *
	 * @access public
	 * @since 3.0.21
	 * @var string
	 */
	public $code_type = 'text/css';

	/**
	 * Code editor settings.
	 *
	 * @see wp_enqueue_code_editor()
	 * @since 3.0.21
	 * @access public
	 * @var array|false
	 */
	public $editor_settings = array();

	/**
	 * Custom input attributes (defined as an array).
	 *
	 * @access public
	 * @since 3.0.21
	 * @var array
	 */
	public $input_attrs = array(
		'aria-describedby' => 'kirki-code editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
	);

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'code_editor';
	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
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
			$this->editor_settings['codemirror'] = array();
		}
		if ( ! isset( $this->editor_settings['codemirror']['mode'] ) ) {
			$this->editor_settings['codemirror']['mode'] = $language;
		}

		if ( 'text/x-scss' === $this->editor_settings['codemirror']['mode'] ) {
			$this->editor_settings['codemirror'] = array_merge(
				$this->editor_settings['codemirror'],
				array(
					'lint'              => false,
					'autoCloseBrackets' => true,
					'matchBrackets'     => true,
				)
			);
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
		// Code fields must NOT be filtered. Their values usually contain CSS/JS.
		// It is the responsibility of the theme/plugin that registers this field
		// to properly apply any necessary filtering.
		$this->sanitize_callback = array( 'Kirki_Sanitize_Values', 'unfiltered' );
	}
}
