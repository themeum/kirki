<?php
/**
 * dimension Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Dimension_Control' ) ) {
	return;
}

class Kirki_Controls_Dimension_Control extends Kirki_Customize_Control {

	public $type = 'dimension';

	protected function content_template() { ?>
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<input type="number" min="0" step="any" value="{{ parseFloat( data.value ) }}"/>
			<select>
			<# if ( data.choices['units'] ) { #>
				<# for ( key in data.choices['units'] ) { #>
					<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value, data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
				<# } #>
			<# } else { #>
				<# var units = data.value.replace( parseFloat( data.value ), '' ); #>
				<option value="px" <# if ( units == 'px' ) { #> selected <# } #>>px</option>
				<option value="em" <# if ( units == 'em' ) { #> selected <# } #>>em</option>
				<option value="%" <# if ( units == '%' ) { #> selected <# } #>>%</option>
			<# } #>
			</select>
		</label>
		<?php
	}

}
