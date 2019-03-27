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
	 * Has the control already been whitelisted for JS-templating?
	 *
	 * @static
	 * @access private
	 * @since 1.0.1
	 * @var bool
	 */
	private static $js_templating_whitelisted = false;

	/**
	 * Have the assets already been enqueued?
	 *
	 * @static
	 * @access private
	 * @since 1.0.1
	 * @var bool
	 */
	private static $assets_already_enqueued = false;

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * @since 1.0
	 * @see WP_Customize_Manager
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    The arguments.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		if ( ! self::$js_templating_whitelisted ) {
			$manager->register_control_type( '\Kirki\Control\Color' );
			self::$js_templating_whitelisted = true;
		}
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		if ( ! self::$assets_already_enqueued ) {
			// Add view.
			add_action(
				'customize_controls_print_footer_scripts',
				function() {
					echo '<script type="text/html" id="tmpl-kirki-input-color">';
					include apply_filters( 'kirki_control_view_color', __DIR__ . '/view.php' );
					echo '</script>';
				}
			);

			// Enqueue the colorpicker.
			$url = new URL( dirname( __DIR__ ) . '/assets/scripts/wp-color-picker-alpha.js' );
			wp_enqueue_script( 'wp-color-picker-alpha', $url->get_url(), [ 'wp-color-picker' ], '4.0', true );
			wp_enqueue_style( 'wp-color-picker' );

			// Enqueue the control script.
			$url = new URL( dirname( __DIR__ ) . '/assets/scripts/control.js' );
			wp_enqueue_script( 'kirki-control-color', $url->get_url(), [ 'jquery', 'customize-base', 'customize-controls', 'wp-color-picker-alpha', 'kirki-dynamic-control' ], '4.0', false );

			// Enqueue the control style.
			$url = new URL( dirname( __DIR__ ) . '/assets/styles/style.css' );
			wp_enqueue_style( 'kirki-control-color-style', $url->get_url(), [], '4.0' );

			self::$assets_already_enqueued = true;
		}
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
