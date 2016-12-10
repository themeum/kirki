<?php
/**
 * Plugin Name:   Kirki Toolkit
 * Plugin URI:    http://kirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       2.3.7
 * Text Domain:   kirki
 *
 * GitHub Plugin URI: aristath/kirki
 * GitHub Plugin URI: https://github.com/aristath/kirki
 *
 * @package     Kirki
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

// No need to proceed if Kirki already exists.
if ( class_exists( 'Kirki' ) ) {
	return;
}

// Include the autoloader.
include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'autoloader.php' );

if ( ! function_exists( 'Kirki' ) ) {
	// @codingStandardsIgnoreStart
	/**
	 * Returns an instance of the Kirki object.
	 */
	function Kirki() {
		$kirki = Kirki_Toolkit::get_instance();
		return $kirki;
	}
	// @codingStandardsIgnoreEnd

}
// Start Kirki.
global $kirki;
$kirki = Kirki();
// Instamtiate the modules.
$kirki->modules = new Kirki_Modules();

// Make sure the path is properly set.
Kirki::$path = wp_normalize_path( dirname( __FILE__ ) );

// Instantiate 2ndary classes.
new Kirki_l10n();
new Kirki();

// Include deprecated functions & methods.
include_once wp_normalize_path( dirname( __FILE__ ) . '/core/deprecated.php' );

// Include the ariColor library.
include_once wp_normalize_path( dirname( __FILE__ ) . '/lib/class-aricolor.php' );

// Add an empty config for global fields.
Kirki::add_config( '' );
