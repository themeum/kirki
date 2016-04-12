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
			'default'  => 'Kirki_Sections_Default_Section',
			'expanded' => 'Kirki_Sections_Expanded_Section',
			'hover'    => 'Kirki_Sections_Hover_Section',
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
				$args['type'] = 'default';
			}
			$section_classname = $this->section_types[ $args['type'] ];

			$wp_customize->add_section( new $section_classname( $wp_customize, sanitize_key( $args['id'] ), array(
				'title'           => $args['title'], // Already escaped in WP Core.
				'priority'        => absint( $args['priority'] ),
				'panel'           => sanitize_key( $args['panel'] ),
				'description'     => $args['description'], // Already escaped in WP Core.
				'active_callback' => $args['active_callback'],
			) ) );

			if ( isset( $args['icon'] ) ) {
				$args['context'] = 'section';
				Kirki_Scripts_Icons::generate_script( $args );
			}
		}
	}
}
