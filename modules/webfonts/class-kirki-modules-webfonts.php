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
	 * Which method to use when loading googlefonts.
	 * Available options: link, js, embed.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var string
	 */
	private static $method = array(
		'global' => 'embed',
	);

	/**
	 * Whether we should fallback to the link method or not.
	 *
	 * @access private
	 * @since 3.0.0
	 * @var bool
	 */
	private $fallback_to_link = false;

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
		$this->maybe_fallback_to_link();
		$this->init();

	}

	/**
	 * Init other objects depending on the method we'll be using.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function init() {

		foreach ( self::$method as $config_id => $config_method ) {

			$method = $this->get_method( $config_id );
			$method = 'embed';
			$classname = 'Kirki_Modules_Webfonts_' . ucfirst( $method );
			new $classname( $config_id, $this, $this->fonts_google );

		}
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

	/**
	 * Get the method we're going to use.
	 *
	 * @access public
	 * @since 3.0.0
	 * @return string
	 */
	public function get_method( $config_id ) {

		// Figure out which method to use.
		$method = apply_filters( "kirki/{$config_id}/googlefonts_load_method", 'link' );
		if ( 'embed' === $method && true !== $this->fallback_to_link ) {
			$method = 'embed';
		}
		// Force using the JS method while in the customizer.
		// This will help us work-out the live-previews for typography fields.
		if ( is_customize_preview() ) {
			$method = 'async';
		}
		return $method;
	}

	/**
	 * Should we fallback to link method?
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function maybe_fallback_to_link() {

		// Get the $fallback_to_link value from transient.
		$fallback_to_link = get_transient( 'kirki_googlefonts_fallback_to_link' );
		if ( 'yes' === $fallback_to_link ) {
			$this->fallback_to_link = true;
		}

		// Use links when in the customizer.
		global $wp_customize;
		if ( $wp_customize ) {
			$this->fallback_to_link = true;
		}
	}

	/**
	 * Goes through all our fields and then populates the $this->fonts property.
	 *
	 * @access public
	 */
	public function loop_fields() {
		foreach ( Kirki::$fields as $field ) {
			$this->fonts_google->generate_google_font( $field );
		}
	}
}
