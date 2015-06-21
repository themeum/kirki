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
		wp_enqueue_script( 'kirki-switch', trailingslashit( kirki_url() ).'includes/controls/switch/kirki-switch.js', array( 'jquery' ) );
		wp_enqueue_style( 'kirki-switch', trailingslashit( kirki_url() ).'includes/controls/switch/style.css' );
	}

	/**
	 * Render the control's content.
	 */
	protected function render_content() { ?>
		<?php $i18n = Kirki_Toolkit::i18n(); ?>
		<label>
			<div class="switch-info">
				<input style="display: none;" type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
			</div>
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<?php $classes = ( esc_attr( $this->value() ) ) ? ' On' : ' Off'; ?>
			<div class="Switch <?php echo $classes; ?>">
				<div class="Toggle"></div>
				<span class="On"><?php echo $i18n['ON']; ?></span>
				<span class="Off"><?php echo $i18n['OFF']; ?></span>
			</div>
		</label>
		<?php
	}
}
