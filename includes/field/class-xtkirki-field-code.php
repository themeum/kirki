<?php
/**
 * Override field methods
 *
 * @package     XTKirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

if ( ! class_exists( 'XTKirki_Field_Code' ) ) {

	/**
	 * Field overrides.
	 */
	class XTKirki_Field_Code extends XTKirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'xtkirki-code';

		}

		/**
		 * Sets the $choices
		 *
		 * @access protected
		 */
		protected function set_choices() {

			// Get l10n strings.
			$l10n = XTKirki_l10n::get_strings( $this->xtkirki_config );

			// Make sure we have some defaults in case none are defined.
			$defaults = array(
				'language' => 'css',
				'theme'    => 'xtkirki-dark',
				'label'    => $l10n['open-editor'],
			);
			$this->choices = wp_parse_args( $this->choices, $defaults );

			// Make sure the choices are defined and set as an array.
			if ( ! is_array( $this->choices ) ) {
				$this->choices = array();
			}

			// An array of valid languages.
			$valid_languages = array(
				'coffescript',
				'css',
				'haml',
				'htmlembedded',
				'htmlmixed',
				'javascript',
				'markdown',
				'php',
				'sass',
				'smarty',
				'sql',
				'stylus',
				'textile',
				'twig',
				'xml',
				'yaml',
			);
			// Make sure the defined language exists.
			// If not, fallback to CSS.
			if ( ! in_array( $this->choices['language'], $valid_languages, true ) ) {
				$this->choices['language'] = 'css';
			}
			// Hack for 'html' mode.
			if ( 'html' === $this->choices['language'] ) {
				$this->choices['language'] = 'htmlmixed';
			}

			// Set the theme.
			if ( in_array( $this->choices['theme'], array( 'xtkirki-dark', 'xtkirki-light' ), true ) ) {
				return;
			}
			if ( in_array( $this->choices['theme'], array( 'light', 'dark' ), true ) ) {
				$this->choices['theme'] = 'xtkirki-' . $this->choices['theme'];
				return;
			}
			$this->choices['theme'] = $defaults['theme'];

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
			$this->sanitize_callback = array( 'XTKirki_Sanitize_Values', 'unfiltered' );

		}
	}
}
