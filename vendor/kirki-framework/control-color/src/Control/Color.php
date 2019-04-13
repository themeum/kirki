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
	 * @access public
	 * @since 1.0.2
	 * @var string
	 */
	public static $control_ver = '1.0.7';

	/**
	 * Colorpicker palette
	 *
	 * @access public
	 * @since 1.0
	 * @var array|bool
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

		// Enqueue iro.
		wp_enqueue_script( 'iro', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/iro.js' ), [], '4.3.1', true );
		wp_enqueue_script( 'iro-transparency-plugin', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/iro-transparency-plugin.js' ), [ 'iro' ], '1.0.2', true );

		// Enqueue the control script.
		wp_enqueue_script( 'kirki-control-color', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'customize-controls', 'iro', 'iro-transparency-plugin', 'kirki-dynamic-control' ], self::$control_ver, false );
		global $_wp_theme_features;

		// Enqueue the control style.
		wp_enqueue_style( 'kirki-control-color-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
	}

	/**
	 * Get the URL for the control folder.
	 *
	 * This is a static method because there are more controls in the Kirki framework
	 * that use colorpickers, and they all need to enqueue the same assets.
	 *
	 * @static
	 * @access public
	 * @since 1.0.6
	 * @return string
	 */
	public static function get_control_path_url() {
		return URL::get_from_path( dirname( __DIR__ ) );
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
		$this->json['choices']['i18n']  = [
			'default' => esc_html__( 'Default', 'kirki' ),
			'clear'   => esc_html__( 'Clear', 'kirki' ),
		];
		$this->json['defaultPalette'] = [ '#f78da7', '#cf2e2e', '#ff6900', '#fcb900', '#7bdcb5', '#00d084', '#8ed1fc', '#0693e3', '#eee', '#abb8c3', '#313131' ];
	}
}
