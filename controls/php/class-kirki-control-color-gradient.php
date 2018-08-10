<?php
/**
 * Customizer Control: color.
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

class Kirki_Control_Color_Gradient extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-color-gradient';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
 		$this->json['default'] = wp_parse_args( $this->json['default'], array(
			'color1'    => '',
			'color2'    => '',
			'location' => '0%',
			'direction' => 'top right'
		) );
	}
	
	protected function content_template() 
	{
		?>
		<label>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</label>
		<div class="kirki-group-outer color-gradient customize-control-kirki-slider">
			<div class="color1">
				<h5><?php _e( 'Color 1', 'kirki' ) ?></h5>
				<input {{{ data.inputAttrs }}} type="text" class="color-picker" data-alpha="true" value="" />
			</div>
			<div class="color2">
				<h5><?php _e( 'Color 2', 'kirki' ) ?></h5>
				<input {{{ data.inputAttrs }}} type="text" class="color-picker" data-alpha="true" value="" />
			</div>
			<div class="location">
				<h5><?php _e( 'Location', 'kirki' ) ?></h5>
				<div class="wrapper slider-wrapper">
					<input {{{ data.inputAttrs }}} type="range" min="0" max="50" step="1" value="0" />
					<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_attr_e( 'Reset', 'kirki' ); ?></span></span>
					<span class="value">
						<input {{{ data.inputAttrs }}} type="text"/>
						<span class="suffix">%</span>
					</span>
				</div>
			</div>
			<div class="direction">
				<h5><?php _e( 'Direction', 'kirki' ) ?></h5>
				<select {{{ data.inputAttrs }}}>
					<option value=""><?php _e( 'None', 'kirki' ); ?></option>
					<option value="to top"><?php _e( 'To Top', 'kirki' ); ?></option>
					<option value="to right"><?php _e( 'To Right', 'kirki' ); ?></option>
					<option value="to bottom"><?php _e( 'To Bottom', 'kirki' ); ?></option>
					<option value="to left"><?php _e( 'To Left', 'kirki' ); ?></option>
					<option value="to top right"><?php _e( 'To Top Right', 'kirki' ); ?></option>
					<option value="to bottom right"><?php _e( 'To Bottom Right', 'kirki' ); ?></option>
					<option value="to top left"><?php _e( 'To Top Left', 'kirki' ); ?></option>
					<option value="to bottom left"><?php _e( 'To Bottom Left', 'kirki' ); ?></option>
				</select>
			</div>
		</div>
		<input class="color-gradient-hidden-value" type="hidden" value="{{ data.value }}" {{{ data.link }}}>
		<?php
	}
}
