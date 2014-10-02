<?php

class Kirki_Customize_Checkbox_Control extends WP_Customize_Control {

	public $type = 'checkbox';
	public $description = '';
	public $subtitle = '';

	public function render_content() { ?>
		<label class="customizer-checkbox">
			<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" id="<?php echo $this->id . esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
			<strong><?php echo esc_html( $this->label ); ?></strong>
			<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
				<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>
		</label>
		<?php
	}
}
