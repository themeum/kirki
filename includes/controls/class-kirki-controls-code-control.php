<?php
/**
 * code Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Code_Control' ) ) {
	return;
}

class Kirki_Controls_Code_Control extends Kirki_Customize_Control {

	public $type = 'code';

	public function to_json() {
		parent::to_json();
		if ( ! isset( $this->choices['language'] ) ) {
			$this->choices['language'] = 'css';
		}
		if ( ! isset( $this->choices['theme'] ) ) {
			$this->choices['theme'] = 'monokai';
		}
		if ( ! isset( $this->choices['height'] ) ) {
			$this->choices['height'] = 200;
		}
	}

	public function enqueue() {
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'ace', 'vendor/ace/src-min-noconflict/ace', array( 'jquery' ) );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-code', 'controls/code', array( 'jquery', 'ace' ) );
	}

	protected function content_template() { ?>
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>
			<div id="kirki-ace-editor-{{ data.id }}"></div>
		</label>
		<#
		/**
		 * Add some custom CSS to define the height
		 */
		#>
		<style>li#customize-control-{{ data.id }} .ace_editor { height: {{ data.choices['height'] }}px !important; }</style>
		<?php
	}

}
