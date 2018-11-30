<?php
/**
 * Customizer Control: slider.
 *
 * Creates a jQuery slider control.
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

/**
 * Slider control (range).
 */
class Kirki_Control_Spacing_Advanced extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-spacing-advanced';
	
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['choices'] = wp_parse_args( $this->json['choices'], array(
			'use_media_queries' => true,
			'sync_values' => true
		));
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
		<label>
			<div class="kirki-unit-choices-outer">
				<# if ( data.choices.units ) { #>
				<# _.each( data.choices.units, function( unit ) { #>
				<div class="kirki-unit-choice">
					<input id="{{ data.id }}_{{ unit }}" type="radio" name="{{ data.id }}_unit" data-setting="unit" value="{{ unit }}">
					<label class="kirki-unit-choice-label" for="{{ data.id }}_{{ unit }}">{{ unit }}</label>
				</div>
				<# }); #>
				<# 
				} else {
				#>
				<div class="kirki-unit-choice">
					<input id="{{ data.id }}_all" type="radio" name="{{ data.id }}_all" data-setting="unit" value="all" checked>
					<label class="kirki-unit-choice-label" for="{{ data.id }}_all">ALL</label>
				</div>
				<# } #>
			</div>
			<span class="customize-control-title">
				<span>{{{ data.label }}}</span>
				<# if ( data.choices.use_media_queries ) { #>
				<?php Kirki_Helper::responsive_switcher_template(); ?>
				<# } #>
			</span>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="control-wrapper-outer">
				<div class="control-wrapper">
					<div class="kirki-control-type-dimensions">
						<ul class="kirki-control-dimensions">
							<# _.each( ['top', 'right', 'bottom', 'left'], function( side ) {
								if ( data.default && _.isUndefined( data.default[side] ) )
									return false;
								var label = side.charAt( 0 ).toUpperCase() + side.substring( 1 );
								var type = data.choices.units ? 'number' : 'text';
							#>
							<li class="kirki-control-dimension">
								<input type="{{ type }}" id="{{{ data.id }}}-{{{ side }}}" side="{{{ side }}}">
								<label for="{{{ data.id }}}-{{{ side }}}" class="kirki-control-dimension-label"><?php _e('{{{ label }}}', 'kirki') ?></span>
							</li>
							<# }); #>
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
						</ul>
					</div>
				</div>
			</div>
			<input class="spacing-hidden-value" type="hidden" value="" {{{ data.link }}} />
		</label>
		<?php
	}
}