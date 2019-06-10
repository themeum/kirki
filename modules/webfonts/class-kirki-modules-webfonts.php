<?php
/**
 * Handles webfonts.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
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

		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts-helper.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts-google.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

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
			if ( 'async' === $this->get_method() ) {
				new Kirki_Modules_Webfonts_Async( $config_id, $this, $this->fonts_google );
			}
			new Kirki_Modules_Webfonts_Embed( $config_id, $this, $this->fonts_google );
		}
	}

	/**
	 * Get the method we're going to use.
	 *
	 * @access public
	 * @since 3.0.0
	 * @deprecated in 3.0.36.
	 * @return string
	 */
	public function get_method() {
		return ( is_customize_preview() || is_admin() ) ? 'async' : 'embed';
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
