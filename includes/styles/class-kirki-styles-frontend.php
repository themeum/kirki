<?php

/**
 * Generates the styles for the frontend.
 * Handles the 'output' argument of fields
 */
class Kirki_Styles_Frontend {

	public function __construct() {

		$styles_priority = ( isset( $options['styles_priority'] ) ) ? $styles_priority : 10;
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ), $styles_priority );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 150 );

	}

	/**
	 * Add the inline styles
	 */
	public function enqueue_styles() {
		wp_add_inline_style( 'kirki-styles', $this->loop_controls() );
	}

	/**
	 * Add a dummy, empty stylesheet.
	 */
	public function frontend_styles() {
		$config = Kirki_Toolkit::config()->get_all();

		$root_url = ( '' != $config['url_path'] ) ? esc_url_raw( $config['url_path'] ) : KIRKI_URL;
		wp_enqueue_style( 'kirki-styles', trailingslashit( $root_url ) . 'assets/css/kirki-styles.css', NULL, NULL );

	}

	/**
	 * Get the styles for a single field.
	 */
	public function setting_styles( $field, $styles = '', $element = '', $property = '', $units = '', $prefix = '', $suffix = '', $callback = false ) {
		$value   = kirki_get_option( $field['settings_raw'] );
		$value   = ( isset( $callback ) && '' != $callback && '.' != $callback ) ? call_user_func( $callback, $value ) : $value;
		$element = $prefix . $element;
		$units   = $units . $suffix;

		// Color controls
		if ( 'color' == $field['type'] ) {

			$color = Kirki_Color::sanitize_hex( $value );
			$styles[$element][$property] = $color . $units;

		}

		// Font controls
		elseif ( array( $field['output'] ) && isset( $field['output']['property'] ) && in_array( $field['output']['property'], array( 'font-family', 'font-size', 'font-weight' ) ) ) {

			$is_font_family = isset( $field['output']['property'] ) && 'font-family' == $field['output']['property'] ? true : false;
			$is_font_size   = isset( $field['output']['property'] ) && 'font-size'   == $field['output']['property'] ? true : false;
			$is_font_weight = isset( $field['output']['property'] ) && 'font-weight' == $field['output']['property'] ? true : false;

			if ( 'font-family' == $property ) {

				$styles[$field['output']['element']]['font-family'] = $value . $units;

			} else if ( 'font-size' == $property ) {

				// Get the unit we're going to use for the font-size.
				$units = empty( $units ) ? 'px' : $units;
				$styles[$element]['font-size'] = $value . $units;

			} else if ( 'font-weight' == $property ) {

				$styles[$element]['font-weight'] = $value . $units;

			}

		} else {

			$styles[$element][$property] = $value . $units;

		}

		return $styles;

	}

	/**
	 * loop through all fields and create an array of style definitions
	 */
	public function loop_controls() {

		$fields = Kirki::$fields;
		$css    = '';

		// Early exit if no fields are found.
		if ( ! $fields || empty( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {
			$element  = '';
			$property = '';
			$units    = '';
			$prefix   = '';
			$suffix   = '';
			$callback = '';

			// Only continue if $field['output'] is set
			if ( isset( $field['output'] ) ) {

				$css .= Kirki_Output::css(
					$field['settings_raw'],
					$field['option_type'],
					$field['output'],
					isset( $field['output']['callback'] ) ? $field['output']['callback'] : ''
				);

			}

		}

		return $css;

	}

}
