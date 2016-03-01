<?php

if ( ! class_exists( 'Kirki_Panel' ) ) {
	class Kirki_Panel extends Kirki_Customizer {

		/**
		 * An array of our panel types
		 */
		private $panel_types = array(
			'default'  => 'Kirki_Panels_Default_Panel',
			'expanded' => 'Kirki_Panels_Expanded_Panel',
		);

		/**
		 * The class constructor
		 *
		 * @var $args    the panel arguments
		 */
		public function __construct( $args ) {

			$this->panel_types = apply_filters( 'kirki/panel_types', $this->panel_types );

			parent::__construct( $args );
			$this->add_panel( $args );

		}

		/**
		 * Add the panel using the Customizer API
		 *
		 * @var $args    the panel arguments
		 */
		public function add_panel( $args ) {

			if ( ! isset( $args['type'] ) || ! array_key_exists( $args['type'], $this->panel_types ) ) {
				$args['type'] = 'default';
			}
			$panel_classname = $this->panel_types[ $args['type'] ];

			$this->wp_customize->add_panel( new $panel_classname( $this->wp_customize, sanitize_key( $args['id'] ), array(
				'title'           => $args['title'], // already escaped in WP Core
				'priority'        => absint( $args['priority'] ),
				'description'     => $args['description'], // already escaped in WP Core
				'active_callback' => $args['active_callback'],
			) ) );

			// If we've got an icon then call the object to create its script.
			if ( isset( $args['icon'] ) ) {
				$args['context'] = 'panel';
				Kirki_Customizer_Scripts_Icons::generate_script( $args );
			}

		}

	}
}
