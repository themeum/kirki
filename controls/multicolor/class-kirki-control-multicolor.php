<?php
/**
 * Customizer Control: multicolor.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Multicolor control.
 */
class Kirki_Control_Multicolor extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-multicolor';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * Enable/Disable Alpha channel on color pickers
	 *
	 * @access public
	 * @var boolean
	 */
	public $alpha = true;

	/**
	 * Constructor.
	 *
	 * Supplied `$args` override class property defaults.
	 *
	 * If `$args['settings']` is not defined, use the $id as the setting ID.
	 *
	 * @since 3.0.0
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    {
	 *     Optional. Arguments to override class property defaults.
	 *
	 *     @type int                  $instance_number Order in which this instance was created in relation
	 *                                                 to other instances.
	 *     @type WP_Customize_Manager $manager         Customizer bootstrap instance.
	 *     @type string               $id              Control ID.
	 *     @type array                $settings        All settings tied to the control. If undefined, `$id` will
	 *                                                 be used.
	 *     @type string               $setting         The primary setting for the control (if there is one).
	 *                                                 Default 'default'.
	 *     @type int                  $priority        Order priority to load the control. Default 10.
	 *     @type string               $section         Section the control belongs to. Default empty.
	 *     @type string               $label           Label for the control. Default empty.
	 *     @type string               $description     Description for the control. Default empty.
	 *     @type array                $choices         List of choices for 'radio' or 'select' type controls, where
	 *                                                 values are the keys, and labels are the values.
	 *                                                 Default empty array.
	 *     @type boolean              $alpha           Enables/Disables alpha channel on color pickers
	 *     @type array                $input_attrs     List of custom input attributes for control output, where
	 *                                                 attribute names are the keys and values are the values. Not
	 *                                                 used for 'checkbox', 'radio', 'select', 'textarea', or
	 *                                                 'dropdown-pages' control types. Default empty array.
	 *     @type array                $json            Deprecated. Use WP_Customize_Control::json() instead.
	 *     @type string               $type            Control type. Core controls include 'text', 'checkbox',
	 *                                                 'textarea', 'radio', 'select', and 'dropdown-pages'. Additional
	 *                                                 input types such as 'email', 'url', 'number', 'hidden', and
	 *                                                 'date' are supported implicitly. Default 'text'.
	 * }
	 */
	public function __construct( $manager, $id, $args = array() ) {

		parent::__construct( $manager, $id, $args );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999 );

	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2', true );
		wp_enqueue_script( 'kirki-multicolor', trailingslashit( Kirki::$url ) . 'controls/multicolor/multicolor.js', array( 'jquery', 'customize-base', 'wp-color-picker-alpha' ), false, true );
		wp_enqueue_style( 'kirki-multicolor-css', trailingslashit( Kirki::$url ) . 'controls/multicolor/multicolor.css', null );
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['output']  = $this->output;
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;
		$this->json['alpha']   = $this->alpha;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
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
	 */
	protected function content_template() {
		?>
		<div class="kirki-controls-loading-spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
		<span class="customize-control-title">
			{{{ data.label }}}
		</span>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="multicolor-group-wrapper">
			<# for ( key in data.choices ) { #>
				<# if ( 'irisArgs' !== key ) { #>
					<div class="multicolor-single-color-wrapper">
						<# if ( data.choices[ key ] ) { #>
							<label for="{{ data.id }}-{{ key }}">{{ data.choices[ key ] }}</label>
						<# } #>
						<input {{{ data.inputAttrs }}} id="{{ data.id }}-{{ key }}" type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default[ key ] }}" data-alpha="{{ data.alpha }}" value="{{ data.value[ key ] }}" class="kirki-color-control color-picker multicolor-index-{{ key }}" />
					</div>
				<# } #>
			<# } #>
		</div>
		<div class="iris-target"></div>
		<input class="multicolor-hidden-value" type="hidden" value='{{{ JSON.stringify( data.value ) }}}' {{{ data.link }}}>
		<?php
	}

	/**
	 * Render the control's content.
	 *
	 * @see WP_Customize_Control::render_content()
	 */
	protected function render_content() {}
}
