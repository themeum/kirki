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
class Select extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-select';

	/**
	 * Placeholder text.
	 *
	 * @access public
	 * @since 1.0
	 * @var string|false
	 */
	public $placeholder = false;

	/**
	 * Maximum number of options the user will be able to select.
	 * Set to 1 for single-select.
	 *
	 * @access public
	 * @since 1.0
	 * @var int
	 */
	public $multiple = 1;

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

		// Enqueue selectWoo.
		wp_enqueue_script( 'selectWoo', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/selectWoo/js/selectWoo.full.js' ), [ 'jquery' ], '1.0.1', true );
		wp_enqueue_style( 'selectWoo', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/selectWoo/css/selectWoo.css' ), [], '1.0.1' );

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-select', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'selectWoo' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-select-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
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
		$this->json['multiple']    = $this->multiple;
		$this->json['placeholder'] = $this->placeholder;
		$this->json['select_args'] = $this->select_args;
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
	 * @since 1.1
	 * @return void
	 */
	protected function content_template() {
		?>
		<label>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<select data-id="{{ data.id }}" {{{ data.inputAttrs }}} <# if ( 1 < data.multiple ) { #>data-multiple="{{ data.multiple }}" multiple="multiple"<# } #>>
				<# if ( data.placeholder ) { #>
					<option value=""<# if ( '' === data.value ) { #> selected<# } #>></option>
				<# } #>
				<# _.each( data.choices, function( optionLabel, optionKey ) { #>
					<# selected = ( 1 < data.multiple && data.value ) ? _.contains( data.value, optionKey ) : ( data.value === optionKey ); #>
					<# if ( _.isObject( optionLabel ) ) { #>
						<optgroup label="{{ optionLabel[0] }}">
							<# _.each( optionLabel[1], function( optgroupOptionLabel, optgroupOptionKey ) { #>
								<# selected = ( 1 < data.multiple && data.value ) ? _.contains( data.value, optgroupOptionKey ) : ( data.value === optgroupOptionKey ); #>
								<option value="{{ optgroupOptionKey }}"<# if ( selected ) { #> selected<# } #>>{{{ optgroupOptionLabel }}}</option>
							<# } ); #>
						</optgroup>
					<# } else { #>
						<option value="{{ optionKey }}"<# if ( selected ) { #> selected<# } #>>{{{ optionLabel }}}</option>
					<# } #>
				<# } ); #>
			</select>
		</label>
		<?php
	}
}
