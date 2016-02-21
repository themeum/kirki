<?php
/**
 * spacing Customizer Control.
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

if ( ! class_exists( 'Kirki_Controls_Spacing_Control' ) ) {
	class Kirki_Controls_Spacing_Control extends Kirki_Customize_Control {

		public $type = 'spacing';

		public function to_json() {
			parent::to_json();
			$this->json['l10n']    = Kirki_Toolkit::i18n();
			$this->json['choices'] = array();
			if ( is_array( $this->choices ) ) {
				foreach ( $this->choices as $choice => $value ) {
					if ( true === $value ) {
						$this->json['choices'][ $choice ] = true;
					}
				}
			}

			if ( is_array( $this->json['default'] ) ) {
				foreach ( $this->json['default'] as $key => $value ) {
					if ( isset( $this->json['choices'][ $key ] ) && ! isset( $this->json['value'][ $key ] ) ) {
						$this->json['value'][ $key ] = $value;
					}
				}
			}
		}

		protected function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<div class="wrapper">
					<div class="control">
						<# for ( choiceKey in data.choices ) { #>
							<div class="{{ choiceKey }}">
								<h5>{{ data.l10n[ choiceKey ] }}</h5>
								<div class="inner">
									<input type="number" min="0" step="any" value="{{ parseFloat( data.value[ choiceKey ] ) }}"/>
									<select>
									<# if ( data.choices['units'] ) { #>
										<# for ( key in data.choices['units'] ) { #>
											<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value[ choiceKey ], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
										<# } #>
									<# } else { #>
										<# if ( data.value && data.value[ choiceKey ] ) { #>
											<# var units = data.value[ choiceKey ].replace( parseFloat( data.value[ choiceKey ] ), '' ); #>
										<# } else { #>
											<# var units = 'px'; #>
										<# } #>
										<option value="px" <# if ( units == 'px' ) { #> selected <# } #>>px</option>
										<option value="em" <# if ( units == 'em' ) { #> selected <# } #>>em</option>
										<option value="%" <# if ( units == '%' ) { #> selected <# } #>>%</option>
									<# } #>
									</select>
								</div>
							</div>
						<# } #>
					</div>
				</div>
			</label>
			<?php
		}

	}
}
