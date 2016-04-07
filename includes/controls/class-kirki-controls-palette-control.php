<?php
/**
 * palette Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Palette_Control' ) ) {
	class Kirki_Controls_Palette_Control extends Kirki_Customize_Control {

		public $type = 'palette';

		public function enqueue() {
			wp_enqueue_script( 'kirki-palette' );
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
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div id="input_{{ data.id }}" class="buttonset">
				<# for ( key in data.choices ) { #>
					<input type="radio" value="{{ key }}" name="_customize-palette-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value == key ) { #> checked<# } #>>
						<label for="{{ data.id }}{{ key }}">
							<# for ( color in data.choices[ key ] ) { #>
								<span style='background: {{ data.choices[ key ][ color ] }}'>{{ data.choices[ key ][ color ] }}</span>
							<# } #>
						</label>
					</input>
				<# } #>
			</div>
			<?php
		}
	}
}
