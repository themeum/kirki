<?php

/**
 * Create a palette control.
 */
class Kirki_Controls_Palette_Control extends Kirki_Control {

	public $type = 'palette';

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-palette-' . $this->id;

		?>
		<?php $this->title(); ?>

		<div id="input_<?php echo $this->id; ?>" class="buttonset">
			<?php foreach ( $this->choices as $value => $colorSet ) : ?>
				<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
					<label for="<?php echo $this->id . $value; ?>">
						<?php
						foreach ( $colorSet as $color ) {
							printf( "<span style='background: {$color}'>{$color}</span>" );
						}
						?>
					</label>
				</input>
			<?php endforeach; ?>
		</div>
		<script>jQuery(document).ready(function($) { $( '[id="input_<?php echo $this->id; ?>"]' ).buttonset(); });</script>

		<?php
	}
}
