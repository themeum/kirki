<?php
/**
 * Customizer Controls Base.
 *
 * Extend this in other controls.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.12
 */

namespace Kirki\Control;

use Kirki\Core\Kirki;

/**
 * A base for controls.
 */
class Base extends \WP_Customize_Control {

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * Option name (if using options).
	 *
	 * @access public
	 * @var string
	 */
	public $option_name = false;

	/**
	 * The kirki_config we're using for this control
	 *
	 * @access public
	 * @var string
	 */
	public $kirki_config = 'global';

	/**
	 * Whitelisting the "required" argument.
	 *
	 * @since 3.0.17
	 * @access public
	 * @var array
	 */
	public $required = array();

	/**
	 * Whitelisting the "preset" argument.
	 *
	 * @since 3.0.26
	 * @access public
	 * @var array
	 */
	public $preset = array();

	/**
	 * Whitelisting the "css_vars" argument.
	 *
	 * @since 3.0.28
	 * @access public
	 * @var string
	 */
	public $css_vars = '';

	/**
	 * Extra script dependencies.
	 *
	 * @since 3.1.0
	 * @return array
	 */
	public function kirki_script_dependencies() {
		return array();
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		// The Kirki plugin URL.
		$kirki_url = trailingslashit( Kirki::$url );

		$url = apply_filters(
			'kirki_package_url_control_base',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-base/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-setting',
			"$url/assets/scripts/kirki.setting.js",
			[
				'jquery',
				'customize-base',
			],
			KIRKI_VERSION,
			false
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-dynamic-control',
			"$url/assets/scripts/dynamic-control.js",
			[
				'jquery',
				'customize-base',
				'kirki-setting',
			],
			KIRKI_VERSION,
			false
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {

		// Get the basics from the parent class.
		parent::to_json();

		// Default value.
		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		// Required.
		$this->json['required'] = $this->required;

		// Output.
		$this->json['output'] = $this->output;

		// Value.
		$this->json['value'] = $this->value();

		// Choices.
		$this->json['choices'] = $this->choices;

		// The link.
		$this->json['link'] = $this->get_link();

		// The ID.
		$this->json['id'] = $this->id;

		// Translation strings.
		$this->json['l10n'] = $this->l10n();

		// The ajaxurl in case we need it.
		$this->json['ajaxurl'] = admin_url( 'admin-ajax.php' );

		// Input attributes.
		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

		// The kirki-config.
		$this->json['kirkiConfig'] = $this->kirki_config;

		// The option-type.
		$this->json['kirkiOptionType'] = $this->option_type;

		// The option-name.
		$this->json['kirkiOptionName'] = $this->option_name;

		// The preset.
		$this->json['preset'] = $this->preset;

		// The CSS-Variables.
		$this->json['css-var'] = $this->css_vars;
	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 *
	 * @since 3.4.0
	 */
	protected function render_content() {}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @return array
	 */
	protected function l10n() {
		return array();
	}
}
