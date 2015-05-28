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

		// Background Controls
		elseif ( 'background' == $field['type'] ) {

			if ( isset( $field['default']['color'] ) ) {
				$color_mode = ( false !== strpos( $field['default']['color'], 'rgba' ) ) ? 'color-alpha' : 'color';
				$value = kirki_get_option( $field['settings_raw'] . '_color' );
				if ( 'color-alpha' == $color_mode ) {
					$bg_color = Kirki_Sanitize::rgba( $value );
				} else {
					$bg_color = Kirki_Color::sanitize_hex( $value );
				}
			}
			if ( isset( $field['default']['image'] ) ) {
				$bg_image = kirki_get_option( $field['settings_raw'] . '_image' );
				$bg_image = esc_url_raw( $bg_image );
			}
			if ( isset( $field['default']['repeat'] ) ) {
				$bg_repeat = kirki_get_option( $field['settings_raw'] . '_repeat' );
				$bg_repeat = Kirki_Sanitize::bg_repeat( $bg_repeat );
			}
			if ( isset( $field['default']['size'] ) ) {
				$bg_size = kirki_get_option( $field['settings_raw'] . '_size' );
				$bg_size = Kirki_Sanitize::bg_size( $bg_size );
			}
			if ( isset( $field['default']['attach'] ) ) {
				$bg_attach = kirki_get_option( $field['settings_raw'] . '_attach' );
				$bg_attach = Kirki_Sanitize::bg_attach( $bg_attach );
			}
			if ( isset( $field['default']['position'] ) ) {
				$bg_position = kirki_get_option( $field['settings_raw'] . '_position' );
				$bg_position = Kirki_Sanitize::bg_position( $bg_position );
			}
			if ( isset( $field['default']['opacity'] ) && $field['default']['opacity'] ) {
				$bg_opacity = kirki_get_option( $field['settings_raw'] . '_opacity' );
				$bg_opacity = Kirki_Sanitize::number( $bg_opacity );
				if ( isset( $bg_color ) ) {
					// If we're using an opacity other than 100, then convert the color to RGBA.
					$bg_color = ( 100 != $bg_opacity ) ? Kirki_Color::get_rgba( $bg_color, $bg_opacity ) : $bg_color;
				} elseif ( isset( $bg_image ) ) {
					$element_opacity = ( $bg_opacity / 100 );
				}

			}

			if ( isset( $bg_color ) ) {
				$styles[$element]['background-color'] = $bg_color . $units;
			}
			if ( isset( $bg_image ) && '' != $bg_image ) {
				$styles[$element]['background-image'] = 'url("' . $bg_image . '")' . $units;
				if ( isset( $bg_repeat ) ) {
					$styles[$element]['background-repeat'] = $bg_repeat . $units;
				}
				if ( isset( $bg_size ) ) {
					$styles[$element]['background-size'] = $bg_size . $units;
				}
				if ( isset( $bg_attach ) ) {
					$styles[$element]['background-attachment'] = $bg_attach . $units;
				}
				if ( isset( $bg_position ) ) {
					$styles[$element]['background-position'] = str_replace( '-', ' ', $bg_position ) . $units;
				}
			}

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
