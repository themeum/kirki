<?php
/**
 * Controls handler
 *
 * @package     XTKirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 */

if ( ! class_exists( 'XTKirki_Control' ) ) {

	/**
	 * Our main XTKirki_Control object
	 */
	class XTKirki_Control {

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
		 * @param array $args The field definition as sanitized in XTKirki_Field.
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
		 * @param array $args The field definition as sanitized in XTKirki_Field.
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
		 * @param array $args The field definition as sanitized in XTKirki_Field.
		 */
		final protected function add_control( $args ) {

			// Get the name of the class we're going to use.
			$class_name = $this->get_control_class_name( $args );
			// Add the control.
			$this->wp_customize->add_control( new $class_name( $this->wp_customize, $args['settings'], $args ) );

		}

		/**
		 * Sets the $this->control_types property.
		 * Makes sure the xtkirki/control_types filter is applied
		 * and that the defined classes actually exist.
		 * If a defined class does not exist, it is removed.
		 */
		final private function set_control_types() {

			$this->control_types = apply_filters( 'xtkirki/control_types', array(
				'xtkirki-checkbox'        => 'XTKirki_Controls_Checkbox_Control',
				'xtkirki-code'            => 'XTKirki_Controls_Code_Control',
				'xtkirki-color'           => 'XTKirki_Controls_Color_Control',
				'xtkirki-color-palette'   => 'XTKirki_Controls_Color_Palette_Control',
				'xtkirki-custom'          => 'XTKirki_Controls_Custom_Control',
				'xtkirki-date'            => 'XTKirki_Controls_Date_Control',
				'xtkirki-dashicons'       => 'XTKirki_Controls_Dashicons_Control',
				'xtkirki-dimension'       => 'XTKirki_Controls_Dimension_Control',
				'xtkirki-editor'          => 'XTKirki_Controls_Editor_Control',
				'xtkirki-multicolor'      => 'XTKirki_Controls_Multicolor_Control',
				'xtkirki-multicheck'      => 'XTKirki_Controls_MultiCheck_Control',
				'xtkirki-number'          => 'XTKirki_Controls_Number_Control',
				'xtkirki-palette'         => 'XTKirki_Controls_Palette_Control',
				'xtkirki-preset'          => 'XTKirki_Controls_Preset_Control',
				'xtkirki-radio'           => 'XTKirki_Controls_Radio_Control',
				'xtkirki-radio-buttonset' => 'XTKirki_Controls_Radio_ButtonSet_Control',
				'xtkirki-radio-image'     => 'XTKirki_Controls_Radio_Image_Control',
				'repeater'              => 'XTKirki_Controls_Repeater_Control',
				'xtkirki-select'          => 'XTKirki_Controls_Select_Control',
				'xtkirki-slider'          => 'XTKirki_Controls_Slider_Control',
				'xtkirki-sortable'        => 'XTKirki_Controls_Sortable_Control',
				'xtkirki-spacing'         => 'XTKirki_Controls_Spacing_Control',
				'xtkirki-switch'          => 'XTKirki_Controls_Switch_Control',
				'xtkirki-generic'         => 'XTKirki_Controls_Generic_Control',
				'xtkirki-toggle'          => 'XTKirki_Controls_Toggle_Control',
				'xtkirki-typography'      => 'XTKirki_Controls_Typography_Control',
				'xtkirki-dropdown-pages'  => 'XTKirki_Controls_Dropdown_Pages_Control',
				'image'                 => 'WP_Customize_Image_Control',
				'cropped_image'         => 'WP_Customize_Cropped_Image_Control',
				'upload'                => 'WP_Customize_Upload_Control',
			) );

			// Make sure the defined classes actually exist.
			foreach ( $this->control_types as $key => $classname ) {

				if ( ! class_exists( $classname ) ) {
					unset( $this->control_types[ $key ] );
				}
			}
		}
	}
}
