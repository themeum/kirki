<?php

class Kirki_Control extends Kirki_Customizer {

	/**
	 * an array of all the control types
	 * and the classname each one of them will use.
	 */
	public static $control_types = array(
		'checkbox'         => 'Kirki_Controls_Checkbox_Control',
		'code'             => 'Kirki_Controls_Code_Control',
		'color-alpha'      => 'Kirki_Controls_Color_Alpha_Control',
		'custom'           => 'Kirki_Controls_Custom_Control',
		'dimension'        => 'Kirki_Controls_Dimension_Control',
		'editor'           => 'Kirki_Controls_Editor_Control',
		'multicheck'       => 'Kirki_Controls_MultiCheck_Control',
		'number'           => 'Kirki_Controls_Number_Control',
		'palette'          => 'Kirki_Controls_Palette_Control',
		'preset'           => 'Kirki_Controls_Preset_Control',
		'radio'            => 'Kirki_Controls_Radio_Control',
		'radio-buttonset'  => 'Kirki_Controls_Radio_ButtonSet_Control',
		'radio-image'      => 'Kirki_Controls_Radio_Image_Control',
		'repeater'         => 'Kirki_Controls_Repeater_Control',
		'select'           => 'Kirki_Controls_Select_Control',
		'slider'           => 'Kirki_Controls_Slider_Control',
		'sortable'         => 'Kirki_Controls_Sortable_Control',
		'spacing'          => 'Kirki_Controls_Spacing_Control',
		'switch'           => 'Kirki_Controls_Switch_Control',
		'text'             => 'Kirki_Controls_Text_Control',
		'textarea'         => 'Kirki_Controls_Textarea_Control',
		'toggle'           => 'Kirki_Controls_Toggle_Control',
		'typography'       => 'Kirki_Controls_Typography_Control',
		'color'            => 'WP_Customize_Color_Control',
		'image'            => 'WP_Customize_Image_Control',
		'upload'           => 'WP_Customize_Upload_Control',
	);

	/**
	 * Some controls may need to create additional classes
	 * for their settings regiastration.
	 * in that case here's an array of those controls.
	 */
	public static $setting_types = array(
		'repeater' => 'Kirki_Settings_Repeater_Setting',
	);

	public $wp_customize;

	/**
	 * The class constructor
	 */
	public function __construct( $args ) {
		// call the parent constructor
		parent::__construct( $args );
		/**
		 * Apply the 'kirki/control_types' filter to Kirki_Control::$control_types.
		 * We can use that to register our own customizer controls and extend Kirki.
		 */
		self::$control_types = apply_filters( 'kirki/control_types', self::$control_types );
		/**
		 * Apply the 'kirki/setting_types' filter to Kirki_Control::$control_types.
		 * We can use that to register our own setting classes for controls and extend Kirki.
		 */
		self::$setting_types = apply_filters( 'kirki/setting_types', self::$setting_types );
		// Add the control
		$this->add_control( $args );

	}

	/**
	 * Get the class name of the class needed to create tis control.
	 *
	 * @param  $args array
	 * @return  string
	 */
	public static function control_class_name( $args ) {
		// Set a default class name
		$class_name = 'WP_Customize_Control';
		// Get the classname from the array of control classnames
		if ( array_key_exists( $args['type'], self::$control_types ) ) {
			$class_name = self::$control_types[ $args['type'] ];
		}

		return $class_name;

	}

	/**
	 * Add the control.
	 *
	 * @param  $arg array
	 * @return  void
	 */
	public function add_control( $args ) {

		$control_class_name = self::control_class_name( $args );

		$this->wp_customize->add_control( new $control_class_name(
			$this->wp_customize,
			Kirki_Field_Sanitize::sanitize_id( $args ),
			Kirki_Field_Sanitize::sanitize_field( $args )
		) );

	}

}
