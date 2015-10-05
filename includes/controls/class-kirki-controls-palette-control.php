<?php
/**
 * palette Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Palette_Control' ) ) {
	return;
}

class Kirki_Controls_Palette_Control extends Kirki_Customize_Control {

	public $type = 'palette';

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-palette', 'controls/palette', array( 'jquery', 'jquery-ui-button' ) );
	}

	protected function content_template() { ?>
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<# if ( ! data.choices ) { return; } #>
		<span class="customize-control-title">
			{{ data.label }}
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>
		</span>

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
