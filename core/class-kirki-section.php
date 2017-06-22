<?php
/**
 * Handles sections created via the Kirki API.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Each section is a separate instrance of the Kirki_Section object.
 */
class Kirki_Section {

	/**
	 * An array of our section types.
	 *
	 * @access private
	 * @var array
	 */
	private $section_types = array();

	/**
	 * The object constructor.
	 *
	 * @access public
	 * @param array $args The section parameters.
	 */
	public function __construct( $args ) {

		$this->section_types = apply_filters( 'kirki/section_types', $this->section_types );
		$this->add_section( $args );

	}

	/**
	 * Adds the section using the WordPress Customizer API.
	 *
	 * @access public
	 * @param array $args The section parameters.
	 */
	public function add_section( $args ) {

		global $wp_customize;

		// The default class to be used when creating a section.
		$section_classname = 'WP_Customize_Section';

		if ( isset( $args['type'] ) && array_key_exists( $args['type'], $this->section_types ) ) {
			$section_classname = $this->section_types[ $args['type'] ];
		}

		// Add the section.
		$wp_customize->add_section( new $section_classname( $wp_customize, sanitize_key( $args['id'] ), $args ) );

	}
}
