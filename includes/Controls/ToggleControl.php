<?php

namespace Kirki\Controls;

class ToggleControl extends \WP_Customize_Control {

	public $type = 'toggle';

	/**
	 * Render the control's content.
	 */
	protected function render_content() { ?>
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
			<?php $classes .= ' Round'; ?>
			<div class="Switch <?php echo $classes; ?>">
				<div class="Toggle"></div>
			</div>
		</label>
		<?php
	}
}
