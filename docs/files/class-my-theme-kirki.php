<?php
/**
 * Wrapper Class for kirki which also acts as a fallback for CSS generation
 * when the kirki plugin is disabled.
 *
 * @package kirki
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is a wrapper class for Kirki.
 * If the Kirki plugin is installed, then all CSS & Google fonts
 * will be handled by the plugin.
 * In case the plugin is not installed, this acts as a fallback
 * ensuring that all CSS & fonts still work.
 * It does not handle the customizer options, simply the frontend CSS.
 */
class My_Theme_Kirki {

	/**
	 * The config ID.
	 *
	 * @static
	 * @access protected
	 * @var array
	 */
	protected static $config = array();

	/**
	 * An array of all our fields.
	 *
	 * @static
	 * @access protected
	 * @var array
	 */
	protected static $fields = array();

	/**
	 * The class constructor
	 */
	public function __construct() {

		// If Kirki exists then there's no reason to proceed.
		if ( class_exists( 'Kirki' ) ) {
			return;
		}

		// Add our CSS.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 20 );

		// Add google fonts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fonts' ) );
	}

	/**
	 * Get the value of an option from the db.
	 *
	 * @param string $config_id The ID of the configuration corresponding to this field.
	 * @param string $field_id  The field_id (defined as 'settings' in the field arguments).
	 * @return mixed            The saved value of the field.
	 */
	public static function get_option( $config_id = '', $field_id = '' ) {

		// if Kirki exists, use it.
		if ( class_exists( 'Kirki' ) ) {
			return Kirki::get_option( $config_id, $field_id );
		}

		// Kirki does not exist, continue with our custom implementation.
		// Get the default value of the field.
		$default = '';
		if ( isset( self::$fields[ $field_id ] ) && isset( self::$fields[ $field_id ]['default'] ) ) {
			$default = self::$fields[ $field_id ]['default'];
		}

		// Make sure the config is defined.
		if ( isset( self::$config[ $config_id ] ) ) {
			if ( 'option' === self::$config[ $config_id ]['option_type'] ) {

				// check if we're using serialized options.
				if ( isset( self::$config[ $config_id ]['option_name'] ) && ! empty( self::$config[ $config_id ]['option_name'] ) ) {

					// Get all our options.
					$all_options = get_option( self::$config[ $config_id ]['option_name'], array() );

					// If our option is not saved, return the default value.
					// If option was set, return its value unserialized.
					return ( ! isset( $all_options[ $field_id ] ) ) ? $default : maybe_unserialize( $all_options[ $field_id ] );
				}

				// If we're not using serialized options, get the value and return it.
				// We'll be using a dummy default here to check if the option has been set or not.
				// We'll be using md5 to make sure it's randomish and impossible to be actually set by a user.
				$dummy = md5( $config_id . '_UNDEFINED_VALUE' );
				$value = get_option( $field_id, $dummy );

				// setting has not been set, return default.
				return ( $dummy === $value ) ? $default : $value;
			}

			// We're not using options so fallback to theme_mod.
			return get_theme_mod( $field_id, $default );
		}
	}

	/**
	 * Create a new panel.
	 *
	 * @param string $id   The ID for this panel.
	 * @param array  $args The panel arguments.
	 */
	public static function add_panel( $id = '', $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_panel( $id, $args );
		}
		/* If Kirki does not exist then there's no reason to add any panels. */
	}

	/**
	 * Create a new section.
	 *
	 * @param string $id   The ID for this section.
	 * @param array  $args The section arguments.
	 */
	public static function add_section( $id, $args ) {
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_section( $id, $args );
		}
		/* If Kirki does not exist then there's no reason to add any sections. */
	}

	/**
	 * Sets the configuration options.
	 *
	 * @param string $config_id The configuration ID.
	 * @param array  $args      The configuration arguments.
	 */
	public static function add_config( $config_id, $args = array() ) {

		// if Kirki exists, use it.
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_config( $config_id, $args );
			return;
		}

		// Kirki does not exist, set the config arguments.
		self::$config[ $config_id ] = $args;

		// Make sure an option_type is defined.
		if ( ! isset( self::$config[ $config_id ]['option_type'] ) ) {
			self::$config[ $config_id ]['option_type'] = 'theme_mod';
		}
	}

	/**
	 * Create a new field
	 *
	 * @param string $config_id The configuration ID.
	 * @param array  $args      The field's arguments.
	 * @return null
	 */
	public static function add_field( $config_id, $args ) {

		// if Kirki exists, use it.
		if ( class_exists( 'Kirki' ) ) {
			Kirki::add_field( $config_id, $args );
			return;
		}

		// Kirki was not located, so we'll need to add our fields here.
		// Check that the "settings" & "type" arguments have been defined.
		if ( isset( $args['settings'] ) && isset( $args['type'] ) ) {

			// Make sure we add the config_id to the field itself.
			// This will make it easier to get the value when generating the CSS later.
			if ( ! isset( $args['kirki_config'] ) ) {
				$args['kirki_config'] = $config_id;
			}
			self::$fields[ $args['settings'] ] = $args;
		}
	}

	/**
	 * Enqueues the stylesheet.
	 *
	 * @access public
	 * @return null
	 */
	public function enqueue_styles() {

		// If Kirki exists there's no need to proceed any further.
		if ( class_exists( 'Kirki' ) ) {
			return;
		}

		// Get our inline styles.
		$styles = $this->get_styles();

		// If we have some styles to add, add them now.
		if ( ! empty( $styles ) ) {

			// Enqueue the theme's style.css file.
			$current_theme = ( wp_get_theme() );
			wp_enqueue_style( $current_theme->stylesheet . '_no-kirki', get_stylesheet_uri(), array(), '1.0' );
			wp_add_inline_style( $current_theme->stylesheet . '_no-kirki', $styles );
		}
	}

	/**
	 * Gets all our styles and returns them as a string.
	 *
	 * @access public
	 * @return string
	 */
	public function get_styles() {

		// Get an array of all our fields.
		$fields = self::$fields;

		// Check if we need to exit early.
		if ( empty( self::$fields ) || ! is_array( $fields ) ) {
			return;
		}

		// Initially we're going to format our styles as an array.
		// This is going to make processing them a lot easier
		// and make sure there are no duplicate styles etc.
		$css = array();

		// Start parsing our fields.
		foreach ( $fields as $field ) {

			// No need to process fields without an output, or an improperly-formatted output.
			if ( ! isset( $field['output'] ) || empty( $field['output'] ) || ! is_array( $field['output'] ) ) {
				continue;
			}

			// Get the value of this field.
			$value = self::get_option( $field['kirki_config'], $field['settings'] );

			// Start parsing the output arguments of the field.
			foreach ( $field['output'] as $output ) {
				$output = wp_parse_args(
					$output,
					array(
						'element'       => '',
						'property'      => '',
						'media_query'   => 'global',
						'prefix'        => '',
						'units'         => '',
						'suffix'        => '',
						'value_pattern' => '$',
						'choice'        => '',
					)
				);

				// If element is an array, convert it to a string.
				if ( is_array( $output['element'] ) ) {
					$output['element'] = implode( ',', $output['element'] );
				}

				// Simple fields.
				if ( ! is_array( $value ) ) {
					$value = str_replace( '$', $value, $output['value_pattern'] );
					if ( ! empty( $output['element'] ) && ! empty( $output['property'] ) ) {
						$css[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $value . $output['units'] . $output['suffix'];
					}
				} else {
					if ( 'typography' === $field['type'] ) {

						foreach ( $value as $key => $subvalue ) {

							// Add double quotes if needed to font-families.
							if ( 'font-family' === $key && false !== strpos( $subvalue, ' ' ) && false === strpos( $subvalue, '"' ) ) {
								$css[ $output['media_query'] ][ $output['element'] ]['font-family'] = '"' . $subvalue . '"';
							}

							// Variants contain both font-weight & italics.
							if ( 'variant' === $key ) {
								$font_weight = str_replace( 'italic', '', $subvalue );
								$font_weight = ( in_array( $font_weight, array( '', 'regular' ), true ) ) ? '400' : $font_weight;
								$css[ $output['media_query'] ][ $output['element'] ]['font-weight'] = $font_weight;

								// Is this italic?
								if ( false !== strpos( $subvalue, 'italic' ) ) {
									$css[ $output['media_query'] ][ $output['element'] ]['font-style'] = 'italic';
								}
							} else {
								$css[ $output['media_query'] ][ $output['element'] ][ $key ] = $subvalue;
							}
						}
					} elseif ( 'multicolor' === $field['type'] ) {

						if ( ! empty( $output['element'] ) && ! empty( $output['property'] ) && ! empty( $output['choice'] ) ) {
							$css[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $value[ $output['choice'] ] . $output['units'] . $output['suffix'];
						}
					} else {

						foreach ( $value as $key => $subvalue ) {
							$property = $key;
							if ( false !== strpos( $output['property'], '%%' ) ) {
								$property = str_replace( '%%', $key, $output['property'] );
							} elseif ( ! empty( $output['property'] ) ) {
								$output['property'] = $output['property'] . '-' . $key;
							}
							if ( 'background-image' === $output['property'] && false === strpos( $subvalue, 'url(' ) ) {
								$subvalue = 'url("' . set_url_scheme( $subvalue ) . '")';
							}
							if ( $subvalue ) {
								$css[ $output['media_query'] ][ $output['element'] ][ $property ] = $subvalue;
							}
						}
					}
				}
			}
		}

		// Process the array of CSS properties and produce the final CSS.
		$final_css = '';
		if ( ! is_array( $css ) || empty( $css ) ) {
			return '';
		}

		// Parse the generated CSS array and create the CSS string for the output.
		foreach ( $css as $media_query => $styles ) {

			// Handle the media queries.
			$final_css .= ( 'global' !== $media_query ) ? $media_query . '{' : '';
			foreach ( $styles as $style => $style_array ) {

				$final_css .= $style . '{';
				foreach ( $style_array as $property => $value ) {

					$value = ( is_string( $value ) ) ? $value : '';

					// Make sure background-images are properly formatted.
					if ( 'background-image' === $property ) {
						if ( false === strrpos( $value, 'url(' ) ) {
							$value = set_url_scheme( $value );
							$value = 'url("' . esc_url_raw( $value ) . '")';
						}
					} else {
						$value = esc_textarea( $value );
					}
					$final_css .= $property . ':' . $value . ';';
				}
				$final_css .= '}';
			}
			$final_css .= ( 'global' !== $media_query ) ? '}' : '';
		}
		return $final_css;
	}

	/**
	 * Enqueue google fonts.
	 *
	 * @access public
	 * @return null
	 */
	public function enqueue_fonts() {

		// Check if we need to exit early.
		if ( empty( self::$fields ) || ! is_array( self::$fields ) ) {
			return;
		}

		foreach ( self::$fields as $field ) {

			// Process typography fields.
			if ( isset( $field['type'] ) && 'typography' === $field['type'] ) {

				// Check if we've got everything we need.
				if ( ! isset( $field['kirki_config'] ) || ! isset( $field['settings'] ) ) {
					continue;
				}
				$value = self::get_option( $field['kirki_config'], $field['settings'] );
				if ( isset( $value['font-family'] ) ) {
					$url              = '//fonts.googleapis.com/css?family=' . str_replace( ' ', '+', $value['font-family'] );
					$value['variant'] = ( isset( $value['variant'] ) ) ? $value['variant'] : '';
					$url             .= ( empty( $value['variant'] ) ) ? '' : ':' . $value['variant'];

					$key = md5( $value['font-family'] . $value['variant'] );

					// Check that the URL is valid. we're going to use transients to make this faster.
					$url_is_valid = get_transient( $key );

					/**
					 * Reset the cache if we're using action=kirki-reset-cache in the URL.
					 *
					 * Note to code reviewers:
					 * There's no need to check nonces or anything else, this is a simple true/false evaluation.
					 */
					if ( ! empty( $_GET['action'] ) && 'kirki-reset-cache' === $_GET['action'] ) { // phpcs:ignore WordPress.Security.NonceVerification
						$url_is_valid = false;
					}

					// If transient does not exist.
					if ( false === $url_is_valid ) {
						$response = wp_remote_get( 'https:' . $url );
						if ( ! is_array( $response ) ) {

							// The url was not properly formatted,
							// cache for 12 hours and continue to the next field.
							set_transient( $key, null, 12 * HOUR_IN_SECONDS );
							continue;
						}

						// Check the response headers.
						if ( isset( $response['response'] ) && isset( $response['response']['code'] ) ) {
							if ( 200 === $response['response']['code'] ) {

								// URL was ok. Set transient to true and cache for an hour.
								set_transient( $key, true, 7 * 24 * HOUR_IN_SECONDS );
								$url_is_valid = true;
							}
						}
					}

					// If the font-link is valid, enqueue it.
					if ( $url_is_valid ) {
						wp_enqueue_style( $key, $url, array(), '1.0' );
					}
				}
			}
		}
	}
}
new My_Theme_Kirki();
