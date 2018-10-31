<?php
/**
 * Handles panels added via the Kirki API.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

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
		'default' => 'WP_Customize_Panel',
	);

	/**
	 * The class constructor.
	 *
	 * @access public
	 * @param array $args The panel arguments.
	 */
	public function __construct( $args ) {
		$this->panel_types = apply_filters( 'kirki_panel_types', $this->panel_types );
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
			$args['type'] = 'default';
		}
		$panel_classname = $this->panel_types[ $args['type'] ];

		$wp_customize->add_panel( new $panel_classname( $wp_customize, $args['id'], $args ) );
	}
}
