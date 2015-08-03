<?php
/**
 * slider Customizer Control.
 *
 * Creates a jQuery slider control.
 * TODO: Migrate to an HTML5 range control. Range control are hard to style 'cause they don't display the value
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Slider_Control' ) ) {
	return;
}

class Kirki_Controls_Slider_Control extends WP_Customize_Control {

	public $type = 'slider';

	public function enqueue() {

		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_style( 'kirki-slider', trailingslashit( kirki_url() ).'includes/controls/slider/style.css' );

	}

	public function render_content() { ?>
		<label>

			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>

			<input type="text" class="kirki-slider" id="input_<?php echo $this->id; ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?>/>

		</label>

		<div id="slider_<?php echo $this->id; ?>" class="ss-slider"></div>
		<script>
		jQuery(document).ready(function($) {
			$( '[id="slider_<?php echo $this->id; ?>"]' ).slider({
					value : <?php echo esc_attr( $this->value() ); ?>,
					min   : <?php echo ($this->choices['min']) ? $this->choices['min'] : '0'; ?>,
					max   : <?php echo ($this->choices['max']) ? $this->choices['max'] : '100'; ?>,
					step  : <?php echo ($this->choices['step']) ? $this->choices['step'] : '1'; ?>,
					slide : function( event, ui ) { $( '[id="input_<?php echo $this->id; ?>"]' ).val(ui.value).keyup(); }
			});
			$( '[id="input_<?php echo $this->id; ?>"]' ).val( $( '[id="slider_<?php echo $this->id; ?>"]' ).slider( "value" ) );

			$( '[id="input_<?php echo $this->id; ?>"]' ).change(function() {
				$( '[id="slider_<?php echo $this->id; ?>"]' ).slider({
					value : $( this ).val()
				});
			});

		});
		</script>
		<?php

	}
}
