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
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-switch', trailingslashit( kirki_url() ) . 'includes/controls/switch/style.css' );
		}
	}

	/**
	 * Render the control's content.
	 */
	protected function render_content() { ?>
		<?php $i18n = Kirki_Toolkit::i18n(); ?>
		<div class="switch<?php echo ( isset( $this->choices['round'] ) && true == $this->choices['round'] ) ? ' round' : ''; ?>">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<input name="switch_<?php echo $this->id; ?>" id="switch_<?php echo $this->id; ?>" type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> <?php if ( '1' == $this->value() ) { echo 'checked'; } ?> />
			<label for="switch_<?php echo $this->id; ?>">
				<span class="switch-on"><?php echo ( ! empty( $this->choices ) && isset( $this->choices['on'] ) ) ? $this->choices['on'] : $i18n['ON']; ?></span>
				<span class="switch-off"><?php echo ( ! empty( $this->choices ) && isset( $this->choices['off'] ) ) ? $this->choices['off'] : $i18n['OFF']; ?></span>
			</label>
		</div>
		<?php
	}
}
