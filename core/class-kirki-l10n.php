<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Handles translations
 */
class Kirki_L10n {

	/**
	 * The plugin textdomain
	 *
	 * @access protected
	 * @var string
	 */
	protected $textdomain = 'kirki';

	/**
	 * The class constructor.
	 * Adds actions & filters to handle the rest of the methods.
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

	}

	/**
	 * Load the plugin textdomain
	 *
	 * @access public
	 */
	public function load_textdomain() {

		if ( null !== $this->get_path() ) {
			load_textdomain( $this->textdomain, $this->get_path() );
		}
		load_plugin_textdomain( $this->textdomain, false, Kirki::$path . '/languages' );

	}

	/**
	 * Gets the path to a translation file.
	 *
	 * @access protected
	 * @return string Absolute path to the translation file.
	 */
	protected function get_path() {
		$path_found = false;
		$found_path = null;
		foreach ( $this->get_paths() as $path ) {
			if ( $path_found ) {
				continue;
			}
			$path = wp_normalize_path( $path );
			if ( file_exists( $path ) ) {
				$path_found = true;
				$found_path = $path;
			}
		}

		return $found_path;

	}

	/**
	 * Returns an array of paths where translation files may be located.
	 *
	 * @access protected
	 * @return array
	 */
	protected function get_paths() {

		return array(
			WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
			Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
		);

	}
}
