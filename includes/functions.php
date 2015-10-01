<?php
/**
 * Helper functions
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'kirki_path' ) ) {
	/**
	 * Returns the absolute path to the plugin.
	 * @return string
	 */
	function kirki_path() {
		return KIRKI_PATH;
	}
}

if ( ! function_exists( 'kirki_url' ) ) {
	/**
	 * Returns the URL of the plugin.
	 * @return string
	 */
	function kirki_url() {
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $config['url_path'] ) ) {
			return esc_url_raw( $config['url_path'] );
		} else {
			return KIRKI_URL;
		}
	}
}
