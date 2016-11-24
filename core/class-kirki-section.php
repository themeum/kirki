<?php
/**
 * Handles sections created via the Kirki API.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_Section' ) ) {

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
		private $section_types = array(
			'kirki-default'  => 'Kirki_Sections_Default_Section',
			'kirki-expanded' => 'Kirki_Sections_Expanded_Section',
			'kirki-hover'    => 'Kirki_Sections_Hover_Section',
		);

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

			if ( ! isset( $args['type'] ) || ! array_key_exists( $args['type'], $this->section_types ) ) {
				$args['type'] = 'kirki-default';
			}
			$section_classname = $this->section_types[ $args['type'] ];

			if ( isset( $args['icon'] ) && ! empty( $args['icon'] ) ) {
				$args['title'] = '<span class="dashicons ' . esc_attr( $args['icon'] ) . '"></span> ' . esc_html( $args['title'] );
			}

			// Add the section.
			$wp_customize->add_section( new $section_classname( $wp_customize, sanitize_key( $args['id'] ), $args ) );

		}
	}
}
