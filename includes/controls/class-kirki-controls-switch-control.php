<?php
/**
 * switch Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Switch_Control' ) ) {
	return;
}

class Kirki_Controls_Switch_Control extends Kirki_Customize_Control {

	public $type = 'switch';

	public function to_json() {
		parent::to_json();
		$i18n = Kirki_Toolkit::i18n();
		$this->json['choices'] = ( empty( $this->choices ) || ! is_array( $this->choices ) ) ? array() : $this->choices;
		$this->json['choices']['on']    = ( isset( $this->choices['on'] ) ) ? $this->choices['on'] : $i18n['on'];
		$this->json['choices']['off']   = ( isset( $this->choices['off'] ) ) ? $this->choices['off'] : $i18n['off'];
		$this->json['choices']['round'] = ( isset( $this->choices['round'] ) ) ? $this->choices['round'] : false;
	}

	protected function content_template() { ?>
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<div class="switch<# if ( data.choices['round'] ) { #> round<# } #>">
			<span class="customize-control-title">
				{{{ data.label }}}
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</span>
			<input name="switch_{{ data.id }}" id="switch_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' == data.value ) { #> checked<# } #> />
			<label class="switch-label" for="switch_{{ data.id }}">
				<span class="switch-on">{{ data.choices['on'] }}</span>
				<span class="switch-off">{{ data.choices['off'] }}</span>
			</label>
		</div>
		<?php
	}
}
