<?php
/**
 * Checkbox Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( ! class_exists( 'Kirki_Controls_Checkbox_Control' ) ) {
	class Kirki_Controls_Checkbox_Control extends Kirki_Customize_Control {

		public $type = 'kirki-checkbox';

		public function to_json() {
			parent::to_json();

			if ( isset( $this->default ) ) {
				$this->json['default'] = $this->default;
			} else {
				$this->json['default'] = $this->setting->default;
			}
			$this->json['value']   = $this->value();
			if ( null === $this->json['value'] ) {
				$this->json['value'] = $this->json['default'];
			}

		}

		protected function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label>
				<input type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( data.value !== false ) { #> checked<# } #> />
				{{ data.label }}
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</label>
			<?php
		}

	}
}
