<?php
/**
 * Plugin Name:   Kirki Customizer Framework
 * Plugin URI:    https://kirki.org
 * Description:   The Ultimate WordPress Customizer Framework
 * Author:        Ari Stathopoulos (@aristath)
 * Author URI:    https://aristath.github.io
 * Version:       4.0-dev
 * Text Domain:   kirki
 * Requires WP:   4.9
 * Requires PHP:  5.3
 * GitHub Plugin URI: aristath/kirki
 * GitHub Plugin URI: https://github.com/aristath/kirki
 *
 * @package   Kirki
 * @category  Core
 * @author    Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

use Kirki\Compatibility\Init;
use Kirki\L10n;
use Kirki\Compatibility\Modules;
use Kirki\Compatibility\Framework;
use Kirki\Compatibility\Kirki;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No need to proceed if Kirki already exists.
if ( class_exists( 'Kirki' ) ) {
	return;
}

if ( ! defined( 'KIRKI_PLUGIN_FILE' ) ) {
	define( 'KIRKI_PLUGIN_FILE', __FILE__ );
}

require_once __DIR__ . '/lib/class-aricolor.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
require_once __DIR__ . '/lib/class-kirki-color.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
require_once __DIR__ . '/packages/autoload.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
require_once __DIR__ . '/inc/bootstrap.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

// Define the KIRKI_VERSION constant.
if ( ! defined( 'KIRKI_VERSION' ) ) {
	define( 'KIRKI_VERSION', '4.0-dev' );
}

if ( ! function_exists( 'Kirki' ) ) {
	/**
	 * Returns an instance of the Kirki object.
	 */
	function kirki() {
		$kirki = Framework::get_instance();
		return $kirki;
	}
}

// Start Kirki.
global $kirki;
$kirki = kirki();

// Instantiate the modules.
$kirki->modules = new Modules();

// Instantiate classes.
new Kirki();
new L10n( 'kirki', __DIR__ . '/languages' );

// Include the ariColor library.
require_once wp_normalize_path( dirname( __FILE__ ) . '/lib/class-aricolor.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

// Add an empty config for global fields.
Kirki::add_config( '' );

$custom_config_path = dirname( __FILE__ ) . '/custom-config.php';
$custom_config_path = wp_normalize_path( $custom_config_path );
if ( file_exists( $custom_config_path ) ) {
	require_once $custom_config_path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
}

// Add upgrade notifications.
require_once wp_normalize_path( dirname( __FILE__ ) . '/upgrade-notifications.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

/**
 * To enable tests, add this line to your wp-config.php file (or anywhere alse):
 * define( 'KIRKI_TEST', true );
 *
 * Please note that the example.php file is not included in the wordpress.org distribution
 * and will only be included in dev versions of the plugin in the github repository.
 */
if ( defined( 'KIRKI_TEST' ) && true === KIRKI_TEST && file_exists( dirname( __FILE__ ) . '/example.php' ) ) {
	include_once dirname( __FILE__ ) . '/example.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
}
