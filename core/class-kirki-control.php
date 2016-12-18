<?php
/**
 * Controls handler
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
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
	protected static $control_types = array();

	/**
	 * The class constructor.
	 * Creates the actual controls in the customizer.
	 *
	 * @access public
	 * @param array $args The field definition as sanitized in Kirki_Field.
	 */
	public function __construct( $args ) {

		// Set the $wp_customize property.
		global $wp_customize;
		if ( ! $wp_customize ) {
			return;
		}
		$this->wp_customize = $wp_customize;

		// Set the control types.
		$this->set_control_types();
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
		if ( array_key_exists( $args['type'], self::$control_types ) ) {
			$class_name = self::$control_types[ $args['type'] ];
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

	/**
	 * Sets the $control_types property.
	 * Makes sure the kirki/control_types filter is applied
	 * and that the defined classes actually exist.
	 * If a defined class does not exist, it is removed.
	 *
	 * @access private
	 */
	final private function set_control_types() {

		// Early exit if this has already run.
		if ( ! empty( self::$control_types ) ) {
			return;
		}

		self::$control_types = apply_filters( 'kirki/control_types', array(
			'checkbox'              => 'WP_Customize_Control',
			'kirki-code'            => 'Kirki_Control_Code',
			'kirki-color'           => 'Kirki_Control_Color',
			'kirki-color-palette'   => 'Kirki_Control_Color_Palette',
			'kirki-custom'          => 'Kirki_Control_Custom',
			'kirki-date'            => 'Kirki_Control_Date',
			'kirki-dashicons'       => 'Kirki_Control_Dashicons',
			'kirki-dimension'       => 'Kirki_Control_Dimension',
			'kirki-dimensions'      => 'Kirki_Control_Dimensions',
			'kirki-editor'          => 'Kirki_Control_Editor',
			'kirki-multicolor'      => 'Kirki_Control_Multicolor',
			'kirki-multicheck'      => 'Kirki_Control_MultiCheck',
			'kirki-number'          => 'Kirki_Control_Number',
			'kirki-palette'         => 'Kirki_Control_Palette',
			'kirki-preset'          => 'Kirki_Control_Preset',
			'kirki-radio'           => 'Kirki_Control_Radio',
			'kirki-radio-buttonset' => 'Kirki_Control_Radio_ButtonSet',
			'kirki-radio-image'     => 'Kirki_Control_Radio_Image',
			'repeater'              => 'Kirki_Control_Repeater',
			'kirki-select'          => 'Kirki_Control_Select',
			'kirki-slider'          => 'Kirki_Control_Slider',
			'kirki-sortable'        => 'Kirki_Control_Sortable',
			'kirki-spacing'         => 'Kirki_Control_Dimensions',
			'kirki-switch'          => 'Kirki_Control_Switch',
			'kirki-generic'         => 'Kirki_Control_Generic',
			'kirki-toggle'          => 'Kirki_Control_Toggle',
			'kirki-typography'      => 'Kirki_Control_Typography',
			'dropdown-pages'        => 'Kirki_Control_Dropdown_Pages',
			'image'                 => 'WP_Customize_Image_Control',
			'cropped_image'         => 'WP_Customize_Cropped_Image_Control',
			'upload'                => 'WP_Customize_Upload_Control',
		) );

		// Make sure the defined classes actually exist.
		foreach ( self::$control_types as $key => $classname ) {

			if ( ! class_exists( $classname ) ) {
				unset( self::$control_types[ $key ] );
			}
		}
	}
}
