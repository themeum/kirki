<?php
/**
 * The main Kirki object
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

// Early exit if the class already exists
if ( class_exists( 'Kirki_Toolkit' ) ) {
	return;
}

final class Kirki_Toolkit {

	/** @var Kirki The only instance of this class */
	public static $instance = null;

	public static $version = '2.0.5';

	public $font_registry = null;
	public $scripts       = null;
	public $api           = null;
	public $styles        = array();

	/**
	 * Access the single instance of this class
	 * @return Kirki
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new Kirki_Toolkit();
		}
		return self::$instance;
	}

	/**
	 * Shortcut method to get the translation strings
	 */
	public static function i18n() {

		$i18n = array(
			'background-color'      => esc_attr__( 'Background Color', 'kirki' ),
			'background-image'      => esc_attr__( 'Background Image', 'kirki' ),
			'no-repeat'             => esc_attr__( 'No Repeat', 'kirki' ),
			'repeat-all'            => esc_attr__( 'Repeat All', 'kirki' ),
			'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'kirki' ),
			'repeat-y'              => esc_attr__( 'Repeat Vertically', 'kirki' ),
			'inherit'               => esc_attr__( 'Inherit', 'kirki' ),
			'background-repeat'     => esc_attr__( 'Background Repeat', 'kirki' ),
			'cover'                 => esc_attr__( 'Cover', 'kirki' ),
			'contain'               => esc_attr__( 'Contain', 'kirki' ),
			'background-size'       => esc_attr__( 'Background Size', 'kirki' ),
			'fixed'                 => esc_attr__( 'Fixed', 'kirki' ),
			'scroll'                => esc_attr__( 'Scroll', 'kirki' ),
			'background-attachment' => esc_attr__( 'Background Attachment', 'kirki' ),
			'left-top'              => esc_attr__( 'Left Top', 'kirki' ),
			'left-center'           => esc_attr__( 'Left Center', 'kirki' ),
			'left-bottom'           => esc_attr__( 'Left Bottom', 'kirki' ),
			'right-top'             => esc_attr__( 'Right Top', 'kirki' ),
			'right-center'          => esc_attr__( 'Right Center', 'kirki' ),
			'right-bottom'          => esc_attr__( 'Right Bottom', 'kirki' ),
			'center-top'            => esc_attr__( 'Center Top', 'kirki' ),
			'center-center'         => esc_attr__( 'Center Center', 'kirki' ),
			'center-bottom'         => esc_attr__( 'Center Bottom', 'kirki' ),
			'background-position'   => esc_attr__( 'Background Position', 'kirki' ),
			'background-opacity'    => esc_attr__( 'Background Opacity', 'kirki' ),
			'on'                    => esc_attr__( 'ON', 'kirki' ),
			'off'                   => esc_attr__( 'OFF', 'kirki' ),
			'all'                   => esc_attr__( 'All', 'kirki' ),
			'cyrillic'              => esc_attr__( 'Cyrillic', 'kirki' ),
			'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'kirki' ),
			'devanagari'            => esc_attr__( 'Devanagari', 'kirki' ),
			'greek'                 => esc_attr__( 'Greek', 'kirki' ),
			'greek-ext'             => esc_attr__( 'Greek Extended', 'kirki' ),
			'khmer'                 => esc_attr__( 'Khmer', 'kirki' ),
			'latin'                 => esc_attr__( 'Latin', 'kirki' ),
			'latin-ext'             => esc_attr__( 'Latin Extended', 'kirki' ),
			'vietnamese'            => esc_attr__( 'Vietnamese', 'kirki' ),
			'hebrew'                => esc_attr__( 'Hebrew', 'kirki' ),
			'arabic'                => esc_attr__( 'Arabic', 'kirki' ),
			'bengali'               => esc_attr__( 'Bengali', 'kirki' ),
			'gujarati'              => esc_attr__( 'Gujarati', 'kirki' ),
			'tamil'                 => esc_attr__( 'Tamil', 'kirki' ),
			'telugu'                => esc_attr__( 'Telugu', 'kirki' ),
			'thai'                  => esc_attr__( 'Thai', 'kirki' ),
			'serif'                 => _x( 'Serif', 'font style', 'kirki' ),
			'sans-serif'            => _x( 'Sans Serif', 'font style', 'kirki' ),
			'monospace'             => _x( 'Monospace', 'font style', 'kirki' ),
			'font-family'           => esc_attr__( 'Font Family', 'Kirki' ),
			'font-size'             => esc_attr__( 'Font Size', 'Kirki' ),
			'font-weight'           => esc_attr__( 'Font Weight', 'Kirki' ),
			'line-height'           => esc_attr__( 'Line Height', 'Kirki' ),
			'letter-spacing'        => esc_attr__( 'Letter Spacing', 'Kirki' ),
			'top'                   => esc_attr__( 'Top', 'kirki' ),
			'bottom'                => esc_attr__( 'Bottom', 'kirki' ),
			'left'                  => esc_attr__( 'Left', 'kirki' ),
			'right'                 => esc_attr__( 'Right', 'kirki' ),
		);

		$config = apply_filters( 'kirki/config', array() );

		if ( isset( $config['i18n'] ) ) {
			$i18n = wp_parse_args( $config['i18n'], $i18n );
		}

		return $i18n;

	}

	/**
	 * Shortcut method to get the font registry.
	 */
	public static function fonts() {
		return self::get_instance()->font_registry;
	}

	/**
	 * Constructor is private, should only be called by get_instance()
	 */
	private function __construct() {
	}

	/**
	 * Return true if we are debugging Kirki.
	 */
	public static function kirki_debug() {
		return (bool) ( defined( 'KIRKI_DEBUG' ) && KIRKI_DEBUG );
	}

    /**
     * Take a path and return it clean
     *
     * @param string $path
	 * @return string
     */
    public static function clean_file_path( $path ) {
        $path = str_replace( '', '', str_replace( array( "\\", "\\\\" ), '/', $path ) );
        if ( '/' === $path[ strlen( $path ) - 1 ] ) {
            $path = rtrim( $path, '/' );
        }
        return $path;
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
		$file = str_replace( '//', '/', $file );
		$dir  = str_replace( '//', '/', $dir );
		if ( false !== strpos( $file, $dir ) ) {
			return true;
		}
		return false;
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
		$file = str_replace( '//', '/', $file );
		$dir  = str_replace( '//', '/', $dir );
		if ( false !== strpos( $file, $dir ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Determine if we're running as a plugin
	 */
	private static function is_plugin() {
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_stylesheet_directory() ) ) ) {
			return false;
		}
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( get_template_directory_uri() ) ) ) {
			return false;
		}
		if ( false !== strpos( self::clean_file_path( __FILE__ ), self::clean_file_path( WP_CONTENT_DIR . '/themes/' ) ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Determine if we're on a theme
	 *
	 * @param $file string
	 * @return bool
	 */
	public static function is_theme( $file ) {
		if ( true == self::is_child_theme( $file ) || true == self::is_parent_theme( $file ) ) {
			return true;
		}
		return false;
	}
}
