<?php

namespace Kirki\Controls;

class CustomControl extends \WP_Customize_Control {

	public $type = 'custom';

	public function render_content() { ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif;
			if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<?php echo $this->value(); ?>
		</label>
		<?php

	}

}
