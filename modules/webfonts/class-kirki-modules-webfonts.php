<?php
/**
 * Handles webfonts.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds script for tooltips.
 */
class Kirki_Modules_Webfonts {

	/**
	 * The Kirki_Fonts_Google object.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var object
	 */
	protected $fonts_google;


	/**
	 * The class constructor
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {

		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts.php' );
		include_once wp_normalize_path( dirname( __FILE__ ) . '/class-kirki-fonts-google.php' );

		$this->fonts_google = Kirki_Fonts_Google::get_instance();

	}

	/**
	 * Parses fields and if any tooltips are found, they are added to the
	 * object's $tooltips_content property.
	 *
	 * @access private
	 * @since 3.0.0
	 */
	private function parse_fields() {

		$fields = Kirki::$fields;
		foreach ( $fields as $field ) {
		}
	}
}
