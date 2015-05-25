<?php

/**
 * Parses the fields and creates the new controls depending on the field type.
 */
class Kirki_Controls {

	public $control_types;

	public function __construct() {

		// Control types and their classes.
		$this->control_types = 	apply_filters( 'kirki/control_types', array(
			'color'           => 'WP_Customize_Color_Control',
			'color-alpha'     => 'Kirki_Controls_Color_Alpha_Control',
			'image'           => 'WP_Customize_Image_Control',
			'upload'          => 'WP_Customize_Upload_Control',
			'switch'          => 'Kirki_Controls_Switch_Control',
			'toggle'          => 'Kirki_Controls_Toggle_Control',
			'radio-buttonset' => 'Kirki_Controls_Radio_ButtonSet_Control',
			'radio-image'     => 'Kirki_Controls_Radio_Image_Control',
			'sortable'        => 'Kirki_Controls_Sortable_Control',
			'slider'          => 'Kirki_Controls_Slider_Control',
			'number'          => 'Kirki_Controls_Number_Control',
			'multicheck'      => 'Kirki_Controls_MultiCheck_Control',
			'palette'         => 'Kirki_Controls_Palette_Control',
			'custom'          => 'Kirki_Controls_Custom_Control',
			'editor'          => 'Kirki_Controls_Editor_Control',
			'select2'         => 'Kirki_Controls_Select_Control'
		) );

		// global $wp_customize;
		// add_action( 'customize_register', array( $this, 'register_control_type' ) );

	}

	public function register_control_type( $wp_customize ) {
		foreach ( $this->control_types as $type => $control_class ) {
			if ( false !== strpos( $control_class, 'Kirki' ) ) {
				$wp_customize->register_control_type( $control_class );
			}
		}
	}

	/**
	 * Add our fields.
	 * We use the default WordPress Core Customizer fields when possible
	 * and only add our own custom controls when needed.
	 */
	public function add( $wp_customize, $field ) {

		if ( array_key_exists( $field['type'], $this->control_types ) ) {
			$class_name = $this->control_types[$field['type']];
			$wp_customize->add_control( new $class_name( $wp_customize, $field['id'], $field ) );
		} else {
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $field['id'], $field ) );
		}

	}

}
