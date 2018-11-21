<?php
/**
 * Customizer Control: border.
 *
 * Creates a new custom control.
 * Custom controls contains all border-related options.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Adds multiple input fields that combined make up the border control.
 */
class Kirki_Control_Border extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-border';
	
	public function to_json() {
		parent::to_json();
		
		$this->json['choices'] = wp_parse_args( $this->json['choices'], array(
				'sync_values' => true
			)
		);
	}
	
	protected function content_template() 
	{
		?>
		<label>
			<#
			if ( data.choices.units ) {
				_.each( data.choices.units, function( unit ) {
			#>
			<div class="kirki-units-choices-outer">
				<div class="kirki-units-choices">
					<input id="{{ data.id }}_{{ unit }}" type="radio" name="{{ data.id }}_unit" data-setting="unit" value="{{ unit }}">
					<label class="kirki-units-choices-label" for="{{ data.id }}_{{ unit }}">{{ unit }}</label>
				</div>
			</div>
			<# }); } #>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</label>
		<div class="kirki-group-outer border">
			<h5><?php _e( 'Border Style', 'kirki' ) ?></h5>
			<div class="border-style">
				<select>
					<option value="none"><?php _e( 'None', 'kirki' ); ?></option>
					<option value="solid"><?php _e( 'Solid', 'kirki' ); ?></option>
					<option value="double"><?php _e( 'Double', 'kirki' ); ?></option>
					<option value="dotted"><?php _e( 'Dotted', 'kirki' ); ?></option>
					<option value="dashed"><?php _e( 'Dashed', 'kirki' ); ?></option>
					<option value="groove"><?php _e( 'Groove', 'kirki' ); ?></option>
				</select>
			</div>
			<div class="size">
				<h5><?php _e( 'Size', 'kirki' ) ?></h5>
				<div class="kirki-control-type-dimensions">
					<ul class="kirki-control-dimensions">
						<# _.each( ['top', 'right', 'bottom', 'left'], function( side ) {
							if ( _.isUndefined( data.default[side] ) )
								return false;
							var label = side.charAt( 0 ).toUpperCase() + side.substring( 1 );
						#>
						<li class="kirki-control-dimension">
							<input type="number" id="{{{ data.id }}}-{{{ side }}}" data-side="{{{ side }}}">
							<label for="{{{ data.id }}}-{{{ side }}}" class="kirki-control-dimension-label"><?php _e('{{{ label }}}', 'kirki') ?></span>
						</li>
						<# }); #>
						<# if ( data.choices.sync_values ) { #>
						<li>
							<button class="kirki-input-link tooltip-target unlinked" data-tooltip="<?php _e( 'Link values together', 'kirki' ); ?>" original-title="">
								<span class="kirki-linked">
									<span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
									<span class="kirki-screen-only"><?php _e( 'Link values together', 'kirki' );?></span>
								</span>
								<span class="kirki-unlinked">
									<span class="dashicons dashicons-editor-unlink" aria-hidden="true"></span>
									<span class="kirki-screen-only"><?php _e( 'Unlinked values', 'kirki' );?></span>
								</span>
							</button>
						</li>
						<# } #>
					</ul>
				</div>
			</div>
			<div class="color">
				<h5><?php _e( 'Color', 'kirki' ) ?></h5>
				<input type="text" class="color-picker" data-alpha="true" value="" />
			</div>
		</div>
		<input class="border-hidden-value" type="hidden" value="{{ data.value }}" {{{ data.link }}}>
		<?php
	}
}
