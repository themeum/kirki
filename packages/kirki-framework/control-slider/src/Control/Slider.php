<?php
/**
 * Customizer Control: slider.
 *
 * Creates a slider control.
 *
 * @package   kirki-framework/control-slider
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Slider control (range).
 *
 * @since 1.0
 */
class Slider extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-slider';

	/**
	 * The control version.
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
		wp_enqueue_script(
			'kirki-control-react-range',
			URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/main.js' ),
			[
				'customize-controls',
				'customize-base',
				'wp-element',
				'wp-compose',
				'wp-components',
				'jquery',
				'wp-i18n',
			],
			time(),
			false
		);

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-react-range-style', URL::get_from_path( dirname( __DIR__ ) . '/style.css' ), [], self::$control_ver );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['choices'] = wp_parse_args(
			$this->json['choices'],
			[
				'min'    => '0',
				'max'    => '100',
				'step'   => '1',
				'suffix' => '',
			]
		);
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
	protected function content_template() {}
}
