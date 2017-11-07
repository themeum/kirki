<?php
/**
 * Customizer Control: color.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds a color & color-alpha control
 *
 * @see https://github.com/23r9i0/wp-color-picker-alpha
 */
class Kirki_Control_Color extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-color';

	/**
	 * Colorpicker palette
	 *
	 * @access public
	 * @var bool
	 */
	public $palette = true;

	/**
	 * Mode.
	 *
	 * @since 3.0.12
	 * @var string
	 */
	public $mode = 'full';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();

		$this->json['palette'] = $this->palette;
		$this->json['choices']['alpha'] = ( isset( $this->choices['alpha'] ) && $this->choices['alpha'] ) ? 'true' : 'false';
		$this->json['mode'] = $this->mode;
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
	 */
	protected function content_template() {
		?>
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<input type="text" data-type="{{{ data.mode }}}" {{{ data.inputAttrs }}} data-palette="{{ data.palette }}" data-default-color="{{ data.default }}" data-alpha="{{ data.choices['alpha'] }}" value="{{ data.value }}" class="kirki-color-control" {{{ data.link }}} />
		<?php
	}
}
