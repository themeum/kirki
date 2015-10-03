<?php

class Kirki_Init {

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
		'textarea'         => 'Kirki_Controls_Textarea_Control',
		'toggle'           => 'Kirki_Controls_Toggle_Control',
		'typography'       => 'Kirki_Controls_Typography_Control',

		'color'            => 'WP_Customize_Color_Control',
		'image'            => 'WP_Customize_Image_Control',
		'upload'           => 'WP_Customize_Upload_Control',
	);

	public static $setting_types = array(
		'repeater' => 'Kirki_Settings_Repeater_Setting',
	);

	/**
	 * the class constructor
	 */
	public function __construct() {
		self::$control_types = apply_filters( 'kirki/control_types', self::$control_types );
		self::$setting_types = apply_filters( 'kirki/setting_types', self::$setting_types );
		add_action( 'wp_loaded', array( $this, 'add_to_customizer' ), 1 );
	}

	/**
	 * Helper function that adds the fields, sections and panels to the customizer.
	 * @return void
	 */
	public function add_to_customizer() {
		new Kirki_Fields_Filter();
		add_action( 'customize_register', array( $this, 'register_control_types' ) );
		add_action( 'customize_register', array( $this, 'add_panels' ), 97 );
		add_action( 'customize_register', array( $this, 'add_sections' ), 98 );
		add_action( 'customize_register', array( $this, 'add_fields' ), 99 );
	}

	/**
	 * Register control types
	 */
	public function register_control_types() {
		global $wp_customize;
		$wp_customize->register_control_type( 'Kirki_Controls_Checkbox_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Code_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Color_Alpha_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Custom_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Dimension_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Number_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Radio_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Radio_Buttonset_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Radio_Image_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Select_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Slider_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Spacing_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Switch_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Textarea_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Toggle_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Typography_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Palette_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Preset_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Multicheck_Control' );
	}

	/**
	 * register our panels to the WordPress Customizer
	 * @var	object	The WordPress Customizer object
	 */
	public function add_panels() {
		if ( ! empty( Kirki::$panels ) ) {
			foreach ( Kirki::$panels as $panel_args ) {
				new Kirki_Panel( $panel_args );
			}
		}
	}

	/**
	 * register our sections to the WordPress Customizer
	 * @var	object	The WordPress Customizer object
	 */
	public function add_sections() {
		if ( ! empty( Kirki::$sections ) ) {
			foreach ( Kirki::$sections as $section_args ) {
				new Kirki_Section( $section_args );
			}
		}
	}

	/**
	 * Create the settings and controls from the $fields array and register them.
	 * @var	object	The WordPress Customizer object
	 */
	public function add_fields() {
		foreach ( Kirki::$fields as $field ) {
			if ( isset( $field['type'] ) && 'background' == $field['type'] ) {
				continue;
			}
			if ( isset( $field['type'] ) && 'select2-multiple' == $field['type'] ) {
				$field['multiple'] = 999;
			}
			new Kirki_Field( $field );
		}
	}

	/**
	 * Build the variables.
	 *
	 * @return array 	('variable-name' => value)
	 */
	public function get_variables() {

		$variables = array();

		/**
		 * Loop through all fields
		 */
		foreach ( Kirki::$fields as $field ) {
			/**
			 * Check if we have variables for this field
			 */
			if ( isset( $field['variables'] ) && false != $field['variables'] && ! empty( $field['variables'] ) ) {
				/**
				 * Loop through the array of variables
				 */
				foreach ( $field['variables'] as $field_variable ) {
					/**
					 * Is the variable ['name'] defined?
					 * If yes, then we can proceed.
					 */
					if ( isset( $field_variable['name'] ) ) {
						/**
						 * Sanitize the variable name
						 */
						$variable_name = esc_attr( $field_variable['name'] );
						/**
						 * Do we have a callback function defined?
						 * If not then set $variable_callback to false.
						 */
						$variable_callback = ( isset( $field_variable['callback'] ) && is_callable( $field_variable['callback'] ) ) ? $field_variable['callback'] : false;
						/**
						 * If we have a variable_callback defined then get the value of the option
						 * and run it through the callback function.
						 * If no callback is defined (false) then just get the value.
						 */
						if ( $variable_callback ) {
							$variables[ $variable_name ] = call_user_func( $field_variable['callback'], Kirki::get_option( Kirki_Field_Sanitize::sanitize_settings( $field ) ) );
						} else {
							$variables[ $variable_name ] = Kirki::get_option( $field['settings'] );
						}

					}

				}

			}

		}
		/**
		 * Pass the variables through a filter ('kirki/variable')
		 * and return the array of variables
		 */
		return apply_filters( 'kirki/variable', $variables );

	}

	public static function path() {

	}

}
