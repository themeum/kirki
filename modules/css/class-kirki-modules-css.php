<?php
/**
 * Handles the CSS Output of fields.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.4.0
 */

/**
 * The Kirki_Modules_CSS object.
 */
class Kirki_Modules_CSS {

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
	 * Set to true if you want to use the AJAX method.
	 *
	 * @access public
	 * @var bool
	 */
	public static $ajax = false;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {

		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-modules-css-generator.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-output.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/field/class-kirki-output-field-multicolor.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/field/class-kirki-output-field-dimensions.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/field/class-kirki-output-field-typography.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/property/class-kirki-output-property.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/property/class-kirki-output-property-background-image.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/property/class-kirki-output-property-background-position.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/property/class-kirki-output-property-font-family.php' );

		add_action( 'init', array( $this, 'init' ) );

	}

	/**
	 * Init.
	 *
	 * @access public
	 */
	public function init() {

		Kirki_Fonts_Google::get_instance();

		global $wp_customize;

		$config   = apply_filters( 'kirki/config', array() );
		$priority = 999;
		if ( isset( $config['styles_priority'] ) ) {
			$priority = absint( $config['styles_priority'] );
		}

		// Allow completely disabling Kirki CSS output.
		if ( ( defined( 'KIRKI_NO_OUTPUT' ) && KIRKI_NO_OUTPUT ) || ( isset( $config['disable_output'] ) && true !== $config['disable_output'] ) ) {
			return;
		}

		// If we are in the customizer, load CSS using inline-styles.
		// If we are in the frontend AND self::$ajax is true, then load dynamic CSS using AJAX.
		if ( ! $wp_customize && ( ( true === self::$ajax ) || ( isset( $config['inline_css'] ) && false === $config['inline_css'] ) ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ), $priority );
			add_action( 'wp_ajax_kirki_dynamic_css', array( $this, 'ajax_dynamic_css' ) );
			add_action( 'wp_ajax_nopriv_kirki_dynamic_css', array( $this, 'ajax_dynamic_css' ) );
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'inline_dynamic_css' ), $priority );
		}
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
				if ( isset( $args['disable_output'] ) && true === $args['disable_output'] ) {
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
		require wp_normalize_path( Kirki::$path . '/modules/css/dynamic-css.php' );
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

		// Get an instance of the Kirki_Modules_CSS_Generator class.
		// This will make sure google fonts and backup fonts are loaded.
		Kirki_Modules_CSS_Generator::get_instance();

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
						$controller_value = Kirki_Values::get_value( $config_id, $requirement['setting'] );
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
				$css  = Kirki_Helper::array_replace_recursive( $css, Kirki_Modules_CSS_Generator::css( $field ) );

				// Add the globals.
				if ( isset( self::$css_array[ $config_id ] ) && ! empty( self::$css_array[ $config_id ] ) ) {
					Kirki_Helper::array_replace_recursive( $css, self::$css_array[ $config_id ] );
				}
			}
		}

		$css = apply_filters( 'kirki/' . $config_id . '/styles', $css );

		if ( is_array( $css ) ) {
			return Kirki_Modules_CSS_Generator::styles_parse( Kirki_Modules_CSS_Generator::add_prefixes( $css ) );
		}

		return;

	}
}
