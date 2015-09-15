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

class Kirki_Controls_Code_Control extends WP_Customize_Control {

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
		$this->json['value'] = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link'] = $this->get_link();
	}

	public function enqueue() {

		wp_enqueue_script( 'ace', trailingslashit( kirki_url() ) . 'includes/controls/code/src-min-noconflict/ace.js', array( 'jquery' ) );
		wp_enqueue_script( 'kirki-code', trailingslashit( kirki_url() ) . 'includes/controls/code/script.js', array( 'jquery', 'ace' ) );
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-code-style', trailingslashit( kirki_url() ).'includes/controls/code/style.css' );
		}

	}

	public function content_template() { ?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>
			<textarea {{{ data.link }}} data-editor="{{ data.choices['language'] }}" data-theme="{{ data.choices['theme'] }}" height="{{ data.choices['height'] }}" rows="15">
				<#
				/**
				 * This is a CODE EDITOR.
				 * As such, we will not be escaping anything by default.
				 *
				 * It can be used for custom CSS, custom JS and even custom PHP depending on the implementation.
				 * It's up to the theme/plugin developer to properly sanitize it depending on the use case.
				 */
				#>
				{{ data.value }}
			</textarea>
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
