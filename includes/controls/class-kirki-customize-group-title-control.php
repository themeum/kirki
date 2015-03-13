<?php

class Kirki_Customize_Group_Title_Control extends WP_Customize_Control {

	public $type = 'group_title';

	public function render_content() { ?>

		<label class="customizer-separator">
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
		</label>
		<?php
	}
}
