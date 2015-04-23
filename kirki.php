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


include_once( KIRKI_PATH . '/includes/class-kirki.php' );

function kirki_autoload_classes( $class_name ) {
	if ( stripos( $class_name, 'Kirki' ) === 0 ) {
		$class_path = KIRKI_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';
		if ( file_exists( $class_path ) ) {
			include $class_path;
		}
	}
}
spl_autoload_register( 'kirki_autoload_classes' );

// Include helper files
include_once( KIRKI_PATH . '/includes/deprecated.php' );
include_once( KIRKI_PATH . '/includes/sanitize.php' );
include_once( KIRKI_PATH . '/includes/helpers.php' );

// Make sure the class is instanciated
Kirki::get_instance();
