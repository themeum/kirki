<?php
/**
 * Customizer Control: dropdown-pages.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.8
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Dropdown_Pages_Control' ) ) {

	/**
	 * A copy of WordPress core's "dropdown-pages" control.
	 * The template has been converted to use Underscore.js
	 * and we added a tooltip.
	 */
	class Kirki_Controls_Dropdown_Pages_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-dropdown-pages';

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-dropdown-pages' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			parent::to_json();
			$l10n = Kirki_l10n::get_strings( $this->kirki_config );
			$dropdown = wp_dropdown_pages(
				array(
					'name'              => '_customize-dropdown-pages-' . esc_attr( $this->id ),
					'echo'              => 0,
					'show_option_none'  => esc_attr( $l10n['select-page'] ),
					'option_none_value' => '0',
					'selected'          => esc_attr( $this->value() ),
				)
			);

			// Hackily add in the data link parameter.
			$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

			$this->json['dropdown'] = $dropdown;
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
				<div class="customize-control-content">{{{ data.dropdown }}}</div>
			</label>
			<?php
		}
	}
}
