<?php
/**
 * An expanded panel.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'Kirki_Panels_Expanded_Panel' ) ) {

	/**
	 * Expanded Panel.
	 */
	class Kirki_Panels_Expanded_Panel extends WP_Customize_Panel {

		/**
		 * The panel type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-expanded';

		/**
		 * An Underscore (JS) template for rendering this panel's container.
		 * Class variables for this panel class are available in the `data` JS object;
		 * export custom variables by overriding WP_Customize_Panel::json().
		 *
		 * @see WP_Customize_Panel::print_template()
		 * @access protected
		 */
		protected function render_template() {
			?>
			<li id="accordion-panel-{{ data.id }}" class="control-section control-panel control-panel-{{ data.type }}">
				<ul class="accordion-sub-container control-panel-content"></ul>
			</li>
			<?php
		}

		/**
		 * An Underscore (JS) template for this panel's content (but not its container).
		 * Class variables for this panel class are available in the `data` JS object;
		 * export custom variables by overriding WP_Customize_Panel::json().
		 *
		 * @see WP_Customize_Panel::print_template()
		 * @access protected
		 */
		protected function content_template() {
			?>
			<li class="panel-meta customize-info accordion-section <# if ( ! data.description ) { #> cannot-expand<# } #>">
				<div class="accordion-section-title">
					<strong class="panel-title">{{ data.title }}</strong>
				</div>
				<# if ( data.description ) { #>
					<div class="description customize-panel-description">
						{{{ data.description }}}
					</div>
				<# } #>
			</li>
			<?php
		}
	}
}
