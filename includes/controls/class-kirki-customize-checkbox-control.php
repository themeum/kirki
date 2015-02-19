<?php

class Kirki_Customize_Checkbox_Control extends Kirki_Customize_Control {

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'checkbox';
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() { ?>
		<label class="customizer-checkbox">
			<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" id="<?php echo $this->id . esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
			<strong><?php echo esc_html( $this->label ); ?></strong>
			<?php $this->description(); ?>
			<?php $this->subtitle(); ?>
		</label>
		<?php
	}
}
