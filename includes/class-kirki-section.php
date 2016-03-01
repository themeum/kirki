<?php

if ( ! class_exists( 'Kirki_Section' ) ) {
	class Kirki_Section extends Kirki_Customizer {

		public function __construct( $args ) {

			parent::__construct( $args );
			$this->add_section( $args );

		}

		public function add_section( $args ) {

			if ( isset( $args['type'] ) && 'expanded' == $args['type'] ) {
				$this->wp_customize->add_section( new Kirki_Sections_Expanded_Section( $this->wp_customize, sanitize_key( $args['id'] ), array(
					'title'           => $args['title'], // already escaped in WP Core
					'priority'        => absint( $args['priority'] ),
					'panel'           => sanitize_key( $args['panel'] ),
					'description'     => $args['description'], // already escaped in WP Core
					'active_callback' => $args['active_callback'],
				) ) );
			} else {
				$this->wp_customize->add_section( sanitize_key( $args['id'] ), array(
					'title'           => $args['title'], // already escaped in WP Core
					'priority'        => absint( $args['priority'] ),
					'panel'           => sanitize_key( $args['panel'] ),
					'description'     => $args['description'], // already escaped in WP Core
					'active_callback' => $args['active_callback'],
				) );
			}

			if ( isset( $args['icon'] ) ) {
				$args['context'] = 'section';
				Kirki_Customizer_Scripts_Icons::generate_script( $args );
			}

		}

	}
}
