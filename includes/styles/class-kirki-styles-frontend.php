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
	 * Detect if we're using the 'output' argument in one of our fields.
	 *
	 * @return	boolean
	 */
	public function uses_output() {

		// Get all fields
		$fields = Kirki::fields()->get_all();
		// Are we using 'output' in any of our fields?
		$uses_output = 'no';
		foreach( $fields as $field ) {
			if ( 'no' == $uses_output && null != $field['output'] ) {
				$uses_output = 'yes';
			}
		}

		// Return true if we're using 'output' in our fields else returns false.
		return ( 'yes' == $uses_output ) ? true : false;

	}

	/**
	 * Add the inline styles
	 */
	public function enqueue_styles() {

		// Early exit if we're not using output
		if ( ! $this->uses_output() ) {
			return;
		}
		wp_add_inline_style( Kirki::config()->getOrThrow( 'stylesheet_id' ), $this->styles_parse() );

	}

	/**
	 * Add a dummy, empty stylesheet if no stylesheet_id has been defined and we need one.
	 */
	public function frontend_styles() {

		// Early exit if we're not using output
		if ( ! $this->uses_output() ) {
			return;
		}

		$config = Kirki::config()->get_all();

		$kirki_stylesheet = Kirki::config()->getOrThrow( 'stylesheet_id' );
		$root_url = ( '' != $config['url_path'] ) ? Kirki::config()->getOrThrow( 'url_path' ) : KIRKI_URL;

		if ( 'kirki-styles' == $kirki_stylesheet ) {
			wp_enqueue_style( 'kirki-styles', trailingslashit( $root_url ) . 'assets/css/kirki-styles.css', NULL, NULL );
		}

	}

	/**
	 * Gets the array of generated styles and creates the minimized, inline CSS
	 */
	public function styles_parse() {

		$styles = $this->loop_controls();
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
	public function setting_styles( $field, $styles = '', $element = '', $property = '', $units = '', $prefix = '', $suffix = '', $callback = false ) {

		$value   = kirki_get_option( $field['settings_raw'] );
		$value   = ( $callback ) ? call_user_func( $callback, $value ) : $value;
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
					$bg_color = kirki_sanitize_rgba( $value );
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
				$bg_repeat = kirki_sanitize_bg_repeat( $bg_repeat );
			}
			if ( isset( $field['default']['size'] ) ) {
				$bg_size = kirki_get_option( $field['settings_raw'] . '_size' );
				$bg_size = kirki_sanitize_bg_size( $bg_size );
			}
			if ( isset( $field['default']['attach'] ) ) {
				$bg_attach = kirki_get_option( $field['settings_raw'] . '_attach' );
				$bg_attach = kirki_sanitize_bg_attach( $bg_attach );
			}
			if ( isset( $field['default']['position'] ) ) {
				$bg_position = kirki_get_option( $field['settings_raw'] . '_position' );
				$bg_position = kirki_sanitize_bg_position( $bg_position );
			}
			if ( isset( $field['default']['opacity'] ) && $field['default']['opacity'] ) {
				$bg_opacity = kirki_get_option( $field['settings_raw'] . '_opacity' );
				$bg_opacity = kirki_sanitize_number( $bg_opacity );
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

		$fields = Kirki::fields()->get_all();
		$styles   = array();

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

				// Check if this is an array of style definitions
				$multiple_styles = isset( $field['output'][0]['element'] ) ? true : false;

				if ( ! $multiple_styles ) { // single style

					// If $field['output'] is not an array, then use the string as the target element
					if ( is_string( $field['output'] ) ) {
						$element  = $field['output'];
					} else {
						$element  = isset( $field['output']['element'] )  ? $field['output']['element']  : '';
						$property = isset( $field['output']['property'] ) ? $field['output']['property'] : '';
						$units    = isset( $field['output']['units'] )    ? $field['output']['units']    : '';
						$prefix   = isset( $field['output']['prefix'] )   ? $field['output']['prefix']   : '';
						$suffix   = isset( $field['output']['suffix'] )   ? $field['output']['suffix']   : '';
						$callback = isset( $field['output']['callback'] ) ? $field['output']['callback'] : '';
					}

					$styles = $this->setting_styles( $field, $styles, $element, $property, $units, $prefix, $suffix, $callback );

				} else { // Multiple styles set

					foreach ( $field['output'] as $style ) {

						if ( ! array( $style ) ) {
							$element = $style;
						} else {
							$element  = isset( $style['element'] )  ? $style['element']  : '';
							$property = isset( $style['property'] ) ? $style['property'] : '';
							$units    = isset( $style['units'] )    ? $style['units']    : '';
							$prefix   = isset( $style['prefix'] )   ? $style['prefix']   : '';
							$suffix   = isset( $style['suffix'] )   ? $style['suffix']   : '';
							$callback = isset( $style['callback'] ) ? $style['callback'] : '';
						}

						$styles = $this->setting_styles( $field, $styles, $element, $property, $units, $prefix, $suffix, $callback );

					}

				}

			}

		}

		return $styles;

	}

}
