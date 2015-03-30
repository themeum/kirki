<?php

namespace Kirki\Controls;

class SwitchControl extends \WP_Customize_Control {

	public $type = 'switch';

	/**
	 * Render the control's content.
	 */
	protected function render_content() { ?>
		<?php $textdomain = kirki_textdomain(); ?>
		<label>
			<div class="switch-info">
				<input style="display: none;" type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
			</div>
			<?php echo esc_html( $this->label ); ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<?php $classes = ( esc_attr( $this->value() ) ) ? ' On' : ' Off'; ?>
			<div class="Switch <?php echo $classes; ?>">
				<div class="Toggle"></div>
				<span class="On"><?php _e( 'ON', $textdomain ); ?></span>
				<span class="Off"><?php _e( 'OFF', $textdomain ); ?></span>
			</div>
		</label>
		<?php
	}
}
