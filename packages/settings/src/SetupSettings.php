<?php
/**
 * Class to setup Kirki's admin page.
 *
 * @package Kirki
 */

namespace Kirki\Settings;

use WP_Filesystem_Direct;

/**
 * Class to setup Kirki's admin page.
 */
class SetupSettings {

	/**
	 * Setting up hooks.
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'submenu_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );

		add_action( 'wp_ajax_kirki_clear_font_cache', array( $this, 'clear_font_cache' ) );

		new Notice();

	}

	/**
	 * Add submenu page.
	 */
	public function submenu_page() {

		add_submenu_page(
			'options-general.php',
			__( 'Kirki Customizer Framework', 'kirki' ),
			__( 'Kirki', 'kirki' ),
			apply_filters( 'kirki_settings_capability', 'manage_options' ),
			'kirki_settings',
			array( $this, 'submenu_page_content' )
		);

	}

	/**
	 * Submenu page content.
	 */
	public function submenu_page_content() {

		$template = require KIRKI_PLUGIN_DIR . '/packages/settings/templates/settings-template.php';
		$template();

	}

	/**
	 * Check if we're on the Kirki settings page.
	 *
	 * @return bool
	 */
	public function is_settings_page() {
		$current_screen = get_current_screen();

		return ( 'settings_page_kirki_settings' === $current_screen->id ? true : false );
	}

	/**
	 * Enqueue admin styles.
	 */
	public function admin_styles() {

		if ( ! $this->is_settings_page() ) {
			return;
		}

		wp_enqueue_style( 'heatbox', KIRKI_PLUGIN_URL . '/packages/settings/dist/heatbox.css', array(), KIRKI_VERSION );
		wp_enqueue_style( 'kirki-settings', KIRKI_PLUGIN_URL . '/packages/settings/dist/settings.css', array(), KIRKI_VERSION );

	}

	/**
	 * Enqueue admin scripts.
	 */
	public function admin_scripts() {

		if ( ! $this->is_settings_page() ) {
			return;
		}

		wp_enqueue_script( 'kirki-settings', KIRKI_PLUGIN_URL . '/packages/settings/dist/settings.js', array( 'jquery', 'wp-polyfill' ), KIRKI_VERSION, true );

		wp_localize_script(
			'kirki-settings',
			'kirkiSettings',
			array()
		);

	}

	/**
	 * Admin body class.
	 *
	 * @param string $classes The existing body classes.
	 * @return string The body classes.
	 */
	public function admin_body_class( $classes ) {

		if ( ! $this->is_settings_page() ) {
			return $classes;
		}

		$classes .= ' heatbox-admin has-header';

		return $classes;

	}

	/**
	 * Clear font cache directory.
	 */
	public function clear_font_cache() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'Kirki_Clear_Font_Cache' ) ) {
			wp_send_json_error( 'Invalid nonce' );
		}

		$capability = apply_filters( 'kirki_settings_capability', 'manage_options' );

		if ( ! current_user_can( $capability ) ) {
			wp_send_json_error( "You don't have capability to run this action" );
		}

		include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
		include_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

		$file_system = new WP_Filesystem_Direct( false );
		$fonts_dir   = WP_CONTENT_DIR . '/fonts';

		if ( is_dir( $fonts_dir ) ) {
			// Delete fonts directory.
			$file_system->rmdir( $fonts_dir, true );
		} else {
			wp_send_json_error( 'No local fonts found.', 'kirki' );
		}

		wp_send_json_success( 'Font cache cleared.', 'kirki' );

	}

}
