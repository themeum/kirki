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

class Kirki_Controls_Switch_Control extends WP_Customize_Control {

	public $type = 'switch';

	public function enqueue() {
		wp_enqueue_script( 'formstone', trailingslashit( kirki_url() ).'includes/controls/switch/formstone-core.js', array( 'jquery' ) );
		wp_enqueue_script( 'formstone-touch', trailingslashit( kirki_url() ).'includes/controls/switch/formstone-touch.js', array( 'jquery', 'formstone' ) );
		wp_enqueue_script( 'formstone-checkbox', trailingslashit( kirki_url() ).'includes/controls/switch/formstone-checkbox.js', array( 'jquery', 'formstone', 'formstone-touch' ) );
		wp_enqueue_style( 'kirki-switch', trailingslashit( kirki_url() ).'includes/controls/switch/style.css' );
	}

	/**
	 * Render the control's content.
	 */
	protected function render_content() { ?>
		<?php $i18n = Kirki_Toolkit::i18n(); ?>
		<label for="switch_<?php echo $this->id; ?>">
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
		</label>
		<input name="switch_<?php echo $this->id; ?>" id="switch_<?php echo $this->id; ?>" type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> <?php if ( '1' == $this->value() ) { echo 'checked'; } ?> />
		<script>
		jQuery(document).ready(function($){
			$('[id="switch_<?php echo $this->id; ?>"]').checkbox({
				toggle:true,
				labels:{
					on:"<?php echo ( ! empty( $this->choices ) && isset( $this->choices['on'] ) ) ? $this->choices['on'] : $i18n['ON']; ?>",
					off:"<?php echo ( ! empty( $this->choices ) && isset( $this->choices['off'] ) ) ? $this->choices['off'] : $i18n['OFF']; ?>"
				}
			});
		});
		</script>
		<?php if ( '0' == $this->value() ) { ?>
			<script>jQuery(document).ready(function($){$('#customize-control-<?php echo $this->id; ?> .fs-checkbox').removeClass('fs-checkbox-checked');});</script>
		<?php } ?>
		<?php
	}
}
