<?php
/**
 * Customizer Control: color.
 *
 * @package   kirki-framework/control-color
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\Core\Kirki;
use Kirki\URL;

/**
 * Adds a color & color-alpha control
 *
 * @since 1.0
 */
class Color extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-color';

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access private
	 * @since 1.0.2
	 */
	private static $control_ver = '1.0.2';

	/**
	 * Colorpicker palette
	 *
	 * @access public
	 * @since 1.0
	 * @var bool
	 */
	public $palette = true;

	/**
	 * Mode.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $mode = 'full';

	/**
	 * Has the template already been added?
	 *
	 * @static
	 * @access private
	 * @since 1.0.1
	 * @var bool
	 */
	private static $template_added = false;

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		if ( ! self::$template_added ) {
			// Add view.
			add_action(
				'customize_controls_print_footer_scripts',
				function() {
					echo '<script type="text/html" id="tmpl-kirki-input-color">';
					include apply_filters( 'kirki_control_view_color', __DIR__ . '/view.php' );
					echo '</script>';
				}
			);
			self::$template_added = true;
		}

		// Enqueue the colorpicker.
		wp_enqueue_script( 'wp-color-picker-alpha', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/wp-color-picker-alpha.js' ), [ 'wp-color-picker' ], self::$control_ver, true );
		wp_enqueue_style( 'wp-color-picker' );

		// Enqueue the control script.
		wp_enqueue_script( 'kirki-control-color', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'customize-controls', 'wp-color-picker-alpha', 'kirki-dynamic-control' ], self::$control_ver, false );

		// Enqueue the control style.
		wp_enqueue_style( 'kirki-control-color-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
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

		$this->json['palette']          = $this->palette;
		$this->json['choices']['alpha'] = ( isset( $this->choices['alpha'] ) && $this->choices['alpha'] ) ? 'true' : 'false';
		$this->json['mode']             = $this->mode;
	}
}
