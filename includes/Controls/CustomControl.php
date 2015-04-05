<?php

namespace Kirki\Controls;

class CustomControl extends \WP_Customize_Control {

	public $type = 'custom';

	public function render_content() { ?>
		<label>
			<?php
				// The label has already been sanitized in the Fields class, no need to re-sanitize it.
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo $this->label; ?></span>
			<?php endif;
			if ( ! empty( $this->description ) ) : ?>
				<?php
					// The description has already been sanitized in the Fields class, no need to re-sanitize it.
				?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<?php
				/**
				 * The value is defined by the developer in the field configuration as the default value.
				 * There is no user input on this field, it's a raw HTML/JS field and we don not sanitize it.
				 * Do not be alarmed, this is not a security issue.
				 * In order for someone to be able to change this they would have to have access to your filesystem.
				 * If that happens, they can change whatever they want anyways. This field is not a concern.
				 */
			?>
			<?php echo $this->value(); ?>
		</label>
		<?php

	}

}
