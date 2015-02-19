<?php

class Kirki_Customize_Group_Title_Control extends Kirki_Customize_Control {

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'group_title';
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() { ?>

		<label class="customizer-separator">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php $this->description; ?>
			</span>
			<?php $this->subtitle(); ?>
		</label>
		<?php
	}
}
