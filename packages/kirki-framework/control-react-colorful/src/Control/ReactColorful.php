<?php
/**
 * Customizer Control: kirki-react-colorful.
 *
 * @package   kirki-framework/control-react-colorful
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
 * The react-colorful control.
 *
 * @since 1.0
 */
class ReactColorful extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-react-colorful';

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
	 * The color mode.
	 *
	 * Used by 'mode' => 'alpha' argument.
	 *
	 * @access public
	 * @var string
	 */
	public $mode = '';

	/**
	 * Whether control has small gap or not.
	 *
	 * Used by field-multicolor.
	 *
	 * @access public
	 * @var bool
	 */
	public $has_small_gap = false;

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
		wp_enqueue_script( 'kirki-control-react-colorful', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/control.js' ), [ 'customize-controls', 'wp-element', 'jquery', 'customize-base', 'kirki-dynamic-control' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-react-colorful-style', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/control.css' ), [], self::$control_ver );

	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 *
	 * @since 3.4.0
	 */
	public function render() {
		$id     = 'customize-control-' . str_replace( [ '[', ']' ], [ '-', '' ], $this->id );
		$class  = 'customize-control customize-control-' . $this->type;
		$class .= property_exists( $this, 'has_small_gap' ) && $this->has_small_gap ? ' has-small-gap' : '';

		printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
		$this->render_content();
		echo '</li>';
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

		// Mode.
		$this->json['mode'] = $this->mode;

		// Color swatches.
		$this->json['choices']['swatches'] = $this->color_swatches();

		// Trigger style.
		$this->json['choices']['triggerStyle'] = isset( $this->json['choices']['triggerStyle'] ) ? $this->json['choices']['triggerStyle'] : 'input';

		// Trigger style.
		$this->json['choices']['buttonText'] = isset( $this->json['choices']['buttonText'] ) ? $this->json['choices']['buttonText'] : '';

	}

	/**
	 * Get color swatches values.
	 *
	 * @return array The color swatches values.
	 */
	public function color_swatches() {

		$default_swatches = [
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		];

		$default_swatches = apply_filters( 'kirki_default_color_swatches', $default_swatches );

		if ( isset( $this->choices['swatches'] ) && ! empty( $this->choices['swatches'] ) ) {
			$swatches = $this->choices['swatches'];

			$total_swatches = count( $swatches );

			if ( $total_swatches < 8 ) {
				for ( $i = $total_swatches; $i <= 8; $i++ ) {
					$swatches[] = $total_swatches[ $i ];
				}
			}
		} else {
			$swatches = $default_swatches;
		}

		$swatches = apply_filters( 'kirki_color_swatches', $swatches );

		return $swatches;

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
