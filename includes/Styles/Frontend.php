<?php

namespace Kirki\Styles;
use Kirki;
use Kirki\Styles;

class Frontend {

	function __construct() {
		$styles_priority = ( isset( $options['styles_priority'] ) ) ? $styles_priority : 10;
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ), $styles_priority );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 150 );
	}


	function enqueue_styles() {
		wp_add_inline_style( Kirki::config()->getOrThrow( 'stylesheet_id' ), $this->styles_parse() );
	}


	/**
	 * Add a dummy, empty stylesheet if no stylesheet_id has been defined and we need one.
	 */
	function frontend_styles() {
		$config = Kirki::config()->get_all();
		$fields = Kirki::fields()->get_all();

		$kirki_stylesheet = Kirki::config()->getOrThrow( 'stylesheet_id' );

		foreach( $fields as $field ) {
			if ( isset( $field['output'] ) ) {
				$uses_output = true;
			}
		}

		$root = ( '' != $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

		if ( isset( $uses_output )  && $uses_output && $kirki_stylesheet === 'kirki-styles' ) {
			wp_enqueue_style( 'kirki-styles', trailingslashit( $root ) . 'assets/css/kirki-styles.css', NULL, NULL );
		}

	}


	function styles_parse() {

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


	function setting_styles( $field, $styles, $element, $property, $units ) {

		$value = kirki_get_option( $field['settings'] );

		// Color controls
		if ( 'color' == $field['type'] ) {

			$color = \Kirki_Color::sanitize_hex( $value );
			$styles[$element][$property] = $color;

		}

		// Background Controls
		elseif ( 'background' == $field['type'] ) {

			if ( isset( $field['default']['color'] ) ) {
				$color_mode = ( false !== strpos( $field['default']['color'], 'rgba' ) ) ? 'color-alpha' : 'color';
				$value = kirki_get_option( $field['settings'] . '_color' );
				if ( 'color-alpha' == $color_mode ) {
					$bg_color = esc_js( $value );
				} else {
					$bg_color = \Kirki_Color::sanitize_hex( $value );
				}
			}
			if ( isset( $field['default']['image'] ) ) {
				$bg_image = kirki_get_option( $field['settings'] . '_image' );
				$bg_image = esc_url_raw( $bg_image );
			}
			if ( isset( $field['default']['repeat'] ) ) {
				$bg_repeat = kirki_get_option( $field['settings'] . '_repeat' );
				$bg_repeat = kirki_sanitize_bg_repeat( $bg_repeat );
			}
			if ( isset( $field['default']['size'] ) ) {
				$bg_size = kirki_get_option( $field['settings'] . '_size' );
				$bg_size = kirki_sanitize_bg_size( $bg_size );
			}
			if ( isset( $field['default']['attach'] ) ) {
				$bg_attach = kirki_get_option( $field['settings'] . '_attach' );
				$bg_attach = kirki_sanitize_bg_attach( $bg_attach );
			}
			if ( isset( $field['default']['position'] ) ) {
				$bg_position = kirki_get_option( $field['settings'] . '_position' );
				$bg_position = kirki_sanitize_bg_position( $bg_position );
			}
			if ( isset( $field['default']['opacity'] ) && $field['default']['opacity'] ) {
				$bg_opacity = kirki_get_option( $field['settings'] . '_opacity' );
				$bg_opacity = kirki_sanitize_number( $bg_opacity );
				if ( isset( $bg_color ) ) {
					// If we're using an opacity other than 100, then convert the color to RGBA.
					$bg_color = ( 100 != $bg_opacity ) ? \Kirki_Color::get_rgba( $bg_color, $bg_opacity ) : $bg_color;
				} elseif ( isset( $bg_image ) ) {
					$element_opacity = ( $bg_opacity / 100 );
				}

			}

			if ( isset( $bg_color ) ) {
				$styles[$element]['background-color'] = $bg_color;
			}
			if ( isset( $bg_image ) && '' != $bg_image ) {
				$styles[$element]['background-image'] = 'url("' . $bg_image . '")';
				if ( isset( $bg_repeat ) ) {
					$styles[$element]['background-repeat'] = $bg_repeat;
				}
				if ( isset( $bg_size ) ) {
					$styles[$element]['background-size'] = $bg_size;
				}
				if ( isset( $bg_attach ) ) {
					$styles[$element]['background-attachment'] = $bg_attach;
				}
				if ( isset( $bg_position ) ) {
					$styles[$element]['background-position'] = str_replace( '-', ' ', $bg_position );
				}
			}

		}

		// Font controls
		elseif ( array( $field['output'] ) && isset( $field['output']['property'] ) && in_array( $field['output']['property'], array( 'font-family', 'font-size', 'font-weight' ) ) ) {

			$is_font_family = isset( $field['output']['property'] ) && 'font-family' == $field['output']['property'] ? true : false;
			$is_font_size   = isset( $field['output']['property'] ) && 'font-size'   == $field['output']['property'] ? true : false;
			$is_font_weight = isset( $field['output']['property'] ) && 'font-weight' == $field['output']['property'] ? true : false;

			if ( 'font-family' == $property ) {

				$styles[$field['output']['element']]['font-family'] = $value;

			} else if ( 'font-size' == $property ) {

				// Get the unit we're going to use for the font-size.
				$units = empty( $units ) ? 'px' : $units;
				$styles[$element]['font-size'] = $value . $units;

			} else if ( 'font-weight' == $property ) {

				$styles[$element]['font-weight'] = $value;

			}

		} else {

			$styles[$element][$property] = $value . $units;

		}

		return $styles;

	}


	function loop_controls() {

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

			// Only continue if $field['output'] is set
			if ( isset( $field['output'] ) ) {

				// Check if this is an array of style definitions
				$multiple_styles = isset( $field['output'][0]['element'] ) ? true : false;

				if ( ! $multiple_styles ) { // single style

					// If $field['output'] is not an array, then use the string as the target element
					if ( is_string( $field['output'] ) ) {
						$element = $field['output'];
					} else {
						$element  = isset( $field['output']['element'] )  ? $field['output']['element'] : '';
						$property = isset( $field['output']['property'] ) ? $field['output']['property'] : '';
						$units    = isset( $field['output']['units'] )    ? $field['output']['units']    : '';
					}

					$styles = $this->setting_styles( $field, $styles, $element, $property, $units );

				} else { // Multiple styles set

					foreach ( $field['output'] as $style ) {

						if ( ! array( $style ) ) {
							$element = $style;
						} else {
							$element  = isset( $style['element'] )  ? $style['element'] : '';
							$property = isset( $style['property'] ) ? $style['property'] : '';
							$units    = isset( $style['units'] )    ? $style['units']    : '';
						}

						$styles = $this->setting_styles( $field, $styles, $element, $property, $units );

					}

				}

			}

		}

		return $styles;

	}

}
