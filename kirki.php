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

// Set the KIRKI_PATH constant.
if ( ! defined( 'KIRKI_PATH' ) ) {
	define( 'KIRKI_PATH', dirname( __FILE__ ) );
}
// Set the KIRKI_URL constant.
if ( ! defined( 'KIRKI_URL' ) ) {
	define( 'KIRKI_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! function_exists( 'kirki_autoload_classes' ) ) {
	/**
	 * The Kirki class autoloader.
	 * Finds the path to a class that we're requiring and includes the file.
	 */
	function kirki_autoload_classes( $class_name ) {
		$paths = array();
		if ( 0 === stripos( $class_name, 'Kirki' ) ) {

			$replacements = array(
				'Controls',
				'Scripts',
				'Settings',
				'Styles',
			);

			$path     = KIRKI_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
			$filename = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';

			$paths[] = $path . $filename;

			foreach ( $replacements as $replacement ) {
				if ( 0 === stripos( $class_name, 'Kirki_' . $replacement ) ) {
					$substr   = str_replace( 'Kirki_' . $replacement, '', $class_name );
					$exploded = explode( '_', $substr );

					$paths[] = $path . strtolower( $replacement ) . DIRECTORY_SEPARATOR . $filename;
					$paths[] = $path . strtolower( $replacement ) . DIRECTORY_SEPARATOR . strtolower( str_replace( '_', '-', str_replace( '_' . $replacement, '', str_replace( 'Kirki_' . $replacement . '_', '', $class_name ) ) ) ) . DIRECTORY_SEPARATOR . $filename;
					if ( isset( $exploded[1] ) ) {
						$paths[] = $path . strtolower( $replacement ) . DIRECTORY_SEPARATOR . strtolower( $exploded[1] ) . DIRECTORY_SEPARATOR . $filename;
						if ( isset( $exploded[2] ) ) {
							$paths[] = $path . strtolower( $replacement ) . DIRECTORY_SEPARATOR . strtolower( $exploded[1] ) . DIRECTORY_SEPARATOR . strtolower( $exploded[2] ) . DIRECTORY_SEPARATOR . $filename;
							$paths[] = $path . strtolower( $replacement ) . DIRECTORY_SEPARATOR . strtolower( $exploded[1] ) . '-' .  strtolower( $exploded[2] ) . DIRECTORY_SEPARATOR . $filename;
						}
					}
				}
			}

			foreach ( $paths as $path ) {
				if ( file_exists( $path ) ) {
					include $path;
					return;
				}
			}

		}

	}
	// Run the autoloader
	spl_autoload_register( 'kirki_autoload_classes' );
}

// Include helper files
include_once( KIRKI_PATH.'/includes/functions.php' );
include_once( KIRKI_PATH.'/includes/deprecated.php' );
// Include the API class
include_once( KIRKI_PATH.'/includes/class-kirki.php' );

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

		return $kirki;

	}

	global $kirki;
	$kirki = Kirki();
}

if ( defined( 'KIRKI_REDUX_COMPATIBILITY' ) && KIRKI_REDUX_COMPATIBILITY ) {
	include_once( KIRKI_PATH.'/includes/redux-compatibility.php' );
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
		if ( file_exists( WP_LANG_DIR.'/'.$textdomain.'-'.get_locale().'.mo' ) ) {
			$file = WP_LANG_DIR.'/'.$textdomain.'-'.get_locale().'.mo';
		}
		// Look for KIRKI_PATH/languages/{$domain}-{$locale}.mo
		if ( ! isset( $file ) && file_exists( KIRKI_PATH.'/languages/'.$textdomain.'-'.get_locale().'.mo' ) ) {
			$file = KIRKI_PATH.'/languages/'.$textdomain.'-'.get_locale().'.mo';
		}

		if ( isset( $file ) ) {
			load_textdomain( $textdomain, $file );
		}

		load_plugin_textdomain( $textdomain, false, KIRKI_PATH.'/languages' );
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
if ( defined( 'KIRKI_DEMO' ) && KIRKI_DEMO && file_exists( dirname( __FILE__ ) . '/demo-theme/style.css' ) )  {
	register_theme_directory( dirname( __FILE__ ) );
}
