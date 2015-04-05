<?php

namespace Kirki\Controls;

use Kirki;

class SwitchControl extends \WP_Customize_Control {

	public $type = 'switch';

	/**
	 * Render the control's content.
	 */
	protected function render_content() { ?>
		<?php $i18n = Kirki::i18n(); ?>
		<label>
			<div class="switch-info">
				<input style="display: none;" type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
			</div>
			<?php
				// The label has already been sanitized in the Fields class, no need to re-sanitize it.
			?>
			<?php echo $this->label; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<?php
					// The description has already been sanitized in the Fields class, no need to re-sanitize it.
				?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
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
