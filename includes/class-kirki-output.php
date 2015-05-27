<?php

/**
 * Generates the styles for the frontend.
 * Handles the 'output' argument of fields
 */
class Kirki_Output {

	public $settings = null;
	public $output   = array();
	public $type     = 'theme_mod';

	public $value = null;

	public function __construct( $setting = '', $type = 'theme_mod', $output = array(), $callback = '' ) {

		// No need to proceed any further if we don't have the required arguments.
		if ( '' == $setting || empty( $output ) ) {
			return;
		}

		$this->settings    = $field['settings'];
		$this->option_type = ( isset( $field['option_type'] ) ) ? $field['option_type'] : 'theme_mod';
		$this->value       = $this->get_value( $field, $callback );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 150 );

	}

	public function get_value( $field, $callback = '' ) {

		$default = ( isset( $field['default'] ) ) ? $field['default'] : null;
		if ( 'theme_mod' == $this->option_type ) {
			$value = get_theme_mod( $field['settings'], $default );
		} else {
			$value = get_option( $field['settings'], $default );
		}

		if ( '' != $callback ) {
			$value = call_user_func( $callback, $value );
		}

		return $value;

	}

	/**
	 * Add the inline styles
	 */
	public function enqueue_styles() {
		wp_add_inline_style( 'kirki-styles', $this->styles_parse() );
	}

	/**
	 * Gets the array of generated styles and creates the minimized, inline CSS
	 */
	public function styles_parse() {

		$styles = $this->styles();
		$css = '';

		// Early exit if styles are empty or not an array
		if ( empty( $styles ) || ! is_array( $styles ) ) {
			return;
		}

		foreach ( $styles as $style => $style_array ) {
			$css .= $style . '{';
			foreach ( $style_array as $property => $value ) {
				$css .= $property . ':' . $value . ';';
			}
			$css .= '}';
		}

		return $css;

	}

	/**
	 * Get the styles for a single field.
	 */
	public function styles() {

		$styles = array();

		foreach ( $this->output as $output ) {

			$prefix = ( isset( $output['prefix'] ) ) ? $output['prefix'] : '';
			$suffix = ( isset( $output['suffix'] ) ) ? $output['suffix'] : '';
			$units  = ( isset( $output['units'] ) )  ? $output['units']  : '';

			if ( isset( $output['element'] ) && isset( $output['property'] ) ) {
				$styles[$prefix . $output['element']][$output['property']] = $this->value . $units;
			}

		}

		return $styles;

	}

}
