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
if ( class_exists( 'Kirki_Controls_Select_Control' ) ) {
	return;
}

class Kirki_Controls_Select_Control extends Kirki_Customize_Control {

	public $type = 'kirki-select';

	public $multiple = 1;

	public function to_json() {
		parent::to_json();
		$this->json['multiple'] = $this->multiple;
	}

	public function enqueue() {
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'selectize', 'vendor/selectize', array( 'jquery' ) );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-select', 'controls/select', array( 'jquery', 'selectize' ) );
	}

	protected function content_template() { ?>

		<# if ( ! data.choices ) return; #>
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<select {{{ data.link }}} data-multiple="{{ data.multiple }}"<# if ( 1 < data.multiple ) { #> multiple<# } #>>
				<# if ( 1 < data.multiple && data.value ) { #>
					<# for ( key in data.value ) { #>
						<option value="{{ data.value[ key ] }}" selected>{{ data.choices[ data.value[ key ] ] }}</option>
					<# } #>
					<# for ( key in data.choices ) { #>
						<# if ( data.value[ key ] in data.value ) { #>
						<# } else { #>
							<option value="{{ key }}">{{ data.choices[ key ] }}</option>
						}
						<# } #>
					<# } #>
				<# } else { #>
					<# for ( key in data.choices ) { #>
						<option value="{{ key }}"<# if ( key === data.value ) { #>selected<# } #>>{{ data.choices[ key ] }}</option>
					<# } #>
				<# } #>
			</select>
		</label>
		<?php
	}
}
