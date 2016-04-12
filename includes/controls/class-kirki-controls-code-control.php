<?php
/**
 * Customizer Control: code.
 *
 * Creates a new custom control.
 * Custom controls accept raw HTML/JS.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Code_Control' ) ) {

	/**
	 * Adds a "code" control, using CodeMirror.
	 */
	class Kirki_Controls_Code_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'code';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
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

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {

			wp_enqueue_script( 'kirki-code' );

			// Get the language.
			$lang_file = '/assets/js/vendor/codemirror/mode/' . $this->choices['language'] . '/' . $this->choices['language'] . '.js';
			$language  = 'css';
			if ( file_exists( Kirki::$path . $lang_file ) || ! file_exists( Kirki::$path . str_replace( '/', DIRECTORY_SEPARATOR, $lang_file ) ) ) {
				$language = $this->choices['language'];
			}

			// Hack for 'html' mode.
			if ( 'html' == $language ) {
				$language = 'htmlmixed';
			}

			// Get the theme.
			$theme_file = '/assets/js/vendor/codemirror/theme/' . $this->choices['theme'] . '.css';
			$theme      = 'monokai';
			if ( file_exists( Kirki::$path . $theme_file ) || file_exists( Kirki::$path . str_replace( '/', DIRECTORY_SEPARATOR, $theme_file ) ) ) {
				$theme = $this->choices['theme'];
			}
			wp_enqueue_script( 'kirki-code', trailingslashit( Kirki::$url ) . 'assets/js/controls/code.js', array( 'jquery', 'codemirror' ), false );

			// If we're using html mode, we'll also need to include the multiplex addon
			// as well as dependencies for XML, JS, CSS languages.
			if ( in_array( $language, array( 'html', 'htmlmixed' ) ) ) {
				wp_enqueue_script( 'codemirror-multiplex', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/addon/mode/multiplex.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-xml', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/xml/xml.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-javascript', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/javascript/javascript.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-css', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/css/css.js', array( 'jquery', 'codemirror' ) );
				wp_enqueue_script( 'codemirror-language-htmlmixed', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/htmlmixed/htmlmixed.js', array( 'jquery', 'codemirror', 'codemirror-multiplex', 'codemirror-language-xml', 'codemirror-language-javascript', 'codemirror-language-css' ) );
			} else {
				// Add language script.
				wp_enqueue_script( 'codemirror-language-' . $language, trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/mode/' . $language . '/' . $language . '.js', array( 'jquery', 'codemirror' ) );
			}

			// Add theme styles.
			wp_enqueue_style( 'codemirror-theme-' . $theme, trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/theme/' . $theme . '.css' );

		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
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
				<textarea class="kirki-codemirror-editor">{{{ data.value }}}</textarea>
			</label>
			<?php
		}
	}
}
