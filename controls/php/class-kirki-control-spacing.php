<?php
/**
 * Customizer Control: kirki-generic.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A generic and pretty abstract control.
 * Allows for great manipulation using the field's "choices" argumnent.
 */
class Kirki_Control_Spacing extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-spacing-advanced';
	
	public function to_json() {
		parent::to_json();
	}
	
	protected function content_template() 
	{
		?>
		<label>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</label>
		<div class="kirki-group-outer spacing">
			<div class="kirki-control-type-dimensions">
				<ul class="kirki-control-dimensions">
					<li class="kirki-control-dimension">
						<input type="number" id="{{{ data.id }}}-top" data-spacing-type="top">
						<label for="{{{ data.id }}}-top" class="kirki-control-dimension-label"><?php _e('Top', 'kirki') ?></span>
					</li>
					<li class="kirki-control-dimension">
						<input type="number" id="{{{ data.id }}}-right" data-spacing-type="right">
						<label for="{{{ data.id }}}-right" class="kirki-control-dimension-label"><?php _e('Right', 'kirki') ?></span>
					</li>
					<li class="kirki-control-dimension">
						<input type="number" id="{{{ data.id }}}-bottom" data-spacing-type="bottom">
						<label for="{{{ data.id }}}-bottom" class="kirki-control-dimension-label"><?php _e('Bottom', 'kirki') ?></span>
					</li>
					<li class="kirki-control-dimension">
						<input type="number" id="{{{ data.id }}}-left" data-spacing-type="left">
						<label for="{{{ data.id }}}-left" class="kirki-control-dimension-label"><?php _e( 'Left', 'kirki' ) ?></span>
					</li>
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
		<input class="spacing-hidden-value" type="hidden" value="{{ data.value }}" {{{ data.link }}}>
		<?php
	}
}
