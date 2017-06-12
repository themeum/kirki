<?php
/**
 * Customizer Control: gradient.
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
 * Adds a gradients control.
 *
 * @uses https://github.com/23r9i0/wp-color-picker-alpha
 */
class Kirki_Control_Gradient extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-gradient';

	/**
	 * Colorpicker palette
	 *
	 * @access public
	 * @var bool
	 */
	public $palette = true;

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
	 * The kirki_config we're using for this control
	 *
	 * @access public
	 * @var string
	 */
	public $kirki_config = 'global';

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
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
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

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

		$this->json['palette']  = $this->palette;
		$this->choices['alpha'] = ( isset( $this->choices['alpha'] ) && $this->choices['alpha'] ) ? 'true' : 'false';
		$this->json['l10n']     = $this->l10n();
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue_scripts() {

		Kirki_Custom_Build::register_dependency( 'jquery' );
		Kirki_Custom_Build::register_dependency( 'customize-base' );
		Kirki_Custom_Build::register_dependency( 'wp-color-picker-alpha' );

		wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2', true );

		if ( ! Kirki_Custom_Build::is_custom_build() ) {
			wp_enqueue_script( 'kirki-gradient', trailingslashit( Kirki::$url ) . 'controls/gradient/gradient.js', array( 'jquery', 'customize-base', 'wp-color-picker-alpha' ), false, true );
			wp_enqueue_style( 'kirki-gradient-css', trailingslashit( Kirki::$url ) . 'controls/gradient/gradient.css', null );
		}
		wp_enqueue_style( 'wp-color-picker' );
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
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="gradient-preview"></div>
		<div class="angle">
			<h4>{{ data.l10n.angle }}</h4>
			<input type="range" class="angle gradient-{{ data.id }}" value="{{ data.value.angle }}" min="-90" max="90">
		</div>
		<div class="colors">
			<# _.each( ['start', 'end'], function( index ) { #>
				<div class="color-{{ index }}">
					<h4>{{ data.l10n[ index + 'color' ] }}</h4>
					<input type="text" {{{ data.inputAttrs }}} data-palette="{{ data.palette }}" data-default-color="{{ data.default[ index ].color }}" data-alpha="{{ data.choices['alpha'] }}" value="{{ data.value[ index ].color }}" class="kirki-gradient-control-{{ index }} color-picker" />
					<h4>{{ data.l10n['color_stop'] }}</h4>
					<input type="range" class="position gradient-{{ data.id }}-{{ index }}" value="{{ data.value[ index ].position }}" min="0" max="100">
				</div>
			<# }) #>
		</div>
		<?php
	}
	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @return string
	 */
	protected function l10n() {
		$translation_strings = array(
			'angle'      => esc_attr__( 'Angle', 'kirki' ),
			'startcolor' => esc_attr__( 'Start Color', 'kirki' ),
			'endcolor'   => esc_attr__( 'End Color', 'kirki' ),
			'color_stop' => esc_attr__( 'Color Stop', 'kirki' ),
			'linear'     => esc_attr__( 'Linear', 'kirki' ),
			'radia'      => esc_attr__( 'Radial', 'kirki' ),
		);
		$translation_strings = apply_filters( "kirki/{$this->kirki_config}/l10n", $translation_strings );
		return $translation_strings;
	}
}
