<?php
/**
 * Hover sections.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'Kirki_Sections_Hover_Section' ) ) {

	/**
	 * Hover Section.
	 */
	class Kirki_Sections_Hover_Section extends Kirki_Sections_Default_Section {

		/**
		 * The section type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-hover';

		/**
		 * An Underscore (JS) template for rendering this section.
		 *
		 * Class variables for this section class are available in the `data` JS object;
		 * export custom variables by overriding WP_Customize_Section::json().
		 *
		 * @access protected
		 */
		protected function render_template() {
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
				<h3 class="accordion-section-title" tabindex="0">
					{{ data.title }}
					<span class="screen-reader-text"><?php esc_html_e( 'Press return or enter to open this section', 'kirki' ); ?></span>
				</h3>
				<ul class="accordion-section-content">
					<li class="customize-section-description-container">
						<div class="customize-section-title">
							<button class="customize-section-back" tabindex="-1">
								<span class="screen-reader-text"><?php esc_html_e( 'Back', 'kirki' ); ?></span>
							</button>
							<h3>
								<span class="customize-action">
									{{{ data.customizeAction }}}
								</span>
								{{ data.title }}
							</h3>
						</div>
						<# if ( data.description ) { #>
							<div class="description customize-section-description">
								{{{ data.description }}}
							</div>
						<# } #>
					</li>
				</ul>
			</li>
			<?php
		}
	}
}
