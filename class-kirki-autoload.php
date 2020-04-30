<?php
/**
 * The Kirki autoloader.
 * Handles locating and loading other class-files.
 *
 * @package     Kirki
 * @category    Core
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Autoloader class.
 *
 * @since 3.0.10
 */
class Kirki_Autoload {

	/**
	 * Cached paths.
	 *
	 * @access private
	 * @since 3.0.10
	 * @var array
	 */
	private $cached_paths = array();

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since 3.0.10
	 */
	public function __construct() {

		spl_autoload_register( array( $this, 'autoload' ) );
	}

	/**
	 * The Kirki class autoloader.
	 * Finds the path to a class that we're requiring and includes the file.
	 *
	 * @access protected
	 * @since 3.0.10
	 * @param string $class_name The name of the class we're trying to load.
	 */
	protected function autoload( $class_name ) {

		// Not a Kirki file, early exit.
		if ( 0 !== stripos( $class_name, 'Kirki' ) ) {
			return;
		}

		// Check if we've got it cached and ready.
		if ( isset( $this->cached_paths[ $class_name ] ) && file_exists( $this->cached_paths[ $class_name ] ) ) {
			include_once $this->cached_paths[ $class_name ]; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
			return;
		}

		$paths = $this->get_paths( $class_name );

		foreach ( $paths as $path ) {
			$path = wp_normalize_path( $path );
			if ( file_exists( $path ) ) {
				$this->cached_paths[ $class_name ] = $path;
				include_once $path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
				return;
			}
		}
	}

	/**
	 * Get an array of possible paths for the file.
	 *
	 * @access protected
	 * @since 3.0.10
	 * @param string $class_name The name of the class we're trying to load.
	 * @return array
	 */
	protected function get_paths( $class_name ) {

		$paths = array();
		// Build the filename.
		$filename = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';

		// Break class-name is parts.
		$name_parts = explode( '_', str_replace( 'Kirki_', '', $class_name ) );

		// Handle modules loading.
		if ( isset( $name_parts[0] ) && 'Modules' === $name_parts[0] ) {
			$path    = dirname( __FILE__ ) . '/modules/';
			$path   .= strtolower( str_replace( '_', '-', str_replace( 'Kirki_Modules_', '', $class_name ) ) ) . '/';
			$paths[] = $path . $filename;
		} elseif ( 'Kirki_Fonts' === $class_name ) {
			$paths[] = dirname( __FILE__ ) . '/modules/webfonts/class-kirki-fonts.php';
		}

		if ( isset( $name_parts[0] ) ) {

			// Handle controls loading.
			if ( 'Control' === $name_parts[0] || 'Settings' === $name_parts[0] ) {
				$path    = dirname( __FILE__ ) . '/controls/php/';
				$paths[] = $path . $filename;
			}
		}

		$paths[] = dirname( __FILE__ ) . '/core/' . $filename;
		$paths[] = dirname( __FILE__ ) . '/lib/' . $filename;

		$substr   = str_replace( 'Kirki_', '', $class_name );
		$exploded = explode( '_', $substr );
		$levels   = count( $exploded );

		$previous_path = '';
		for ( $i = 0; $i < $levels; $i++ ) {
			$paths[]        = dirname( __FILE__ ) . '/' . $previous_path . strtolower( $exploded[ $i ] ) . '/' . $filename;
			$previous_path .= strtolower( $exploded[ $i ] ) . '/';
		}
		return $paths;
	}
}
