<?php
/**
 * typography Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
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
			wp_enqueue_script( 'kirki-typography' );
		}

		public function to_json() {
			parent::to_json();
			$this->add_values_backwards_compatibility();
			$this->json['l10n'] = Kirki_l10n::get_strings();
			$defaults = array(
				'font-family'    => false,
				'font-size'      => false,
				'line-height'    => false,
				'line-height'    => false,
				'letter-spacing' => false,
				'color'          => false,
				'text-align'     => false,
			);
			$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );
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

				<# if ( data.default['font-family'] ) { #>
					<# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
					<# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
					<div class="font-family">
						<h5>{{ data.l10n['font-family'] }}</h5>
						<select id="kirki-typography-font-family-{{{ data.id }}}" placeholder="{{ data.i18n['select-font-family'] }}"></select>
					</div>
					<div class="variant kirki-variant-wrapper">
						<h5>{{ data.l10n['variant'] }}</h5>
						<select class="variant" id="kirki-typography-variant-{{{ data.id }}}"></select>
					</div>
					<div class="subset hide-on-standard-fonts kirki-subset-wrapper">
						<h5>{{ data.l10n['subsets'] }}</h5>
						<select class="subset" id="kirki-typography-subset-{{{ data.id }}}"></select>
					</div>
				<# } #>

				<# if ( data.default['font-size'] ) { #>
					<div class="font-size">
						<h5>{{ data.l10n['font-size'] }}</h5>
						<input type="text" value="{{ data.value['font-size'] }}"/>
					</div>
				<# } #>

				<# if ( data.default['line-height'] ) { #>
					<div class="line-height">
						<h5>{{ data.l10n['line-height'] }}</h5>
						<input type="text" value="{{ data.value['line-height'] }}"/>
					</div>
				<# } #>

				<# if ( data.default['letter-spacing'] ) { #>
					<div class="letter-spacing">
						<h5>{{ data.l10n['letter-spacing'] }}</h5>
						<input type="text" value="{{ data.value['letter-spacing'] }}"/>
					</div>
				<# } #>

				<# if ( data.default['text-align'] ) { #>
					<div class="text-align">
						<h5>{{ data.l10n['text-align'] }}</h5>
						<input type="radio" value="inherit" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-inherit" <# if ( data.value['text-align'] === 'inherit' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-inherit">
								<span class="dashicons dashicons-editor-removeformatting"></span>
								<span class="screen-reader-text">{{ data.l10n['inherit'] }}</span>
							</label>
						</input>
						<input type="radio" value="left" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-left" <# if ( data.value['text-align'] === 'left' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-left">
								<span class="dashicons dashicons-editor-alignleft"></span>
								<span class="screen-reader-text">{{ data.l10n['left'] }}</span>
							</label>
						</input>
						<input type="radio" value="center" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-center" <# if ( data.value['text-align'] === 'center' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-center">
								<span class="dashicons dashicons-editor-aligncenter"></span>
								<span class="screen-reader-text">{{ data.l10n['center'] }}</span>
							</label>
						</input>
						<input type="radio" value="right" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-right" <# if ( data.value['text-align'] === 'right' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-right">
								<span class="dashicons dashicons-editor-alignright"></span>
								<span class="screen-reader-text">{{ data.l10n['right'] }}</span>
							</label>
						</input>
						<input type="radio" value="justify" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-justify" <# if ( data.value['text-align'] === 'justify' ) { #> checked="checked"<# } #>>
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
						<select id="kirki-typography-text-transform-{{{ data.id }}}">
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
						<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="kirki-color-control color-picker" {{{ data.link }}} />
					</div>
				<# } #>
			</div>
			<?php
		}

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
			// All values are the same with the exception of 400 (becomes regular)
			if ( '400' == $old_values['variant'] ) {
				$old_values['variant'] = 'regular';
			}
			// Letter spacing was in px, now it requires units.
			if ( isset( $value['letter-spacing'] ) && intval( $value['letter-spacing'] ) == $value['letter-spacing'] ) {
				$value['letter-spacing'] .= 'px';
			}
			$this->json['value'] = wp_parse_args( $value, $old_values );
		}

	}

}
