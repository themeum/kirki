<?php
/**
 * The default section.
 * Inspired from https://github.com/justintadlock/trt-customizer-pro
 *
 * @package    Kirki
 * @subpackage Custom Sections Module
 * @copyright  Copyright (c) 2020, David Vongries
 * @license    https://opensource.org/licenses/MIT
 * @since      3.0.36
 */

/**
 * Link Section.
 */
class Kirki_Sections_Link_Section extends WP_Customize_Section {

	/**
	 * The section type.
	 *
	 * @since 3.0.36
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-link';

	/**
	 * Button Text
	 *
	 * @since  3.0.36
	 * @access public
	 * @var string
	 */
	public $button_text = '';

	/**
	 * Button URL.
	 *
	 * @since  3.0.36
	 * @access public
	 * @var string
	 */
	public $button_url = '';

	/**
	 * Gather the parameters passed to client JavaScript via JSON.
	 *
	 * @access public
	 * @since 3.0.36
	 * @return array The array to be exported to the client as JSON.
	 */
	public function json() {
		$json = parent::json();

		$json['button_text'] = $this->button_text;
		$json['button_url']  = esc_url( $this->button_url );

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  3.0.36
	 * @access public
	 * @return void
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				{{ data.title }}
				<a href="{{ data.button_url }}" class="button alignright" target="_blank" rel="nofollow">{{ data.button_text }}</a>
			</h3>
		</li>
		<?php
	}
}
