<?php
/**
 * Controls handler
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 */

/**
 * Our main Kirki_Control object
 */
class Kirki_Control {

	/**
	 * The $wp_customize WordPress global.
	 *
	 * @access protected
	 * @var WP_Customize_Manager
	 */
	protected $wp_customize;

	/**
	 * An array of all available control types.
	 *
	 * @access protected
	 * @var array
	 */
	protected $control_types = array();

	/**
	 * The class constructor.
	 * Creates the actual controls in the customizer.
	 *
	 * @access public
	 * @param array $args The field definition as sanitized in Kirki_Field.
	 */
	public function __construct( $args ) {

		$this->control_types = apply_filters( 'kirki/control_types', array() );

		if ( ! is_customize_preview() ) {
			return;
		}

		// Set the $wp_customize property.
		global $wp_customize;
		$this->wp_customize = $wp_customize;

		// Add the control.
		$this->add_control( $args );

	}

	/**
	 * Get the class name of the class needed to create tis control.
	 *
	 * @access private
	 * @param array $args The field definition as sanitized in Kirki_Field.
	 *
	 * @return         string   the name of the class that will be used to create this control.
	 */
	final private function get_control_class_name( $args ) {

		// Set a default class name.
		$class_name = 'WP_Customize_Control';
		// Get the classname from the array of control classnames.
		if ( array_key_exists( $args['type'], $this->control_types ) ) {
			$class_name = $this->control_types[ $args['type'] ];
		}
		return $class_name;

	}

	/**
	 * Adds the control.
	 *
	 * @access protected
	 * @param array $args The field definition as sanitized in Kirki_Field.
	 */
	final protected function add_control( $args ) {

		// Get the name of the class we're going to use.
		$class_name = $this->get_control_class_name( $args );
		// Add the control.
		$this->wp_customize->add_control( new $class_name( $this->wp_customize, $args['settings'], $args ) );

	}
}
