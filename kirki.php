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

// Include helper files
include_once( KIRKI_PATH . '/includes/Helpers/libraries/class-kirki-color.php' );
include_once( KIRKI_PATH . '/includes/Helpers/libraries/class-kirki-colourlovers.php' );
include_once( KIRKI_PATH . '/includes/Helpers/deprecated.php' );
include_once( KIRKI_PATH . '/includes/Helpers/sanitize.php' );
include_once( KIRKI_PATH . '/includes/Helpers/helpers.php' );

// Include the main kirki class
include_once( KIRKI_PATH . '/includes/Kirki.php' );

// Make sure the class is instanciated
Kirki::get_instance();
