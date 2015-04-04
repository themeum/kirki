<?php

namespace Kirki;

use Kirki;
use Kirki\Controls\CustomControl;
use Kirki\Controls\EditorControl;
use Kirki\Controls\MultiCheckControl;
use Kirki\Controls\NumberControl;
use Kirki\Controls\PaletteControl;
use Kirki\Controls\RadioButtonSetControl;
use Kirki\Controls\RadioImageControl;
use Kirki\Controls\SliderControl;
use Kirki\Controls\SortableControl;
use Kirki\Controls\SwitchControl;
use Kirki\Controls\ToggleControl;
use Kirki\Controls\ColorAlphaControl;

class Controls {

	public function __construct() {
		global $wp_customize;
		// add_action( 'customize_register', array( $this, 'register_control_type' ) );
	}

	public function register_control_type( $wp_customize ) {
		$wp_customize->register_control_type( '\Kirki\Controls\CustomControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\EditorControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\MulticheckControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\NumberControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\PaletteControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\RadioImageControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\SliderControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\SortableControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\SwitchControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\ToggleControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\ColorAlphaControl' );
		$wp_customize->register_control_type( '\Kirki\Controls\TabControl' );
	}

	/**
	 * Add our fields.
	 * We use the default WordPress Core Customizer fields when possible
	 * and only add our own custom controls when needed.
	 */
	public function add( $wp_customize, $field ) {

		switch ( $field['type'] ) {

			case 'color' :
				$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'color-alpha' :
				$wp_customize->add_control( new ColorAlphaControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'image' :
				$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'upload' :
				$wp_customize->add_control( new \WP_Customize_Upload_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'switch' :
				$wp_customize->add_control( new SwitchControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'toggle' :
				$wp_customize->add_control( new ToggleControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'radio-buttonset' :
				$wp_customize->add_control( new RadioButtonSetControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'radio-image' :
				$wp_customize->add_control( new RadioImageControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'sortable' :
				$wp_customize->add_control( new SortableControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'slider' :
				$wp_customize->add_control( new SliderControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'number' :
				$wp_customize->add_control( new NumberControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'multicheck' :
				$wp_customize->add_control( new MultiCheckControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'palette' :
				$wp_customize->add_control( new PaletteControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'custom' :
				$wp_customize->add_control( new CustomControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'editor' :
				$wp_customize->add_control( new EditorControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'background' :
				// Do nothing.
				// The 'background' field is just the sum of its sub-fields
				// which are created individually.
				break;

			default :
				$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, $field['id'], $field ) );
				break;

		}

	}

}
