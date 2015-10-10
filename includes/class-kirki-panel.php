<?php

class Kirki_Panel extends Kirki_Customizer {

	public function __construct( $args ) {

		parent::__construct( $args );
		$this->add_panel( $args );

	}

	public function add_panel( $args ) {

		$this->wp_customize->add_panel( sanitize_key( $args['id'] ), array(
			'title'           => esc_textarea( $args['title'] ),
			'priority'        => esc_attr( $args['priority'] ),
			'description'     => esc_textarea( $args['description'] ),
			'active_callback' => $args['active_callback'],
		) );

		if ( isset( $args['icon'] ) ) {
			$args['context'] = 'panel';
			Kirki_Customizer_Scripts_Icons::generate_script( $args );
		}

	}

}
