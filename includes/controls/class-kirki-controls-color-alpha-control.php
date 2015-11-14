<?php
/**
 * color-alpha Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Color_Alpha_Control' ) ) {
	return;
}

class Kirki_Controls_Color_Alpha_Control extends Kirki_Customize_Control {

	public $type = 'color-alpha';

	public $palette = true;

	public $default = '#FFFFFF';

	public function to_json() {
		parent::to_json();
		$this->json['palette'] = $this->palette;
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
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{ data.description }}</span>
				<# } #>
			</span>
			<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default }}" data-alpha="true" value="{{ data.value }}" class="kirki-color-control color-picker" {{{ data.link }}} />
		</label>
	<?php }
}
