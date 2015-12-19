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
		/**
		 * Get the language
		 */
		$lang_file = '/assets/js/vendor/codemirror/mode/' . $this->choices['language'] . '/' . $this->choices['language'] . '.js';
		$language  = 'css';
		if ( file_exists( Kirki::$path . $lang_file ) || ! file_exists( Kirki::$path . str_replace( '/', DIRECTORY_SEPARATOR, $lang_file ) ) ) {
			$language = $this->choices['language'];
		}
		// hack for 'html' mode.
		if ( 'html' == $language ) {
			$language = 'htmlmixed';
		}
		/**
		 * Get the theme
		 */
		$theme_file = '/assets/js/vendor/codemirror/theme/' . $this->choices['theme'] . '.css';
		$theme      = 'monokai';
		if ( file_exists( Kirki::$path . $theme_file ) || file_exists( Kirki::$path . str_replace( '/', DIRECTORY_SEPARATOR, $theme_file ) ) ) {
			$theme = $this->choices['theme'];
		}
		/**
		 * Enqueue dependencies
		 */
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'codemirror', 'vendor/codemirror/lib/codemirror', array( 'jquery' ) );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-code', 'controls/code', array( 'jquery', 'codemirror' ) );
		/**
		 * If we're using html mode, we'll also need to include the multiplex addon
		 * as well as dependencies for XML, JS, CSS languages.
		 */
		if ( in_array( $language, array( 'html', 'htmlmixed' ) ) ) {
			wp_enqueue_script( 'codemirror-multiplex', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/addon/mode/multiplex.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-xml', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/xml/xml.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-javascript', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/javascript/javascript.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-css', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/css/css.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-htmlmixed', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/htmlmixed/htmlmixed.js', array( 'jquery', 'codemirror', 'codemirror-multiplex', 'codemirror-language-xml', 'codemirror-language-javascript', 'codemirror-language-css' ) );
		} else {
			/**
			 * Add language script
			 */
			wp_enqueue_script( 'codemirror-language-' . $language, trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/' . $language . '/' . $language . '.js', array( 'jquery', 'codemirror' ) );
		}
		/**
		 * Add theme styles
		 */
		wp_enqueue_style( 'codemirror-theme-' . $theme, trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/theme/' . $theme . '.css' );
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
			<textarea id="kirki-codemirror-editor-{{ data.id }}">{{{ data.value }}}</textarea>
		</label>
		<?php
	}

}
