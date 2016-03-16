<?php
/**
 * Generic Field Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Generic_Control' ) ) {
	class Kirki_Controls_Generic_Control extends Kirki_Customize_Control {

		public $type = 'kirki-generic';

		protected function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<div class="customize-control-content">
					<# if ( 'textarea' == data.choices['element'] ) { #>
						<textarea {{{ data.link }}} <# for ( key in data.choices ) { #> {{ key }}="{{ data.choices[ key ] }}"<# } #>>{{ data.value }}</textarea>
					<# } else { #>
						<# var element = ( data.choices['element'] ) ? data.choices['element'] : 'input'; #>
						<{{ element }} value="{{ data.value }}" {{{ data.link }}} <# for ( key in data.choices ) { #> {{ key }}="{{ data.choices[ key ] }}"<# } #> />
					<# } #>
				</div>
			</label>
			<?php
		}

	}
}
