<?php

/**
 * Create a simple number control
 */
class Kirki_Controls_Number_Control extends WP_Customize_Control {

	public $type = 'number';

	public function enqueue() {

		wp_enqueue_script( 'formstone', trailingslashit( KIRKI_URL ) . 'assets/js/formstone-core.js', array( 'jquery' ) );
		wp_enqueue_script( 'formstone-number', trailingslashit( KIRKI_URL ) . 'assets/js/formstone-number.js', array( 'jquery', 'formstone' ) );
		wp_enqueue_style( 'kirki-number', trailingslashit( KIRKI_URL ) . 'assets/css/number.css' );

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
				$( "#customize-control-<?php echo $this->id; ?> input[type='number']").number();
			});
		</script>

		<?php
	}
}
