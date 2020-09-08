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
		wp_enqueue_style( 'kirki-control-select-style', URL::get_from_path( dirname( __DIR__ ) . '/style.css' ), [], self::$control_ver );
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
