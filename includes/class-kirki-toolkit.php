<?php
/**
 * The main Kirki object
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Toolkit' ) ) {
	final class Kirki_Toolkit {

		/**
		 * @static
		 * @access protected
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * @static
		 * @access protected
		 * @var string
		 */
		protected static $version = '2.2.4';

		/**
		 * Access the single instance of this class
		 *
		 * @static
		 * @access public
		 * @return Kirki_Toolkit
		 */
		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Return true if we are debugging Kirki
		 *
		 * @access public
		 * @return bool
		 */
		public static function is_debug() {
			return (bool) ( ( defined( 'KIRKI_DEBUG' ) && KIRKI_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) );
		}

		/**
		 * Take a path and return it clean
		 *
		 * @param string $path
		 * @return string
		 */
		public static function clean_file_path( $path ) {
			$path = wp_normalize_path( $path );
			return rtrim( $path, '/' );
		}

		/**
		 * Determine if we're on a parent theme
		 *
		 * @param $file string
		 * @return bool
		 */
		public static function is_parent_theme( $file ) {
			$file = self::clean_file_path( $file );
			$dir  = self::clean_file_path( get_template_directory() );
			return ( false !== strpos( $file, $dir ) );
		}

		/**
		 * Determine if we're on a child theme.
		 *
		 * @param $file string
		 * @return bool
		 */
		public static function is_child_theme( $file ) {
			$file = self::clean_file_path( $file );
			$dir  = self::clean_file_path( get_stylesheet_directory() );
			return ( false !== strpos( $file, $dir ) );
		}

		/**
		 * Determine if we're running as a plugin
		 */
		public static function is_plugin() {
			if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_stylesheet_directory() ) ) ) {
				return false;
			}
			if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_template_directory_uri() ) ) ) {
				return false;
			}
			return ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( WP_CONTENT_DIR . '/themes/' ) ) );
		}

		/**
		 * Determine if we're on a theme
		 *
		 * @param $file string
		 * @return bool
		 */
		public static function is_theme( $file ) {
			return ( true === self::is_child_theme( $file ) || true === self::is_parent_theme( $file ) );
		}

		/**
		 * Get the version
		 *
		 * @return string
		 */
		public static function get_version() {
			return self::$version;
		}

	}

}
