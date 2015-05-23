<?php
/*
Plugin Name:   Kirki Framework
Plugin URI:    http://kirki.org
Description:   An options framework using and extending the WordPress Customizer
Author:        Aristeides Stathopoulos
Author URI:    http://aristeides.com
Version:       0.8.4
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
include_once( KIRKI_PATH . '/includes/sanitize.php' );
include_once( KIRKI_PATH . '/includes/helpers.php' );
// Include the API class
include_once( KIRKI_PATH . '/includes/class-kirki.php' );

/**
 * Returns the Kirki object
 */
function Kirki() {
	// Make sure the class is instanciated
	$kirki = Kirki_Framework::get_instance();

	$kirki->font_registry = new Kirki_Fonts_Font_Registry();
	$kirki->config        = new Kirki_Config();
	$kirki->fields        = new Kirki_Fields();
	$kirki->scripts       = new Kirki_Scripts_Registry();
	$kirki->styles        = new Kirki_Styles();
	$kirki->builder       = new Kirki_Builder();
	$kirki->api           = new Kirki();

	return $kirki;

}

global $kirki;
$kirki = Kirki();

if ( defined( 'KIRKI_REDUX_COMPATIBILITY' ) && KIRKI_REDUX_COMPATIBILITY ) {
	include_once( KIRKI_PATH . '/includes/redux-compatibility.php' );
}
