<?php

namespace Kirki\Controls;

use Kirki\Control;

class ToggleControl extends Control {

	public $type = 'toggle';

	/**
	 * Render the control's content.
	 */
	protected function render_content() { ?>
		<label>
			<div class="switch-info">
				<input style="display: none;" type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
			</div>
			<?php $this->label(); ?>
			<?php $this->description(); ?>
			<?php $classes = ( esc_attr( $this->value() ) ) ? ' On' : ' Off'; ?>
			<?php $classes .= ' Round'; ?>
			<div class="Switch <?php echo $classes; ?>">
				<div class="Toggle"></div>
			</div>
		</label>
		<?php
	}
}
