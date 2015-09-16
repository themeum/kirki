<?php
/**
 * typography Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Typography_Control' ) ) {
	return;
}

class Kirki_Controls_Typography_Control extends WP_Customize_Control {

	public $type = 'typography';

	public function enqueue() {

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-typography', trailingslashit( kirki_url() ) . 'includes/controls/typography/style.css' );
		}
		wp_enqueue_script( 'kirki-typography', trailingslashit( kirki_url() ) . 'includes/controls/typography/script.js', array( 'jquery' ) );

	}

	public function to_json() {
		parent::to_json();
		$this->json['id']      = $this->id;
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['fonts']   = $this->get_all_fonts();
		$value = $this->value();
		$this->json['value'] = array(
			'bold'           => isset( $value['bold'] ) ? $value['bold'] : false,
			'italic'         => isset( $value['italic'] ) ? $value['italic'] : false,
			'underline'      => isset( $value['underline'] ) ? $value['underline'] : false,
			'strikethrough'  => isset( $value['strikethrough'] ) ? $value['strikethrough'] : false,
			'font-family'    => isset( $value['font-family'] ) ? $value['font-family'] : false,
			'font-size'      => isset( $value['font-size'] ) ? $value['font-size'] : false,
			'font-weight'    => isset( $value['font-weight'] ) ? $value['font-weight'] : false,
			'line-height'    => isset( $value['line-height'] ) ? $value['line-height'] : false,
			'letter-spacing' => isset( $value['letter-spacing'] ) ? $value['letter-spacing'] : false,
		);
	}

	public function content_template() { ?>
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<# if ( data.choices['font-style'] ) { #>
				<div class="font-style">
					<label>
						<input name="bold_{{ data.id }}" id="bold_{{ data.id }}" type="checkbox" value="{{ data.value['bold'] }}" {{{ data.link }}}<# if ( '1' == data.value['bold'] ) { #> checked<# } #>>
						<span class="dashicons dashicons-editor-bold"></span>
					</label>
					<label>
						<input name="italic_{{ data.id }}" id="italic_{{ data.id }}" type="checkbox" value="{{ data.value['italic'] }}" {{{ data.link }}}<# if ( '1' == data.value['italic'] ) { #> checked<# } #>>
						<span class="dashicons dashicons-editor-italic"></span>
					</label>
					<label>
						<input name="underline_{{ data.id }}" id="underline_{{ data.id }}" type="checkbox" value="{{ data.value['underline'] }}" {{{ data.link }}}<# if ( '1' == data.value['underline'] ) { #> checked<# } #>>
						<span class="dashicons dashicons-editor-underline"></span>
					</label>
					<label>
						<input name="strikethrough_{{ data.id }}" id="strikethrough_{{ data.id }}" type="checkbox" value="{{ data.value['strikethrough'] }}" {{{ data.link }}}<# if ( '1' == data.value['strikethrough'] ) { #> checked<# } #>>
						<span class="dashicons dashicons-editor-strikethrough"></span>
					</label>
				</div>
			<# } #>

			<# if ( data.choices['font-family'] ) { #>
				<div class="font-family">
					<h5>font-family</h5>
					<select class="font-family">
						<# for ( key in data.fonts ) { #>
							<option value="{{ key }}" <# if ( key === data.value['font-family'] ) { #> checked="checked" <# } #>>{{ data.fonts[ key ] }}</option>
						<# } #>
					</select>
				</div>
			<# } #>

			<# if ( data.choices['font-size'] ) { #>
				<div class="font-size">
					<h5>font-size</h5>
					<input type="number" min="0" step="any" value="{{ parseFloat( data.value['font-size'] ) }}"/>
					<select>
						<option value="px" <# if ( ~data.value['font-size'].indexOf('px') ) { #> selected <# } #>>px</option>
						<option value="em" <# if ( ~data.value['font-size'].indexOf('em') ) { #> selected <# } #>>em</option>
						<option value="%" <# if ( ~data.value['font-size'].indexOf('%') ) { #> selected <# } #>>%</option>
					</select>
				</div>
			<# } #>

			<# if ( data.choices['font-weight'] ) { #>
				<div class="font-weight">
					<h5>font-weight</h5>
					<select class="font-family">
						<option value="100" <# if ( 100 === data.value['font-weight'] ) { #> checked="checked" <# } #>>100</option>
						<option value="200" <# if ( 200 === data.value['font-weight'] ) { #> checked="checked" <# } #>>200</option>
						<option value="300" <# if ( 300 === data.value['font-weight'] ) { #> checked="checked" <# } #>>300</option>
						<option value="400" <# if ( 400 === data.value['font-weight'] ) { #> checked="checked" <# } #>>400</option>
						<option value="500" <# if ( 500 === data.value['font-weight'] ) { #> checked="checked" <# } #>>500</option>
						<option value="600" <# if ( 600 === data.value['font-weight'] ) { #> checked="checked" <# } #>>600</option>
						<option value="700" <# if ( 700 === data.value['font-weight'] ) { #> checked="checked" <# } #>>700</option>
						<option value="800" <# if ( 800 === data.value['font-weight'] ) { #> checked="checked" <# } #>>800</option>
						<option value="900" <# if ( 900 === data.value['font-weight'] ) { #> checked="checked" <# } #>>900</option>
					</select>
				</div>
			<# } #>

			<# if ( data.choices['line-height'] ) { #>
				<div class="line-height">
					<h5>line-height</h5>
					<input type="number" min="0" step="any" value="{{ data.value['line-height'] }}"/>
				</div>
			<# } #>

			<# if ( data.choices['letter-spacing'] ) { #>
				<div class="letter-spacing">
					<h5>letter-spacing</h5>
					<input type="number" min="0" step="any" value="{{ parseFloat( data.value['letter-spacing'] ) }}"/>
					<select>
						<option value="px" <# if ( ~data.value['letter-spacing'].indexOf('px') ) { #> selected <# } #>>px</option>
						<option value="em" <# if ( ~data.value['letter-spacing'].indexOf('em') ) { #> selected <# } #>>em</option>
						<option value="%" <# if ( ~data.value['letter-spacing'].indexOf('%') ) { #> selected <# } #>>%</option>
					</select>
				</div>
			<# } #>
		</label>
		<?php
	}

	public function get_standard_fonts() {
		return Kirki()->font_registry->get_standard_fonts();
	}

	public function get_google_fonts() {
		return Kirki()->font_registry->get_google_fonts();
	}

	public function get_all_fonts() {
		$fonts = Kirki()->font_registry->get_all_fonts();
		$fonts_array = array();
		foreach ( $fonts as $font => $properties ) {
			$fonts_array[ $font ] = $font;
		}
		return $fonts_array;
	}

}
