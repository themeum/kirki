<?php

class Kirki_Select_Control extends WP_Customize_Control {
	/**
	 * @access public
	 * @var string
	 */
	public $type = 'select';

	public $description = '';

	public $subtitle = '';

	public $separator = false;

	public $required;

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		} ?>

		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && ! empty( $this->description ) ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>

			<select <?php $this->link(); ?>>
				<?php
				foreach ( $this->choices as $value => $label ) {
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
				} ?>
			</select>
		</label>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; ?>
		<?php foreach ( $this->required as $id => $value ) :

			if ( isset($id) && isset($value) && get_theme_mod($id,0)==$value ) { ?>
				<script>
				jQuery(document).ready(function($) {
					$( "#customize-control-<?php echo $this->id; ?>" ).show();
					$( "#<?php echo $id . get_theme_mod($id,0); ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeOut(300);
					});
					$( "#<?php echo $id . $value; ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeIn(300);
					});
				});
				</script>
			<?php }

			if ( isset($id) && isset($value) && get_theme_mod($id,0)!=$value ) { ?>
				<script>
				jQuery(document).ready(function($) {
					$( "#customize-control-<?php echo $this->id; ?>" ).hide();
					$( "#<?php echo $id . get_theme_mod($id,0); ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeOut(300);
					});
					$( "#<?php echo $id . $value; ?>" ).click(function(){
						$( "#customize-control-<?php echo $this->id; ?>" ).fadeIn(300);
					});
				});
				</script>
			<?php }

		endforeach;
	}
}
