<?php
/**
 * Plugin Name:   Kirki Toolkit
 * Plugin URI:    http://kirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       3.0.10
 * Text Domain:   kirki
 *
 * GitHub Plugin URI: aristath/kirki
 * GitHub Plugin URI: https://github.com/aristath/kirki
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
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
include_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'class-kirki-autoload.php';
new Kirki_Autoload();

if ( ! defined( 'KIRKI_PLUGIN_FILE' ) ) {
	define( 'KIRKI_PLUGIN_FILE', __FILE__ );
}

// Make sure the path is properly set.
Kirki::$path = wp_normalize_path( dirname( __FILE__ ) );
Kirki_Init::set_url();

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

Kirki::$url  = str_replace( wp_normalize_path( WP_CONTENT_DIR ), WP_CONTENT_URL, Kirki::$path );

// Instantiate 2ndary classes.
new Kirki_L10n();
new Kirki();
// Include deprecated functions & methods.
include_once wp_normalize_path( dirname( __FILE__ ) . '/core/deprecated.php' );

// Include the ariColor library.
include_once wp_normalize_path( dirname( __FILE__ ) . '/lib/class-aricolor.php' );

// Add an empty config for global fields.
Kirki::add_config( '' );

$custom_config_path = dirname( __FILE__ ) . '/custom-config.php';
$custom_config_path = wp_normalize_path( $custom_config_path );
if ( file_exists( $custom_config_path ) ) {
	include_once $custom_config_path;
}

// Add upgrade notifications.
include_once wp_normalize_path( dirname( __FILE__ ) . '/upgrade-notifications.php' );

// Handle localization when kirki is included in a theme.
include_once wp_normalize_path( dirname( __FILE__ ) . '/l10n.php' );
