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

		$row_fields = array(
			array(
				'type' => 'text',
				'id' => 'first_field',
				'args' => array(
					'label' => 'First Field'
				)
			)
		);


		foreach ( $row_fields as $field ) {
			$id = $this->id . '-' . $field['id'];
			$control = new WP_Customize_Control( $wp_customize, $id, $field['args'] );
			$control->render_content();

		}


	}

}