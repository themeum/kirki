<?php

/**
 * Creates a new color-alpha control.
 */
class Kirki_Controls_Color_Alpha_Control extends Kirki_Control {

	public $type = 'color-alpha';
	public $palette = true;
	public $default = '#FFFFFF';

	protected function render() {
		$id = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
		$class = 'customize-control customize-control-' . $this->type; ?>
		<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li>
	<?php }

	public function render_content() { ?>
		<label>
			<?php $this->title(); ?>
			<input type="text" data-palette="<?php echo esc_textarea( $this->palette ); ?>" data-default-color="<?php echo $this->default; ?>" value="<?php echo intval( $this->value() ); ?>" class="kirki-color-control" <?php $this->link(); ?>  />
		</label>
	<?php }
}
