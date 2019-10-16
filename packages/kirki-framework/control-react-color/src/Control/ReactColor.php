<?php
/**
 * Customizer Control: kirki-react-color.
 *
 * @package   kirki-framework/control-react-color
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * React-color control.
 *
 * @since 1.0
 */
class ReactColor extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-react-color';

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
		wp_enqueue_script( 'kirki-control-react-color', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/main.js' ), [ 'customize-controls', 'wp-element', 'jquery', 'customize-base', 'kirki-dynamic-control' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-react-color-style', URL::get_from_path( dirname( __DIR__ ) . '/style.css' ), [], self::$control_ver );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 * @since 1.0
	 * @see WP_Customize_Control::to_json()
	 * @return void
	 */
	public function to_json() {

		// Get the basics from the parent class.
		parent::to_json();

		if ( ! isset( $this->json['choices']['formComponent'] ) ) {
			$this->json['choices']['formComponent'] = 'ChromePicker';
		}
		if ( isset( $this->json['choices']['alpha'] ) && false === $this->json['choices']['alpha'] ) {
			$this->json['choices']['disableAlpha'] = true;
		}
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
