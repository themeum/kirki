<?php
/**
 * Handles panels added via the XTKirki API.
 *
 * @package     XTKirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'XTKirki_Panel' ) ) {

	/**
	 * Each panel is a separate instance of the XTKirki_Panel object.
	 */
	class XTKirki_Panel {

		/**
		 * An array of our panel types.
		 *
		 * @access private
		 * @var array
		 */
		private $panel_types = array(
			'xtkirki-default'  => 'XTKirki_Panels_Default_Panel',
			'xtkirki-expanded' => 'XTKirki_Panels_Expanded_Panel',
		);

		/**
		 * The class constructor.
		 *
		 * @access public
		 * @param array $args The panel arguments.
		 */
		public function __construct( $args ) {

			$this->panel_types = apply_filters( 'xtkirki/panel_types', $this->panel_types );
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
				$args['type'] = 'xtkirki-default';
			}
			$panel_classname = $this->panel_types[ $args['type'] ];

			// If we've got an icon then call the object to create its script.
			if ( isset( $args['icon'] ) ) {
				XTKirki_Scripts_Icons::generate_script( $args );
			}

			$wp_customize->add_panel( new $panel_classname( $wp_customize, sanitize_key( $args['id'] ), $args ) );

		}
	}
}
