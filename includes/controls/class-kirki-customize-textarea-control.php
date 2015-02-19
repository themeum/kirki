<?php

class Kirki_Customize_Textarea_Control extends Kirki_Customize_Control {

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'textarea';
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() { ?>
		<label class="customizer-textarea">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php $this->description(); ?>
			</span>
			<?php $this->subtitle(); ?>

			<textarea class="of-input" rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php

	}
}
