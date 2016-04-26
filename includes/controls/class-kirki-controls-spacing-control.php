<?php
/**
 * Customizer Control: spacing.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Spacing_Control' ) ) {

	/**
	 * Spacing control.
	 * multiple checkboxes with CSS units validation.
	 */
	class Kirki_Controls_Spacing_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-spacing';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			parent::to_json();
			$this->json['choices'] = array();
			if ( is_array( $this->choices ) ) {
				foreach ( $this->choices as $choice => $value ) {
					if ( true === $value ) {
						$this->json['choices'][ $choice ] = true;
					}
				}
			}

			if ( is_array( $this->json['default'] ) ) {
				foreach ( $this->json['default'] as $key => $value ) {
					if ( isset( $this->json['choices'][ $key ] ) && ! isset( $this->json['value'][ $key ] ) ) {
						$this->json['value'][ $key ] = $value;
					}
				}
			}
		}

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-spacing' );
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
				<div class="wrapper">
					<div class="control">
						<# for ( choiceKey in data.default ) { #>
							<div class="{{ choiceKey }}">
								<h5>{{ data.i18n[ choiceKey ] }}</h5>
								<div class="{{ choiceKey }} input-wrapper">
									<input type="text" value="{{ data.value[ choiceKey ] }}"/>
									<span class="invalid-value">{{ data.i18n['invalid-value'] }}</span>
								</div>
							</div>
						<# } #>
					</div>
				</div>
			</label>
			<?php
		}
	}
}
