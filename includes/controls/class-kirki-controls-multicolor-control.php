<?php
/**
 * multicolor Customizer Control.
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

if ( ! class_exists( 'Kirki_Controls_Multicolor_Control' ) ) {

	class Kirki_Controls_Multicolor_Control extends Kirki_Customize_Control {

		public $type = 'multicolor';

		public $palette = true;

		public $default = '#FFFFFF';

		public function to_json() {
			parent::to_json();
			$this->json['palette']  = $this->palette;
		}

		protected function render() {
			$id    = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
			$class = 'customize-control customize-control-' . $this->type; ?>
			<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
				<?php $this->render_content(); ?>
			</li>
		<?php }

		public function render_content() {}

		public function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="multicolor-group-wrapper">
				<# for ( key in data.choices ) { #>
					<div class="multicolor-single-color-wrapper">
						<# if ( data.choices[ key ] ) { #>
							<label for="{{ data.id }}-{{ key }}">{{ data.choices[ key ] }}</label>
						<# } #>
						<input id="{{ data.id }}-{{ key }}" type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default[ key ] }}" data-alpha="true" value="{{ data.value[ key ] }}" class="kirki-color-control color-picker multicolor-index-{{ key }}" />
					</div>
				<# } #>
			</div>
			<div class="iris-target"></div>
			<input type="hidden" value="" {{{ data.link }}} />
			<?php
		}

	}

}
