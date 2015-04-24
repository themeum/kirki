<?php

/**
 * Creates a Switch control.
 */
class Kirki_Controls_Switch_Control extends Kirki_Control {

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
			<?php $this->label(); ?>
			<?php $this->description(); ?>
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
