<?php

/**
 * Parses the fields and creates the new controls depending on the field type.
 */
class Kirki_Controls {

	public function __construct() {
		global $wp_customize;
		// add_action( 'customize_register', array( $this, 'register_control_type' ) );
	}

	public function register_control_type( $wp_customize ) {
		$wp_customize->register_control_type( 'Kirki_Controls_Custom_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Editor_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Multicheck_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Number_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Palette_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Radio_Image_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Slider_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Sortable_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Switch_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Toggle_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Color_Alpha_Control' );
		$wp_customize->register_control_type( 'Kirki_Controls_Tab_Control' );
	}

	/**
	 * Add our fields.
	 * We use the default WordPress Core Customizer fields when possible
	 * and only add our own custom controls when needed.
	 */
	public function add( $wp_customize, $field ) {

		switch ( $field['type'] ) {

			case 'color' :
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'color-alpha' :
				$wp_customize->add_control( new Kirki_Controls_Color_Alpha_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'image' :
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'upload' :
				$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'switch' :
				$wp_customize->add_control( new Kirki_Controls_Switch_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'toggle' :
				$wp_customize->add_control( new Kirki_Controls_Toggle_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'radio-buttonset' :
				$wp_customize->add_control( new Kirki_Controls_Radio_ButtonSet_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'radio-image' :
				$wp_customize->add_control( new Kirki_Controls_Radio_Image_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'sortable' :
				$wp_customize->add_control( new Kirki_Controls_Sortable_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'slider' :
				$wp_customize->add_control( new Kirki_Controls_Slider_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'number' :
				$wp_customize->add_control( new Kirki_Controls_Number_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'multicheck' :
				$wp_customize->add_control( new Kirki_Controls_MultiCheck_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'palette' :
				$wp_customize->add_control( new Kirki_Controls_Palette_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'custom' :
				$wp_customize->add_control( new Kirki_Controls_Custom_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'editor' :
				$wp_customize->add_control( new Kirki_Controls_Editor_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'background' :
				// Do nothing.
				// The 'background' field is just the sum of its sub-fields
				// which are created individually.
				break;

			default :
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $field['id'], $field ) );
				break;

		}

	}

}
