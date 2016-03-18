<?php

if ( ! class_exists( 'Kirki_Section' ) ) {
	class Kirki_Section extends Kirki_Customizer {

		/**
		 * An array of our section types
		 */
		private $section_types = array(
			'default'  => 'Kirki_Sections_Default_Section',
			'expanded' => 'Kirki_Sections_Expanded_Section',
			'hover'    => 'Kirki_Sections_Hover_Section'
		);

		public function __construct( $args ) {

			$this->section_types = apply_filters( 'kirki/section_types', $this->section_types );

			parent::__construct( $args );
			$this->add_section( $args );

		}

		public function add_section( $args ) {

			if ( ! isset( $args['type'] ) || ! array_key_exists( $args['type'], $this->section_types ) ) {
				$args['type'] = 'default';
			}
			$section_classname = $this->section_types[ $args['type'] ];

			$this->wp_customize->add_section( new $section_classname( $this->wp_customize, sanitize_key( $args['id'] ), array(
				'title'           => $args['title'], // already escaped in WP Core
				'priority'        => absint( $args['priority'] ),
				'panel'           => sanitize_key( $args['panel'] ),
				'description'     => $args['description'], // already escaped in WP Core
				'active_callback' => $args['active_callback'],
			) ) );

			if ( isset( $args['icon'] ) ) {
				$args['context'] = 'section';
				Kirki_Customizer_Scripts_Icons::generate_script( $args );
			}

		}

	}
}
