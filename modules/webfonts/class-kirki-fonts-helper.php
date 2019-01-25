<?php
/**
 * Helper methods for fonts.
 *
 * @package    Kirki
 * @category   Core
 * @author     Aristeides Stathopoulos
 * @copyright  Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since      3.0.36
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The Kirki_Fonts object.
 *
 * @since 3.0.28
 */
final class Kirki_Fonts_Helper {

	/**
	 * Gets the remote URL contents.
	 *
	 * @static
	 * @access public
	 * @since 3.0.36
	 * @param string $url  The URL we want to get.
	 * @param array  $args An array of arguments for the wp_remote_retrieve_body() function.
	 * @return string      The contents of the remote URL.
	 */
	public static function get_remote_url_contents( $url, $args = array() ) {
		$response = wp_remote_get( $url, $args );
		if ( is_wp_error( $response ) ) {
			return array();
		}
		$html = wp_remote_retrieve_body( $response );
		if ( is_wp_error( $html ) ) {
			return;
		}
		return $html;
	}

	/**
	 * Gets the root fonts folder path.
	 * Other paths are built based on this.
	 *
	 * @static
	 * @since 3.0.36
	 * @access public
	 * @return string
	 */
	public static function get_root_path() {

		// Get the upload directory for this site.
		$upload_dir = wp_upload_dir();
		$path       = untrailingslashit( wp_normalize_path( $upload_dir['basedir'] ) ) . '/webfonts';

		// If the folder doesn't exist, create it.
		if ( ! file_exists( $path ) ) {
			wp_mkdir_p( $path );
		}

		// Return the path.
		return apply_filters( 'kirki_googlefonts_root_path', $path );
	}

	/**
	 * Gets the filename by breaking-down the URL parts.
	 *
	 * @static
	 * @access private
	 * @since 3.0.28
	 * @param string $url The URL.
	 * @return string     The filename.
	 */
	private static function get_filename_from_url( $url ) {
		$url_parts   = explode( '/', $url );
		$parts_count = count( $url_parts );
		if ( 1 < $parts_count ) {
			return $url_parts[ count( $url_parts ) - 1 ];
		}
		return $url;
	}

	/**
	 * Downloads a font-file and saves it locally.
	 *
	 * @access public
	 * @since 3.0.28
	 * @param string $url The URL of the file we want to get.
	 * @return bool
	 */
	public static function download_font_file( $url ) {

		// Get the remote file.
		$contents = self::get_remote_url_contents( $url );

		// Build the folder path.
		$folder_path = self::get_root_path();

		// The filename.
		$filename = self::get_filename_from_url( $url );

		// Build the file path.
		$path = $folder_path . '/' . $filename;

		// If the folder doesn't exist, create it.
		if ( ! file_exists( $folder_path ) ) {
			wp_mkdir_p( $folder_path );
		}

		// If the file exists there's no reason to do anything.
		if ( file_exists( $path ) ) {
			return self::get_root_url() . '/' . $filename;
		}

		// Write file.
		if ( Kirki_Helper::init_filesystem()->put_contents( $path, $contents, FS_CHMOD_FILE ) ) {
			return self::get_root_url() . '/' . $filename;
		}
		return false;
	}

	/**
	 * Gets the root folder url.
	 * Other urls are built based on this.
	 *
	 * @static
	 * @since 3.0.36
	 * @access public
	 * @return string
	 */
	public static function get_root_url() {

		// Get the upload directory for this site.
		$upload_dir = wp_upload_dir();

		// The URL.
		$url = trailingslashit( $upload_dir['baseurl'] );

		// Take care of domain mapping.
		// When using domain mapping we have to make sure that the URL to the file
		// does not include the original domain but instead the mapped domain.
		if ( defined( 'DOMAIN_MAPPING' ) && DOMAIN_MAPPING ) {
			if ( function_exists( 'domain_mapping_siteurl' ) && function_exists( 'get_original_url' ) ) {
				$mapped_domain   = domain_mapping_siteurl( false );
				$original_domain = get_original_url( 'siteurl' );
				$url             = str_replace( $original_domain, $mapped_domain, $url );
			}
		}
		$url = str_replace( array( 'https://', 'http://' ), '//', $url );
		return apply_filters( 'kirki_googlefonts_root_url', untrailingslashit( esc_url_raw( $url ) ) . '/webfonts' );
	}
}
