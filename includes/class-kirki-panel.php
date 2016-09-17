<?php
/**
 * Handles panels added via the Kirki API.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_Panel' ) ) {

	/**
	 * Each panel is a separate instance of the Kirki_Panel object.
	 */
	class Kirki_Panel {

		/**
		 * An array of our panel types.
		 *
		 * @access private
		 * @var array
		 */
		private $panel_types = array(
			'kirki-default'  => 'Kirki_Panels_Default_Panel',
			'kirki-expanded' => 'Kirki_Panels_Expanded_Panel',
		);

		/**
		 * The class constructor.
		 *
		 * @access public
		 * @param array $args The panel arguments.
		 */
		public function __construct( $args ) {

			$this->panel_types = apply_filters( 'kirki/panel_types', $this->panel_types );
			$this->add_panel( $args );

		}

		/**
		 * Add the panel using the Customizer API.
		 *
		 * @param array $args The panel arguments.
		 */
		public function add_panel( $args ) {
			global $wp_customize;

			if ( ! isset( $args['type'] ) || ! array_key_exists( $args['type'], $this->panel_types ) ) {
				$args['type'] = 'kirki-default';
			}
			$panel_classname = $this->panel_types[ $args['type'] ];

			// If we've got an icon then call the object to create its script.
			if ( isset( $args['icon'] ) ) {
				Kirki_Scripts_Icons::generate_script( $args );
			}

			$wp_customize->add_panel( new $panel_classname( $wp_customize, sanitize_key( $args['id'] ), $args ) );

		}
	}
}
