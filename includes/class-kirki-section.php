<?php

class Kirki_Section extends Kirki_Customizer {

	public function __construct( $args ) {

		parent::__construct( $args );
		$this->add_section( $args );

	}

	public function add_section( $args ) {

		$this->wp_customize->add_section( sanitize_key( $args['id'] ), array(
			'title'           => esc_textarea( $args['title'] ),
			'priority'        => esc_attr( $args['priority'] ),
			'panel'           => esc_attr( $args['panel'] ),
			'description'     => esc_textarea( $args['description'] ),
			'active_callback' => $args['active_callback'],
		) );

		if ( isset( $args['icon'] ) ) {
			$args['context'] = 'section';
			Kirki_Customizer_Scripts_Icons::generate_script( $args );
		}

	}

}
