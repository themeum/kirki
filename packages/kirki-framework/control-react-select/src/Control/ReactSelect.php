<?php
/**
 * Customizer Control: kirki-select.
 *
 * @package   kirki-framework/control-select
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Select control.
 *
 * @since 1.0
 */
class ReactSelect extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-react-select';

	/**
	 * Placeholder text.
	 *
	 * @access public
	 * @since 1.0
	 * @var string|false
	 */
	public $placeholder = false;

	/**
	 * Whether the select should be clearable or not.
	 *
	 * @link https://react-select.com/props#select-props
	 * @since 0.3.0
	 * @var bool
	 */
	public $isClearable = false;

	/**
	 * whether this is a multi-select or not.
	 *
	 * @access public
	 * @since 1.0
	 * @var bool
	 */
	public $multiple = false;

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public static $control_ver = '1.1';

	/**
	 * Whitelist the "select_args" argument.
	 *
	 * The arguments here will be passed-on to select2.
	 *
	 * @see https://select2.org/
	 * @access protected
	 * @since 1.1
	 * @var string|array
	 */
	protected $select_args;

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
			'kirki-control-select',
			URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/control.js' ),
			[
				'customize-controls',
				'customize-base',
				'wp-element',
				'wp-compose',
				'wp-components',
				'jquery',
				'wp-i18n',
				'kirki-control-base',
			],
			time(),
			false
		);

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-select-style', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/control.css' ), [], self::$control_ver );
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
	 * @see WP_Customize_Control::to_json()
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		if ( isset( $this->json['label'] ) ) {
			$this->json['label'] = html_entity_decode( $this->json['label'] );
		}

		if ( isset( $this->json['description'] ) ) {
			$this->json['description'] = html_entity_decode( $this->json['description'] );
		}

		$this->json['isClearable'] = $this->isClearable;

		// Backwards-compatibility: The "multiple" argument used to be a number of maximum options users can select.
		// That was based on select2. Since we switched to react-select this option is a boolean so we need to convert it.
		switch ( $this->multiple ) {
			case true:
			case false:
				$this->json['multiple'] = $this->multiple; // Already a bool.
				break;
			case 0:
			case '0':
				$this->json['multiple'] = true; // 0 used to be infinite.
				break;
			case 1:
			case '1':
				$this->json['multiple'] = false; // Single option.
				break;
			case ( is_numeric( $this->multiple ) && 1 < $this->multiple ):
				$this->json['multiple'] = true; // More than 1 options.
				break;
			default:
				$this->multiple = false;
		}

		$this->json['placeholder'] = ( $this->placeholder ) ? $this->placeholder : esc_html__( 'Select...', 'kirki' );
		$this->json['select_args'] = $this->select_args;
	}
}
