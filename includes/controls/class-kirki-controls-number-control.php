<?php

/**
 * Create a simple number control
 */
class Kirki_Controls_Number_Control extends WP_Customize_Control {

	public $type = 'number';

	public function enqueue() {

		$config   = Kirki_Toolkit::config()->get_all();
		$root_url = ( '' != $config['url_path'] ) ? esc_url_raw( $config['url_path'] ) : KIRKI_URL;

        wp_enqueue_script( 'kirki-fs-stepper', trailingslashit( $root_url ) . 'assets/js/jquery.fs.stepper.min.js', array( 'jquery' ) );

    }

	public function render_content() { ?>

		<label class="customizer-text">
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>"/>
		</label>
		<script>
			jQuery(document).ready(function($) {
				"use strict";
				$( "#customize-control-<?php echo $this->id; ?> input[type='number']").stepper();
			});
		</script>

		<?php
	}
}
