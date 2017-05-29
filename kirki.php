<?php
/**
 * Plugin Name:   Kirki Toolkit
 * Plugin URI:    http://kirki.org
 * Description:   The ultimate WordPress Customizer Toolkit
 * Author:        Aristeides Stathopoulos
 * Author URI:    http://aristeides.com
 * Version:       2.3.8
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
	/**
	 * Returns an instance of the Kirki object.
	 */
	function Kirki() {
		$kirki = Kirki_Toolkit::get_instance();
		return $kirki;
	}
}
// Start Kirki.
global $kirki;
$kirki = Kirki();

// Make sure the path is properly set.
Kirki::$path = wp_normalize_path( dirname( __FILE__ ) );

// Instantiate 2ndary classes.
new Kirki_l10n();
new Kirki_Scripts_Registry();
new Kirki_Styles_Customizer();
new Kirki_Styles_Frontend();
new Kirki_Selective_Refresh();
new Kirki();

// Include deprecated functions & methods.
include_once wp_normalize_path( dirname( __FILE__ ) . '/includes/deprecated.php' );

// Include the ariColor library.
include_once wp_normalize_path( dirname( __FILE__ ) . '/includes/lib/class-aricolor.php' );

//The editor fix
if( $pagenow == 'customize.php' )
{
	add_action( 'admin_enqueue_scripts', 'kirki_type_editor_fixer' );
}

function kirki_type_editor_fixer()
{
	wp_enqueue_style( 'kirki-type-editor-fix', plugins_url( 'assets/css/kirki-editor-fix.css', __FILE__ ) );
}

// Add an empty config for global fields.
Kirki::add_config( '' );

/**
 * Fires at the end of the update message container in each
 * row of the plugins list table.
 * Allows us to add important notices about updates should they be needed.
 *
 * @since 2.3.8
 * @param array $plugin_data An array of plugin metadata.
 * @param array $response    An array of metadata about the available plugin update.
 */
function kirki_show_upgrade_notification( $plugin_data, $response ) {

    // Check "upgrade_notice".
    if ( isset( $response->upgrade_notice ) && strlen( trim( $response->upgrade_notice ) ) > 0 ) : ?>
        <style>
        .kirki-upgrade-notification {
            background-color: #d54e21;
            padding: 10px;
            color: #f9f9f9;
            margin-top: 10px;
        }
        .kirki-upgrade-notification + p {
            display: none;
        }
        </style>
        <div class="kirki-upgrade-notification">
            <strong><?php esc_attr_e( 'Important Upgrade Notice:', 'kirki' ); ?></strong>
            <?php echo wp_strip_all_tags( $response->upgrade_notice ); ?>
        </div>
    <?php endif;
}
add_action( 'in_plugin_update_message-' . plugin_basename( __FILE__ ), 'kirki_show_upgrade_notification', 10, 2 );
