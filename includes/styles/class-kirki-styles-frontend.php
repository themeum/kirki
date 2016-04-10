<?php
/**
 * Generates the styles for the frontend.
 * Handles the 'output' argument of fields.
 * Usage instructions on https://github.com/aristath/kirki/wiki/output
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Styles_Frontend' ) ) {

	/**
	 * Applies field-generated styles to the frontend.
	 */
	class Kirki_Styles_Frontend {

		/**
		 * Whether we've already processed this or not.
		 *
		 * @access public
		 * @var bool
		 */
		public $processed = false;

		/**
		 * The CSS array
		 *
		 * @access public
		 * @var array
		 */
		public static $css_array = array();

		/**
		 * Constructor
		 *
		 * @access public
		 */
		public function __construct() {

			Kirki_Fonts_Google::get_instance();

			global $wp_customize;

			$config   = apply_filters( 'kirki/config', array() );
			$priority = ( isset( $config['styles_priority'] ) ) ? intval( $config['styles_priority'] ) : 999;

			if ( ( defined( 'KIRKI_NO_OUTPUT' ) && KIRKI_NO_OUTPUT ) || ( isset( $config['disable_output'] ) && true !== $config['disable_output'] ) ) {
				return;
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'inline_dynamic_css' ), $priority );

		}

		/**
		 * Adds inline styles.
		 *
		 * @access public
		 */
		public function inline_dynamic_css() {
			$configs = Kirki::$config;
			if ( ! $this->processed ) {
				foreach ( $configs as $config_id => $args ) {
					if ( true === $args['disable_output'] ) {
						continue;
					}
					$styles = self::loop_controls( $config_id );
					$styles = apply_filters( 'kirki/' . $config_id . '/dynamic_css', $styles );
					if ( ! empty( $styles ) ) {
						wp_enqueue_style( 'kirki-styles-' . $config_id, trailingslashit( Kirki::$url ) . 'assets/css/kirki-styles.css', null, null );
						wp_add_inline_style( 'kirki-styles-' . $config_id, $styles );
					}
				}
				$this->processed = true;
			}
		}

		/**
		 * Get the dynamic-css.php file
		 *
		 * @access public
		 */
		public function ajax_dynamic_css() {
			require( Kirki::$path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'dynamic-css.php' );
			exit;
		}

		/**
		 * Enqueues the ajax stylesheet.
		 *
		 * @access public
		 */
		public function frontend_styles() {
			wp_enqueue_style( 'kirki-styles-php', admin_url( 'admin-ajax.php' ) . '?action=kirki_dynamic_css', null, null );
		}

		/**
		 * Loop through all fields and create an array of style definitions.
		 *
		 * @static
		 * @access public
		 * @param string $config_id The configuration ID.
		 */
		public static function loop_controls( $config_id ) {

			// Get an instance of the Kirki_Styles_Output_CSS class.
			// This will make sure google fonts and backup fonts are loaded.
			Kirki_Styles_Output_CSS::get_instance();

			$fields = Kirki::$fields;
			$css    = array();

			// Early exit if no fields are found.
			if ( empty( $fields ) ) {
				return;
			}

			foreach ( $fields as $field ) {

				// Only process fields that belong to $config_id.
				if ( $config_id != $field['kirki_config'] ) {
					continue;
				}

				// Only continue if field dependencies are met.
				if ( ! empty( $field['required'] ) ) {
					$valid = true;

					foreach ( $field['required'] as $requirement ) {
						if ( isset( $requirement['setting'] ) && isset( $requirement['value'] ) && isset( $requirement['operator'] ) ) {
							$controller_value = Kirki::get_option( $requirement['setting'] );
							if ( ! Kirki_Active_Callback::compare( $controller_value, $requirement['value'], $requirement['operator'] ) ) {
								$valid = false;
							}
						}
					}

					if ( ! $valid ) {
						continue;
					}
				}

				// Only continue if $field['output'] is set.
				if ( isset( $field['output'] ) && ! empty( $field['output'] ) && 'background' != $field['type'] ) {
					$css  = Kirki_Helper::array_replace_recursive( $css, Kirki_Styles_Output_CSS::css( $field ) );

					// Add the globals.
					if ( isset( self::$css_array[ $config_id ] ) && ! empty( self::$css_array[ $config_id ] ) ) {
						Kirki_Helper::array_replace_recursive( $css, self::$css_array[ $config_id ] );
					}
				}
			}

			if ( is_array( $css ) ) {
				return Kirki_Styles_Output_CSS::styles_parse( Kirki_Styles_Output_CSS::add_prefixes( $css ) );
			}

			return;

		}
	}
}
