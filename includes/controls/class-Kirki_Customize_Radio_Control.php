<?php

class Kirki_Customize_Radio_Control extends WP_Customize_Control {

	public $type = 'radio';
	public $description = '';
	public $mode = 'radio';
	public $subtitle = '';

	public function enqueue() {

		if ( 'buttonset' == $this->mode || 'image' == $this->mode ) {
			wp_enqueue_script( 'jquery-ui-button' );
		}

	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;

		?>
		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
			<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
				<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
		</span>

		<div id="input_<?php echo $this->id; ?>" class="<?php echo $this->mode; ?>">
			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>
			<?php

			// JqueryUI Button Sets
			if ( 'buttonset' == $this->mode ) {

				foreach ( $this->choices as $value => $label ) : ?>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo $this->id . $value; ?>">
							<?php echo esc_html( $label ); ?>
						</label>
					</input>
					<?php
				endforeach;

			// Image radios.
			} elseif ( 'image' == $this->mode ) {

				foreach ( $this->choices as $value => $label ) : ?>
					<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo $this->id . $value; ?>">
							<img src="<?php echo esc_html( $label ); ?>">
						</label>
					</input>
					<?php
				endforeach;

			// Normal radios
			} else {

				foreach ( $this->choices as $value => $label ) :
					?>
					<label class="customizer-radio">
						<input class="kirki-radio" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<?php echo esc_html( $label ); ?><br/>
					</label>
					<?php
				endforeach;

			}
			?>
		</div>
		<?php if ( 'buttonset' == $this->mode || 'image' == $this->mode ) { ?>
			<script>
			jQuery(document).ready(function($) {
				$( '[id="input_<?php echo $this->id; ?>"]' ).buttonset();
			});
			</script>
		<?php }

	}
}
