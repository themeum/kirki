<?php
/**
 * Telemetry implementation for Kirki.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.34
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Telemetry implementation.
 */
final class Kirki_Telemetry {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.34
	 */
	public function __construct() {

		// Early exit if telemetry is disabled.
		if ( ! apply_filters( 'kirki_telemetry', true ) ) {
			return;
		}
	}

	/**
	 * Maybe send data.
	 *
	 * @access public
	 * @since 3.0.34
	 * @return void
	 */
	public function maybe_send_data() {

		// Check if the user has consented to the data sending.
		$optin = get_option( 'kirki_telemetry_optin' );
		if ( ! $optin ) {
			return;
		}

		$sent = get_site_transient( 'kirki_telemetry_sent' );
		if ( ! $sent ) {
			$this->send_data();
			set_site_transient( 'kirki_telemetry_sent', time(), WEEK_IN_SECONDS );
		}
	}

	/**
	 * Sends data.
	 *
	 * @access private
	 * @since 3.0.34
	 * @return void
	 */
	private function send_data() {

		// The data.
		$data = array_merge(
			array(
				'action' => 'kirki-stats',
			),
			$this->get_data()
		);

		// Build the URL with the arguments.
		$url = add_query_arg( $data, 'https://wpmu.io/?action=kirki-stats' );

		// Ping remote server.
		wp_remote_get( $url );
	}

	/**
	 * Builds and returns the data or uses cached if data already exists.
	 *
	 * @access private
	 * @since 3.0.34
	 * @return array
	 */
	private function get_data() {
		// Get the theme.
		$theme = wp_get_theme();

		// Build data and return the array.
		return array(
			'phpver'       => PHP_VERSION,
			'siteID'       => md5( home_url() ),
			'themeName'    => $theme->get( 'Name' ),
			'themeAuthor'  => $theme->get( 'Author' ),
			'themeURI'     => $theme->get( 'ThemeURI' ),
			'themeVersion' => $theme->get( 'Version' ),
		);
	}
}
