<?php
/**
 * Handles webfonts.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds script for tooltips.
 */
class Kirki_Modules_Webfonts {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Whether we should fallback to the link method or not.
	 *
	 * @access private
	 * @since 3.0.0
	 * @var bool
	 */
	private $fallback_to_link = false;

	/**
	 * The Kirki_Fonts_Google object.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var object
	 */
	protected $fonts_google;


	/**
	 * The class constructor
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {

		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts-google.php' );

		add_action( 'wp_loaded', array( $this, 'run' ) );

	}

	/**
	 * Run on after_setup_theme.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function run() {
		$this->fonts_google = Kirki_Fonts_Google::get_instance();
		$this->maybe_fallback_to_link();
		$this->init();
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Init other objects depending on the method we'll be using.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function init() {

		foreach ( array_keys( Kirki::$config ) as $config_id ) {
			$method    = $this->get_method( $config_id );
			$classname = 'Kirki_Modules_Webfonts_' . ucfirst( $method );
			new $classname( $config_id, $this, $this->fonts_google );
		}
	}

	/**
	 * Get the method we're going to use.
	 *
	 * @access public
	 * @since 3.0.0
	 * @return string
	 */
	public function get_method() {

		// Figure out which method to use.
		$method = apply_filters( 'kirki_googlefonts_load_method', 'async' );

		// Fallback to 'link' if value is invalid.
		if ( 'async' !== $method && 'embed' !== $method && 'link' !== $method ) {
			$method = 'async';
		}

		// Fallback to 'link' if embed was not possible.
		if ( 'embed' === $method && $this->fallback_to_link ) {
			$method = 'link';
		}

		$classname = 'Kirki_Modules_Webfonts_' . ucfirst( $method );
		if ( ! class_exists( $classname ) ) {
			$method = 'async';
		}

		// Force using the JS method while in the customizer.
		// This will help us work-out the live-previews for typography fields.
		// If we're not in the customizer use the defined method.
		return ( is_customize_preview() ) ? 'async' : $method;
	}

	/**
	 * Should we fallback to link method?
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function maybe_fallback_to_link() {

		// Get the $fallback_to_link value from transient.
		$fallback_to_link = get_transient( 'kirki_googlefonts_fallback_to_link' );
		if ( 'yes' === $fallback_to_link ) {
			$this->fallback_to_link = true;
		}

		// Use links when in the customizer.
		global $wp_customize;
		if ( $wp_customize ) {
			$this->fallback_to_link = true;
		}
	}

	/**
	 * Goes through all our fields and then populates the $this->fonts property.
	 *
	 * @access public
	 * @param string $config_id The config-ID.
	 */
	public function loop_fields( $config_id ) {
		foreach ( Kirki::$fields as $field ) {
			if ( isset( $field['kirki_config'] ) && $config_id !== $field['kirki_config'] ) {
				continue;
			}
			if ( true === apply_filters( "kirki_{$config_id}_webfonts_skip_hidden", true ) ) {
				// Only continue if field dependencies are met.
				if ( ! empty( $field['required'] ) ) {
					$valid = true;

					foreach ( $field['required'] as $requirement ) {
						if ( isset( $requirement['setting'] ) && isset( $requirement['value'] ) && isset( $requirement['operator'] ) ) {
							$controller_value = Kirki_Values::get_value( $config_id, $requirement['setting'] );
							if ( ! Kirki_Helper::compare_values( $controller_value, $requirement['value'], $requirement['operator'] ) ) {
								$valid = false;
							}
						}
					}

					if ( ! $valid ) {
						continue;
					}
				}
			}
			$this->fonts_google->generate_google_font( $field );
		}
	}
}
