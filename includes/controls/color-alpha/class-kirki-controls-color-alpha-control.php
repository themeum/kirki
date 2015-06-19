<?php

/**
 * Creates a new color-alpha control.
 */
class Kirki_Controls_Color_Alpha_Control extends WP_Customize_Control {

	public $type = 'color-alpha';
	public $palette = true;
	public $default = '#FFFFFF';

	public function enqueue() {

		wp_enqueue_script( 'kirki-color-alpha', trailingslashit( kirki_url() ) . 'includes/controls/color-alpha/script.js', array( 'jquery' ) );
		wp_enqueue_style( 'kirki-color-alpha', trailingslashit( kirki_url() ) . 'includes/controls/color-alpha/style.css' );

	}

	protected function render() {
		$id = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
		$class = 'customize-control customize-control-' . $this->type; ?>
		<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li>
	<?php }

	public function render_content() { ?>
		<label>
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<input type="text" data-palette="<?php echo esc_textarea( $this->palette ); ?>" data-default-color="<?php echo $this->default; ?>" value="<?php echo intval( $this->value() ); ?>" class="kirki-color-control" <?php $this->link(); ?>  />
		</label>
	<?php }
}
