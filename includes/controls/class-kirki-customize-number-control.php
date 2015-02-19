<?php

class Kirki_Customize_Number_Control extends Kirki_Customize_Control {

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'number';
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() { ?>

		<label class="customizer-text">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php $this->description(); ?>
			</span>
			<?php $this->subtitle(); ?>
			<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>"/>
			<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
				<a href="#" class="button tooltip hint--left" data-hint="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
		</label>
		<?php
	}
}
