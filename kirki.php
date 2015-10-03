<?php
/**
 * Plugin Name:   Kirki Toolkit
 * Plugin URI:    http://kirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       1.0.2
 * Text Domain:   kirki
 *
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include the autoloader
include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'autoloader.php' );

if ( ! function_exists( 'Kirki' ) ) {
	/**
	 * Returns the Kirki object
	 */
	function Kirki() {
		// Make sure the class is instanciated
		$kirki = Kirki_Toolkit::get_instance();

		$kirki->font_registry = new Kirki_Fonts_Font_Registry();
		$kirki->api           = new Kirki();
		$kirki->scripts       = new Kirki_Scripts_Registry();
		$kirki->styles        = array(
			'back'  => new Kirki_Styles_Customizer(),
			'front' => new Kirki_Styles_Frontend(),
		);

		/**
		 * The path of the current Kirki instance
		 */
		Kirki::$path = dirname( __FILE__ );
		/**
		 * The URL of the current Kirki instance
		 */
		if ( false !== strpos( dirname( __FILE__ ), WP_PLUGIN_DIR ) ) {
			/**
			 * Kirki is activated as a plugin.
			 */
			Kirki::$url = plugin_dir_url( __FILE__ );
		} else if ( false !== strpos( dirname( __FILE__ ), get_template_directory() ) ) {
			/**
			 * Kirki is embedded in a theme
			 */
			Kirki::$url = get_template_directory_uri() . str_replace( get_template_directory(), '', dirname( __FILE__ ) );
		}
		/**
		 * Apply the filters to the Kirki::$url
		 */
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $config['url_path'] ) ) {
			Kirki::$url = esc_url_raw( $config['url_path'] );
		}

		return $kirki;

	}

	global $kirki;
	$kirki = Kirki();
}

include_once( Kirki::$path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'deprecated.php' );
// Include the API class
include_once( Kirki::$path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'class-kirki.php' );

if ( defined( 'KIRKI_REDUX_COMPATIBILITY' ) && KIRKI_REDUX_COMPATIBILITY ) {
	include_once( Kirki::$path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'redux-compatibility.php' );
}

if ( ! function_exists( 'kirki_load_textdomain' ) ) {
	/**
	 * Load plugin textdomain.
	 *
	 * @since 0.8.0
	 */
	function kirki_load_textdomain() {
		$textdomain = 'kirki';

		// Look for WP_LANG_DIR/{$domain}-{$locale}.mo
		if ( file_exists( WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
			$file = WP_LANG_DIR . '/' . $textdomain . '-' . get_locale() . '.mo';
		}
		// Look for Kirki::$path/languages/{$domain}-{$locale}.mo
		if ( ! isset( $file ) && file_exists( Kirki::$path . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $textdomain . '-' . get_locale() . '.mo' ) ) {
			$file = Kirki::$path . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $textdomain . '-' . get_locale() . '.mo';
		}

		if ( isset( $file ) ) {
			load_textdomain( $textdomain, $file );
		}

		load_plugin_textdomain( $textdomain, false, Kirki::$path . DIRECTORY_SEPARATOR . 'languages' );
	}
	add_action( 'plugins_loaded', 'kirki_load_textdomain' );
}

// Add an empty config for global fields
Kirki::add_config( '' );

/**
 * To enable the demo theme, just add this line to your wp-config.php file:
 * define( 'KIRKI_CONFIG', true );
 * Once you add that line, you'll see a new theme in your dashboard called "Kirki Demo".
 * Activate that theme to test all controls.
 */
if ( defined( 'KIRKI_DEMO' ) && KIRKI_DEMO && file_exists( dirname( __FILE__ ) . '/demo-theme/style.css' ) ) {
	register_theme_directory( dirname( __FILE__ ) );
}
