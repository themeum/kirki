<?php

if ( ! class_exists( 'Kirki_Field_Code' ) ) {

	class Kirki_Field_Code extends Kirki_Field {

		/**
		 * Sets the control type.
		 *
		 * @access protected
		 */
		protected function set_type() {

			$this->type = 'code';

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

}
