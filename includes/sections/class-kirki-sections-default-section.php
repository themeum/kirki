<?php
/**
 * The default section.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.0
 */

if ( ! class_exists( 'Kirki_Sections_Default_Section' ) ) {

	/**
	 * Default Section.
	 */
	class Kirki_Sections_Default_Section extends WP_Customize_Section {

		/**
		 * The section type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-default';

		/**
		 * Gather the parameters passed to client JavaScript via JSON.
		 *
		 * @since 2.3.3
		 *
		 * @return array The array to be exported to the client as JSON.
		 */
		public function json() {
			$array = parent::json();
			$array['description'] = html_entity_decode( $array['description'], ENT_QUOTES, get_bloginfo( 'charset' ) );
			return $array;
		}

		/**
		 * An Underscore (JS) template for rendering this section.
		 *
		 * Class variables for this section class are available in the `data` JS object;
		 * export custom variables by overriding WP_Customize_Section::json().
		 *
		 * @access protected
		 */
		protected function render_template() {
			$l10n = Kirki_l10n::get_strings();
			?>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
				<h3 class="accordion-section-title" tabindex="0">
					{{{ data.title }}}
					<span class="screen-reader-text">{{ window.kirki.l10n.global['open-section'] }}</span>
				</h3>
				<ul class="accordion-section-content">
					<li class="customize-section-description-container">
						<div class="customize-section-title">
							<button class="customize-section-back" tabindex="-1">
								<span class="screen-reader-text">{{ window.kirki.l10n.global.back }}</span>
							</button>
							<h3>
								<span class="customize-action">
									{{{ data.customizeAction }}}
								</span>
								{{{ data.title }}}
								<a href="#" class="kirki-reset-section" data-reset-section-id="{{ data.id }}">
									{{{ window.kirki.l10n.global['reset-with-icon'] }}}
								</a>
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
