<?php
/**
 * select2 Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Select2_Control' ) ) {
	return;
}

class Kirki_Controls_Select2_Control extends WP_Customize_Control {

	public $type = 'select2';

	protected function render() {
		$id = str_replace( '[', '-', str_replace( ']', '', $this->id ) );
		$class = 'customize-control customize-control-'.$this->type; ?>
		<li id="customize-control-<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li>
	<?php }

	public function render_content() {
		$id = str_replace( '[', '-', str_replace( ']', '', $this->id ) );

		if ( empty( $this->choices ) ) {
		return;
		} ?>

		<label>
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>

			<select data-customize-setting-link="<?php echo esc_attr( $id ); ?>" class="select2">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<script>
		jQuery(document).ready(function($) {
		$('.select2').select2();
	  });
		</script>
		<?php
		}

}
