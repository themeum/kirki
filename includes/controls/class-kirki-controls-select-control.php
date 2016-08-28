<?php
/**
 * Customizer Control: kirki-select.
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

if ( ! class_exists( 'Kirki_Controls_Select_Control' ) ) {

	/**
	 * Select control.
	 */
	class Kirki_Controls_Select_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-select';

		/**
		 * Maximum number of options the user will be able to select.
		 * Set to 1 for single-select.
		 *
		 * @access public
		 * @var int
		 */
		public $multiple = 1;

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			parent::to_json();
			$this->json['multiple'] = $this->multiple;
		}

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-select' );
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
			<# if ( ! data.choices ) return; #>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{ data.label }}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<select {{{ data.inputAttrs }}} {{{ data.link }}} data-multiple="{{ data.multiple }}"<# if ( 1 < data.multiple ) { #> multiple<# } #>>
					<# if ( 1 < data.multiple && data.value ) { #>
						<# for ( key in data.value ) { #>
							<option value="{{ data.value[ key ] }}" selected>{{ data.choices[ data.value[ key ] ] }}</option>
						<# } #>
						<# for ( key in data.choices ) { #>
							<# if ( data.value[ key ] in data.value ) { #>
							<# } else { #>
								<option value="{{ key }}">{{ data.choices[ key ] }}</option>
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
}
