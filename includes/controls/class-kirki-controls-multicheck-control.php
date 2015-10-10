<?php
/**
 * editor Customizer Control.
 *
 * Multiple checkbox customize control class.
 * Props @ Justin Tadlock: http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
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
if ( class_exists( 'Kirki_Controls_MultiCheck_Control' ) ) {
	return;
}

class Kirki_Controls_MultiCheck_Control extends Kirki_Customize_Control {

	public $type = 'multicheck';

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

		<ul>
			<# for ( key in data.choices ) { #>
				<li>
					<label>
						<input type="checkbox" value="{{ key }}"<# if ( _.contains( data.value, key ) ) { #> checked<# } #> />
						{{ data.choices[ key ] }}
					</label>
				</li>
			<# } #>
		</ul>
	<?php }
}
