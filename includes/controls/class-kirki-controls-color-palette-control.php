<?php
/**
 * palette Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Color_Palette_Control' ) ) {
	class Kirki_Controls_Color_Palette_Control extends Kirki_Customize_Control {

		public $type = 'color-palette';

		public function enqueue() {
			wp_enqueue_script( 'jquery-ui-button' );
			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-palette', 'controls/palette', array( 'jquery', 'jquery-ui-button' ) );
		}

		public function to_json() {
			parent::to_json();
			// If no palette has been defined, use Material Design Palette
			if ( ! isset( $this->json['choices']['colors'] ) || empty( $this->json['choices']['colors'] ) ) {
				$this->json['choices']['colors'] = Kirki_Helper::get_material_design_colors( 'primary' );
			}
			if ( ! isset( $this->json['choices']['size'] ) || empty( $this->json['choices']['size'] ) ) {
				$this->json['choices']['size']   = 42;
			}
		}

		protected function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<# if ( ! data.choices ) { return; } #>
			<span class="customize-control-title">
				{{ data.label }}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>
			<div id="input_{{ data.id }}" class="colors-wrapper">
				<# for ( key in data.choices['colors'] ) { #>
					<input type="radio" value="{{ data.choices['colors'][ key ] }}" name="_customize-color-palette-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value == data.choices['colors'][ key ] ) { #> checked<# } #>>
						<label for="{{ data.id }}{{ key }}">
							<span class="color-palette-color" style='background: {{ data.choices['colors'][ key ] }}; width: {{ data.choices['size'] }}px; height: {{ data.choices['size'] }}px;'>{{ data.choices['colors'][ key ] }}</span>
						</label>
					</input>
				<# } #>
			</div>
			<?php
		}
	}
}
