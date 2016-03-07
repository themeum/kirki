<?php
/**
 * Plugin Name:   Kirki Toolkit
 * Plugin URI:    http://kirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       2.2.0.beta.3
 * Text Domain:   kirki
 *
 * GitHub Plugin URI: aristath/kirki
 * GitHub Plugin URI: https://github.com/aristath/kirki
 *
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include the autoloader
include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'autoloader.php' );

// Gets an instance of the main Kirki object.
if ( ! function_exists( 'Kirki' ) ) {
	function Kirki() {
		$kirki = Kirki_Toolkit::get_instance();
		return $kirki;
	}
}
// Start Kirki
global $kirki;
$kirki = Kirki();
// Make sure the path is properly set
Kirki::$path = wp_normalize_path( dirname( __FILE__ ) );
// Instantiate 2ndary classes
new Kirki_l10n();
new Kirki_Scripts_Registry();
new Kirki_Styles_Customizer();
new Kirki_Styles_Frontend();
new Kirki_Selective_Refresh();
new Kirki();

// apply the kirki/config filter to the URL
if ( ! function_exists( 'kirki_filtered_url' ) ) {
	function kirki_filtered_url() {
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $config['url_path'] ) ) {
			Kirki::$url = esc_url_raw( $config['url_path'] );
		}
	}
}
if ( ! Kirki_Toolkit::is_plugin() ) {
	add_action( 'after_setup_theme', 'kirki_filtered_url' );
}
// Include deprectaed functions & methods
include_once( Kirki::$path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'deprecated.php' );
// Include the ariColor library
include_once( wp_normalize_path( Kirki::$path . '/includes/lib/class-aricolor.php' ) );

// Add an empty config for global fields
Kirki::add_config( '' );
