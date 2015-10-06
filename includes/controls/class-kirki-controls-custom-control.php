<?php
/**
 * custom Customizer Control.
 *
 * Creates a new custom control.
 * Custom controls accept raw HTML/JS.
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
if ( class_exists( 'Kirki_Controls_Custom_Control' ) ) {
	return;
}

class Kirki_Controls_Custom_Control extends Kirki_Customize_Control {

	public $type = 'custom';

	protected function content_template() { ?>
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<?php
				/**
				 * The value is defined by the developer in the field configuration as 'default'.
				 * There is no user input on this field, it's a raw HTML/JS field and we do not sanitize it.
				 * Do not be alarmed, this is not a security issue.
				 * In order for someone to be able to change this they would have to have access to your filesystem.
				 * If that happens, they can change whatever they want anyways. This field is not a concern.
				 */
			?>
			{{{ data.value }}}
		</label>
		<?php

	}

}
