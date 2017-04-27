<?php
/**
 * Customizer Control: typography.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Typography control.
 */
class Kirki_Control_Typography extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-typography';

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
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'select2', trailingslashit( Kirki::$url ) . 'assets/vendor/select2/js/select2.full.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'select2', trailingslashit( Kirki::$url ) . 'assets/vendor/select2/css/select2.min.css', null );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'controls/typography/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2', true );
		wp_enqueue_script( 'kirki-typography', trailingslashit( Kirki::$url ) . 'controls/typography/typography.js', array( 'jquery', 'customize-base', 'select2', 'wp-color-picker-alpha' ), false, true );

		// Add fonts to our JS objects.
		$google_fonts   = Kirki_Fonts::get_google_fonts();
		$standard_fonts = Kirki_Fonts::get_standard_fonts();
		$all_variants   = Kirki_Fonts::get_all_variants();
		$all_subsets    = Kirki_Fonts::get_google_font_subsets();

		$standard_fonts_final = array();
		foreach ( $standard_fonts as $font ) {
			$standard_fonts_final[] = array(
				'family'      => $font['stack'],
				'label'       => $font['label'],
				'subsets'     => array(),
				'is_standard' => true,
				'variants'    => array(
					array(
						'id'    => 'regular',
						'label' => $all_variants['regular'],
					),
					array(
						'id'    => 'italic',
						'label' => $all_variants['italic'],
					),
					array(
						'id'    => '700',
						'label' => $all_variants['700'],
					),
					array(
						'id'    => '700italic',
						'label' => $all_variants['700italic'],
					),
				),
			);
		}

		$google_fonts_final = array();
		foreach ( $google_fonts as $family => $args ) {
			$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
			$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
			$subsets  = ( isset( $args['subsets'] ) ) ? $args['subsets'] : array();

			$available_variants = array();
			foreach ( $variants as $variant ) {
				if ( array_key_exists( $variant, $all_variants ) ) {
					$available_variants[] = array(
						'id' => $variant,
						'label' => $all_variants[ $variant ],
					);
				}
			}

			$available_subsets = array();
			foreach ( $subsets as $subset ) {
				if ( array_key_exists( $subset, $all_subsets ) ) {
					$available_subsets[] = array(
						'id' => $subset,
						'label' => $all_subsets[ $subset ],
					);
				}
			}

			$google_fonts_final[] = array(
				'family'       => $family,
				'label'        => $label,
				'variants'     => $available_variants,
				'subsets'      => $available_subsets,
			);
		}
		$final = array(
			'standard' => $standard_fonts_final,
			'google'   => $google_fonts_final,
		);
		wp_localize_script( 'kirki-typography', 'kirkiAllFonts', $final );

		wp_enqueue_style( 'kirki-typography-css', trailingslashit( Kirki::$url ) . 'controls/typography/typography.css', null );

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
		$this->json['l10n']    = $this->l10n();

		if ( 'user_meta' === $this->option_type ) {
			$this->json['value'] = get_user_meta( get_current_user_id(), $this->id, true );
		}

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

		$this->add_values_backwards_compatibility();
		$defaults = array(
			'font-family'    => false,
			'font-size'      => false,
			'variant'        => false,
			'line-height'    => false,
			'letter-spacing' => false,
			'word-spacing'   => false,
			'color'          => false,
			'text-align'     => false,
		);
		$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );
		$this->json['show_variants'] = ( true === Kirki_Fonts_Google::$force_load_all_variants ) ? false : true;
		$this->json['show_subsets']  = ( true === Kirki_Fonts_Google::$force_load_all_subsets ) ? false : true;
		$this->json['languages'] = array(
			'cyrillic'     => 'Cyrillic',
			'cyrillic-ext' => 'Cyrillic Extended',
			'devanagari'   => 'Devanagari',
			'greek'        => 'Greek',
			'greek-ext'    => 'Greek Extended',
			'khmer'        => 'Khmer',
			'latin'        => 'Latin',
			'latin-ext'    => 'Latin Extended',
			'vietnamese'   => 'Vietnamese',
			'hebrew'       => 'Hebrew',
			'arabic'       => 'Arabic',
			'bengali'      => 'Bengali',
			'gujarati'     => 'Gujarati',
			'tamil'        => 'Tamil',
			'telugu'       => 'Telugu',
			'thai'         => 'Thai',
		);
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
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<div class="wrapper">

			<# if ( data.default['font-family'] ) { #>
				<# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
				<# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
				<div class="font-family">
					<h5>{{ data.l10n['font-family'] }}</h5>
					<select {{{ data.inputAttrs }}} id="kirki-typography-font-family-{{{ data.id }}}" placeholder="{{ data.l10n['select-font-family'] }}">
						<option value="{{ data.value['font-family'] }}" selected="selected">{{ data.value['font-family'] }}</option>
					</select>
				</div>
				<# if ( true === data.show_variants || false !== data.default.variant ) { #>
					<div class="variant hide-on-standard-fonts kirki-variant-wrapper">
						<h5>{{ data.l10n['variant'] }}</h5>
						<select {{{ data.inputAttrs }}} class="variant" id="kirki-typography-variant-{{{ data.id }}}"></select>
					</div>
				<# } #>
				<# if ( true === data.show_subsets ) { #>
					<div class="subsets hide-on-standard-fonts kirki-subsets-wrapper">
						<h5>{{ data.l10n['subsets'] }}</h5>
						<select {{{ data.inputAttrs }}} class="subset" id="kirki-typography-subsets-{{{ data.id }}}" multiple>
							<# _.each( data.value.subsets, function( subset ) { #>
								<option value="{{ subset }}" selected="selected">{{ data.languages[ subset ] }}</option>
							<# } ); #>
						</select>
					</div>
				<# } #>
			<# } #>

			<# if ( data.default['font-size'] ) { #>
				<div class="font-size">
					<h5>{{ data.l10n['font-size'] }}</h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['font-size'] }}"/>
				</div>
			<# } #>

			<# if ( data.default['line-height'] ) { #>
				<div class="line-height">
					<h5>{{ data.l10n['line-height'] }}</h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['line-height'] }}"/>
				</div>
			<# } #>

			<# if ( data.default['letter-spacing'] ) { #>
				<div class="letter-spacing">
					<h5>{{ data.l10n['letter-spacing'] }}</h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['letter-spacing'] }}"/>
				</div>
			<# } #>

			<# if ( data.default['word-spacing'] ) { #>
				<div class="word-spacing">
					<h5>{{ data.l10n['word-spacing'] }}</h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['word-spacing'] }}"/>
				</div>
			<# } #>

			<# if ( data.default['text-align'] ) { #>
				<div class="text-align">
					<h5>{{ data.l10n['text-align'] }}</h5>
					<input {{{ data.inputAttrs }}} type="radio" value="inherit" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-inherit" <# if ( data.value['text-align'] === 'inherit' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-inherit">
							<span class="dashicons dashicons-editor-removeformatting"></span>
							<span class="screen-reader-text">{{ data.l10n['inherit'] }}</span>
						</label>
					</input>
					<input {{{ data.inputAttrs }}} type="radio" value="left" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-left" <# if ( data.value['text-align'] === 'left' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-left">
							<span class="dashicons dashicons-editor-alignleft"></span>
							<span class="screen-reader-text">{{ data.l10n['left'] }}</span>
						</label>
					</input>
					<input {{{ data.inputAttrs }}} type="radio" value="center" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-center" <# if ( data.value['text-align'] === 'center' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-center">
							<span class="dashicons dashicons-editor-aligncenter"></span>
							<span class="screen-reader-text">{{ data.l10n['center'] }}</span>
						</label>
					</input>
					<input {{{ data.inputAttrs }}} type="radio" value="right" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-right" <# if ( data.value['text-align'] === 'right' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-right">
							<span class="dashicons dashicons-editor-alignright"></span>
							<span class="screen-reader-text">{{ data.l10n['right'] }}</span>
						</label>
					</input>
					<input {{{ data.inputAttrs }}} type="radio" value="justify" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-justify" <# if ( data.value['text-align'] === 'justify' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-justify">
							<span class="dashicons dashicons-editor-justify"></span>
							<span class="screen-reader-text">{{ data.l10n['justify'] }}</span>
						</label>
					</input>
				</div>
			<# } #>

			<# if ( data.default['text-transform'] ) { #>
				<div class="text-transform">
					<h5>{{ data.l10n['text-transform'] }}</h5>
					<select {{{ data.inputAttrs }}} id="kirki-typography-text-transform-{{{ data.id }}}">
						<option value="none"<# if ( 'none' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['none'] }}</option>
						<option value="capitalize"<# if ( 'capitalize' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['capitalize'] }}</option>
						<option value="uppercase"<# if ( 'uppercase' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['uppercase'] }}</option>
						<option value="lowercase"<# if ( 'lowercase' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['lowercase'] }}</option>
						<option value="initial"<# if ( 'initial' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['initial'] }}</option>
						<option value="inherit"<# if ( 'inherit' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['inherit'] }}</option>
					</select>
				</div>
			<# } #>

			<# if ( data.default['color'] ) { #>
				<div class="color">
					<h5>{{ data.l10n['color'] }}</h5>
					<input {{{ data.inputAttrs }}} type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="kirki-color-control color-picker" {{{ data.link }}} />
				</div>
			<# } #>
		</div>
		<?php
	}

	/**
	 * Adds backwards-compatibility for values.
	 * Converts font-weight to variant
	 * Adds units to letter-spacing
	 *
	 * @access protected
	 */
	protected function add_values_backwards_compatibility() {
		$value = $this->value();
		$old_values = array(
			'font-family'    => '',
			'font-size'      => '',
			'variant'        => ( isset( $value['font-weight'] ) ) ? $value['font-weight'] : 'regular',
			'line-height'    => '',
			'letter-spacing' => '',
			'color'          => '',
		);

		// Font-weight is now variant.
		// All values are the same with the exception of 400 (becomes regular).
		if ( '400' === $old_values['variant'] || 400 === $old_values['variant'] ) {
			$old_values['variant'] = 'regular';
		}

		if ( isset( $value['variant'] ) && in_array( $value['variant'], array( '100light', '600bold', '800bold', '900bold' ) ) ) {
			$value['variant'] = (string) intval( $value['variant'] );
		}

		// Letter spacing was in px, now it requires units.
		if ( isset( $value['letter-spacing'] ) && is_numeric( $value['letter-spacing'] ) && $value['letter-spacing'] ) {
			$value['letter-spacing'] .= 'px';
		}

		$this->json['value'] = wp_parse_args( $value, $old_values );

		// Cleanup.
		if ( isset( $this->json['value']['font-weight'] ) ) {
			unset( $this->json['value']['font-weight'] );
		}

		// Make sure we use "subsets" instead of "subset".
		if ( isset( $this->json['value']['subset'] ) ) {
			if ( ! empty( $this->json['value']['subset'] ) ) {
				if ( ! isset( $this->json['value']['subsets'] ) || empty( $this->json['value']['subsets'] ) ) {
					$this->json['value']['subsets'] = $this->json['value']['subset'];
				}
			}
			unset( $this->json['value']['subset'] );
		}
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param string|false $id The string-ID.
	 * @return string
	 */
	protected function l10n( $id = false ) {
		$translation_strings = array(
			'inherit'        => esc_attr__( 'Inherit', 'kirki' ),
			'font-family'    => esc_attr__( 'Font Family', 'kirki' ),
			'font-size'      => esc_attr__( 'Font Size', 'kirki' ),
			'line-height'    => esc_attr__( 'Line Height', 'kirki' ),
			'letter-spacing' => esc_attr__( 'Letter Spacing', 'kirki' ),
			'word-spacing'   => esc_attr__( 'Word Spacing', 'kirki' ),
			'left'           => esc_attr__( 'Left', 'kirki' ),
			'right'          => esc_attr__( 'Right', 'kirki' ),
			'center'         => esc_attr__( 'Center', 'kirki' ),
			'justify'        => esc_attr__( 'Justify', 'kirki' ),
			'color'          => esc_attr__( 'Color', 'kirki' ),
			'variant'        => esc_attr__( 'Variant', 'kirki' ),
			'subsets'        => esc_attr__( 'Subset', 'kirki' ),
			'text-align'     => esc_attr__( 'Text Align', 'kirki' ),
			'text-transform' => esc_attr__( 'Text Transform', 'kirki' ),
			'none'           => esc_attr__( 'None', 'kirki' ),
			'capitalize'     => esc_attr__( 'Capitalize', 'kirki' ),
			'uppercase'      => esc_attr__( 'Uppercase', 'kirki' ),
			'lowercase'      => esc_attr__( 'Lowercase', 'kirki' ),
			'initial'        => esc_attr__( 'Initial', 'kirki' ),
		);
		$translation_strings = apply_filters( "kirki/{$this->kirki_config}/l10n", $translation_strings );
		if ( false === $id ) {
			return $translation_strings;
		}
		return $translation_strings[ $id ];
	}

	/**
	 * Render the control's content.
	 *
	 * @see WP_Customize_Control::render_content()
	 */
	protected function render_content() {}
}
