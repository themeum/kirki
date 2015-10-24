<?php

class Kirki_Panel extends Kirki_Customizer {

	/**
	 * The class constructor
	 *
	 * @var $args    the panel arguments
	 */
	public function __construct( $args ) {

		parent::__construct( $args );
		$this->add_panel( $args );

	}

	/**
	 * Add the panel using the Customizer API
	 *
	 * @var $args    the panel arguments
	 */
	public function add_panel( $args ) {

		// Add the panel using the customizer API
		$this->wp_customize->add_panel( sanitize_key( $args['id'] ), array(
			'title'           => esc_textarea( $args['title'] ),
			'priority'        => esc_attr( $args['priority'] ),
			'description'     => esc_textarea( $args['description'] ),
			'active_callback' => $args['active_callback'],
		) );

		// If we've got an icon then call the object to create its script.
		if ( isset( $args['icon'] ) ) {
			$args['context'] = 'panel';
			Kirki_Customizer_Scripts_Icons::generate_script( $args );
		}

	}

}
