<?php
/**
 * Plugin Name:   Kirki Toolkit
 * Plugin URI:    http://kirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       3.0.0-beta.2
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
include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'autoloader.php' );

if ( ! defined( 'KIRKI_PLUGIN_FILE' ) ) {
	define( 'KIRKI_PLUGIN_FILE', __FILE__ );
}

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

// If Kirki is installed as a plugin, use plugin_dir_url().
$kirki_is_plugin = Kirki_Init::is_plugin();
if ( $kirki_is_plugin ) {
	Kirki::$url = plugin_dir_url( __FILE__ );
} elseif ( function_exists( 'is_link' ) && is_link( dirname( __FILE__ ) ) && function_exists( 'readlink' ) ) {
	// If the path is a symlink, get the target.
	Kirki::$path = readlink( Kirki::$path );
}

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
	include_once( $custom_config_path );
}

if ( ! function_exists( 'kirki_show_upgrade_notification' ) ) :
	/**
	 * Fires at the end of the update message container in each
	 * row of the plugins list table.
	 * Allows us to add important notices about updates should they be needed.
	 * Notices should be added using "== Upgrade Notice ==" in readme.txt.
	 *
	 * @since 2.3.8
	 * @param array $plugin_data An array of plugin metadata.
	 * @param array $response    An array of metadata about the available plugin update.
	 */
	function kirki_show_upgrade_notification( $plugin_data, $response ) {

		// Check "upgrade_notice".
		if ( isset( $response->upgrade_notice ) && strlen( trim( $response->upgrade_notice ) ) > 0 ) : ?>
			<style>.kirki-upgrade-notification {background-color:#d54e21;padding:10px;color:#f9f9f9;margin-top:10px;margin-bottom:10px;}.kirki-upgrade-notification + p {display:none;}</style>
			<div class="kirki-upgrade-notification">
				<strong><?php esc_attr_e( 'Important Upgrade Notice:', 'kirki' ); ?></strong>
				<?php $upgrade_notice = wp_strip_all_tags( $response->upgrade_notice ); ?>
				<?php echo esc_html( $upgrade_notice ); ?>
			</div>
		<?php endif;
	}
endif;
add_action( 'in_plugin_update_message-' . plugin_basename( __FILE__ ), 'kirki_show_upgrade_notification', 10, 2 );
