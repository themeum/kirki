<?php
/**
 * spacing Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Spacing_Control' ) ) {
	return;
}

class Kirki_Controls_Spacing_Control extends Kirki_Customize_Control {

	public $type = 'spacing';

	public function to_json() {
		parent::to_json();
		$this->json['choices'] = array();
		if ( is_array( $this->choices ) ) {
			if ( isset( $this->choices['top'] ) && true == $this->choices['top'] ) {
				$this->json['choices']['top'] = true;
			}
			if ( isset( $this->choices['bottom'] ) && true == $this->choices['bottom'] ) {
				$this->json['choices']['bottom'] = true;
			}
			if ( isset( $this->choices['left'] ) && true == $this->choices['left'] ) {
				$this->json['choices']['left'] = true;
			}
			if ( isset( $this->choices['right'] ) && true == $this->choices['right'] ) {
				$this->json['choices']['right'] = true;
			}
		}

		$i18n = Kirki_Toolkit::i18n();
		$this->json['l10n'] = array(
			'top'    => $i18n['top'],
			'bottom' => $i18n['bottom'],
			'left'   => $i18n['left'],
			'right'  => $i18n['right'],
		);

		if ( isset( $this->json['choices']['top'] ) && ! isset( $this->json['value']['top'] ) ) {
			$this->json['value']['top'] = $this->json['default']['top'];
		}
		if ( isset( $this->json['choices']['bottom'] ) && ! isset( $this->json['value']['bottom'] ) ) {
			$this->json['value']['bottom'] = $this->json['default']['bottom'];
		}
		if ( isset( $this->json['choices']['left'] ) && ! isset( $this->json['value']['left'] ) ) {
			$this->json['value']['left'] = $this->json['default']['left'];
		}
		if ( isset( $this->json['choices']['right'] ) && ! isset( $this->json['value']['top'] ) ) {
			$this->json['value']['right'] = $this->json['default']['right'];
		}

	}

	protected function content_template() { ?>
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
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
					<# if ( data.choices['top'] ) { #>
						<div class="top">
							<h5>{{ data.l10n['top'] }}</h5>
							<div class="inner">
								<input type="number" min="0" step="any" value="{{ parseFloat( data.value['top'] ) }}"/>
								<select>
								<# if ( data.choices['units'] ) { #>
									<# for ( key in data.choices['units'] ) { #>
										<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['top'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
									<# } #>
								<# } else { #>
									<# if ( data.value && data.value['top'] ) { #>
										<# var units = data.value['top'].replace( parseFloat( data.value['top'] ), '' ); #>
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

					<# if ( data.choices['bottom'] ) { #>
						<div class="bottom">
							<h5>{{ data.l10n['bottom'] }}</h5>
							<div class="inner">
								<input type="number" min="0" step="any" value="{{ parseFloat( data.value['bottom'] ) }}"/>
								<select>
								<# if ( data.choices['units'] ) { #>
									<# for ( key in data.choices['units'] ) { #>
										<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['bottom'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
									<# } #>
								<# } else { #>
									<# if ( data.value && data.value['bottom'] ) { #>
										<# var units = data.value['bottom'].replace( parseFloat( data.value['bottom'] ), '' ); #>
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

					<# if ( data.choices['left'] ) { #>
						<div class="left">
							<h5>{{ data.l10n['left'] }}</h5>
							<div class="inner">
								<input type="number" min="0" step="any" value="{{ parseFloat( data.value['left'] ) }}"/>
								<select>
								<# if ( data.choices['units'] ) { #>
									<# for ( key in data.choices['units'] ) { #>
										<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['left'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
									<# } #>
								<# } else { #>
									<# if ( data.value && data.value['left'] ) { #>
										<# var units = data.value['left'].replace( parseFloat( data.value['left'] ), '' ); #>
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

					<# if ( data.choices['right'] ) { #>
						<div class="right">
							<h5>{{ data.l10n['right'] }}</h5>
							<div class="inner">
								<input type="number" min="0" step="any" value="{{ parseFloat( data.value['right'] ) }}"/>
								<select>
								<# if ( data.choices['units'] ) { #>
									<# for ( key in data.choices['units'] ) { #>
										<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['right'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
									<# } #>
								<# } else { #>
									<# if ( data.value && data.value['right'] ) { #>
										<# var units = data.value['right'].replace( parseFloat( data.value['right'] ), '' ); #>
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
