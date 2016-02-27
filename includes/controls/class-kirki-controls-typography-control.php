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
			$value = $this->value();
			$this->json['value'] = array(
				'font-style'     => isset( $value['font-style'] ) ? $value['font-style'] : false,
				'font-family'    => isset( $value['font-family'] ) ? $value['font-family'] : '',
				'font-size'      => isset( $value['font-size'] ) ? $value['font-size'] : '',
				'variant'        => isset( $value['variant'] ) ? $value['variant'] : '',
				'line-height'    => isset( $value['line-height'] ) ? $value['line-height'] : '',
				'letter-spacing' => isset( $value['letter-spacing'] ) ? $value['letter-spacing'] : '',
				'color'          => isset( $value['color'] ) ? $value['color'] : '',
			);
			$this->json['l10n'] = array(
				'font-family'    => $i18n['font-family'],
				'font-size'      => $i18n['font-size'],
				'variant'        => $i18n['variant'],
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
						<select id="kirki-typography-font-family-{{{ data.id }}}" placeholder="{{ data.i18n['select-font-family'] }}"></select>
					</div>
					<div class="variant">
						<h5>{{ data.l10n['variant'] }}</h5>
						<select class="variant" id="kirki-typography-variant-{{{ data.id }}}"></select>
					</div>
					<div class="subset">
						<h5>{{ data.l10n['subset'] }}</h5>
						<select class="subset" id="kirki-typography-subset-{{{ data.id }}}"></select>
					</div>
				<# } #>

				<# if ( data.choices['font-size'] ) { #>
					<div class="font-size">
						<h5>{{ data.l10n['font-size'] }}</h5>
						<input type="text" value="{{ data.value['font-size'] }}"/>
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
						<input type="text" value="{{ data.value['letter-spacing'] }}"/>
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
