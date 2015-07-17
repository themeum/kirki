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

class Kirki_Toolkit {

	/** @var Kirki The only instance of this class */
	public static $instance = null;

	public static $version = '1.0.2';

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
			'background-color'      => __( 'Background Color', 'kirki' ),
			'background-image'      => __( 'Background Image', 'kirki' ),
			'no-repeat'             => __( 'No Repeat', 'kirki' ),
			'repeat-all'            => __( 'Repeat All', 'kirki' ),
			'repeat-x'              => __( 'Repeat Horizontally', 'kirki' ),
			'repeat-y'              => __( 'Repeat Vertically', 'kirki' ),
			'inherit'               => __( 'Inherit', 'kirki' ),
			'background-repeat'     => __( 'Background Repeat', 'kirki' ),
			'cover'                 => __( 'Cover', 'kirki' ),
			'contain'               => __( 'Contain', 'kirki' ),
			'background-size'       => __( 'Background Size', 'kirki' ),
			'fixed'                 => __( 'Fixed', 'kirki' ),
			'scroll'                => __( 'Scroll', 'kirki' ),
			'background-attachment' => __( 'Background Attachment', 'kirki' ),
			'left-top'              => __( 'Left Top', 'kirki' ),
			'left-center'           => __( 'Left Center', 'kirki' ),
			'left-bottom'           => __( 'Left Bottom', 'kirki' ),
			'right-top'             => __( 'Right Top', 'kirki' ),
			'right-center'          => __( 'Right Center', 'kirki' ),
			'right-bottom'          => __( 'Right Bottom', 'kirki' ),
			'center-top'            => __( 'Center Top', 'kirki' ),
			'center-center'         => __( 'Center Center', 'kirki' ),
			'center-bottom'         => __( 'Center Bottom', 'kirki' ),
			'background-position'   => __( 'Background Position', 'kirki' ),
			'background-opacity'    => __( 'Background Opacity', 'kirki' ),
			'ON'                    => __( 'ON', 'kirki' ),
			'OFF'                   => __( 'OFF', 'kirki' ),
			'all'                   => __( 'All', 'kirki' ),
			'cyrillic'              => __( 'Cyrillic', 'kirki' ),
			'cyrillic-ext'          => __( 'Cyrillic Extended', 'kirki' ),
			'devanagari'            => __( 'Devanagari', 'kirki' ),
			'greek'                 => __( 'Greek', 'kirki' ),
			'greek-ext'             => __( 'Greek Extended', 'kirki' ),
			'khmer'                 => __( 'Khmer', 'kirki' ),
			'latin'                 => __( 'Latin', 'kirki' ),
			'latin-ext'             => __( 'Latin Extended', 'kirki' ),
			'vietnamese'            => __( 'Vietnamese', 'kirki' ),
			'serif'                 => _x( 'Serif', 'font style', 'kirki' ),
			'sans-serif'            => _x( 'Sans Serif', 'font style', 'kirki' ),
			'monospace'             => _x( 'Monospace', 'font style', 'kirki' ),
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

}
