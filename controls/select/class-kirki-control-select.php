<?php
/**
 * Customizer Control: kirki-select.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Select control.
 */
class Kirki_Control_Select extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-select';

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
	 * Maximum number of options the user will be able to select.
	 * Set to 1 for single-select.
	 *
	 * @access public
	 * @var int
	 */
	public $multiple = 1;

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'selectize', trailingslashit( Kirki::$url ) . 'controls/select/selectize.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'kirki-select', trailingslashit( Kirki::$url ) . 'controls/select/select.js', array( 'jquery', 'customize-base', 'selectize' ), false, true );
		wp_enqueue_style( 'kirki-select-css', trailingslashit( Kirki::$url ) . 'controls/select/select.css', null );
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

		if ( 'user_meta' === $this->option_type ) {
			$this->json['value'] = get_user_meta( get_current_user_id(), $this->id, true );
		}

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

		$this->json['multiple'] = $this->multiple;
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
		<# if ( ! data.choices ) return; #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<select {{{ data.inputAttrs }}} {{{ data.link }}} data-multiple="{{ data.multiple }}"<# if ( 1 < data.multiple ) { #> multiple<# } #>>
				<# if ( 1 < data.multiple && data.value ) { #>
					<# for ( key in data.value ) { #>
						<option value="{{ data.value[ key ] }}" selected>{{ data.choices[ data.value[ key ] ] }}</option>
					<# } #>
					<# for ( key in data.choices ) { #>
						<# if ( data.value[ key ] in data.value ) { #>
						<# } else { #>
							<option value="{{ key }}">{{ data.choices[ key ] }}</option>
						<# } #>
					<# } #>
				<# } else { #>
					<# for ( key in data.choices ) { #>
						<option value="{{ key }}"<# if ( key === data.value ) { #>selected<# } #>>{{ data.choices[ key ] }}</option>
					<# } #>
				<# } #>
			</select>
		</label>
		<?php
	}
}
