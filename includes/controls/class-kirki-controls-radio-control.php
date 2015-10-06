<?php
/**
 * select2 Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Radio_Control' ) ) {
	return;
}

class Kirki_Controls_Radio_Control extends Kirki_Customize_Control {

	public $type = 'kirki-radio';

	protected function content_template() { ?>
		<# if ( ! data.choices ) { return; } #>

		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{ data.description }}</span>
		<# } #>
		<# for ( key in data.choices ) { #>
			<label>
				<input type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked<# } #> />
				<# if ( _.isArray( data.choices[ key ] ) ) { #>
					{{ data.choices[ key ][0] }}
					<span class="option-description">{{ data.choices[ key ][1] }}</span>
				<# } else { #>
					{{ data.choices[ key ] }}
				<# } #>
			</label>
		<# } #>
		<?php
	}

}
