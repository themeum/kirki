<?php
/**
 * Helper methods for fonts.
 *
 * @package kirki-framework/module-webfonts
 * @author Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license https://opensource.org/licenses/MIT
 * @since 1.0.0
 */

namespace Kirki\Module\Webfonts;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The Helper object.
 *
 * @since 1.0.0
 */
final class Helper {

	/**
	 * Gets the remote URL contents.
	 *
	 * @static
	 * @access public
	 * @since 1.0.0
	 * @param string $url  The URL we want to get.
	 * @param array  $args An array of arguments for the wp_remote_retrieve_body() function.
	 * @return string      The contents of the remote URL.
	 */
	public static function get_remote_url_contents( $url, $args = [] ) {
		$response = wp_remote_get( $url, $args );
		if ( is_wp_error( $response ) ) {
			return [];
		}
		$html = wp_remote_retrieve_body( $response );
		if ( is_wp_error( $html ) ) {
			return;
		}
		return $html;
	}

	/**
	 * Gets the root fonts folder path and url.
	 * Other paths are built based on this.
	 *
	 * @static
	 *
	 * @param array $upload_dir wp_upload_dir()
	 *
	 * @return array Returns customized wp_upload_dir() array
	 * @see https://developer.wordpress.org/reference/functions/wp_upload_dir/
	 * @since 1.0.0
	 * @access public
	 */
	public static function kirki_fonts_dir( $upload_dir = [] ) {
		// Get the upload directory for this site iof not passed as param.
		$upload_dir = empty( $upload_dir ) ? wp_upload_dir() : $upload_dir;

		// The default fonts folder
		$append = '/fonts';

		// Overwrite path and url and allow customizations
		$upload_dir['path'] = apply_filters( 'kirki_googlefonts_root_path', $upload_dir['basedir'] . $append );
		$upload_dir['url']  = apply_filters( 'kirki_googlefonts_root_url', $upload_dir['baseurl'] . $append );

		// If the folder doesn't exist, create it.
		if ( ! file_exists( $upload_dir['path'] ) ) {
			wp_mkdir_p( $upload_dir['path'] );
		}

		return $upload_dir;
	}

	/**
	 * Downloads a font-file and saves it locally.
	 *
	 * @access public
	 * @since 1.0.0
	 * @param string $url The URL of the file we want to get.
	 * @return bool
	 */
	public static function download_font_file( $url ) {

		$saved_fonts = get_option( 'kirki_font_local_filenames', [] );
		if ( isset( $saved_fonts[ $url ] ) && file_exists( $saved_fonts[ $url ]['file'] ) ) {
			return str_replace(
				wp_normalize_path( untrailingslashit( WP_CONTENT_DIR ) ),
				untrailingslashit( content_url() ),
				$saved_fonts[ $url ]['file']
			);
		}

		// Gives us access to the download_url() and wp_handle_sideload() functions.
		require_once ABSPATH . 'wp-admin/includes/file.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

		$timeout_seconds = 5;

		// Download file to temp dir.
		$temp_file = download_url( $url, $timeout_seconds );

		if ( is_wp_error( $temp_file ) ) {
			return false;
		}

		// Array based on $_FILE as seen in PHP file uploads.
		$file = [
			'name'     => basename( $url ),
			'type'     => 'font/woff',
			'tmp_name' => $temp_file,
			'error'    => 0,
			'size'     => filesize( $temp_file ),
		];

		$overrides = [
			'test_type' => false,
			'test_form' => false,
			'test_size' => true,
		];

		// Move the temporary file into the fonts uploads directory.
		add_filter( 'upload_dir', [ __CLASS__, 'kirki_fonts_dir' ] );
			$results = wp_handle_sideload( $file, $overrides );
		remove_filter( 'upload_dir', [ __CLASS__, 'kirki_fonts_dir' ] );

		if ( empty( $results['error'] ) ) {
			$saved_fonts[ $url ] = $results;
			update_option( 'kirki_font_local_filenames', $saved_fonts );
			return $results['url'];
		}
		return false;
	}

	/**
	 * Gets the root folder path.
	 * This is left for backward compatibility.
	 *
	 *
	 * @static
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public static function get_root_path() {
		return self::kirki_fonts_dir()['path'];
	}

	/**
	 * Gets the root folder url.
	 * This is left for backward compatibility.
	 *
	 *
	 * @static
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public static function get_root_url() {
		return self::kirki_fonts_dir()['url'];
	}
}
