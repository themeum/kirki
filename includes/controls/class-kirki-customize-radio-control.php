<?php

class Kirki_Customize_Radio_Control extends Kirki_Customize_Control {

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'radio';
		$this->mode = ( ! isset( $this->mode ) || empty( $this->mode ) ) ? 'radio' : $this->mode;
		parent::__construct( $manager, $id, $args );
	}

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
			<?php $this->description(); ?>
		</span>
		<?php $this->subtitle(); ?>

		<div id="input_<?php echo $this->id; ?>" class="<?php echo $this->mode; ?>">
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
