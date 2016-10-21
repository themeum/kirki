<?php
/**
 * Plugin Name:   XTKirki Toolkit
 * Plugin URI:    http://xtkirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       2.3.6
 * Text Domain:   xtkirki
 *
 * GitHub Plugin URI: aristath/xtkirki
 * GitHub Plugin URI: https://github.com/aristath/xtkirki
 *
 * @package     XTKirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No need to proceed if XTKirki already exists.
if ( class_exists( 'XTKirki' ) ) {
	return;
}

// Include the autoloader.
include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'autoloader.php' );

if ( ! function_exists( 'XTKirki' ) ) {
	/**
	 * Returns an instance of the XTKirki object.
	 */
	function XTKirki() {
		$xtkirki = XTKirki_Toolkit::get_instance();
		return $xtkirki;
	}
}
// Start XTKirki.
global $xtkirki;
$xtkirki = XTKirki();

// Make sure the path is properly set.
XTKirki::$path = wp_normalize_path( dirname( __FILE__ ) );

// Instantiate 2ndary classes.
new XTKirki_l10n();
new XTKirki_Scripts_Registry();
new XTKirki_Styles_Customizer();
new XTKirki_Styles_Frontend();
new XTKirki_Selective_Refresh();
new XTKirki();

// Include deprecated functions & methods.
include_once wp_normalize_path( dirname( __FILE__ ) . '/includes/deprecated.php' );

// Include the ariColor library.
include_once wp_normalize_path( dirname( __FILE__ ) . '/includes/lib/class-aricolor.php' );

// Add an empty config for global fields.
XTKirki::add_config( '' );
