<?php
/*
Plugin Name:   Kirki Framework
Plugin URI:    http://kirki.org
Description:   An options framework using and extending the WordPress Customizer
Author:        Aristeides Stathopoulos
Author URI:    http://press.codes
Version:       0.8.0-dev
Text Domain:   kirki
*/

if ( ! defined( 'KIRKI_PATH' ) ) {
	define( 'KIRKI_PATH', dirname( __FILE__ ) );
}
if ( ! defined( 'KIRKI_URL' ) ) {
	define( 'KIRKI_URL', plugin_dir_url( __FILE__ ) );
}

// Include the main kirki class
include_once( KIRKI_PATH . '/includes/Kirki.php' );

// Make sure the class is instanciated
Kirki::get_instance();

add_action( 'plugins_loaded', 'kirki_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function kirki_load_textdomain() {
	$textdomain = kirki_textdomain();
	load_plugin_textdomain( $textdomain, false, KIRKI_PATH . '/languages' );
}
