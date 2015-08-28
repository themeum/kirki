<?php
/**
 * Repeater Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Repeater_Control' ) ) {
	return;
}

class Kirki_Controls_Repeater_Control extends WP_Customize_Control {

	public $type = 'repeater';

	public function enqueue() {
	}

	public function render_content() {
		global $wp_customize;

		$control_types = apply_filters( 'kirki/repeater_control_types', array(
			'color'            => 'WP_Customize_Color_Control',
			'color-alpha'      => 'Kirki_Controls_Color_Alpha_Control',
			'image'            => 'WP_Customize_Image_Control',
			'upload'           => 'WP_Customize_Upload_Control',
			'switch'           => 'Kirki_Controls_Switch_Control',
			'toggle'           => 'Kirki_Controls_Toggle_Control',
			'radio-buttonset'  => 'Kirki_Controls_Radio_ButtonSet_Control',
			'radio-image'      => 'Kirki_Controls_Radio_Image_Control',
			'sortable'         => 'Kirki_Controls_Sortable_Control',
			'slider'           => 'Kirki_Controls_Slider_Control',
			'number'           => 'Kirki_Controls_Number_Control',
			'multicheck'       => 'Kirki_Controls_MultiCheck_Control',
			'palette'          => 'Kirki_Controls_Palette_Control',
			'custom'           => 'Kirki_Controls_Custom_Control',
			'editor'           => 'Kirki_Controls_Editor_Control',
			'select2'          => 'Kirki_Controls_Select2_Control',
			'select2-multiple' => 'Kirki_Controls_Select2_Multiple_Control',
			'dimension'        => 'Kirki_Controls_Dimension_Control',
		) );

		$row_fields = array(
			array(
				'type' => 'text',
				'id' => 'first_field',
				'args' => array(
					'label' => 'First Field'
				)
			),
			array(
				'type' => 'color',
				'id' => 'second_field'
			)
		);


		foreach ( $row_fields as $field ) {

			$class_name = 'WP_Customize_Control';
			if ( array_key_exists( $field['type'], $control_types ) )
				$class_name = $control_types[ $field['type'] ];

			$id = $this->id . '-' . $field['id'];
			$control = new $class_name(
				$wp_customize,
				Kirki_Field::sanitize_id( $id ),
				Kirki_Field::sanitize_field( $field['args'] )
			);

			$control->enqueue();
			$control->render_content();

		}


	}

}