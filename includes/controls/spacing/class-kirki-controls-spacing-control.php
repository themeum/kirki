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

class Kirki_Controls_Spacing_Control extends WP_Customize_Control {

	public $type = 'spacing';

	public function enqueue() {

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-spacing', trailingslashit( kirki_url() ).'includes/controls/spacing/style.css' );
		}
		wp_enqueue_script( 'kirki-spacing', trailingslashit( kirki_url() ).'includes/controls/spacing/script.js', array( 'jquery' ) );

	}

	public function to_json() {
		parent::to_json();
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['choices'] = ( is_array( $this->choices ) ) ? array(
			'top'    => ( in_array( 'top', $this->choices ) ) ? true : false,
			'bottom' => ( in_array( 'bottom', $this->choices ) ) ? true : false,
			'left'   => ( in_array( 'left', $this->choices ) ) ? true : false,
			'right'  => ( in_array( 'right', $this->choices ) ) ? true : false,
			'units'  => ( isset( $this->choices['units'] ) ) ? $this->choices['units'] : false,
		) : array();

		$i18n = Kirki_Toolkit::i18n();
		$this->json['l10n'] = array(
			'top'    => $i18n['top'],
			'bottom' => $i18n['bottom'],
			'left'   => $i18n['left'],
			'right'  => $i18n['right'],
		);

	}

	public function content_template() { ?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="wrapper">
				<# if ( data.choices['top'] ) { #>
					<div class="top">
						<h5>{{ data.l10n['top'] }}</h5>
						<div class="inner">
							<span class="dashicons dashicons-arrow-up"></span>
							<input type="number" min="0" step="any" value="{{ parseFloat( data.value['top'] ) }}"/>
							<select>
							<# if ( data.choices['units'] ) { #>
								<# for ( key in data.choices['units'] ) { #>
									<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['top'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
								<# } #>
							<# } else { #>
								<option value="px" <# if ( _.contains( data.value['top'], 'px' ) ) { #> selected <# } #>>px</option>
								<option value="em" <# if ( _.contains( data.value['top'], 'em' ) ) { #> selected <# } #>>em</option>
								<option value="%" <# if ( _.contains( data.value['top'], '%' ) ) { #> selected <# } #>>%</option>
							<# } #>
							</select>
						</div>
					</div>
				<# } #>

				<# if ( data.choices['bottom'] ) { #>
					<div class="bottom">
						<h5>{{ data.l10n['bottom'] }}</h5>
						<div class="inner">
							<span class="dashicons dashicons-arrow-down"></span>
							<input type="number" min="0" step="any" value="{{ parseFloat( data.value['bottom'] ) }}"/>
							<select>
							<# if ( data.choices['units'] ) { #>
								<# for ( key in data.choices['units'] ) { #>
									<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['bottom'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
								<# } #>
							<# } else { #>
								<option value="px" <# if ( _.contains( data.value['bottom'], 'px' ) ) { #> selected <# } #>>px</option>
								<option value="em" <# if ( _.contains( data.value['bottom'], 'em' ) ) { #> selected <# } #>>em</option>
								<option value="%" <# if ( _.contains( data.value['bottom'], '%' ) ) { #> selected <# } #>>%</option>
							<# } #>
							</select>
						</div>
					</div>
				<# } #>

				<# if ( data.choices['left'] ) { #>
					<div class="left">
						<h5>{{ data.l10n['left'] }}</h5>
						<div class="inner">
							<span class="dashicons dashicons-arrow-left"></span>
							<input type="number" min="0" step="any" value="{{ parseFloat( data.value['left'] ) }}"/>
							<select>
							<# if ( data.choices['units'] ) { #>
								<# for ( key in data.choices['units'] ) { #>
									<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['left'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
								<# } #>
							<# } else { #>
								<option value="px" <# if ( _.contains( data.value['left'], 'px' ) ) { #> selected <# } #>>px</option>
								<option value="em" <# if ( _.contains( data.value['left'], 'em' ) ) { #> selected <# } #>>em</option>
								<option value="%" <# if ( _.contains( data.value['left'], '%' ) ) { #> selected <# } #>>%</option>
							<# } #>
							</select>
						</div>
					</div>
				<# } #>

				<# if ( data.choices['right'] ) { #>
					<div class="right">
						<h5>{{ data.l10n['right'] }}</h5>
						<div class="inner">
							<span class="dashicons dashicons-arrow-right"></span>
							<input type="number" min="0" step="any" value="{{ parseFloat( data.value['right'] ) }}"/>
							<select>
							<# if ( data.choices['units'] ) { #>
								<# for ( key in data.choices['units'] ) { #>
									<option value="{{ data.choices['units'][ key ] }}" <# if ( _.contains( data.value['right'], data.choices['units'][ key ] ) ) { #> selected <# } #>>{{ data.choices['units'][ key ] }}</option>
								<# } #>
							<# } else { #>
								<option value="px" <# if ( _.contains( data.value['right'], 'px' ) ) { #> selected <# } #>>px</option>
								<option value="em" <# if ( _.contains( data.value['right'], 'em' ) ) { #> selected <# } #>>em</option>
								<option value="%" <# if ( _.contains( data.value['right'], '%' ) ) { #> selected <# } #>>%</option>
							<# } #>
							</select>
						</div>
					</div>
				<# } #>
			</div>
		</label>
		<?php
	}

}
