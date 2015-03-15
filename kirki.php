<?php
/*
Plugin Name:   Kirki Framework
Plugin URI:    http://kirki.org
Description:   An options framework using and extending the WordPress Customizer
Author:        Aristeides Stathopoulos
Author URI:    http://press.codes
Version:       0.7.1
*/

// Load Kirki_Fonts before everything else
include_once( dirname( __FILE__ ) . '/includes/class-kirki-fonts.php' );

/**
 * The main Kirki class
 */
if ( ! class_exists( 'Kirki' ) ) :
class Kirki {

	public $version = '0.7.1';

	public $scripts;
	public $styles;
	public $controls;

	private static $instance;

	protected function __construct() {

		if ( ! defined( 'KIRKI_PATH' ) ) {
			define( 'KIRKI_PATH', dirname( __FILE__ ) );
		}
		if ( ! defined( 'KIRKI_URL' ) ) {
			define( 'KIRKI_URL', plugin_dir_url( __FILE__ ) );
		}

		$options = $this->get_config();

		include_once( dirname( __FILE__ ) . '/includes/required.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-kirki-style.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-kirki-scripts.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-kirki-fonts-script.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-kirki-color.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-kirki-settings.php' );
		include_once( dirname( __FILE__ ) . '/includes/class-kirki-controls.php' );
		include_once( dirname( __FILE__ ) . '/includes/deprecated.php' );

		$this->scripts  = Kirki_Scripts::get_instance();
		$this->styles   = new Kirki_Style();
		$this->controls = new Kirki_Controls();

		add_action( 'customize_register', array( $this, 'include_customizer_controls' ), 1 );
		add_action( 'customize_register', array( $this, 'customizer_builder' ), 99 );
		add_action( 'wp', array( $this, 'update' ) );

	}

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Include the necessary files for custom controls.
	 * Default WP Controls are not included here because they are already being loaded from WP Core.
	 */
	function include_customizer_controls() {

		$controls = $this->get_controls();
		foreach ( $controls as $control ) {
			if ( 'group_title' == $control['type'] ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-group-title-control.php' );
			} elseif ( 'multicheck' == $control['type'] ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-multicheck-control.php' );
			} elseif ( 'number' == $control['type'] ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-number-control.php' );
			} elseif ( 'radio-buttonset' == $control['type'] || ( 'radio' == $control['type'] && isset( $control['mode'] ) && 'buttonset' == $control['mode'] ) ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-buttonset-control.php' );
			} elseif ( 'radio-image' == $control['type'] || ( 'radio' == $control['type'] && isset( $control['mode'] ) && 'image' == $control['mode'] ) ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-image-control.php' );
			} elseif ( 'slider' == $control['type'] ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
			} elseif ( 'sortable' == $control['type'] ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-sortable-control.php' );
			} elseif ( 'switch' == $control['type'] || ( 'checkbox' == $control['type'] && isset( $control['mode'] ) && 'switch' == $control['mode'] ) ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-switch-control.php' );
			} elseif ( 'toggle' == $control['type'] || ( 'checkbox' == $control['type'] && isset( $control['mode'] ) && 'toggle' == $control['mode'] ) ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-toggle-control.php' );
			} elseif ( 'background' == $control['type'] ) {
				include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
			}
		}

	}

	/**
	 * Build the controls
	 */
	function customizer_builder( $wp_customize ) {

		$controls = $this->get_controls();
		$kirki_settings = new Kirki_Settings();
		$kirki_controls = $this->controls;

		// Early exit if controls are not set or if they're empty
		if ( ! isset( $controls ) || empty( $controls ) ) {
			return;
		}
		foreach ( $controls as $control ) {
			$kirki_settings->add_setting( $wp_customize, $control );
			$kirki_controls->add_control( $wp_customize, $control );
		}

	}

	function get_config() {

		$config = apply_filters( 'kirki/config', array() );

		$controls = $this->get_controls();
		foreach( $controls as $control ) {
			if ( isset( $control['output'] ) ) {
				$uses_output = true;
			}
		}

		if ( isset( $uses_output ) && ! isset( $config['stylesheet_id'] ) ) {
			$config['stylesheet_id'] = 'kirki-styles';
		}
		return $config;

	}

	function get_controls() {

		$controls = apply_filters( 'kirki/controls', array() );
		return $controls;

	}

	function update() {

		$version = get_option( 'kirki_version' );
		$version = ( ! $version ) ? '0' : $version;
		// < 0.6.1 -> 0.6.2
		if ( ! get_option( 'kirki_version' ) ) {
			/**
			 * In versions 0.6.0 & 0.6.1 there was a bug and some fields were saved as ID_opacity istead if ID
			 * This will fix the wrong settings naming and save new settings.
			 */
			$control_ids = array();
			$controls = $this->get_controls();
			foreach ( $controls as $control ) {
				$control = Kirki_Controls::control_clean( $control );

				if ( 'background' != $control['type'] ) {
					$control_ids[] = $control['settings'];
				}
			}
			foreach ( $control_ids as $control_id ) {
				if ( get_theme_mod( $control_id . '_opacity' ) && ! get_theme_mod( $control_id ) ) {
					update_theme_mod( $control_id, get_theme_mod( $control_id . '_opacity' ) );
				}
			}

		}

		if ( version_compare( $this->version, $version ) ) {
			update_option( 'kirki_version', $this->version );
		}

	}

}
endif;

if ( ! function_exists( 'Kirki' ) ) :
function Kirki() {
	return Kirki::get_instance();
}
endif;
// Global for backwards compatibility.
$GLOBALS['kirki'] = Kirki();
global $kirki;

// TODO: The following is commented out because so far it just doesn't work.
// I can't figure out why, if anyone has any ideas then please do let me know
//
// /**
//  * A wrapper function for get_theme_mod.
//  *
//  * This will be a bit more generic and will future-proof the plugin
//  * in case we ever decide to switch to using options instead of theme mods.
//  *
//  * An additional benefit is that it also gets the default values
//  * without the need to manually define them like in get_theme_mod();
//  *
//  * It's recommended that you add the following to your theme/plugin before using this function:
//  *

// if ( ! function_exists( 'kirki_get_option' ) ) :
// function kirki_get_option( $option ) {
// 	get_theme_mod( $option, '' );
// }
// endif;

//  *
//  * This will NOT get the right value, but at least no fatal errors will occur in case the plugin is not installed.
//  */
// function kirki_get_option( $option ) {

// 	// Get the array of controls
// 	$controls = Kirki()->get_controls();

// 	foreach ( $controls as $control ) {
// 		// Sanitize out control array and make sure we're using the right syntax
// 		$control = Kirki_Controls::control_clean( $control );
// 		$setting = $control['settings'];
// 		// Get the theme_mod and pass the default value as well
// 		if ( $option == $setting ) {
// 			$value = get_theme_mod( $option, $control['default'] );
// 		}

// 	}

// 	// If no value has been set, use get_theme_mod with an empty default.
// 	$value = ( isset( $value ) ) ? $value : get_theme_mod( $option, '' );

// 	return $value;

// }
