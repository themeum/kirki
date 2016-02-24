<?php
/**
 * typography Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Typography_Control' ) ) {
	class Kirki_Controls_Typography_Control extends Kirki_Customize_Control {

		public $type = 'typography';

		public function enqueue() {
			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'selectize', 'vendor/selectize', array( 'jquery' ) );
			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-typography', 'controls/typography', array( 'jquery', 'selectize' ) );
		}

		public function to_json() {
			parent::to_json();

			$i18n = Kirki_Toolkit::i18n();
			$this->json['fonts'] = Kirki_Fonts::get_font_choices();
			$value = $this->value();
			$this->json['value'] = array(
				'font-style'     => isset( $value['font-style'] ) ? $value['font-style'] : false,
				'font-family'    => isset( $value['font-family'] ) ? $value['font-family'] : '',
				'font-size'      => isset( $value['font-size'] ) ? $value['font-size'] : '',
				'font-weight'    => isset( $value['font-weight'] ) ? $value['font-weight'] : '',
				'line-height'    => isset( $value['line-height'] ) ? $value['line-height'] : '',
				'letter-spacing' => isset( $value['letter-spacing'] ) ? $value['letter-spacing'] : '',
				'color'          => isset( $value['color'] ) ? $value['color'] : '',
			);
			$this->json['l10n'] = array(
				'font-family'    => $i18n['font-family'],
				'font-size'      => $i18n['font-size'],
				'font-weight'    => $i18n['font-weight'],
				'line-height'    => $i18n['line-height'],
				'letter-spacing' => $i18n['letter-spacing'],
				'font-style'     => $i18n['font-style'],
				'color'          => $i18n['color'],
			);
		}

		public function render_content() {}

		protected function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label class="customizer-text">
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</label>

			<div class="wrapper">

				<# if ( data.choices['font-family'] ) { #>
					<# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
					<# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
					<div class="font-family">
						<h5>{{ data.l10n['font-family'] }}</h5>
						<select class="font-family select2">
							<# for ( key in data.fonts ) { #>
								<option value="{{ key }}" <# if ( key === data.value['font-family'] ) { #> selected<# } #>>{{ data.fonts[ key ] }}</option>
							<# } #>
						</select>
					</div>
				<# } #>

				<# if ( data.choices['font-size'] ) { #>
					<div class="font-size">
						<h5>{{ data.l10n['font-size'] }}</h5>
						<input type="number" min="0" step="any" value="{{ parseFloat( data.value['font-size'] ) }}"/>
						<select>
							<# if ( data.choices['units'] ) { #>
								<# for ( key in data.choices['units'] ) { #>
									<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['font-size'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
								<# } #>
							<# } else { #>
								<# var units = data.value['font-size'].replace( parseFloat( data.value['font-size'] ), '' ); #>
								<option value="px" <# if ( units == 'px' ) { #> selected <# } #>>px</option>
								<option value="em" <# if ( units == 'em' ) { #> selected <# } #>>em</option>
								<option value="%" <# if ( units == '%' ) { #> selected <# } #>>%</option>
							<# } #>
						</select>
					</div>
				<# } #>

				<# if ( data.choices['font-weight'] ) { #>
					<div class="font-weight">
						<h5>{{ data.l10n['font-weight'] }}</h5>
						<select class="font-weight">
							<# var fontWeights = ['100', '200', '300', '400', '500', '600', '700', '800', '900']; #>
							<# for ( key in fontWeights ) { #>
								<option value="{{ fontWeights[ key ] }}" <# if ( fontWeights[ key ] == data.value['font-weight'] ) { #> selected<# } #>>{{ fontWeights[ key ] }}</option>
							<# } #>
						</select>
					</div>
				<# } #>

				<# if ( data.choices['line-height'] ) { #>
					<div class="line-height">
						<h5>{{ data.l10n['line-height'] }}</h5>
						<input type="number" min="0" step="any" value="{{ data.value['line-height'] }}"/>
					</div>
				<# } #>

				<# if ( data.choices['letter-spacing'] ) { #>
					<div class="letter-spacing">
						<h5>{{ data.l10n['letter-spacing'] }}</h5>
						<input type="number" min="0" step="any" value="{{ parseFloat( data.value['letter-spacing'] ) }}"/>
						<select>
							<# if ( data.choices['units'] ) { #>
								<# for ( key in data.choices['units'] ) { #>
									<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['letter-spacing'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
								<# } #>
							<# } else { #>
								<# var units = data.value['letter-spacing'].replace( parseFloat( data.value['letter-spacing'] ), '' ); #>
								<option value="px" <# if ( units == 'px' ) { #> selected <# } #>>px</option>
								<option value="em" <# if ( units == 'em' ) { #> selected <# } #>>em</option>
								<option value="%" <# if ( units == '%' ) { #> selected <# } #>>%</option>
							<# } #>
						</select>
					</div>
				<# } #>

				<# if ( data.choices['font-style'] ) { #>
					<div class="font-style ">
						<h5>{{ data.l10n['font-style'] }}</h5>
						<input class="switch-input" type="radio" value="normal" name="_typography_font_style_customize-radio-{{{ data.id }}}" id="{{ data.id }}_font_style_normal" {{{ data.link }}}<# if ( 'normal' === data.value['font-style'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( 'normal' === data.value['font-style'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}_font_style_normal">
								<span class="dashicons dashicons-editor-removeformatting"></span>
							</label>
						</input>
						<# for ( styleProperty in data.choices['font-style'] ) { #>
							<input class="switch-input" type="radio" value="{{ data.choices['font-style'][ styleProperty ] }}" name="_typography_font_style_customize-radio-{{{ data.id }}}" id="{{ data.id }}_font_style_{{ data.choices['font-style'][ styleProperty ] }}" {{{ data.link }}}<# if ( data.choices['font-style'][ styleProperty ] === data.value['font-style'] ) { #> checked="checked" <# } #>>
								<label class="switch-label switch-label-<# if ( data.choices['font-style'][ styleProperty ] === data.value['font-style'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}_font_style_{{ data.choices['font-style'][ styleProperty ] }}">
									<span class="dashicons dashicons-editor-{{ data.choices['font-style'][ styleProperty ] }}"></span>
								</label>
							</input>
						<# } #>
					</div>
				<# } #>

				<# if ( data.choices['color'] ) { #>
					<div class="color">
						<h5>{{ data.l10n['color'] }}</h5>
						<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="kirki-color-control color-picker" {{{ data.link }}} />
					</div>
				<# } #>
			</div>
			<?php
		}

	}

}
