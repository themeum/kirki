<?php
/*
Plugin Name:   Kirki Toolkit
Plugin URI:    http://kirki.org
Description:   The ultimate WordPress Customizer Toolkit
Author:        Aristeides Stathopoulos
Author URI:    http://aristeides.com
Version:       1.0.0-alpha
Text Domain:   kirki
*/

if ( ! defined( 'KIRKI_PATH' ) ) {
	define( 'KIRKI_PATH', dirname( __FILE__ ) );
}
if ( ! defined( 'KIRKI_URL' ) ) {
	define( 'KIRKI_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * The Kirki class autoloader.
 * Finds the path to a class that we're requiring and includes the file.
 */
function kirki_autoload_classes( $class_name ) {

	if ( 0 === stripos( $class_name, 'Kirki' ) ) {

		$foldername = ( 0 === stripos( $class_name, 'Kirki_Controls_' ) ) ? 'controls' : '';
		$foldername = ( 0 === stripos( $class_name, 'Kirki_Scripts' ) )   ? 'scripts'  : $foldername;
		$foldername = ( 0 === stripos( $class_name, 'Kirki_Styles' ) )    ? 'styles'   : $foldername;

		$foldername = ( '' != $foldername ) ? $foldername . DIRECTORY_SEPARATOR : '';

		$class_path = KIRKI_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $foldername . 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
		if ( file_exists( $class_path ) ) {
			include $class_path;
		}

	}

}
// Run the autoloader
spl_autoload_register( 'kirki_autoload_classes' );

// Include helper files
include_once( KIRKI_PATH . '/includes/deprecated.php' );
include_once( KIRKI_PATH . '/includes/functions.php' );
// Include the API class
include_once( KIRKI_PATH . '/includes/class-kirki.php' );

/**
 * Returns the Kirki object
 */
function Kirki() {
	// Make sure the class is instanciated
	$kirki = Kirki_Toolkit::get_instance();

	$kirki->field         = new Kirki_Field();
	$kirki->font_registry = new Kirki_Fonts_Font_Registry();
	$kirki->config        = new Kirki_Config();
	$kirki->scripts       = new Kirki_Scripts_Registry();
	$kirki->settings      = new Kirki_Settings();
	$kirki->controls      = new Kirki_Controls();
	$kirki->api           = new Kirki();
	$kirki->styles        = new Kirki_Styles();

	return $kirki;

}

global $kirki;
$kirki = Kirki();

if ( defined( 'KIRKI_REDUX_COMPATIBILITY' ) && KIRKI_REDUX_COMPATIBILITY ) {
	include_once( KIRKI_PATH . '/includes/redux-compatibility.php' );
}

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
	// Look for KIRKI_PATH/languages/{$domain}-{$locale}.mo
	if ( ! isset( $file ) && file_exists( KIRKI_PATH . '/languages/' . $textdomain . '-' . get_locale() . '.mo' ) ) {
		$file = KIRKI_PATH . '/languages/' . $textdomain . '-' . get_locale() . '.mo';
	}

	if ( isset( $file ) ) {
		load_textdomain( $textdomain, $file );
	}

	load_plugin_textdomain( $textdomain, false, KIRKI_PATH . '/languages' );
}
add_action( 'plugins_loaded', 'kirki_load_textdomain' );

// Add an empty config for global fields
Kirki::add_config( '' );
