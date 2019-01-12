<?php
/**
 * Writes compiled CSS to a file.
 *
 * @package     Kirki
 * @subpackage  CSS Module
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Handles writing CSS to a file.
 */
class Kirki_CSS_To_File {

	/**
	 * Fallback to inline CSS?
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var bool
	 */
	protected $fallback = false;

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {

		// If the file doesn't exist, create it.
		if ( ! file_exists( $this->get_path( 'file' ) ) ) {
			// If the file-write fails, fallback to inline
			// and cache the failure so we don't try again immediately.
			$this->write_file();
		}
		add_action( 'customize_save_after', array( $this, 'write_file' ) );
	}

	/**
	 * Gets the path of the CSS file and folder in the filesystem.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param string $context Can be "file" or "folder". If empty, returns both as array.
	 * @return string|array
	 */
	protected function get_path( $context = '' ) {

		$upload_dir = wp_upload_dir();

		$paths = array(
			'file'   => wp_normalize_path( $upload_dir['basedir'] . '/kirki-css/styles.css' ),
			'folder' => wp_normalize_path( $upload_dir['basedir'] . '/kirki-css' ),
		);

		if ( 'file' === $context ) {
			return $paths['file'];
		}
		if ( 'folder' === $context ) {
			return $paths['folder'];
		}
		return $paths;

	}

	/**
	 * Gets the URL of the CSS file in the filesystem.
	 *
	 * @access public
	 * @since 3.0.0
	 * @return string
	 */
	public function get_url() {

		$upload_dir = wp_upload_dir();
		return esc_url_raw( $upload_dir['baseurl'] . '/kirki-css/styles.css' );

	}

	/**
	 * Gets the timestamp of the file.
	 * This will be used as "version" for cache-busting purposes.
	 *
	 * @access public
	 * @since 3.0.0
	 * @return integer|false
	 */
	public function get_timestamp() {

		if ( file_exists( $this->get_path( 'file' ) ) ) {
			return filemtime( $this->get_path( 'file' ) );
		}
		return false;
	}

	/**
	 * Writes the file to disk.
	 *
	 * @access public
	 * @since 3.0.0
	 * @return bool
	 */
	public function write_file() {

		$css     = array();
		$configs = Kirki::$config;
		foreach ( $configs as $config_id => $args ) {
			// Get the CSS we want to write.
			$css[ $config_id ] = apply_filters( "kirki_{$config_id}_dynamic_css", Kirki_Modules_CSS::loop_controls( $config_id ) );
		}
		$css = implode( $css, '' );

		// If the folder doesn't exist, create it.
		if ( ! file_exists( $this->get_path( 'folder' ) ) ) {
			wp_mkdir_p( $this->get_path( 'folder' ) );
		}

		$filesystem = $this->get_filesystem();
		$write_file = (bool) $filesystem->put_contents( $this->get_path( 'file' ), $css );
		if ( ! $write_file ) {
			$this->fallback = true;
			set_transient( 'kirki_css_write_to_file_failed', true, HOUR_IN_SECONDS );
		}
		return $write_file;

	}

	/**
	 * Gets the WP_Filesystem object.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @return object
	 */
	protected function get_filesystem() {

		// The WordPress filesystem.
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		return $wp_filesystem;
	}
}
