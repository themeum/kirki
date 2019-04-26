<?php
/**
 * Customizer Control: kirki-date.
 *
 * @package   kirki-framework/control-date
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\URL;
use Kirki\Control\Base;

/**
 * A simple date control, using jQuery UI.
 *
 * @since 1.0
 */
class Date extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-date';

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public static $control_ver = '1.0';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-date', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'kirki-dynamic-control', 'jquery-ui-datepicker' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-date-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
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
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="customize-control-content">
				<input {{{ data.inputAttrs }}} class="datepicker" type="text" id="{{ data.id }}" value="{{ data.value }}" {{{ data.link }}} />
			</div>
		</label>
		<?php
	}
}
