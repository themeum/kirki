<?php
/**
 * slider Customizer Control.
 *
 * Creates a jQuery slider control.
 * TODO: Migrate to an HTML5 range control. Range control are hard to style 'cause they don't display the value
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
if ( class_exists( 'Kirki_Controls_Slider_Control' ) ) {
	return;
}

class Kirki_Controls_Slider_Control extends WP_Customize_Control {

	public $type = 'slider';

	public function enqueue() {

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-slider', trailingslashit( kirki_url() ) . 'includes/controls/slider/style.css' );
		}
		wp_enqueue_script( 'kirki-slider', trailingslashit( kirki_url() ) . 'includes/controls/slider/script.js', array( 'jquery' ) );

	}

	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['default'] = $this->setting->default;

		$this->json['choices']['min']  = ( isset( $this->choices['min'] ) ) ? $this->choices['min'] : '0';
		$this->json['choices']['max']  = ( isset( $this->choices['max'] ) ) ? $this->choices['max'] : '100';
		$this->json['choices']['step'] = ( isset( $this->choices['step'] ) ) ? $this->choices['step'] : '1';
	}

	public function content_template() { ?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="wrapper">
				<input type="range" min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" value="{{ data.value }}" {{{ data.link }}} data-reset_value="{{ data.default }}" />
				<div class="kirki_range_value">
					<span class="value">{{ data.value }}</span>
					<# if ( data.choices['suffix'] ) { #>
						{{ data.choices['suffix'] }}
					<# } #>
				</div>
				<div class="kirki-slider-reset">
					<span class="dashicons dashicons-image-rotate"></span>
				</div>
			</div>
		</label>
		<?php

	}
}
