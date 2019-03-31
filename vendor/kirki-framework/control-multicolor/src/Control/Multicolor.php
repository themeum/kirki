<?php
/**
 * Customizer Control: multicolor.
 *
 * @package   kirki-framework/control-multicolor
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\Control\Color;
use Kirki\URL;

/**
 * Multicolor control.
 *
 * @since 1.0
 */
class Multicolor extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-multicolor';

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access private
	 * @since 1.0
	 * @var string
	 */
	private static $control_ver = '1.0';

	/**
	 * Enable/Disable Alpha channel on color pickers
	 *
	 * @access public
	 * @since 1.0
	 * @var boolean
	 */
	public $alpha = true;

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		// Enqueue colorpicker.
		wp_enqueue_script( 'wp-color-picker-alpha', Color::get_control_path_url() . '/assets/scripts/wp-color-picker-alpha.js', [ 'wp-color-picker' ], Color::$control_ver, true );
		wp_enqueue_style( 'wp-color-picker' );

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-color', Color::get_control_path_url() . '/assets/scripts/control.js', [ 'jquery', 'customize-base', 'wp-color-picker-alpha', 'kirki-dynamic-control' ], Color::$control_ver, false );

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-multicolor', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-multicolor-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['alpha'] = (bool) $this->alpha;
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function content_template() {
		?>
		<span class="customize-control-title">
			{{{ data.label }}}
		</span>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="multicolor-group-wrapper">
			<# for ( key in data.choices ) { #>
				<# if ( 'irisArgs' !== key ) { #>
					<div class="multicolor-single-color-wrapper">
						<input {{{ data.inputAttrs }}} id="{{ data.id }}-{{ key }}" type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default[ key ] }}" data-alpha="{{ data.alpha }}" value="{{ data.value[ key ] }}" class="kirki-color-control color-picker multicolor-index-{{ key }}" data-label="<# if ( data.choices[ key ] ) { #>{{ data.choices[ key ] }}<# } else { #>{{ key }}<# } #>" />
					</div>
				<# } #>
			<# } #>
		</div>
		<input class="multicolor-hidden-value" type="hidden" {{{ data.link }}}>
		<?php
	}
}
