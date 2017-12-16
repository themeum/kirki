<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
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

		switch ( $this->choices['language'] ) {
			case 'css':
			case 'html':
			case 'htmlmixed':
			case 'htm':
			case 'json':
			case 'jsx':
			case 'markdown':
			case 'md':
			case 'xml':
				if ( 'md' === $this->choices['language'] ) {
					$this->choices['language'] = 'markdown';
				} elseif ( 'htm' === $this->choices['language'] || 'htmlmixed' === $this->choices['language'] ) {
					$this->choices['language'] = 'html';
				}
				$this->code_type = 'text/' . $this->choices['language'];
				if ( 'html' === $this->choices['language'] ) {
					$this->choices['language'] = 'htmlmixed';
				}
				break;
			case 'http':
			case 'javascript':
			case 'js':
			case 'php':
			case 'phtml':
			case 'php3':
			case 'php4':
			case 'php5':
			case 'php7':
			case 'phps':
				if ( 'js' === $this->choices['language'] ) {
					$this->choices['language'] = 'javascript';
				} elseif ( in_array( $this->choices['language'], array( 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps' ), true ) ) {
					$this->choices['language'] = 'php';
				}
				$this->code_type = 'application/' . $this->choices['language'];
				break;
			case 'svg':
				$this->code_type = 'image/svg-xml';
				break;
			case 'text':
				$this->code_type = 'text/plain';
				break;
			default:
				$this->code_type = 'text/x-' . $this->choices['language'];
				break;
		}
		if ( ! isset( $this->editor_settings['codemirror'] ) ) {
			$this->editor_settings['codemirror'] = array();
		}
		if ( ! isset( $this->editor_settings['codemirror']['mode'] ) ) {
			$this->editor_settings['codemirror']['mode'] = $this->choices['language'];
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
