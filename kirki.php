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

// Include the main plugin class
include_once( KIRKI_PATH . '/includes/class-kirki.php' );

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

// Make sure the class is instanciated
Kirki::get_instance();
