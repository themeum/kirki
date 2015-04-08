<?php

namespace Kirki\Controls;

use Kirki\Control;

class EditorControl extends Control {

	public $type = 'editor';

	public function render_content() { ?>

		<label>
			<?php $this->title(); ?>
			<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
			<?php
				$settings = array(
					'textarea_name'    => $this->id,
					'teeny'            => true
				);
				wp_editor( esc_textarea( $this->value() ), $this->id, $settings );

				do_action('admin_footer');
				do_action('admin_print_footer_scripts');
			?>
		</label>
		<?php
	}

}
